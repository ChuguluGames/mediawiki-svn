<?php
/**
 * Hooks for Vector extension
 * 
 * @file
 * @ingroup Extensions
 */

class VectorHooks {
	
	/* Protected Static Members */
	
	protected static $features = array(
		'collapsiblenav' => array(
			'preferences' => array(
				'vector-collapsiblenav' => array(
					'type' => 'toggle',
					'label-message' => 'vector-collapsiblenav-preference',
					'section' => 'rendering/advancedrendering',
				),
			),
			'requirements' => array(
				'vector-collapsiblenav' => true,
			),
			'configurations' => array(
				'wgCollapsibleNavBucketTest',
				'wgCollapsibleNavForceNewVersion',
			),
			'modules' => array( 'ext.vector.collapsibleNav' ),
		),
		'collapsibletabs' => array(
			'modules' => array( 'ext.vector.collapsibleTabs' ),
		),
		'editwarning' => array(
			'preferences' => array(
				// Ideally this would be 'vector-editwarning'
				'useeditwarning' => array(
					'type' => 'toggle',
					'label-message' => 'vector-editwarning-preference',
					'section' => 'editing/advancedediting',
				),
			),
			'requirements' => array(
				'useeditwarning' => true,
			),
			'modules' => array( 'ext.vector.editWarning' ),
		),
		'expandablesearch' => array(
			'requirements' => array( 'vector-simplesearch' => true ),
			'modules' => array( 'ext.vector.expandableSearch' ),
		),
		'footercleanup' => array(
			'modules' => array( 'ext.vector.footerCleanup' ),
		),
		'simplesearch' => array(
			'requirements' => array( 'vector-simplesearch' => true, 'disablesuggest' => false ),
			'modules' => array( 'ext.vector.simpleSearch' ),
		),
	);
	
	/* Protected Static Methods */
	
	protected static function isEnabled( $name ) {
		global $wgVectorFeatures, $wgUser;
		
		// Features with global set to true are always enabled
		if ( !isset( $wgVectorFeatures[$name] ) || $wgVectorFeatures[$name]['global'] ) {
			return true;
		}
		// Features with user preference control can have any number of preferences to be specific values to be enabled
		if ( $wgVectorFeatures[$name]['user'] ) {
			if ( isset( self::$features[$name]['requirements'] ) ) {
				foreach ( self::$features[$name]['requirements'] as $requirement => $value ) {
					// Important! We really do want fuzzy evaluation here
					if ( $wgUser->getOption( $requirement ) != $value ) {
						return false;
					}
				}
			}
			return true;
		}
		// Features controlled by $wgVectorFeatures with both global and user set to false are awlways disabled 
		return false;
	}
	
	/* Static Methods */
	
	/**
	 * BeforePageDisplay hook
	 * 
	 * Adds the modules to the page
	 * 
	 * @param $out OutputPage output page
	 * @param $skin Skin current skin
	 */
	public static function beforePageDisplay( $out, $skin ) {
		if ( $skin instanceof SkinVector ) {
			// Add modules for enabled features
			foreach ( self::$features as $name => $feature ) {
				if ( isset( $feature['modules'] ) && self::isEnabled( $name ) ) {
					$out->addModules( $feature['modules'] );
				}
			}
		}
		return true;
	}
	
	/**
	 * GetPreferences hook
	 * 
	 * Adds Vector-releated items to the preferences
	 * 
	 * @param $out User current user
	 * @param $skin array list of default user preference controls
	 */
	public static function getPreferences( $user, &$defaultPreferences ) {
		global $wgVectorFeatures;
		
		foreach ( self::$features as $name => $feature ) {
			if (
				isset( $feature['preferences'] ) &&
				( !isset( $wgVectorFeatures[$name] ) || $wgVectorFeatures[$name]['user'] )
			) {
				foreach ( $feature['preferences'] as $key => $options ) {
					$defaultPreferences[$key] = $options;
				}
			}
		}
		return true;
	}
	
	/**
	 * MakeGlobalVariablesScript hook
	 * 
	 * Adds enabled/disabled switches for Vector modules
	 */
	public static function makeGlobalVariablesScript( &$vars ) {
		global $wgVectorFeatures;
		
		// Build and export old-style wgVectorEnabledModules object for back compat
		$enabledModules = array();
		foreach ( self::$features as $name => $feature ) {
			$enabledModules[$name] = self::isEnabled( $name );
		}
		
		$vars['wgVectorEnabledModules'] = $enabledModules;
		return true;
	}
}
