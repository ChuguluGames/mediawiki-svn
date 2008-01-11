<?php
/**
 * SpecialOpenID.body.php -- Superclass for all 
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * Copyright 2008 by Evan Prodromou (http://evan.prodromou.name/)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@prodromou.name>
 * @addtogroup Extensions
 */

# FIXME: for login(); figure out better way to share this code
# between Login and Convert

require_once("Auth/OpenID/Consumer.php");
require_once("Auth/OpenID/SReg.php");
require_once("Auth/OpenID/FileStore.php");

class SpecialOpenID extends SpecialPage {

	function getOpenIDStore($storeType, $prefix, $options) {
	    global $wgOut;

	    switch ($storeType) {
		 case 'memcached':
		 case 'memc':
			return new OpenID_MemcStore($prefix);

		 case 'file':
			# Auto-create path if it doesn't exist
			if (!is_dir($options['path'])) {
				if (!mkdir($options['path'], 0770, true)) {
					$wgOut->errorPage('openidconfigerror', 'openidconfigerrortext');
					return NULL;
				}
			}
			return new Auth_OpenID_FileStore($options['path']);

		 default:
			$wgOut->errorPage('openidconfigerror', 'openidconfigerrortext');
	    }
	}

	function xriBase($xri) {
		if (substr($xri, 0, 6) == 'xri://') {
			return substr($xri, 6);
		} else {
			return $xri;
		}
	}

	function xriToUrl($xri) {
		return 'http://xri.net/' . OpenIDXriBase($xri);
	}

	function OpenIDToUrl($openid) {
		/* ID is either an URL already or an i-name */
        if (Services_Yadis_identifierScheme($openid) == 'XRI') {
			return OpenIDXriToUrl($openid);
		} else {
			return $openid;
		}
	}

	function LocalizedPageName(&$specialPageArray, $code) {
		
		# The localized title of the special page is among the messages of the extension:
		SpecialOpenID::loadMessages();
		$text = wfMsg('openidlogin');

		# Convert from title in text form to DBKey and put it into the alias array:
		$title = Title::newFromText($text);
		$specialPageArray['Form'][] = $title->getDBKey();
		
		return true;
	}
	
	function loadMessages() {
		static $messagesLoaded = false;
		global $wgMessageCache;

		if ( $messagesLoaded ) return true;

		require( dirname( __FILE__ ) . '/OpenID.i18n.php' );
		foreach ( $OpenIDMessages as $lang => $langMessages ) {
			$wgMessageCache->addMessages( $langMessages, $lang );
		}

		$messagesLoaded = true;

		return true;
	}
	
	function interwikiExpand($openid_url) {
		# try to make it into a title object
		$nt = Title::newFromText($openid_url);
		# If it's got an iw, return that
		if (!is_null($nt) && !is_null($nt->getInterwiki())
			&& strlen($nt->getInterwiki()) > 0) {
			return $nt->getFullUrl();
		} else {
			return $openid_url;
		}
	}
	
	function getUserUrl($user) {
		$openid_url = null;

		if (isset($user) && $user->getId() != 0) {
			global $wgSharedDB, $wgDBprefix;
			if (isset($wgSharedDB)) {
				$tableName = "`${wgSharedDB}`.${wgDBprefix}user_openid";
			} else {
				$tableName = 'user_openid';
			}

			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->select(array($tableName),
								array('uoi_openid'),
								array('uoi_user' => $user->getId()),
								'OpenIDGetUserUrl');

			# This should return 0 or 1 result, since user is unique
			# in the table.

			while ($res && $row = $dbr->fetchObject($res)) {
				$openid_url = $row->uoi_openid;
			}
			$dbr->freeResult($res);
		}
		return $openid_url;
	}

	# Login, Finish
	
	function getConsumer() {
		global $wgOpenIDConsumerStoreType, $wgOpenIDConsumerStorePath;

		$store = $this->getOpenIDStore($wgOpenIDConsumerStoreType,
									   'consumer',
									   array('path' => $wgOpenIDConsumerStorePath));

		return new Auth_OpenID_Consumer($store);
	}

	function fullUrl($title) {
		$nt = Title::makeTitleSafe(NS_SPECIAL, $title);
		if (isset($nt)) {
			return $nt->getFullURL();
		} else {
			return NULL;
		}
	}
	
