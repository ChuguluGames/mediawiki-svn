<?php

/**
 * API module to delete surveys.
 *
 * @since 0.1
 *
 * @file ApiDeleteSurvey.php
 * @ingroup Survey
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiDeleteSurvey extends ApiBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}
	
	public function execute() {
		global $wgUser;
		
		if ( !$wgUser->isAllowed( 'surveyadmin' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}			
		
		$params = $this->extractRequestParams();
		
	}

	public function getAllowedParams() {
		return array(
		);
	}
	
	public function getParamDescription() {
		return array(
		);
	}
	
	public function getDescription() {
		return array(
			''
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}

	protected function getExamples() {
		return array(
			'api.php?action=deletesurvey&',
		);
	}	
	
	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}		
	
}
