<?php

/**
 * This special page (Special:WantedProperties) for MediaWiki shows all wanted properties (used but not having a page).
 *
 * @file SMW_SpecialWantedProperties.php
 *
 * @ingroup SMWSpecialPage
 * @ingroup SpecialPage
 * 
 * @author Markus Krötzsch
 * @author Jeroen De Dauw
 */
class SMWSpecialWantedProperties extends SpecialPage {
	
	public function __construct() {
		parent::__construct( 'WantedProperties' );
		smwfLoadExtensionMessages( 'SemanticMediaWiki' );
	}
	
	public function execute( $param ) {
		wfProfileIn( 'smwfDoSpecialWantedProperties (SMW)' );
		
		global $wgOut;
		
		$wgOut->setPageTitle( wfMsg( 'wantedproperties' ) );
		
		$rep = new SMWWantedPropertiesPage();
		
		list( $limit, $offset ) = wfCheckLimits();
		$rep->doQuery( $offset, $limit );
		
		// Ensure locally collected output data is pushed to the output!
		SMWOutputs::commitToOutputPage( $wgOut );
		
		wfProfileOut( 'smwfDoSpecialWantedProperties (SMW)' );	
	}

}

/**
 * This query page shows all wanted properties.
 * 
 * @ingroup SMWSpecialPage
 * @ingroup SpecialPage
 * 
 * @author Markus Krötzsch
 */
class SMWWantedPropertiesPage extends SMWQueryPage {

	function getName() {
		return "WantedProperties";
	}

	function isExpensive() {
		return false; /// disables caching for now
	}

	function isSyndicated() {
		return false; ///TODO: why not?
	}

	function getPageHeader() {
		return '<p>' . wfMsg( 'smw_wantedproperties_docu' ) . "</p><br />\n";
	}

	/**
	 * @param $skin
	 * @param array $result First item is SMWDIProperty, second item is int
	 * 
	 * @return string
	 */
	function formatResult( $skin, $result ) {
		$linker = smwfGetLinker();
		
		if ( $result[0]->isUserDefined() ) {
			$proplink = $linker->makeLinkObj( $result[0]->getDiWikiPage()->getTitle(), htmlspecialchars( $result[0]->getLabel() ), 'action=view' );
		} else {
			$proplink = SMWDataValueFactory::newDataItemValue( $result[0], new SMWDIProperty( '_TYPE' ) )->getLongHTMLText( $linker );
		}
		
		return wfMsgExt( 'smw_wantedproperty_template', array( 'parsemag' ), $proplink, $result[1] );
	}

	function getResults( $requestoptions ) {
		return smwfGetStore()->getWantedPropertiesSpecial( $requestoptions );
	}
    
}
