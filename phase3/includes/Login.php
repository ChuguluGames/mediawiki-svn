<?php

/**
 * Encapsulates the backend activities of logging a user into the wiki.
 */
class Login {

	const SUCCESS = 0;
	const NO_NAME = 1;
	const ILLEGAL = 2;
	const WRONG_PLUGIN_PASS = 3;
	const NOT_EXISTS = 4;
	const WRONG_PASS = 5;
	const EMPTY_PASS = 6;
	const RESET_PASS = 7;
	const ABORTED = 8;
	const THROTTLED = 10;
	const USER_BLOCKED = 11;
	const FAILED = 12;
	const READ_ONLY = 13;
	
	const MAIL_PASSCHANGE_FORBIDDEN = 21;
	const MAIL_BLOCKED = 22;
	const MAIL_PING_THROTTLED = 23;
	const MAIL_PASS_THROTTLED = 24;
	const MAIL_EMPTY_EMAIL = 25;
	const MAIL_BAD_IP = 26;
	const MAIL_ERROR = 27;
	
	const CREATE_BLOCKED = 40;
	const CREATE_EXISTS = 41;
	const CREATE_SORBS = 42;
	const CREATE_BADDOMAIN = 43;
	const CREATE_BADNAME = 44;
	const CREATE_BADPASS = 45;
	const CREATE_NEEDEMAIL = 46;
	const CREATE_BADEMAIL = 47;

	protected $mName;
	protected $mPassword;
	public $mRemember; # 0 or 1
	public $mEmail;
	public $mDomain;
	public $mRealname;

	protected $mExtUser = null;
	protected $mUser;
	public $mUserCode = null;	# Status code
	
	public $mLoginResult = '';
	public $mMailResult = '';
	public $mCreateResult = '';

	/**
	 * Constructor
	 * @param $data Array data object passed by reference.
	 */
	public function __construct( $data ) {
		global $wgAuth, $wgHiddenPrefs, $wgEnableEmail;

		$this->mName = $data['Name'];
		$this->mPassword = $data['Password'];
		
		if( isset( $data['Remember'] ) ){
			$this->mRemember = $data['Remember'] ? 1 : 0;
		}

		if( $wgEnableEmail && isset( $data['Email']) ) {
			$this->mEmail = $data['Email'];
		} else {
			$this->mEmail = '';
		}
		
		if( !in_array( 'realname', $wgHiddenPrefs ) && isset( $data['RealName'] ) ) {
		    $this->mRealName = $data['RealName'];
		} else {
		    $this->mRealName = '';
		}

		$this->mDomain = isset( $data['Domain'] )
			? $data['Domain']
			: '';
		if( !$wgAuth->validDomain( $this->mDomain ) ) {
			$this->mDomain = 'invaliddomain';
		}
		$wgAuth->setDomain( $this->mDomain );

	}
	
	/**
	 * Having initialised the Login object with (at least) the wpName
	 * and wpPassword pair, attempt to authenticate the user and log
	 * them into the wiki.  Authentication may come from the local 
	 * user database, or from an AuthPlugin- or ExternalUser-based
	 * foreign database; in the latter case, a local user record may
	 * or may not be created and initialised.  
	 * @param $password String if set, log in with this password rather
	 *     than whatever was given in the initial config.  If set to 
	 *     Bool true, password always matches
	 * @return a Login class constant representing the status.
	 */
	public function attemptLogin( $password=null ){
		global $wgUser;
		
		if( $password !== null ){
			$this->mPassword = $password;
		}
		
		$code = $this->authenticateUserData();
		if( $code != self::SUCCESS ){
			return $code;
		}
		
		# Log the user in and remember them if they asked for that.
		if( (bool)$this->mRemember != (bool)$wgUser->getOption( 'rememberpassword' ) ) {
			$wgUser->setOption( 'rememberpassword', $this->mRemember ? 1 : 0 );
			$wgUser->saveSettings();
		} else {
			$wgUser->invalidateCache();
		}
		$wgUser->setCookies();

		# Reset the password throttle
		$key = wfMemcKey( 'password-throttle', wfGetIP(), md5( $this->mName ) );
		global $wgMemc;
		$wgMemc->delete( $key );
		
		wfRunHooks( 'UserLoginComplete', array( &$wgUser, &$this->mLoginResult ) );
		
		return self::SUCCESS;
	}

