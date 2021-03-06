<?php
/**
 * Setup for ShortUrl extension, a special page that provides redirects to articles
 * via their page IDs
 *
 * @file
 * @ingroup Extensions
 * @author Yuvi Panda, http://yuvi.in
 * @copyright © 2011 Yuvaraj Pandian (yuvipanda@yuvi.in)
 * @licence Modified BSD License
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ShortUrl',
	'version' => '1.0',
	'author' => 'Yuvi Panda',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ShortUrl',
	'descriptionmsg' => 'shorturl-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ShortUrl'] = $dir . 'ShortUrl.i18n.php';
$wgExtensionAliasesFiles['ShortUrl'] = $dir . 'ShortUrl.alias.php';

$wgAutoloadClasses['ShortUrlUtils'] = $dir . 'ShortUrl.utils.php';
$wgAutoloadClasses['ShortUrlHooks'] = $dir . 'ShortUrl.hooks.php';
$wgAutoloadClasses['SpecialShortUrl'] = $dir . 'SpecialShortUrl.php';
$wgSpecialPages['ShortUrl'] = 'SpecialShortUrl';

$wgHooks['SkinTemplateToolboxEnd'][] = 'ShortUrlHooks::addToolboxLink';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ShortUrlHooks::setupSchema';
$wgHooks['OutputPageBeforeHTML'][] = 'ShortUrlHooks::onOutputPageBeforeHTML';

$wgResourceModules['ext.shortUrl'] = array(
	'scripts' => 'js/ext.shortUrl.js',
	'styles' => 'css/ext.shortUrl.css',
	'dependencies' => array( 'jquery' ),
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'ShortUrl'
);

// Configuration
$wgShortUrlPrefix = null; 
