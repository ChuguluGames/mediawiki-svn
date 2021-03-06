<?php
/**
 * Aliases for Special:GoogleNewsSitemap
 *
 * @file
 * @ingroup Extensions
 */

$specialPageAliases = array();

/** English (English) */
$specialPageAliases['en'] = array(
	'GoogleNewsSitemap' => array( 'NewsFeed', 'GoogleNewsSitemap' ),
);

/** Arabic (العربية) */
$specialPageAliases['ar'] = array(
	'GoogleNewsSitemap' => array( 'خريطة_موقع_أخبار_جوجل' ),
);

/** Egyptian Spoken Arabic (مصرى) */
$specialPageAliases['arz'] = array(
	'GoogleNewsSitemap' => array( 'خريطة_سايت_اخبار_جوجل' ),
);

/** Persian (فارسی) */
$specialPageAliases['fa'] = array(
	'GoogleNewsSitemap' => array( 'نقشه_وب‌گاه_گوگل_نیوز', 'خوراک_اخبار' ),
);

/** Haitian (Kreyòl ayisyen) */
$specialPageAliases['ht'] = array(
	'GoogleNewsSitemap' => array( 'KatSitGoogleNews' ),
);

/** Hungarian (Magyar) */
$specialPageAliases['hu'] = array(
	'GoogleNewsSitemap' => array( 'Google_Hírek-oldaltérkép' ),
);

/** Interlingua (Interlingua) */
$specialPageAliases['ia'] = array(
	'GoogleNewsSitemap' => array( 'Mappa_de_sito_Google_News' ),
);

/** Indonesian (Bahasa Indonesia) */
$specialPageAliases['id'] = array(
	'GoogleNewsSitemap' => array( 'Peta_situs_Google_News', 'PetaSitusGoogleNews' ),
);

/** Japanese (日本語) */
$specialPageAliases['ja'] = array(
	'GoogleNewsSitemap' => array( 'Googleニュースサイトマップ' ),
);

/** Ladino (Ladino) */
$specialPageAliases['lad'] = array(
	'GoogleNewsSitemap' => array( 'Mapa_de_sitio_de_GoogleJhabberes' ),
);

/** Macedonian (Македонски) */
$specialPageAliases['mk'] = array(
	'GoogleNewsSitemap' => array( 'ПланНаМрежМестоGoogleNews' ),
);

/** Malayalam (മലയാളം) */
$specialPageAliases['ml'] = array(
	'GoogleNewsSitemap' => array( 'ഗൂഗിൾ‌‌വാർത്തകൾസൈറ്റ്മാപ്പ്' ),
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬) */
$specialPageAliases['no'] = array(
	'GoogleNewsSitemap' => array( 'Google_nyheter-sidekart' ),
);

/** Polish (Polski) */
$specialPageAliases['pl'] = array(
	'GoogleNewsSitemap' => array( 'Mapa_strony_dla_Google_News' ),
);

/** Turkish (Türkçe) */
$specialPageAliases['tr'] = array(
	'GoogleNewsSitemap' => array( 'GoogleNewsSiteHaritası' ),
);

/**
 * For backwards compatibility with MediaWiki 1.15 and earlier.
 */
$aliases =& $specialPageAliases;