	/**
	 * Check whether there is an external authentication mechanism from
	 * which we can automatically authenticate the user and create a 
	 * local account for them. 
	 * @return integer Status code.  Login::SUCCESS == clear to proceed
	 *    with user creation.
	 */
	protected function canAutoCreate() {
		global $wgAuth, $wgUser, $wgAutocreatePolicy;

		if( $wgUser->isBlockedFromCreateAccount() ) {
			wfDebug( __METHOD__.": user is blocked from account creation\n" );
			return self::CREATE_BLOCKED;
		}

		# If the external authentication plugin allows it, automatically 
		# create a new account for users that are externally defined but 
		# have not yet logged in.
		if( $this->mExtUser ) {
			# mExtUser is neither null nor false, so use the new 
			# ExternalAuth system.
			if( $wgAutocreatePolicy == 'never' ) {
				$this->mLoginResult = 'nosuchusershort';
				return self::NOT_EXISTS;
			}
			if( !$this->mExtUser->authenticate( $this->mPassword ) ) {
				$this->mLoginResult = 'wrongpassword';
				return self::WRONG_PLUGIN_PASS;
			}
		} else {
			# Old AuthPlugin.
			if( !$wgAuth->autoCreate() ) {
				$this->mLoginResult = 'nosuchuser';
				return self::NOT_EXISTS;
			}
			if( !$wgAuth->userExists( $this->mUser->getName() ) ) {
				wfDebug( __METHOD__.": user does not exist\n" );
				$this->mLoginResult = 'nosuchuser';
				return self::NOT_EXISTS;
			}
			if( !$wgAuth->authenticate( $this->mUser->getName(), $this->mPassword ) ) {
				wfDebug( __METHOD__.": \$wgAuth->authenticate() returned false, aborting\n" );
				$this->mLoginResult = 'wrongpassword';
				return self::WRONG_PLUGIN_PASS;
			}
		}

		return self::SUCCESS;
	}