	function canLogin($openid_url) {

		global $wgOpenIDConsumerDenyByDefault, $wgOpenIDConsumerAllow, $wgOpenIDConsumerDeny;

		if ($this->isLocalUrl($openid_url)) {
			return false;
		}

		if ($wgOpenIDConsumerDenyByDefault) {
			$canLogin = false;
			foreach ($wgOpenIDConsumerAllow as $allow) {
				if (preg_match($allow, $openid_url)) {
					wfDebug("OpenID: $openid_url matched allow pattern $allow.\n");
					$canLogin = true;
					foreach ($wgOpenIDConsumerDeny as $deny) {
						if (preg_match($deny, $openid_url)) {
							wfDebug("OpenID: $openid_url matched deny pattern $deny.\n");
							$canLogin = false;
							break;
						}
					}
					break;
				}
			}
		} else {
			$canLogin = true;
			foreach ($wgOpenIDConsumerDeny as $deny) {
				if (preg_match($deny, $openid_url)) {
					wfDebug("OpenID: $openid_url matched deny pattern $deny.\n");
					$canLogin = false;
					foreach ($wgOpenIDConsumerAllow as $allow) {
						if (preg_match($allow, $openid_url)) {
							wfDebug("OpenID: $openid_url matched allow pattern $allow.\n");
							$canLogin = true;
							break;
						}
					}
					break;
				}
			}
		}
		return $canLogin;
	}
	
	function isLocalUrl($url) {

		global $wgServer, $wgArticlePath;

		$pattern = $wgServer . $wgArticlePath;
		$pattern = str_replace('$1', '(.*)', $pattern);
		$pattern = str_replace('?', '\?', $pattern);

		return preg_match('|^' . $pattern . '$|', $url);
	}
	
	# Find the user with the given openid, if any

	function getUser($openid) {
		global $wgSharedDB, $wgDBprefix;

		if (isset($wgSharedDB)) {
			$tableName = "`$wgSharedDB`.${wgDBprefix}user_openid";
		} else {
			$tableName = 'user_openid';
		}

		$dbr =& wfGetDB( DB_SLAVE );
		$id = $dbr->selectField($tableName, 'uoi_user',
								array('uoi_openid' => $openid));
		if ($id) {
			$name = User::whoIs($id);
			return User::newFromName($name);
		} else {
			return NULL;
		}
	}
	function login($openid_url, $finish_page = 'OpenIDFinish') {

		global $wgUser, $wgTrustRoot, $wgOut;

		# If it's an interwiki link, expand it

		$openid_url = $this->interwikiExpand($openid_url);

		# Check if the URL is allowed

		if (!$this->canLogin($openid_url)) {
			$wgOut->errorpage('openidpermission', 'openidpermissiontext');
			return;
		}

		$sk = $wgUser->getSkin();

		if (isset($wgTrustRoot)) {
			$trust_root = $wgTrustRoot;
		} else {
			global $wgArticlePath, $wgServer;
			$root_article = str_replace('$1', '', $wgArticlePath);
			$trust_root = $wgServer . $root_article;
		}

		$consumer = $this->getConsumer();

		if (!$consumer) {
			$wgOut->errorpage('openiderror', 'openiderrortext');
			return;
		}

		# Make sure the user has a session!

		global $wgSessionStarted;

		if (!$wgSessionStarted) {
			$wgUser->SetupSession();
		}

		$auth_request = $consumer->begin($openid_url);

		// Handle failure status return values.
		if (!$auth_request) {
			$wgOut->errorpage('openiderror', 'openiderrortext');
			return;
		}

		# Check the processed URLs, too

		$endpoint = $auth_request->endpoint;

		if (isset($endpoint)) {
			# Check if the URL is allowed

			if (isset($endpoint->identity_url) && !$this->canLogin($endpoint->identity_url)) {
				$wgOut->errorpage('openidpermission', 'openidpermissiontext');
				return;
			}

			if (isset($endpoint->delegate) && !$this->canLogin($endpoint->delegate)) {
				$wgOut->errorpage('openidpermission', 'openidpermissiontext');
				return;
			}
		}

		$sreg_request = Auth_OpenID_SRegRequest::build(
													   // Required
													   array(),
													   // Optional
													   array('nickname','email',
															 'fullname','language','timezone'));

		if ($sreg_request) {
			$auth_request->addExtension($sreg_request);
		}
		
		$process_url = $this->fullUrl($finish_page);

		if ($auth_request->shouldSendRedirect()) {
			$redirect_url = $auth_request->redirectURL($trust_root,
													   $process_url);
			if (Auth_OpenID::isFailure($redirect_url)) {
				displayError("Could not redirect to server: " . $redirect_url->message);
			} else {
				# OK, now go
				$wgOut->redirect($redirect_url);
			}
		} else {
			// Generate form markup and render it.
			$form_id = 'openid_message';
			$form_html = $auth_request->formMarkup($trust_root, $process_url,
												   false, array('id' => $form_id));
			
			// Display an error if the form markup couldn't be generated;
			// otherwise, render the HTML.
			if (Auth_OpenID::isFailure($form_html)) {
				displayError("Could not redirect to server: " . $form_html->message);
			} else {
				$page_contents = array(
									   "<html><head><title>",
									   "OpenID transaction in progress",
									   "</title></head>",
									   "<body onload='document.getElementById(\"".$form_id."\").submit()'>",
									   $form_html,
									   "</body></html>");
				$wgOut->disable();
				print implode("\n", $page_contents);
			}
		}
	}
}
