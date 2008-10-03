<?php

class SpecialAccountManager extends SpecialPage {
	function __construct() {
		parent::__construct( 'AccountManager', 'accountmanager', false );
		$this->mErrors = array();
	}
	
	function execute() {
		global $wgUser;
		if( !$this->userCanExecute( $wgUser ) )
			return $this->displayRestrictionError();

		$this->setHeaders();

		$this->users = UserProps::fetchAllUsers();
		if( $this->processData() === true )
			$this->showSuccess();
		if( $this->processCreateAccount() === true )
			$this->showSuccessCreate();
			
		$this->showErrors();
			
		$this->constructForm();
		$this->constructCreateForm();
	}

	function showSuccess() {
		global $wgOut;
		$wgOut->addHTML( Xml::element('p', array(), 'Your changes have been successfully updated' ) );
	}
	function showSuccessCreate() {
		return $this->showSuccess();
	}

	function constructForm() {
		global $wgOut, $wgScript;
		global $wgUserProperties, $wgActivityModes;

		// TODO: wfMsg etc.
		$wgOut->addHTML( Xml::openElement( 'form', array(
			'action' => $this->getTitle()->getLocalURL(),
			'method' => 'post' )
		) );

		$wgOut->addHTML("<table id=\"userprops\" border=\"1\">\n\t<tr>".
			"<th>".wfMsgHtml( 'am-username' ).
			"</th><th>".wfMsgHtml( 'am-email' ).
			"</th><th>".wfMsgHtml( 'am-active' )."</th>");
		foreach( $wgUserProperties as $i ) {
			$msg = 'am-'.$i;
			$wgOut->addHTML( Xml::element( 'th', null, 
				wfEmptyMsg( $msg, wfMsg( $msg ) ) ? $i : wfMsgHtml( $msg ) ) );
		}
		$wgOut->addHTML("</tr>\n\n");

		foreach( $this->users as $user ) {
			$name = $user->getName();
			$row = "\t<tr>";
			$row .= Xml::element( 'td', null, $name );
			$row .= "<td>".Xml::input( "am-{$name}-email", 40, $user->getEmail() )."</td>";
			$select = new XmlSelect( "am-{$name}-active" );
			$select->setDefault( $user->getActive() );
			foreach( $wgActivityModes as $key )
				$select->addOption( $key );
			$row .= "<td>".$select->getHTML()."</td>";

			$props = $user->getProps();
			foreach( $wgUserProperties as $key ) {
				$value = isset( $props[$key] ) ? $props[$key] : '';
				$row .= "<td>".Xml::input( 
						"am-{$name}-{$key}", 40, $value
					)."</td>";
			}
			$row .= "</tr>\n";
			$wgOut->addHTML( $row );
		}
		
		$wgOut->addHTML( "</table>\n" );
		$wgOut->addHTML( "<div id=\"userprops-submit\">\n".
			Xml::hidden( 'action', 'submit' ).
			Xml::element( 'input', array(
				'type' => 'submit',
				'value' => wfMsg( 'nss-save-changes' )
			) ).
			"</div>\n</form>" 
		);
	}
	
	function constructCreateForm() {
		global $wgOut, $wgScript;
		global $wgUserProperties, $wgActivityModes;

		$wgOut->addHTML( Xml::openElement( 'form', array(
			'action' => $this->getTitle()->getLocalURL(),
			'method' => 'post' )
		) );
		
		$wgOut->addHTML( Xml::element( 'h2', null, wfMsg( 'nss-create-account-header' ) )."\n" );

		$wgOut->addHTML( "<table border=\"1\" id=\"newuser\">\n" );
		
		$props = array_merge( array( 'username', 'email' ), $wgUserProperties );
		foreach( $props as $i ) {
			$msg = 'am-'.$i;
			$wgOut->addHTML( "\t<tr><th>".
				(wfEmptyMsg( $msg, wfMsg( $msg ) ) ? $i : wfMsgHtml( $msg )).
				"</th><td>".Xml::input( "am-{$i}", 40 ).
				"</td></tr>\n"
			 );
		}
		
		global $wgActivityModes;
		$select = new XmlSelect( "am-active" );
		$select->setDefault( 'active' );
		$select->setAttribute( 'width', '100%' );
		foreach( $wgActivityModes as $key )
				$select->addOption( $key );
		$wgOut->addHTML( "\t<tr><th>".wfMsgHtml( 'am-active' ).
			"</th><td>".$select->getHTML()."</td></tr>\n" );
		
		$wgOut->addHTML( "</table>\n" );
		$wgOut->addHTML( "<div id=\"newaccount-submit\">\n".
			Xml::hidden( 'action', 'create' ).
			Xml::element( 'input', array(
				'type' => 'submit',
				'value' => wfMsg( 'nss-create-account' )
			) ).
			"</div>\n</form>" 
		);		
	}