	/**
	 * Internally authenticate the login request.
	 *
	 * This may create a local account as a side effect if the
	 * authentication plugin allows transparent local account
	 * creation.
	 * @return class constant status code
	 */
	protected function authenticateUserData() {
		global $wgUser, $wgAuth;
		
		if( '' == $this->mName ) {
			$this->mLoginResult = 'noname';
			return self::NO_NAME;
		}
		
		global $wgPasswordAttemptThrottle;
		$throttleCount = 0;
		if( is_array( $wgPasswordAttemptThrottle ) ) {
			$throttleKey = wfMemcKey( 'password-throttle', wfGetIP(), md5( $this->mName ) );
			$count = $wgPasswordAttemptThrottle['count'];
			$period = $wgPasswordAttemptThrottle['seconds'];
			
			global $wgMemc;
			$throttleCount = $wgMemc->get( $throttleKey );
			if( !$throttleCount ) {
				$wgMemc->add( $throttleKey, 1, $period ); # Start counter
			} elseif( $throttleCount < $count ) {
				$wgMemc->incr($throttleKey);
			} elseif( $throttleCount >= $count ) {
				$this->mLoginResult = 'login-throttled';
				return self::THROTTLED;
			}
		}
		
		# Initialise $this->mUser
		if( $this->getUser() === null ){
			return $this->mUserCode;
		}

		# Shortcut
		if( $wgUser->getName() === $this->mUser->getName() ){
			wfDebug( __METHOD__.": already logged in as {$this->mName}\n" );
			return self::SUCCESS;
		}

		# Give general extensions, such as a captcha, a chance to abort logins
		if( !wfRunHooks( 'AbortLogin', array( &$this->mUser, $this->mPassword, &$this->mLoginResult ) ) ) {
			return self::ABORTED;
		}

		if( $this->mUser->checkPassword( $this->mPassword ) || $this->mPassword === true ) {
			# If we've enabled it, make it so that a blocked user cannot login
			# This is only reached if the password matches, preventing fishing
			# for blocked accounts on private wikis.
			global $wgBlockDisablesLogin;
			if( $wgBlockDisablesLogin && $this->mUser->isBlocked() ) {
				$this->mLoginResult = 'login-userblocked';
				return self::USER_BLOCKED;
			}
		
			$wgAuth->updateUser( $this->mUser );
			$wgUser = $this->mUser;

			# Reset throttle after a successful login
			if( $throttleCount ) {
				$wgMemc->delete( $throttleKey );
			}

			$retval = self::SUCCESS;
		} else {
			if( $this->mUser->checkTemporaryPassword( $this->mPassword ) ) {
				# The e-mailed temporary password should not be used for actual
				# logins; that's a very sloppy habit, and insecure if an
				# attacker has a few seconds to click "search" on someone's 
				# open mail reader.
				#
				# Allow it to be used only to reset the password a single time
				# to a new value, which won't be in the user's e-mail archives
				#
				# For backwards compatibility, we'll still recognize it at the
				# login form to minimize surprises for people who have been
				# logging in with a temporary password for some time.
				#
				# As a side-effect, we can authenticate the user's e-mail ad-
				# dress if it's not already done, since the temporary password
				# was sent via e-mail.
				if( !$this->mUser->isEmailConfirmed() ) {
					$this->mUser->confirmEmail();
					$this->mUser->saveSettings();
				}

				# At this point we just return an appropriate code/ indicating
				# that the UI should show a password reset form; bot interfaces
				# etc will probably just fail cleanly here.
				$retval = self::RESET_PASS;
			} else {
				if( $this->mPassword === '' ){
					$retval = self::EMPTY_PASS;
					$this->mLoginResult = 'wrongpasswordempty';
				} else {
					$retval = self::WRONG_PASS;
					$this->mLoginResult = 'wrongpassword';
				}
			}
		}
		wfRunHooks( 'LoginAuthenticateAudit', array( &$this->mUser, $this->mPassword, $retval ) );
		return $retval;
	}
	
	/**
	 * Initialise and return the User that we're going to be logging in as.  
	 * Note that the object can only be initialised once.  This may result
	 * in the user being added to the database from external sources.
	 * @return &User, or &null on failure.  Sets a status code in $this->mUserCode
	 */
	public function &getUser(){
		if( $this->mUserCode !== null ){
			return $this->mUser;
		}
	
		# Unstub $wgUser if it's not already by calling getName(). This calls 
		# the UserLoadFromSession hook, which potentially creates the user in 
		# the database. Until we load $wgUser, checking for user existence 
		# using User::newFromName($name)->getId() below will effectively be 
		# using stale data.
		global $wgUser;
		$wgUser->getName();
			
		# Load the user, if they exist in the local database.
		$this->mUser = User::newFromName( trim( $this->mName ), 'usable' );

		$this->mExtUser = ExternalUser::newFromName( $this->mName );
		
		# If the given username produces a valid ExternalUser, which is 
		# linked to an existing local user, use that, regardless of 
		# whether the username matches up.
		if( $this->mExtUser ){
			$user = $this->mExtUser->getLocalUser();
			if( $user instanceof User ){
				$this->mUser = $user;
			}
		}

		# TODO: Allow some magic here for invalid external names, e.g., let the
		# user choose a different wiki name.
		if( !$this->mUser instanceof User || !User::isUsableName( $this->mUser->getName() ) ) {
			$this->mUserCode = self::ILLEGAL;
			$this->mUser = null;
			return $this->mUser;
		}


		# If the user doesn't exist in the local database, our only chance 
		# is for an external auth plugin to autocreate the local user first.
		if( $this->mUser->getId() == 0 ) {
			if( $this->canAutoCreate() == self::SUCCESS ) {
				
				wfDebug( __METHOD__.": creating account\n" );
				
				if( !wfRunHooks( 'AbortNewAccountAuto', array( &$this->mUser, &$this->mCreateResult ) ) ) {
					wfDebug( __METHOD__ . ": a hook blocked creation\n" );
					$this->mUserCode = self::ABORTED;
					$this->mUser = null;
					return $this->mUser;
				}
				
				$result = $this->initUser( true );
				if( $result !== self::SUCCESS ){
					$this->mUserCode = $result;
					$this->mUser = null;
					return $this->mUser;
				}
				wfRunHooks( 'AuthPluginAutoCreate', array( &$this->mUser ) );
				
			} else {
				$this->mUserCode = $this->canAutoCreate();
				$this->mUser = null;
				trigger_error( "Login::getUser() failed: {$this->mUserCode} / {$this->mExtUser} / {$this->mName} / {$this->mLoginResult}", E_USER_NOTICE );
				return $this->mUser;
			}
		} else {
			global $wgAutocreatePolicy;
		 	if ( $this->mExtUser 
		 		&& $wgAutocreatePolicy != 'never'
		 		&& $this->mExtUser->authenticate( $this->mPassword ) ) 
		 	{
			 	# The external user and local user have the same name and
			 	# password, so we assume they're the same.
			 	$this->mExtUser->linkToLocal( $this->mUser->getID() );
	 	} 
			$this->mUser->load();
		}
		
		$this->mUserCode = self::SUCCESS;
		return $this->mUser;
	}

