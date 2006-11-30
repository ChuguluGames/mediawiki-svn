<?php

class SpecialTranslateEditTools {

	static function addTools( $object ) {
		if( $object->mTitle->getNamespace() == NS_MEDIAWIKI ) {
			$object->editFormTextTop .= self::getUIeditBoxes( $object );
		}
		return true;
	}

	private static function doBox( $msg, $code, $i18nmsg ) {
		static $names = null;
		$names = Language::getLanguageNames();
		if ($msg) {

			$prettyCode = ucfirst(strtolower(str_replace('-', '_', $code)));

			/* Approximate row count */
			$rows = count(explode("\n", $msg)) -1;
			$rows = max(3, min(15, $rows));
		
			return
				wfMsg( $i18nmsg, $names[$code], $prettyCode ) . " " .
				Xml::Element( 'textarea', array( 'rows' => $rows ), $msg );
		}
	}

	private static function getUIEditBoxes( $object ) {
		global $wgLanguageCode, $wgContLanguageCode, $wgContLang;

		$pieces = explode('/', $wgContLang->lcfirst($object->mTitle->getDBkey()), 3);

		# Msg
		$key = $pieces[0];
		if ($pieces[0] === 'monobook.css') { $key = 'Monobook.css'; }
		if ($pieces[0] === 'monobook.js') { $key = 'Monobook.js'; }

		# Language the user is translating to
		if (!isset($pieces[1])) {
			$langCode = $wgContLanguageCode;
		} else {
			$langCode = $pieces[1];
		}

		$msgArray = Language::getMessagesFor( 'en' );
		$boxes = array();
		$boxes[] = self::dobox( $msgArray[$key], 'en', 'translate-edit-message-in' );

		$targetLanguage = Language::factory( $langCode );
		$langFBcode = $targetLanguage->getFallbackLanguage();

		if ( $langFBcode ) {
			$msgArray = Language::getUnmergedMessagesFor($langFBcode);
			$boxes[] = self::dobox( $msgArray[$key], $langFBcode, 'translate-edit-message-in-fb' );
		}

		$msgArray = Language::getUnmergedMessagesFor($langCode);
		$boxes[] = self::dobox( $msgArray[$key], $langCode, 'translate-edit-message-in' );


		return implode("\n\n", $boxes);
	}

}

?>