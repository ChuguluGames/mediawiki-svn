<?php
/**
 * Get the location of the correct version of a MediaWiki web
 * entry-point file given environmental variables such as the server name.
 *
 * This also has some other effects:
 * (a) Sets the $IP global variable (path to MediaWiki)
 * (b) Sets the MW_INSTALL_PATH environmental variable
 * (c) Changes PHP's current directory to the directory of this file.
 *
 * @param string File path (relative to MediaWiki dir)
 * @return string Absolute file path with proper MW location
 */
function getMediaWiki( $file ) {
	global $IP;

	$scriptName = @$_SERVER['SCRIPT_NAME'];
	$serverName = @$_SERVER['SERVER_NAME'];
	$documentRoot = @$_SERVER['DOCUMENT_ROOT'];

	require( dirname( __FILE__ ) . '/../wmf-config/MWMultiVersion.php' );
	# Upload URL hit (to upload.wikimedia.org rather than wiki of origin)...
	if ( $scriptName === '/w/thumb.php' && $serverName === 'upload.wikimedia.org' ) {
		$multiVersion = MWMultiVersion::initializeForUploadWiki( $_SERVER['PATH_INFO'] );
	# Regular URL hit (wiki of origin)...
	} else {
		$multiVersion = MWMultiVersion::initializeForWiki( $serverName, $documentRoot );
	}

	# Get the MediaWiki version running on this wiki...
	$version = $multiVersion->getVersion();

	# MW_SECURE_HOST set from secure gateway?
	$secure = getenv( 'MW_SECURE_HOST' );
	$host = $secure ? $secure : $_SERVER['HTTP_HOST'];

	# Get the correct MediaWiki path based on this version...
	if ( $host === 'test.wikipedia.org' && !$secure &&
		!preg_match( '!thumb\.php!', $_SERVER['REQUEST_URI'] ) )
	{
		define( 'TESTWIKI', 1 );
		# Test wiki mostly runs off the version of MediaWiki on /home.
		# As horrible hack for NFS-less image scalers, use regular docroot for thumbs?
		$IP = getHomeMediaWikiDir() . "/$version";
	} else {
		$IP = getLocalMediaWikiDir() . "/$version";
	}

	chdir( $IP );
	putenv( "MW_INSTALL_PATH=$IP" );

	return "$IP/$file";
}

/**
 * Get the location of the correct version of a MediaWiki CLI
 * entry-point file given the --wiki parameter passed in.
 *
 * This also has some other effects:
 * (a) Sets the $IP global variable (path to MediaWiki)
 * (b) Sets the MW_INSTALL_PATH environmental variable
 * (c) Changes PHP's current directory to the directory of this file.
 *
 * @param string File path (relative to MediaWiki dir)
 * @return string Absolute file path with proper MW location
 */
function getMediaWikiCli( $file ) {
	global $IP;

	require( dirname( __FILE__ ) . '/../wmf-config/MWMultiVersion.php' );
	$multiVersion = MWMultiVersion::initializeForMaintenance();

	# Get the MediaWiki version running on this wiki...
	$version = $multiVersion->getVersion();

	# Get the correct MediaWiki path based on this version...
	if ( $multiVersion->getDatabase() === 'testwiki' ) {
		define( 'TESTWIKI', 1 );
		$IP = getHomeMediaWikiDir() . "/$version";
	} else {
		$IP = getLocalMediaWikiDir() . "/$version";
	}

	chdir( $IP );
	putenv( "MW_INSTALL_PATH=$IP" );

	return "$IP/$file";
}

function getLocalMediaWikiDir() {
	return "/usr/local/apache/common";
}

function getHomeMediaWikiDir() {
	return "/home/wikipedia/common";
}