	/**
	 * Actually add a user to the database.
	 * Give it a User object that has been initialised with a name.
	 *
	 * @param $autocreate Bool is this is an autocreation from an external
	 *   authentication database?
	 * @param $byEmail Bool is this request going to be handled by sending
	 *   the password by email?
	 * @return Bool whether creation was successful (should only fail for
	 *   Db errors etc).
	 */
	protected function initUser( $autocreate=false, $byEmail=false ) {
		global $wgAuth, $wgUser;

		$fields = array(
			'name' => User::getCanonicalName( $this->mName ),
			'password' => $byEmail ? null : User::crypt( $this->mPassword ),
			'email' => $this->mEmail,
			'real_name' => $this->mRealName,
			'options' => array(
				'rememberpassword' => $this->mRemember ? 1 : 0,
			),
		);
		
		$this->mUser = User::createNew( $this->mName, $fields );
		
		if( $this->mUser === null ){
			return null;
		}

		# Let old AuthPlugins play with the user
		$wgAuth->initUser( $this->mUser, $autocreate );

		# Or new ExternalUser plugins
		if( $this->mExtUser ) {
			$this->mExtUser->linkToLocal( $this->mUser->getId() );
			$email = $this->mExtUser->getPref( 'emailaddress' );
			if( $email && !$this->mEmail ) {
				$this->mUser->setEmail( $email );
			}
		}

		# Update user count and newuser logs
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();
		if( $autocreate ){
			$this->mUser->addNewUserLogEntryAutoCreate();
		} elseif ( $wgUser->isAnon() ){
			# Avoid spamming IP addresses all over the newuser log
			$this->mUser->addNewUserLogEntry( $this->mUser, $byEmail );
		} else {
			$this->mUser->addNewUserLogEntry( $wgUser, $byEmail );
		}
		
		# Run hooks
		wfRunHooks( 'AddNewAccount', array( &$this->mUser, $autocreate, $byEmail ) );
		
		$this->mUser->saveSettings();
		return self::SUCCESS;
	}

