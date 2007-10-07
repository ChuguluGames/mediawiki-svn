<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point\n" );
}

# This is a simple example of a special page module
# Given a string in UTF-8, it converts it to HTML entities suitable for 
# an ISO 8859-1 web page.

global $wgAvailableRights, $wgGroupPermissions;
$wgAvailableRights[] = 'findspam';
$wgGroupPermissions['sysop']['findspam'] = true;

$wgSpecialPages['FindSpam'] = 'FindSpamPage';
$wgAutoloadClasses['FindSpamPage'] = dirname(__FILE__) . '/FindSpam_body.php';
 
$wgExtensionCredits['specialpage'][] = array(
        'name' => 'FindSpam',
        'author' => 'Tim Starling',
        'description' => 'Adds a special page that allows to find recently added spam.'
);

