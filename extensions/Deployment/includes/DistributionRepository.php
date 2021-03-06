<?php

/**
 * Repository class for interaction with repositories provided by
 * the Distirbution extension and the MediaWiki API.
 * 
 * @since 1.17
 * 
 * @file DistributionRepository.php
 * @ingroup Deployment
 * 
 * @author Jeroen De Dauw
 */
class DistributionRepository extends PackageRepository {
	
	/**
	 * Constructor.
	 * 
	 * @param $location String: path to the api of the MediaWiki install providing the repository.
	 * 
	 * @since 1.17
	 */
	public function __construct( $location ) {
		parent::__construct( $location );
	}
	
	/**
	 * @see PackageRepository::findExtenions
	 * 
	 * @since 1.17
	 * 
	 * @param $filterType String
	 * @param $filterValue String
	 * 
	 * @return array
	 */	
	public function findExtenions( $filterType, $filterValue ) {
		global $wgRepositoryPackageStates;
		
		$filterType = urlencode( $filterType );
		$filterValue = urlencode( $filterValue );
		$states = urlencode( implode( '|', $wgRepositoryPackageStates ) );
		
		$response = Http::get(
			"$this->location?format=json&action=query&list=extensions&dstfilter=$filterType&dstvalue=$filterValue&dststate=$states",
			'default',
			array( 'sslVerifyHost' => true, 'sslVerifyCert' => true )
		);
		
		$extensions = array();
		
		if ( $response !== false ) {
			$response = FormatJson::decode( $response );

			if ( property_exists( $response, 'query' ) && property_exists( $response->query, 'extensions' ) ) {
				$extensions = $response->query->extensions;
			}
		}

		return $extensions;
	}
	
	/**
	 * @see PackageRepository::extensionHasUpdate
	 * 
	 * @since 1.17
	 */		
	public function extensionHasUpdate( $extensionName, $currentVersion ) {
		global $wgRepositoryPackageStates;
		
		$extensionName = urlencode( $extensionName );
		$currentVersion = urlencode( $currentVersion );
		$states = urlencode( implode( '|', $wgRepositoryPackageStates ) );
		
		$response = Http::get(
			"$this->location?format=json&action=updates&extensions=$extensionName;$currentVersion&state=$states",
			'default',
			array( 'sslVerifyHost' => true, 'sslVerifyCert' => true )
		);
		
		if ( $response === false ) {
			return false;
		}
		
		$response = FormatJson::decode( $response );
		
		if ( property_exists( $response, 'extensions' ) && property_exists( $response->extensions, $extensionName ) ) {
			return $response->extensions->$extensionName;
		}
		
		return false;
	}
	
	/**
	 * @see PackageRepository::coreHasUpdate
	 * 
	 * @since 1.17
	 */			
	public function coreHasUpdate( $currentVersion ) {
		global $wgRepositoryPackageStates;
		
		$currentVersion = urlencode( $currentVersion );	
		$states = urlencode( implode( '|', $wgRepositoryPackageStates ) );
		
		$response = Http::get(
			"$this->location?format=json&action=updates&mediawiki=$currentVersion&state=$states",
			'default',
			array( 'sslVerifyHost' => true, 'sslVerifyCert' => true )
		);
		
		if ( $response === false ) {
			return false;
		}
		
		$response = FormatJson::decode( $response );
		
		if ( property_exists( $response, 'mediawiki' ) ) {
			return $response->mediawiki;
		}
		
		return false;
	}
	
	/**
	 * @see PackageRepository::coreHasUpdate
	 * 
	 * @since 1.17
	 */		
	public function getLatestCoreVersion() {
		// TODO: use $states
		//global $wgRepositoryPackageStates;
		//$states = urlencode( implode( '|', $wgRepositoryPackageStates ) );
		
		$response = Http::get(
			"$this->location?format=json&action=mwreleases",
			'default',
			array( 'sslVerifyHost' => true, 'sslVerifyCert' => true )
		);
		
		if ( $response === false ) {
			return false;
		}

		$response = FormatJson::decode( $response );
		
		$current = false;
		
		if ( property_exists( $response, 'mwreleases' ) ) {
			foreach ( $response->mwreleases as $release ) {
				if ( property_exists( $release, 'current' ) && property_exists( $release, 'version') ) {
					$current = $release->version;
				}
			}
		}
		
		return $current;
	}
	
	/**
	 * @see PackageRepository::installationHasUpdates
	 * 
	 * @since 1.17
	 */			
	public function installationHasUpdates( $coreVersion, array $extensions ) {
		global $wgRepositoryPackageStates;
		
		$coreVersion = urlencode( $coreVersion );
		$states = urlencode( implode( '|', $wgRepositoryPackageStates ) );
		
		$extensionParams = array();
		
		if ( count( $extensions ) > 0 ) {
			foreach ( $extensions as $extensionName => $extensionVersion ) {
				$extensionParams[] = urlencode( $extensionName ) . ';' . urlencode( $extensionVersion );
			}
			
			$extensionParams = '&extensions=' . urlencode( implode( '|', $extensionParams ) );			
		}

		$response = Http::get(
			"$this->location?format=json&action=updates&mediawiki=$coreVersion{$extensionParams}&state=$states",
			'default',
			array( 'sslVerifyHost' => true, 'sslVerifyCert' => true )
		);
		
		if ( $response === false ) {
			return false;
		}
		
		$response = FormatJson::decode( $response );
		
		$updates = array();
		
		if ( $response ) {
			if ( property_exists( $response, 'mediawiki' ) ) {
				$updates['MediaWiki'] = $response->mediawiki;
			}
			
			if ( property_exists( $response, 'extensions' ) ) {
				foreach ( $extensions as $extensionName => $extensionVersion ) {
					if ( property_exists( $response->extensions, $extensionName ) ) {
						$updates[$extensionName] = $response->extensions->$extensionName;
					}				
				}
			}			
		}

		return count( $updates ) > 0 ? $updates : false;
	}
	
}