	function processData() {
		global $wgRequest, $wgUserProperties;
		if( !$wgRequest->wasPosted() || $wgRequest->getVal('action') != 'submit' )
			return;

		$post = $wgRequest->getValues();
		foreach( $post as $key => $value ) {
			if( substr( $key, 0, 3 ) != 'am-' )
				continue;
			$parts = explode( '-', $key, 3 );
			if( count( $parts ) != 3 )
				continue;

			$username = strtolower( $parts[1] );
			$keyname = strtolower( $parts[2] );
		
			if( !isset( $this->users[$username] ) )
				continue;

			if( !in_array( $keyname, $wgUserProperties ) )
				continue;
			
			$this->users[$username]->set( $keyname, $value );
		}

		foreach( $this->users as $user )
			$user->update();
		return true;
	}
	
	function processCreateAccount() {
		global $wgRequest, $wgUserProperties;
		if( !$wgRequest->wasPosted() || $wgRequest->getVal('action') != 'create' )
			return;

		$options = array();
		
		$post = $wgRequest->getValues();
		foreach( $post as $key => $value ) {
			if( substr( $key, 0, 3 ) != 'am-' )
				continue;
			$parts = explode( '-', $key, 2 );
			if( count( $parts ) != 2 )
				continue;

			$keyname = strtolower( $parts[1] );
			$options[$keyname] = $value;
		}
		if( empty( $options['username'] ) ) {
			$this->mErrors[] = 'noname'; 
			return false;
		}
		$username = $options['username'];
		unset( $options['username'] );
		
		global $wgAuth;
		$password = $wgAuth->createAccount($username, $options);
		
		$user = UserProps::loadFromDb( $username );
		if ( !$user ) {
			$this->mErrors[] = 'nss-db-error';
			return false;
		}
		$this->users[$user->getName()] = $user;
		
		return true;
	}
	
	function showErrors() {
		if ( !$this->mErrors )
			return;
		global $wgOut;
		foreach( $this->mErrors as $error )
			$wgOut->addHTML( 
				Xml::element( 'p',
					array( 'class' => 'error' ),
					wfMsg( $error )
				)."\n"
			);
	}
}

class UserProps {
	static function fetchAllUsers() {
		$users = array();
		$res = self::select();
		while( $row = $res->fetchObject() ) {
			if( !isset( $users[$row->pwd_name] ) )
				$users[$row->pwd_name] = new self( $row->pwd_name, $row->pwd_email );
			$users[$row->pwd_name]->setInternal($row->up_name, $row->up_value);
		}
		$res->free();
		return $users;
	}
	static function loadFromDb( $username ) {
		$res = self::select( $username );
		$row = $res->fetchObject();
		if ( !$row ) 
			return false;
		return new self( $row->pwd_name, $row->pwd_email, $row->pwd_active );
	}
	
	function __construct( $username, $email = null, $active = null ) {
		$this->username = $username;
		$this->props = array();
		$this->email = $email;
		$this->active = $active;
	}
	function getProps() {
		return $this->props;
	}
	function getName() {
		return $this->username;
	}
	function getEmail() {
		return $this->email;
	}
	function setEmail( $email ) {
		$this->email = $email;
	}
	function getActive() {
		return $this->active;
	}
	function setActive( $active ) {
		$this->active = $active; 
	}

	static function select($username = null) {
		global $wgAuth;
		$dbr = $wgAuth->getDB( DB_READ );
		$where = is_null( $username ) ? array() : array( 'pwd_name' => $username );

		return $dbr->select(
			array( 'user_props', 'passwd' ),
			array( 'up_name', 'up_value', 'pwd_name', 'pwd_email', 'pwd_active' ),
			$where, 
			__METHOD__,
			array( 'ORDER BY' => 'pwd_name ASC, up_timestamp ASC' ),
			array( 'passwd' => array( 'RIGHT JOIN', 'pwd_name = up_user' ) )
		);
	}

	function set($name, $value) {
		wfDebug( "{$this->username}: $name => $value\n" );
		$this->props[$name] = $value;
	}
	function setInternal($name, $value) {
		if( is_null( $this->props ) ) {
			$this->props = array();
			$this->old_props = array();
		}
		$this->old_props[$name] = $this->props[$name] = $value;
	}

	function update() {
		$diff = array_diff_assoc($this->props, $this->old_props);
		if( !count( $diff ) ) return;

		
		global $wgAuth;
		$dbw = $wgAuth->getDB( DB_WRITE );
		$timestamp = $dbw->timestamp();

		if( isset( $diff['email'] ) || isset( $diff['active'] ) ) {
			if ( isset( $diff['email'] ) ) $this->email = $diff['email'];
			if ( isset( $diff['active'] ) ) $this->active = $diff['active'];
			$dbw->update( 'passwd', 
				array( 'pwd_email' => $this->email, 'pwd_active' => $this->active ), 
				array( 'pwd_user' => $this->username ),
				__METHOD__
			);
			// Put it into user_props as well for history
		}

		$insert = array();
		foreach( $diff as $key => $value )
			$insert[] = array(
				'up_timestamp' => $timestamp,
				'up_user' => $this->username,
				'up_name' => $key,
				'up_value' => $value,
			);

		$dbw->insert( 'user_props', $insert, __METHOD__ );
	}
}
