<?php

/**
 * Copyright (c) 2008 Brion Vibber <brion@pobox.com>
 * GPLv2
 */


/*

What do I need out of SVN?

1) Find out what revisions exist
2) Get id/author/timestamp/notice basics
  3) base path helps if available
4) get list of affected files
5) get diffs



http://pecl.php.net/package/svn

*/


$dir = dirname( __FILE__ );

$wgAutoloadClasses['CodeRepository'] = "$dir/CodeRepository.php";
$wgAutoloadClasses['CodeRevision'] = "$dir/CodeRevision.php";
$wgAutoloadClasses['SpecialCode'] = "$dir/SpecialCode.php";
$wgAutoloadClasses['SubversionAdaptor'] = "$dir/Subversion.php";

$wgExtensionMessagesFiles['CodeReview'] = "$dir/CodeReview.i18n.php";

$wgSpecialPages['Code'] = 'SpecialCode';
