<?php
/**
 * MediaWiki math extension
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Tomasz Wegrzanowski
 * @author Brion Vibber
 * @copyright © 2002-2011 various MediaWiki contributors
 * @license GPLv2 license; info in main package.
 * @link http://www.mediawiki.org/wiki/Extension:Math Documentation
 * @see https://bugzilla.wikimedia.org/show_bug.cgi?id=14202
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point to MediaWiki.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Math',
	'version' => '1.0',
	'author' => array( 'Tomasz Wegrzanowski', 'Brion Vibber', '...' ),
	'description' => 'Render mathematical formulas between <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code> tags',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Math',
);

/**@{
 * Maths constants
 */
define( 'MW_MATH_PNG',    0 );
define( 'MW_MATH_SIMPLE', 1 );
define( 'MW_MATH_HTML',   2 );
define( 'MW_MATH_SOURCE', 3 );
define( 'MW_MATH_MODERN', 4 );
define( 'MW_MATH_MATHML', 5 );
/**@}*/

/** For back-compat */
$wgUseTeX = true;

/** Location of the texvc binary */
$wgTexvc = dirname( __FILE__ ) . '/math/texvc';
/**
 * Texvc background color
 * use LaTeX color format as used in \special function
 * for transparent background use value 'Transparent' for alpha transparency or
 * 'transparent' for binary transparency.
 */
$wgTexvcBackgroundColor = 'transparent';

/**
 * Normally when generating math images, we double-check that the
 * directories we want to write to exist, and that files that have
 * been generated still exist when we need to bring them up again.
 *
 * This lets us give useful error messages in case of permission
 * problems, and automatically rebuild images that have been lost.
 *
 * On a big site with heavy NFS traffic this can be slow and flaky,
 * so sometimes we want to short-circuit it by setting this to false.
 */
$wgMathCheckFiles = true;

/**
 * The URL path of the math directory. Defaults to "{$wgUploadPath}/math".
 *
 * See http://www.mediawiki.org/wiki/Manual:Enable_TeX for details about how to
 * set up mathematical formula display.
 */
$wgMathPath = false;

/**
 * The filesystem path of the math directory.
 * Defaults to "{$wgUploadDirectory}/math".
 *
 * See http://www.mediawiki.org/wiki/Manual:Enable_TeX for details about how to
 * set up mathematical formula display.
 */
$wgMathDirectory = false;


////////// end of config settings.


$wgExtensionFunctions[] = 'MathHooks::setup';
$wgHooks['ParserFirstCallInit'][] = 'MathHooks::onParserFirstCallInit';
$wgHooks['GetPreferences'][] = 'MathHooks::onGetPreferences';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'MathHooks::onLoadExtensionSchemaUpdates';
$wgHooks['ParserTestTables'][] = 'MathHooks::onParserTestTables';

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['MathHooks'] = $dir . 'Math.hooks.php';
$wgAutoloadClasses['MathRenderer'] = $dir . 'Math.body.php';

$wgExtensionMessagesFiles['Math'] = $dir . 'Math.i18n.php';

$wgParserTestFiles[] = $dir . 'mathParserTests.txt';