	/**
	 * Entry point to create a new local account from user-supplied
	 * data loaded from the WebRequest.  We handle initialising the 
	 * email here because it's needed for some backend things; frontend
	 * interfaces calling this should handle recording things like 
	 * preference options
	 * @param $byEmail Bool whether to email the user their new password
	 * @return Status code; Login::SUCCESS == the user was successfully created
	 */
	public function attemptCreation( $byEmail=false ) {
		global $wgUser, $wgOut;
		global $wgMemc, $wgAccountCreationThrottle;
		global $wgAuth;
		global $wgEmailAuthentication, $wgEmailConfirmToEdit;

		if( wfReadOnly() ) {
			return self::READ_ONLY;
		}
			
		# If the user passes an invalid domain, something is fishy
		if( !$wgAuth->validDomain( $this->mDomain ) ) {
			$this->mCreateResult = 'wrongpassword';
			return self::CREATE_BADDOMAIN;
		}

		# If we are not allowing users to login locally, we should be checking
		# to see if the user is actually able to authenticate to the authenti-
		# cation server before they create an account (otherwise, they can
		# create a local account and login as any domain user). We only need
		# to check this for domains that aren't local.
		if(    !in_array( $this->mDomain, array( 'local', '' ) ) 
			&& !$wgAuth->canCreateAccounts() 
			&& ( !$wgAuth->userExists( $this->mUsername ) 
				|| !$wgAuth->authenticate( $this->mUsername, $this->mPassword ) 
			) ) 
		{
			$this->mCreateResult = 'wrongpassword';
			return self::WRONG_PLUGIN_PASS;
		}

		$ip = wfGetIP();
		if( $wgUser->isDnsBlacklisted( $ip, true /* check $wgProxyWhitelist */ ) ) {
			$this->mCreateResult = 'sorbs_create_account_reason';
			return self::CREATE_SORBS;
		}

		# Now create a dummy user ($user) and check if it is valid
		$name = trim( $this->mName );
		$this->mUser = User::newFromName( $name, 'creatable' );
		if( !$this->mUser instanceof User ) {
			$this->mCreateResult = 'noname';
			return self::CREATE_BADNAME;
		}

		if( $this->mUser->idForName() != 0 ) {
			$this->mCreateResult = 'userexists';
			return self::CREATE_EXISTS;
		}

		# Check that the password is acceptable, if we're actually
		# going to use it
		if( !$byEmail ){
			$valid = $this->mUser->getPasswordValidity( $this->mPassword );
			if( $valid !== true ) {
				$this->mCreateResult = $valid;
				return self::CREATE_BADPASS;
			}
		}

		# if you need a confirmed email address to edit, then obviously you
		# need an email address. Equally if we're going to send the password to it.
		if( ( $wgEmailConfirmToEdit || $byEmail ) && empty( $this->mEmail ) ) {
			$this->mCreateResult = 'noemailcreate';
			return self::CREATE_NEEDEMAIL;
		}

		if( !empty( $this->mEmail ) && !User::isValidEmailAddr( $this->mEmail ) ) {
			$this->mCreateResult = 'invalidemailaddress';
			return self::CREATE_BADEMAIL;
		}

		# Set some additional data so the AbortNewAccount hook can be used for
		# more than just username validation
		$this->mUser->setEmail( $this->mEmail );
		$this->mUser->setRealName( $this->mRealName );

		if( !wfRunHooks( 'AbortNewAccount', array( &$this->mUser, &$this->mCreateResult ) ) ) {
			# Hook point to add extra creation throttles and blocks
			wfDebug( __METHOD__ . ": a hook blocked creation\n" );
			return self::ABORTED;
		}

		if( $wgAccountCreationThrottle && $wgUser->isPingLimitable() ) {
			$key = wfMemcKey( 'acctcreate', 'ip', $ip );
			$value = $wgMemc->get( $key );
			if( !$value ) {
				$wgMemc->set( $key, 0, 86400 );
			}
			if( $value >= $wgAccountCreationThrottle ) {
				return self::THROTTLED;
			}
			$wgMemc->incr( $key );
		}

		# Since we're creating a new local user, give the external 
		# database a chance to synchronise.
		if( !$wgAuth->addUser( $this->mUser, $this->mPassword, $this->mEmail, $this->mRealName ) ) {
			$this->mCreateResult = 'externaldberror';
			return self::ABORTED;
		}

		$result = $this->initUser( false, $byEmail );
		if( $result === null ){
			# It's unlikely we'd get here without some exception 
			# being thrown, but it's probably possible...
			return self::FAILED;
		}
		
		if( $byEmail ){
			# Send out the password by email
			$this->mUser->setPassword( null );
			$this->mUser->saveSettings();
			$emailResult = $this->mailPassword( 'createaccount-text', 'createaccount-title' );
			if( WikiError::isError( $this->mMailResult ) ){
				# FIXME: If the password email hasn't gone out, 
				# then the account is inaccessible :(
				return self::MAIL_ERROR;
			} else {
				return self::SUCCESS;
			}
		} else {
			if( $wgEmailAuthentication && User::isValidEmailAddr( $this->mUser->getEmail() ) ) 
			{
				$this->mMailResult = $this->mUser->sendConfirmationMail();
				return WikiError::isError( $this->mMailResult ) 
					? self::MAIL_ERROR 
					: self::SUCCESS;
			}
		}
		return self::SUCCESS;
	}

