<?php
/*
 (c) Aaron Schulz, Joerg Baach, 2007-2008 GPL
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 http://www.gnu.org/copyleft/gpl.html
*/

if( !defined('MEDIAWIKI') ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

# This messes with dump HTML...
if( defined('MW_HTML_FOR_DUMP') ) {
	return;
}

# Quality -> Sighted (default)
if( !defined('FLAGGED_VIS_QUALITY') )
	define('FLAGGED_VIS_QUALITY',0);
# No precedence
if( !defined('FLAGGED_VIS_LATEST') )
	define('FLAGGED_VIS_LATEST',1);
# Pristine -> Quality -> Sighted
if( !defined('FLAGGED_VIS_PRISTINE') )
	define('FLAGGED_VIS_PRISTINE',2);
	
# SELECT parameters...
if( !defined('FR_FOR_UPDATE') )
	define('FR_FOR_UPDATE',1);
if( !defined('FR_MASTER') )
	define('FR_MASTER',2);
if( !defined('FR_TEXT') )
	define('FR_TEXT',3);

# Level constants...
if( !defined('FR_SIGHTED') )
	define('FR_SIGHTED',0);
if( !defined('FR_QUALITY') )
	define('FR_QUALITY',1);
if( !defined('FR_PRISTINE') )
	define('FR_PRISTINE',2);

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Flagged Revisions',
	'author'         => array( 'Aaron Schulz', 'Joerg Baach' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:FlaggedRevs',
	'descriptionmsg' => 'flaggedrevs-desc',
);

#########
# IMPORTANT:
# When configuring globals, add them to localsettings.php and edit them THERE

# This will only distinguish "sigted", "quality", and unreviewed
# A small icon will show in the upper right hand corner
$wgSimpleFlaggedRevsUI = true;
# Add stable/draft revision tabs. May be redundant due to the tags.
# If you have an open wiki, with the simple UI, you may want to enable these.
$wgFlaggedRevTabs = true;
# For non-user visitors, only show tags/icons for *unreviewed* pages
$wgFlaggedRevsLowProfile = true;

# Allowed namespaces of reviewable pages
$wgFlaggedRevsNamespaces = array( NS_MAIN, NS_FILE, NS_TEMPLATE );
# Patrollable namespaces (overridden by reviewable namespaces)
$wgFlaggedRevsPatrolNamespaces = array();

# Pages exempt from reviewing
$wgFlaggedRevsWhitelist = array();
# $wgFlaggedRevsWhitelist = array( 'Main_Page' );

# Do flagged revs override the default view?
$wgFlaggedRevsOverride = true;
# Are pages only reviewable if the stable shows by default?
$wgFlaggedRevsReviewForDefault = false;
# Hide flaggedrevs UI unless the stable shows by default?
# Pages are still reviewable from diffs/special pages.
$wgFlaggedRevsUIForDefault = false;
# Do quality revisions show instead of sighted if present by default?
# Set to 2 to make "pristine" versions override quality revisions.
$wgFlaggedRevsPrecedence = 1;
# Revision tagging can slow development...
# For example, the main user base may become complacent, perhaps treat flagged
# pages as "done", or just be too lazy to click "current". We may just want non-user
# visitors to see reviewed pages by default.
# Below are groups that see the current revision by default.
$wgFlaggedRevsExceptions = array( 'user' );

# Can users make comments that will show up below flagged revisions?
$wgFlaggedRevsComments = false;
# Redirect users out to review changes since stable version on save?
$wgReviewChangesAfterEdit = true;
# Allow auto-review edits directly to the stable version by reviewers?
# 1 to allow auto-sighting; 2 for auto-quality; 3 for auto-pristine
$wgFlaggedRevsAutoReview = 1;
# Auto-review new pages with the minimal level?
$wgFlaggedRevsAutoReviewNew = true;

# When setting up new dimensions or levels, you will need to add some
# MediaWiki messages for the UI to show properly; any sysop can do this.
# Define the tags we can use to rate an article, number of levels,
# and set the minimum level to have it become a "quality" or "pristine" version.
$wgFlaggedRevTags = array(
	'accuracy' => array( 'levels' => 3, 'quality' => 2, 'pristine' => 4 ),
	'depth'    => array( 'levels' => 3, 'quality' => 1, 'pristine' => 4 ),
	'style'    => array( 'levels' => 3, 'quality' => 1, 'pristine' => 4 ),
);
# Who can set what flags to what level? (use -1 or 0 for not at all)
# This maps rights to the highest reviewable level for each tag.
# Users cannot lower tags from a level they can't set
# Users with 'validate' can do anything regardless
# This is mainly for custom, less experienced, groups
$wgFlagRestrictions = array(
	'accuracy' => array( 'review' => 1 ),
	'depth'	   => array( 'review' => 2 ),
	'style'	   => array( 'review' => 3 ),
);
# Use this to make levels of flags only appear if the page configured to
# select the stable version in a certain way. Array of tags=>level=>config.
$wgFlagAvailability = array();
/* (example usage)
$wgFlagAvailability = array( 
	'style' => array( 1=>FLAGGED_VIS_LATEST, 2=>FLAGGED_VIS_QUALITY )
);
*/

# At what level of review do patrol marks go away?
# 0 => sighted; 1 => quality; 2 => pristine
$wgFlaggedRevsPatrolLevel = 0;

# Restriction levels for auto-review right at Stabilization page
$wgFlaggedRevsRestrictionLevels = array( '', 'sysop' );

# Please set these as something different. Any text will do, though it probably
# shouldn't be very short (less secure) or very long (waste of resources).
# There must be two codes, and only the first two are checked.
$wgReviewCodes = array();

# URL location for flaggedrevs.css and flaggedrevs.js
# Use a literal $wgScriptPath as a placeholder for the runtime value of $wgScriptPath
$wgFlaggedRevsStylePath = '$wgScriptPath/extensions/FlaggedRevs';

# Define our basic reviewer class
$wgGroupPermissions['editor']['review']          = true;
$wgGroupPermissions['editor']['autoreview']      = true;
$wgGroupPermissions['editor']['autoconfirmed']   = true;
$wgGroupPermissions['editor']['patrol']          = true;
$wgGroupPermissions['editor']['autopatrol']      = true;
$wgGroupPermissions['editor']['unreviewedpages'] = true;

# Defines extra rights for advanced reviewer class
$wgGroupPermissions['reviewer']['validate'] = true;
# Let this stand alone just in case...
$wgGroupPermissions['reviewer']['review'] = true;

# Sysops have their edits autoreviewed
$wgGroupPermissions['sysop']['autoreview'] = true;
# Stable version selection and default page revision selection can be set per page.
$wgGroupPermissions['sysop']['stablesettings'] = true;
# Sysops can always move stable pages
$wgGroupPermissions['sysop']['movestable'] = true;

# Try to avoid flood by having autoconfirmed user edits to non-reviewable
# namespaces autopatrolled.
$wgGroupPermissions['autoconfirmed']['autopatrol'] = true;

# Implicit autoreview group
$wgGroupPermissions['autoreview']['autoreview'] = true;

# Bots are granted autoreview via hooks, mark in rights 
# array so that it shows up in sp:ListGroupRights...
$wgGroupPermissions['bot']['autoreview'] = true;

# Define when users get automatically promoted to Editors. Set as false to disable.
# 'spacing' and 'benchmarks' require edits to be spread out. Users must have X (benchmark)
# edits Y (spacing) days apart.
$wgFlaggedRevsAutopromote = array(
	'days'	              => 60, # days since registration
	'edits'	              => 250, # total edit count
	'excludeDeleted'      => true, # exclude deleted edits from 'edits' count above?
	'spacing'	          => 3, # spacing of edit intervals
	'benchmarks'          => 15, # how many edit intervals are needed?
	'recentContentEdits'  => 0, # $wgContentNamespaces edits in recent changes
	// Either totalContentEdits reqs OR totalCheckedEdits requirements needed
	'totalContentEdits'   => 300, # $wgContentNamespaces edits OR...
	'totalCheckedEdits'   => 200, # ...Edits before the stable version of pages
	'uniqueContentPages'  => 12, # $wgContentNamespaces unique pages edited
	'editComments'        => 50, # how many edit comments used?
	'userpageBytes'       => 0, # userpage is needed? with what min size?
	'uniqueIPAddress'     => false, # If $wgPutIPinRC is true, users sharing IPs won't be promoted
	'neverBlocked'        => true, # Can users that were blocked be promoted?
	'maxRevertedEdits'    => 5, # Max edits the user could have had rolled back?
);

# Define when users get to have their own edits auto-reviewed
# This can be used for newer, semi-trusted users to improve workflow.
$wgFlaggedRevsAutoconfirm = false;
/* (example usage)
$wgFlaggedRevsAutoconfirm = array(
	'days'	              => 30, # days since registration
	'edits'	              => 50, # total edit count
	'spacing'	          => 3, # spacing of edit intervals
	'benchmarks'          => 7, # how many edit intervals are needed?
	// Either totalContentEdits reqs OR totalCheckedEdits requirements needed
	'totalContentEdits'   => 150, # $wgContentNamespaces edits OR...
	'totalCheckedEdits'   => 50, # ...Edits before the stable version of pages
	'uniqueContentPages'  => 8, # $wgContentNamespaces unique pages edited
	'editComments'        => 20, # how many edit comments used?
	'email'	              => false, # user must be emailconfirmed?
	'neverBlocked'        => true, # Can users that were blocked be promoted?
);
*/

# Special:Userrights settings
## Basic rights for Sysops
$wgAddGroups['sysop'][] = 'editor';
$wgRemoveGroups['sysop'][] = 'editor';
## Extra ones for Bureaucrats
## Add UI page rights just in case we have non-sysop bcrats
$wgAddGroups['bureaucrat'][] = 'reviewer';
$wgRemoveGroups['bureaucrat'][] = 'reviewer';

# Show reviews in recentchanges? Disabled by default, often spammy...
$wgFlaggedRevsLogInRC = false;

# How far the logs for overseeing quality revisions and depreciations go
$wgFlaggedRevsOversightAge = 30 * 24 * 3600;

# Flagged revisions are always visible to users with rights below.
# Use '*' for non-user accounts.
$wgFlaggedRevsVisible = array();
# If $wgFlaggedRevsVisible is populated, it is applied to talk pages too
$wgFlaggedRevsTalkVisible = true;

$wgFlaggedRevsStatsAge = 2 * 3600; // 2 hours

# We may have templates that do not have stable version. Given situational
# inclusion of templates (such as parser functions that select template
# X or Y depending), there may also be no revision ID for each template
# pointed to by the metadata of how the article was when it was reviewed.
# An example would be an article that selects a template based on time.
# The template to be selected will change, and the metadata only points
# to the reviewed revision ID of the old template. In such cases, we can s
# select the current (unreviewed) revision.
$wgUseCurrentTemplates = true;

# We may have file pages that do not have stable version. Given situational
# inclusion of templates/files (such as a random featured image template), 
# there may also be no sha-1/time for each file pointed to by the metadata 
# of how the article was when it was reviewed. In such cases, we can select 
# the current (unreviewed) revision.
$wgUseCurrentImages = true;

# End of configuration variables.
#########

# Lets some users access the review UI and set some flags
$wgAvailableRights[] = 'review';
$wgAvailableRights[] = 'validate'; # Let some users set higher settings
$wgAvailableRights[] = 'autoreview';
$wgAvailableRights[] = 'patrolmarks';
$wgAvailableRights[] = 'unreviewedpages';
$wgAvailableRights[] = 'movestable';
$wgAvailableRights[] = 'stablesettings';

# Bump this number every time you change flaggedrevs.css/flaggedrevs.js
$wgFlaggedRevStyleVersion = 60;

$wgExtensionFunctions[] = 'efLoadFlaggedRevs';

$dir = dirname(__FILE__) . '/';
$langDir = $dir . 'language/';

$wgSvgGraphDir = $dir . 'svggraph';
$wgPHPlotDir = $dir . 'phplot-5.0.5';

$wgAutoloadClasses['FlaggedRevs'] = $dir.'FlaggedRevs.class.php';
$wgAutoloadClasses['FlaggedRevsHooks'] = $dir.'FlaggedRevs.hooks.php';
$wgAutoloadClasses['FRCacheUpdate'] = $dir.'FRCacheUpdate.php';
$wgAutoloadClasses['FRCacheUpdateJob'] = $dir.'FRCacheUpdate.php';

# Special case cache invalidations
$wgJobClasses['flaggedrevs_CacheUpdate'] = 'FRCacheUpdateJob';

$wgExtensionMessagesFiles['FlaggedRevs'] = $langDir . 'FlaggedRevs.i18n.php';
$wgExtensionAliasesFiles['FlaggedRevs'] = $langDir . 'FlaggedRevs.alias.php';

# Load general UI
$wgAutoloadClasses['FlaggedRevsXML'] = $dir . 'FlaggedRevsXML.php';
# Load context article stuff
$wgAutoloadClasses['FlaggedArticle'] = $dir . 'FlaggedArticle.php';
# Load FlaggedRevision object class
$wgAutoloadClasses['FlaggedRevision'] = $dir . 'FlaggedRevision.php';

# Load review UI
$wgAutoloadClasses['RevisionReview'] = $dir . 'specialpages/RevisionReview_body.php';

# Load stableversions UI
$wgAutoloadClasses['StableVersions'] = $dir . 'specialpages/StableVersions_body.php';
$wgExtensionMessagesFiles['StableVersions'] = $langDir . 'StableVersions.i18n.php';
# Stable version config
$wgAutoloadClasses['Stabilization'] = $dir . 'specialpages/Stabilization_body.php';
$wgExtensionMessagesFiles['Stabilization'] = $langDir . 'Stabilization.i18n.php';
# Load unreviewed pages list
$wgAutoloadClasses['UnreviewedPages'] = $dir . 'specialpages/UnreviewedPages_body.php';
$wgExtensionMessagesFiles['UnreviewedPages'] = $langDir . 'UnreviewedPages.i18n.php';
$wgSpecialPageGroups['UnreviewedPages'] = 'quality';
# Load "in need of re-review" pages list
$wgAutoloadClasses['OldReviewedPages'] = $dir . 'specialpages/OldReviewedPages_body.php';
$wgExtensionMessagesFiles['OldReviewedPages'] = $langDir . 'OldReviewedPages.i18n.php';
$wgSpecialPageGroups['OldReviewedPages'] = 'quality';
# Load "suspicious changes" pages list
$wgAutoloadClasses['ProblemChanges'] = $dir . 'specialpages/ProblemChanges_body.php';
$wgExtensionMessagesFiles['ProblemChanges'] = $langDir . 'ProblemChanges.i18n.php';
$wgSpecialPageGroups['ProblemChanges'] = 'quality';
# Load reviewed pages list
$wgAutoloadClasses['ReviewedPages'] = $dir . 'specialpages/ReviewedPages_body.php';
$wgExtensionMessagesFiles['ReviewedPages'] = $langDir . 'ReviewedPages.i18n.php';
$wgSpecialPageGroups['ReviewedPages'] = 'quality';
# Load stable pages list
$wgAutoloadClasses['StablePages'] = $dir . 'specialpages/StablePages_body.php';
$wgExtensionMessagesFiles['StablePages'] = $langDir . 'StablePages.i18n.php';
$wgSpecialPageGroups['StablePages'] = 'quality';
# Load unstable pages list
$wgAutoloadClasses['UnstablePages'] = $dir . 'specialpages/UnstablePages_body.php';
$wgExtensionMessagesFiles['UnstablePages'] = $langDir . 'UnstablePages.i18n.php';
$wgSpecialPageGroups['UnstablePages'] = 'quality';
# To oversee quality revisions
$wgAutoloadClasses['QualityOversight'] = $dir . 'specialpages/QualityOversight_body.php';
$wgExtensionMessagesFiles['QualityOversight'] = $langDir . 'QualityOversight.i18n.php';
$wgSpecialPageGroups['QualityOversight'] = 'quality';
# Statistics
$wgAutoloadClasses['ValidationStatistics'] = $dir . 'specialpages/ValidationStatistics_body.php';
$wgExtensionMessagesFiles['ValidationStatistics'] = $langDir . 'ValidationStatistics.i18n.php';
$wgSpecialPageGroups['ValidationStatistics'] = 'quality';
# API Modules
$wgAutoloadClasses['FlaggedRevsApiHooks'] = $dir.'api/FlaggedRevsApi.hooks.php';
# OldReviewedPages for API
$wgAutoloadClasses['ApiQueryOldreviewedpages'] = $dir . 'api/ApiQueryOldreviewedpages.php';
$wgAPIListModules['oldreviewedpages'] = 'ApiQueryOldreviewedpages';
# UnreviewedPages for API
$wgAutoloadClasses['ApiQueryUnreviewedpages'] = $dir . 'api/ApiQueryUnreviewedpages.php';
$wgAPIListModules['unreviewedpages'] = 'ApiQueryUnreviewedpages';
# ReviewedPages for API
$wgAutoloadClasses['ApiQueryReviewedpages'] = $dir . 'api/ApiQueryReviewedpages.php';
$wgAPIListModules['reviewedpages'] = 'ApiQueryReviewedpages';
# Flag meta-data for pages
$wgAutoloadClasses['ApiQueryFlagged'] = $dir . 'api/ApiQueryFlagged.php';
$wgAPIPropModules['flagged'] = 'ApiQueryFlagged';

$wgAutoloadClasses['ApiReview'] = $dir.'api/ApiReview.php';
$wgAPIModules['review'] = 'ApiReview';

######### Hook attachments #########
# Autopromote Editors
$wgHooks['ArticleSaveComplete'][] = 'FlaggedRevsHooks::maybeMakeEditor';
# Adds table link references to include ones from the stable version
$wgHooks['LinksUpdate'][] = 'FlaggedRevsHooks::extraLinksUpdate';
# Clear dead config rows
$wgHooks['ArticleDeleteComplete'][] = 'FlaggedRevsHooks::onArticleDelete';
$wgHooks['ArticleRevisionVisiblitySet'][] = 'FlaggedRevsHooks::onRevisionDelete';
$wgHooks['TitleMoveComplete'][] = 'FlaggedRevsHooks::onTitleMoveComplete';
# Check on undelete/merge for changes to stable version
$wgHooks['ArticleMergeComplete'][] = 'FlaggedRevsHooks::updateFromMerge';
$wgHooks['ArticleRevisionUndeleted'][] = 'FlaggedRevsHooks::updateFromRestore';
# Parser hooks, selects the desired images/templates
$wgHooks['ParserClearState'][] = 'FlaggedRevsHooks::parserAddFields';
$wgHooks['BeforeGalleryFindFile'][] = 'FlaggedRevsHooks::galleryFindStableFileTime';
$wgHooks['BeforeParserFetchTemplateAndtitle'][] = 'FlaggedRevsHooks::parserFetchStableTemplate';
$wgHooks['BeforeParserMakeImageLinkObj'][] = 'FlaggedRevsHooks::parserMakeStableFileLink';
# Additional parser versioning
$wgHooks['ParserAfterTidy'][] = 'FlaggedRevsHooks::parserInjectTimestamps';
$wgHooks['OutputPageParserOutput'][] = 'FlaggedRevsHooks::outputInjectTimestamps';
# Auto-reviewing
$wgHooks['RecentChange_save'][] = 'FlaggedRevsHooks::autoMarkPatrolled';
$wgHooks['NewRevisionFromEditComplete'][] = 'FlaggedRevsHooks::maybeMakeEditReviewed';
# Determine what pages can be moved and patrolled
$wgHooks['userCan'][] = 'FlaggedRevsHooks::onUserCan';
# Log parameter
$wgHooks['LogLine'][] = 'FlaggedRevsHooks::reviewLogLine';
# Disable auto-promotion for demoted users
$wgHooks['UserRights'][] = 'FlaggedRevsHooks::recordDemote';
# Local user account preference
$wgHooks['GetPreferences'][] = 'FlaggedRevsHooks::onGetPreferences';
# Show unreviewed pages links
$wgHooks['CategoryPageView'][] = 'FlaggedRevsHooks::onCategoryPageView';
# Backlog notice
$wgHooks['SiteNoticeAfter'][] = 'FlaggedRevsHooks::addBacklogNotice';

# Override current revision, add patrol links, set cache...
$wgHooks['ArticleViewHeader'][] = 'FlaggedRevsHooks::onArticleViewHeader';
$wgHooks['ImagePageFindFile'][] = 'FlaggedRevsHooks::imagePageFindFile';
# Override redirect behavior...
$wgHooks['InitializeArticleMaybeRedirect'][] = 'FlaggedRevsHooks::overrideRedirect';
# Set tabs and permalink
$wgHooks['SkinTemplateTabs'][] = 'FlaggedRevsHooks::setActionTabs';
# Set navigation
$wgHooks['SkinTemplateNavigation'][] = 'FlaggedRevsHooks::setNavigation';
# Add tags to edit view
$wgHooks['EditPage::showEditForm:initial'][] = 'FlaggedRevsHooks::addToEditView';
# Add review form and visiblity settings link
$wgHooks['SkinAfterContent'][] = 'FlaggedRevsHooks::onSkinAfterContent';
# Mark items in page history
$wgHooks['PageHistoryPager::getQueryInfo'][] = 'FlaggedRevsHooks::addToHistQuery';
$wgHooks['PageHistoryLineEnding'][] = 'FlaggedRevsHooks::addToHistLine';
$wgHooks['LocalFile::getHistory'][] = 'FlaggedRevsHooks::addToFileHistQuery';
$wgHooks['ImagePageFileHistoryLine'][] = 'FlaggedRevsHooks::addToFileHistLine';
# Mark items in RC
$wgHooks['SpecialRecentChangesQuery'][] = 'FlaggedRevsHooks::addToRCQuery';
$wgHooks['SpecialWatchlistQuery'][] = 'FlaggedRevsHooks::addToWatchlistQuery';
$wgHooks['ChangesListInsertArticleLink'][] = 'FlaggedRevsHooks::addToChangeListLine';
# Mark items in user contribs
$wgHooks['ContribsPager::getQueryInfo'][] = 'FlaggedRevsHooks::addToContribsQuery';
$wgHooks['ContributionsLineEnding'][] = 'FlaggedRevsHooks::addToContribsLine';
# Page review on edit
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'FlaggedRevsHooks::injectReviewDiffURLParams';
$wgHooks['DiffViewHeader'][] = 'FlaggedRevsHooks::onDiffViewHeader';
# Autoreview stuff
$wgHooks['EditPage::showEditForm:fields'][] = 'FlaggedRevsHooks::addRevisionIDField';
$wgHooks['EditPageBeforeEditChecks'][] = 'FlaggedRevsHooks::addReviewCheck';
# User stats
$wgHooks['ArticleRollbackComplete'][] = 'FlaggedRevsHooks::incrementRollbacks';
$wgHooks['NewRevisionFromEditComplete'][] = 'FlaggedRevsHooks::incrementReverts';
# Add diff url param alias
$wgHooks['NewDifferenceEngine'][] = 'FlaggedRevsHooks::checkDiffUrl';
# Check if a page is being reviewed
$wgHooks['MediaWikiPerformAction'][] = 'FlaggedRevsHooks::markUnderReview';
# Null edit review via checkbox
$wgHooks['ArticleSaveComplete'][] = 'FlaggedRevsHooks::maybeNullEditReview';

# Add CSS/JS as needed
$wgHooks['BeforePageDisplay'][] = 'FlaggedRevsHooks::injectStyleAndJS';

# Cache updates
$wgHooks['HTMLCacheUpdate::doUpdate'][] = 'FlaggedRevsHooks::doCacheUpdate';

# Duplicate flagged* tables in parserTests.php
$wgHooks['ParserTestTables'][] = 'FlaggedRevsHooks::onParserTestTables';

# Add flagging data to ApiQueryRevisions
$wgHooks['APIGetAllowedParams'][] = 'FlaggedRevsApiHooks::addApiRevisionParams';
$wgHooks['APIQueryAfterExecute'][] = 'FlaggedRevsApiHooks::addApiRevisionData';

# Actually register special pages
$wgHooks['SpecialPage_initList'][] = 'efLoadFlaggedRevsSpecialPages';
# Special auto-promote
$wgHooks['GetAutoPromoteGroups'][] = 'FlaggedRevsHooks::checkAutoPromote';

# Stable dump hook
$wgHooks['WikiExporter::dumpStableQuery'][] = 'FlaggedRevsHooks::stableDumpQuery';
#########

function efLoadFlaggedRevs() {
	global $wgUseRCPatrol, $wgFlaggedRevsNamespaces, $wgFlaggedRevsVisible;
	# If patrolling is already on, then we know that it 
	# was intended to have all namespaces patrollable.
	if( $wgUseRCPatrol ) {
		global $wgFlaggedRevsPatrolNamespaces, $wgCanonicalNamespaceNames;
		$wgFlaggedRevsPatrolNamespaces = array_keys( $wgCanonicalNamespaceNames );
	}
	# Use RC Patrolling to check for vandalism
	# When revisions are flagged, they count as patrolled
	if( !empty($wgFlaggedRevsNamespaces) ) {
		$wgUseRCPatrol = true;
	}
	# Visibility - experimental
	if( !empty($wgFlaggedRevsVisible) ) {
		global $wgHooks;
		$wgHooks['userCan'][] = 'FlaggedRevsHooks::userCanView';
	}
	# Don't show autoreview group everywhere
	global $wgImplicitGroups;
	$wgImplicitGroups[] = 'autoreview';
}

/* 
 * Register FlaggedRevs special pages as needed. 
 * Also sets $wgSpecialPages just to be consistent.
 */
function efLoadFlaggedRevsSpecialPages( &$list ) {
	global $wgSpecialPages, $wgFlaggedRevsNamespaces;
	if( !empty($wgFlaggedRevsNamespaces) ) {
		$list['RevisionReview'] = $wgSpecialPages['RevisionReview'] = 'RevisionReview';
		$list['StableVersions'] = $wgSpecialPages['StableVersions'] = 'StableVersions';
		$list['Stabilization'] = $wgSpecialPages['Stabilization'] = 'Stabilization';
		$list['UnreviewedPages'] = $wgSpecialPages['UnreviewedPages'] = 'UnreviewedPages';
		$list['OldReviewedPages'] = $wgSpecialPages['OldReviewedPages'] = 'OldReviewedPages';
		$list['ProblemChanges'] = $wgSpecialPages['ProblemChanges'] = 'ProblemChanges';
		$list['ReviewedPages'] = $wgSpecialPages['ReviewedPages'] = 'ReviewedPages';
		$list['StablePages'] = $wgSpecialPages['StablePages'] = 'StablePages';
		$list['UnstablePages'] = $wgSpecialPages['UnstablePages'] = 'UnstablePages';
		$list['QualityOversight'] = $wgSpecialPages['QualityOversight'] = 'QualityOversight';
		$list['ValidationStatistics'] = $wgSpecialPages['ValidationStatistics'] = 'ValidationStatistics';
	}
	return true;
}

# Add review log
$wgLogTypes[] = 'review';
$wgFilterLogTypes['review'] = true;
$wgLogNames['review'] = 'review-logpage';
$wgLogHeaders['review'] = 'review-logpagetext';
# Various actions are used for log filtering ...
$wgLogActions['review/approve']  = 'review-logentry-app'; // sighted (again)
$wgLogActions['review/approve2']  = 'review-logentry-app'; // quality (again)
$wgLogActions['review/approve-i']  = 'review-logentry-app'; // sighted (first time)
$wgLogActions['review/approve2-i']  = 'review-logentry-app'; // quality (first time)
$wgLogActions['review/approve-a']  = 'review-logentry-app'; // sighted (auto)
$wgLogActions['review/approve-ia']  = 'review-logentry-app'; // sighted (initial & auto)
$wgLogActions['review/unapprove'] = 'review-logentry-dis'; // was sighted
$wgLogActions['review/unapprove2'] = 'review-logentry-dis'; // was quality

# Add stable version log
$wgLogTypes[] = 'stable';
$wgLogNames['stable'] = 'stable-logpage';
$wgLogHeaders['stable'] = 'stable-logpagetext';
$wgLogActions['stable/config'] = 'stable-logentry';
$wgLogActions['stable/reset'] = 'stable-logentry2';

# AJAX functions
$wgAjaxExportList[] = 'RevisionReview::AjaxReview';

// Defaults for prefs
$wgDefaultUserOptions['flaggedrevssimpleui'] = (int)$wgSimpleFlaggedRevsUI;
$wgDefaultUserOptions['flaggedrevsstable'] = false;
$wgDefaultUserOptions['flaggedrevseditdiffs'] = true;

# Cache update
$wgSpecialPageCacheUpdates[] = 'efFlaggedRevsUnreviewedPagesUpdate';

function efFlaggedRevsUnreviewedPagesUpdate() {
	$base = dirname(__FILE__);
	require_once( "$base/maintenance/updateQueryCache.inc" );
	update_flaggedrevs_querycache(); 
	require_once( "$base/maintenance/updateStats.inc" );
	update_flaggedrevs_stats();
}

# B/C ...
$wgLogActions['rights/erevoke']  = 'rights-editor-revoke';

# Schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efFlaggedRevsSchemaUpdates';

function efFlaggedRevsSchemaUpdates() {
	global $wgDBtype, $wgExtNewFields, $wgExtPGNewFields, $wgExtNewIndexes, $wgExtNewTables;
	$base = dirname(__FILE__);
	if( $wgDBtype == 'mysql' ) {
		$wgExtNewTables[] = array( 'flaggedrevs', "$base/FlaggedRevs.sql" ); // Initial install tables
		$wgExtNewFields[] = array( 'flaggedpage_config', 'fpc_expiry', "$base/archives/patch-fpc_expiry.sql" );
		$wgExtNewIndexes[] = array('flaggedpage_config', 'fpc_expiry', "$base/archives/patch-expiry-index.sql" );
		$wgExtNewTables[] = array( 'flaggedrevs_promote', "$base/archives/patch-flaggedrevs_promote.sql" );
		$wgExtNewTables[] = array( 'flaggedpages', "$base/archives/patch-flaggedpages.sql" );
		$wgExtNewFields[] = array( 'flaggedrevs', 'fr_img_name', "$base/archives/patch-fr_img_name.sql" );
		$wgExtNewTables[] = array( 'flaggedrevs_tracking', "$base/archives/patch-flaggedrevs_tracking.sql" );
		$wgExtNewFields[] = array( 'flaggedpages', 'fp_pending_since', "$base/archives/patch-fp_pending_since.sql" );
		$wgExtNewFields[] = array( 'flaggedpage_config', 'fpc_level', "$base/archives/patch-fpc_level.sql" );
		$wgExtNewTables[] = array( 'flaggedpage_pending', "$base/archives/patch-flaggedpage_pending.sql" );
	} elseif( $wgDBtype == 'postgres' ) {
		$wgExtNewTables[] = array( 'flaggedrevs', "$base/FlaggedRevs.pg.sql" ); // Initial install tables
		$wgExtPGNewFields[] = array('flaggedpage_config', 'fpc_expiry', "TIMESTAMPTZ NULL" );
		$wgExtNewIndexes[] = array('flaggedpage_config', 'fpc_expiry', "$base/postgres/patch-expiry-index.sql" );
		$wgExtNewTables[] = array( 'flaggedrevs_promote', "$base/postgres/patch-flaggedrevs_promote.sql" );
		$wgExtNewTables[] = array( 'flaggedpages', "$base/postgres/patch-flaggedpages.sql" );
		$wgExtNewIndexes[] = array('flaggedrevs', 'key_timestamp', "$base/postgres/patch-fr_img_name.sql" );
		$wgExtNewTables[] = array( 'flaggedrevs_tracking', "$base/postgres/patch-flaggedrevs_tracking.sql" );
		$wgExtNewIndexes[] = array('flaggedpages', 'fp_pending_since', "$base/postgres/patch-fp_pending_since.sql" );
		$wgExtPGNewFields[] = array('flaggedpage_config', 'fpc_level', "TEXT NULL" );
		$wgExtNewTables[] = array( 'flaggedpage_pending', "$base/postgres/patch-flaggedpage_pending.sql" );
	}
	return true;
}
