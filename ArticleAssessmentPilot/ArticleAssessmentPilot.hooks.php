<?php

/**
 * Hooks for ArticleAssessmentPilot
 *
 * @file
 * @ingroup Extensions
 */
class ArticleAssessmentPilotHooks {
	private static $styleFiles = array(
		array( 'src' => 'css/ArticleAssessment.css', 'version' => 1 ),
	);

	private static $scriptFiles = array(
		array( 'src' => 'js/ArticleAssessment.js', 'version' => 2 ),
		array( 'src' => 'js/jquery.cookie.js', 'version' => 1 ),
		array( 'src' => 'js/jquery.tipsy.js', 'version' => 1 ),
		array( 'src' => 'js/jquery.stars.js', 'version' => 1 ),
	);

	private static $messages = array();
	private static $scripts = array();

	/* Static Functions */
	public static function schema() {
		global $wgExtNewTables;

		$wgExtNewTables[] = array(
			'article_assessment',
			dirname( __FILE__ ) . '/ArticleAssessmentPilot.sql'
		);

		return true;
	}
	
	public static function addVariables( &$vars ) {
		global $wgArticleAssessmentJUIPath, $wgExtensionAssetsPath;
		$vars['wgArticleAssessmentJUIPath'] = $wgArticleAssessmentJUIPath ? $wgArticleAssessmentJUIPath :
			"$wgExtensionAssetsPath/ArticleAssessmentPilot/js/jui.combined.min.js";
		return true;
	}

	/**
	 * Make sure the tables exist for parser tests
	 * @param $tables
	 * @return bool
	 */
	public static function parserTestTables( &$tables ) {
		$tables[] = 'article_assessment';
		$tables[] = 'article_assessment_pages';
		$tables[] = 'article_assessment_ratings';
		return true;
	}

	public static function addResources( $out ) {
		
		$title = $out->getTitle();

		// Chances are we only want to be rating Mainspace, right?
		if ( $title->getNamespace() !== NS_MAIN ) {
			return true;
		}

		global $wgRequest;

		// Only show for view actions.
		if ( $wgRequest->getVal( 'action' ) !== null && $wgRequest->getVal( 'action' ) !== 'view' ) {
			return true;
		}

		global $wgArticleAssessmentCategory;

		// check if this page should have the form
		if ( $wgArticleAssessmentCategory === ''
				|| !self::isInCategory( $title->getArticleId(), $wgArticleAssessmentCategory ) ) {
			return true;
		}

		global $wgExtensionAssetsPath;

		foreach ( self::$scriptFiles as $script ) {
			$out->addScriptFile( $wgExtensionAssetsPath .
				"/ArticleAssessmentPilot/{$script['src']}", $script['version']
			);
		}

		global $wgArticleAssessmentNeedJUICSS;
		if ( $wgArticleAssessmentNeedJUICSS ) {
			self::$styleFiles[] = array( 'src' => 'css/jquery-ui-1.7.2.css', 'version' => '1.7.2y' );
		}
		foreach ( self::$styleFiles as $style ) {
			$out->addExtensionStyle( $wgExtensionAssetsPath .
				"/ArticleAssessmentPilot/{$style['src']}?{$style['version']}"
			);
		}

		// Transforms messages into javascript object members
		self::$messages = array(
			'articleassessment',
			'articleassessment-desc',
			'articleassessment-yourfeedback',
			'articleassessment-pleaserate',
			'articleassessment-submit',
			'articleassessment-rating-wellsourced',
			'articleassessment-rating-neutrality',
			'articleassessment-rating-completeness',
			'articleassessment-rating-readability',
			'articleassessment-rating-wellsourced-tooltip',
			'articleassessment-rating-neutrality-tooltip',
			'articleassessment-rating-completeness-tooltip',
			'articleassessment-rating-readability-tooltip',
			'articleassessment-error',
			'articleassessment-thanks',
			'articleassessment-articlerating',
			'articleassessment-featurefeedback',
			'articleassessment-noratings',
			'articleassessment-stalemessage-revisioncount',
			'articleassessment-stalemessage-norevisioncount',
			'articleassessment-results-show',
			'articleassessment-results-hide',
			'articleassessment-survey-title',
			'articleassessment-survey-thanks',
		);

		foreach ( self::$messages as $i => $message ) {
			// TODO: Not parsing or even preprocessing the messages would be more efficient,
			// but we can't do that until we have such nice things as JS-side {{PLURAL}}
			// Should be OK for now in a limited deployment scenario
			$escapedMessageValue = Xml::escapeJsString( wfMsgExt( $message, array( 'parseinline' ) ) );
			$escapedMessageKey = Xml::escapeJsString( $message );
			self::$messages[$i] =
				"'{$escapedMessageKey}':'{$escapedMessageValue}'";
		}
		// Add javascript to document
		if ( count( self::$messages ) > 0 ) {
			$out->addScript( Html::inlineScript(
				'$j.ArticleAssessment.fn.addMessages({' . implode( ',', self::$messages ) . '});'
			) );
		}

		return true;
	}

	/**
	 * Returns whether an article is in the specified category
	 *
	 * @param $articleId Integer: Article ID
	 * @param $category String: The category name (without Category: prefix, with underscores)
	 *
	 * @return bool
	 */
	private static function isInCategory( $articleId, $category ) {
		$dbr = wfGetDB( DB_SLAVE );
		return (bool)$dbr->selectRow( 'categorylinks', '1',
			array(
				'cl_from' => $articleId,
				'cl_to' => $category,
			),
			__METHOD__
		);
	}
}