	/**
	 * Email the user a new password, if appropriate to do so.
	 * @param $text String message key
	 * @param $title String message key
	 * @return Status code
	 */
	public function mailPassword( $text='passwordremindertext', $title='passwordremindertitle' ) {
		global $wgUser, $wgOut, $wgAuth, $wgServer, $wgScript, $wgNewPasswordExpiry;

		if( wfReadOnly() ) {
			return self::READ_ONLY;
		}

		# If we let the email go out, it will take users to a form where
		# they are forced to change their password, so don't let us go 
		# there if we don't want passwords changed.
		if( !$wgAuth->allowPasswordChange() ) {
			return self::MAIL_PASSCHANGE_FORBIDDEN;
		}

		# Check against blocked IPs
		# FIXME: -- should we not?
		if( $wgUser->isBlocked() ){
			return self::MAIL_BLOCKED;
		}

		# Check for hooks
		if( !wfRunHooks( 'UserLoginMailPassword', array( $this->mName, &$this->mMailResult ) ) ){
			return self::ABORTED;
		}

		# Check against the rate limiter
		if( $wgUser->pingLimiter( 'mailpassword' ) ){
			return self::MAIL_PING_THROTTLED;
		}

		# Initialise the user before checking data about them
		if( is_null( $this->getUser() ) ){
			return self::NO_NAME;
		}

		# And that the resulting user actually exists
		if( $this->mUser->getId() === 0 ){
			return self::NOT_EXISTS;
		}

		# Check against password throttle
		if( $this->mUser->isPasswordReminderThrottled() ){
			return self::MAIL_PASS_THROTTLED;
		}
		
		# User doesn't have email address set
		if( $this->mUser->getEmail() === '' ){
			return self::MAIL_EMPTY_EMAIL;
		}

		# Don't send to people who are acting fishily by hiding their IP
		$ip = wfGetIP();
		if( !$ip ){
			return self::MAIL_BAD_IP;
		}
		
		# If blocked users cannot log in, don't let them reset passwords either.
		global $wgBlockDisablesLogin;
		if( $wgBlockDisablesLogin && $this->mUser->isBlocked() ) {
			return self::USER_BLOCKED;
		}

		# Let hooks do things with the data
		wfRunHooks( 'User::mailPasswordInternal', array( &$wgUser, &$ip, &$this->mUser) );

		$newpass = $this->mUser->randomPassword();
		$this->mUser->setNewpassword( $newpass, true );

		$message = wfMsgExt( 
			$text, 
			array( 'parsemag', 'language' => $this->mUser->getOption('language') ), 
			array( 
				$ip, 
				$this->mUser->getName(), 
				$newpass,
				$wgServer . $wgScript, 
				round( $wgNewPasswordExpiry / 86400 )
			)
		);
		$title = wfMsgExt( 
			$title, 
			array( 'parseinline', 'language' => $this->mUser->getOption('language') ) 
		);
		$this->mMailResult = $this->mUser->sendMail( $title, $message );
		if( WikiError::isError( $this->mMailResult ) ) {
			# Discard the new password by not saving it, and hence
			# also not setting the newpassword throttle
			return self::MAIL_ERROR;
		} else {
			# Save the new password
			$this->mUser->saveSettings();
			return self::SUCCESS;
		}
	}
}

/**
 * For backwards compatibility, mainly with the state constants, which
 * could be referred to in old extensions with the old class name.
 * @deprecated
 */
class LoginForm extends Login {}