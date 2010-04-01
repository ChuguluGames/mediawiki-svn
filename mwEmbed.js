// Add support for html5 / mwEmbed elements to IE ( must come before js code ) 
// For discussion and comments, see: http://remysharp.com/2009/01/07/html5-enabling-script/
/*@cc_on'video source itext playlist'.replace(/\w+/g,function(n){document.createElement(n)})@*/

/**
 * ~mwEmbed ~
 * For details see: http://www.mediawiki.org/wiki/MwEmbed
 *
 * All MediaWiki code is released under the GPL2.
 * also see: http://svn.wikimedia.org/viewvc/mediawiki/trunk/phase3/COPYING?view=markup
 *
 * @author Michael Dale ( mdale at wikimedia.org )
 * @author and many others, see svn log for details
 *
 * mwEmbed uses the following libraries: 
 *
 * jQuery: 
 * http://jquery.com/ & jquery.ui
 *
 * mw.parseUri:
 * http://stevenlevithan.com/demo/parseuri/js/
 *
 */

/*
* Setup the mw global: 
*/
if ( !window['mw'] ) {
	window['mw'] = { }
}

/*
* Set the mwEmbedVersion
*/
var MW_EMBED_VERSION = '1.1e';

/**
* The global mw object:
*/
( function( mw ) {
	// The version of mwEmbed
	mw.version = MW_EMBED_VERSION
	
	// List valid skins here:
	mw.valid_skins = [ 'mvpcf', 'kskin' ];		
		
	// Storage variable for loaded style sheet keys	
	mw.style = { };
	
	/**
	* Configuration System:  	
	*/	
		
	// Local scope configuration var:
	var mwConfig = { };
	
	// Stores global callbacks for script-loader loading
	var mwLoadDoneCB = { };
	
	//Local scope mwUserConfig var. Stores user configuration 
	var mwUserConfig = { };
	
	/**
	* Setter for configuration values
	*
	* @param [Mixed] name Name of configuration value
	*	{Object} Will iderate through each key and call setConfig
	* 	{String} Will set configuration by string name to value
	* @param {String} value Value of configuration name 
	*/
	mw.setConfig = function ( name, value ) {
		if( typeof name == 'object' ) {
			for( var i in name ) {
				mw.setConfig( i, name[ i ] );
			}
			return ;
		}
		mwConfig[ name ] = value;
	}	
	
	/**
	* Set a default config value 
	* Will only update configuration if no value is present
	* @param [Mixed] name 
	*	{Object} Will iderate through each key and call setDefaultConfig
	* 	{String} Will set configuration by string name to value
	* @param [Mixed] value Set configuration name to value
	*/
	mw.setDefaultConfig = function( name, value ) {	
		if( typeof name == 'object' ) {
			for( var i in name ) {
				mw.setDefaultConfig( i, name[ i ] ); 
			}
			return ;
		}	
		// Name is a string update the config directly	
		if( ! mwConfig[ name ] ) {
			mwConfig[ name ] = value;
		}
	}
	
	/**
	* Getter for configuration values
	*
	* @param {String} name of configuration value to get
	* @return {Mixed} value of configuration key
	* 	returns "false" if key not found
	*/
	mw.getConfig = function ( name ) {
		if( mwConfig[ name ] )
			return mwConfig[ name ];
		return false;
	}

	/**
	* Loads the mwUserConfig from a cookie.
	* 
	* Modules that want to use "User Config" should call
	* this setup function in their moduleLoader code. 
	*
	* For performance interfaces should load '$j.cookie' & 'JSON' 
	*  in their grouped load request
	*
	* By abstracting user preference we could eventually integrate 
	*  a persistent per-account preference system on the server.
	*
	* @parma {Function} callback Function to be called once userPrefrences are loaded 
	*/
	var setupUserConfigFlag = false;
	mw.setupUserConfig = function( callback ) {	
		if( setupUserConfigFlag ) {
			if( callback ) 
				callback();
		}
		// Do Setup user config: 		
		mw.load( [ '$j.cookie', 'JSON' ], function() {
			if( $j.cookie( 'mwUserConfig' ) ) {
				mwUserConfig = JSON.parse( $j.cookie( 'mwUserConfig' ) );
			}
			mw.log( 'mw: ' +  $j.cookie( 'mwUserConfig' ) );
			for(var i in mwUserConfig ) {
				mw.log( 'i: ' + i + ' ' + mwUserConfig[ i ] ) ;
			}
			//debugger;
			
			setupUserConfigFlag = true;
			if( callback ) 
				callback();				
		});				
	}

	/**
	* Save a user configuration var to a cookie & local global variable
	* Loads the cookie plugin if not already loaded
	*
	* @param {String} name Name of user configuration value
	* @param {String} value Value of configuration name 	
	*/
	mw.setUserConfig = function ( name, value, cookieOptions ) {
		if( ! setupUserConfigFlag ) { 
			mw.log( "Error: userConfig not setup" );
			return false; 		
		}		
		// Update local value
		mwUserConfig[ name ] = value;
		
		// Update the cookie ( '$j.cookie' & 'JSON' should already be loaded )			
		$j.cookie( 'mwUserConfig', JSON.stringify( mwUserConfig ) );
	}
	
	/**
	* Save a user configuration var to a cookie & local global variable
	*
	* @param {String} name Name of user configuration value
	* @return 
	*	value of the configuration name
	* 	false if the configuration name could not be found
	*/	
	mw.getUserConfig = function ( name ) {
		if( mwUserConfig[ name ] )
			return mwUserConfig[ name ];
		return false;
	}

	/**
	* Language classes mw.lang
	*
	* Localized Language support attempts to mirror some of the functionality of Language.php in MediaWiki
	* It contains methods for loading and transforming msg text
	*
	*/
	mw.lang = { };
	
	/**
	* Setup the lang object
	*/
	var messageCache = { };
	var gRuleSet = { };

	/**
	* mw.addMessages function
	* Loads a set of json messages into the messegeCache object.
	*
	* @param {JSON} msgSet The set of msgs to be loaded
	*/
	mw.addMessages = function( msgSet ) {
		for ( var i in msgSet ) {
			messageCache[ i ] = msgSet[i];
		}
	}
	
	/**
	 * Returns a transformed msg string
	 *
	 * it take a msg key and array of replacement values of form
	 * $1, $2 and does relevant msgkey transformation returning
	 * the user msg.
	 *
	 * @param {String} msgKey The msg key as set by mw.addMessages
	 * @param {Mixed} args  A string|jQuery Object or array of string|jQuery Objects
	 *
	 * extra paramaters are appended to the args array as numbered replacements
	 *
	 * @return string
	 */
	mw.getMsg = function( msgKey , args ) {		
		
		// Check for missing message key
		if ( ! messageCache[ msgKey ] ){
			return '&lt;' + msgKey + '&gt;';
		}				
		// Check if we need to do args replacements: 
		if( typeof args != 'undefined' ) {
			
			// Make arg into an array if its not already an array
			if ( typeof args == 'string' 
				|| typeof args == 'number'
				|| args instanceof jQuery) 
			{
				args = [ args ];
			}
			
			// Put any extra arguments into the args array
			var extraArgs = $j.makeArray( arguments );
			for(var i=2; i < extraArgs.length; i ++ ){		
				args.push(  extraArgs[ i ] );
			}
			var ms =  mw.lang.msgReplaceArgs( messageCache[ msgKey ], args );
		}else{
			var ms = messageCache[ msgKey ];
		}
		
		// A quick check to see if we need to send the msg to the 'parser'
		if ( ms.indexOf( '{{' ) === -1 && ms.indexOf( '[' ) === -1 ) {									
			return ms;	
		}
					
		// Send the msg key through the parser
		var pObj = mw.parser( ms );
		
		// Return the transformed msg
		return pObj.getHTML();
	}
	
	/**
	* Swap in an array of values for $1, $2, $n for a given msg key 
	*
	* @param string msgKey The msg key to lookup
	* @param [Array] args  An array of string or jquery objects to be swapped in
	* @return string
	*/
	mw.lang.msgReplaceArgs = function( message , args ) {		
		// Replace Values
		for ( var v = 0; v < args.length; v++ ) {				
			if( typeof args[v] == 'undefined' ) {
				continue;
			}				
			var replaceValue =  args[ v ];
			
			// Convert number if applicable
			if( parseInt( replaceValue ) == replaceValue ) {
				replaceValue = mw.lang.convertNumber( replaceValue );
			}
			
			// Message test replace arguments start at 1 instead of zero:
			var rep = new RegExp( '\\$' + ( parseInt( v ) + 1 ), 'g' );			
			// Check if we got passed in a jQuery object:			
			if( replaceValue instanceof jQuery) {				
				message = message.replace( rep, $j('<div />').append( replaceValue ).html() );
			} else {
				// Assume replaceValue is a string
				message = message.replace( rep, replaceValue );
			}				
		}		
		return message;
	}

	/**
	* Get msg content without transformation
	*
	* @returns string The msg key without transforming it
	*/
	mw.lang.msgNoTrans = function( key ) {
		if ( messageCache[ key ] )
			return messageCache[ key ]

		// Missing key placeholder
		return '&lt;' + key + '&gt;';
	}
	
	/**
	* Add Supported Magic Words to parser
	*/
	// Set the setupflag to false:
	mw.lang.doneSetup = false;
	mw.lang.magicSetup = function() {
		if ( !mw.lang.doneSetup ) {
			mw.addTemplateTransform ( {
				'PLURAL' : mw.lang.procPLURAL,
				'GENDER' : mw.lang.procGENDER
			} )

			mw.lang.doneSetup = true;
		}

	}
	
	/**
	 * List of all languages mediaWiki supports ( Avoid an api call to get this same info )
	 * http://commons.wikimedia.org/w/api.php?action=query&meta=siteinfo&siprop=languages&format=jsonfm
	 */
	mw.lang.names = {
		"aa" : "Qaf\u00e1r af",
		"ab" : "\u0410\u04a7\u0441\u0443\u0430",
		"ace" : "Ac\u00e8h",
		"af" : "Afrikaans",
		"ak" : "Akan",
		"aln" : "Geg\u00eb",
		"als" : "Alemannisch",
		"am" : "\u12a0\u121b\u122d\u129b",
		"an" : "Aragon\u00e9s",
		"ang" : "Anglo-Saxon",
		"ar" : "\u0627\u0644\u0639\u0631\u0628\u064a\u0629",
		"arc" : "\u0710\u072a\u0721\u071d\u0710",
		"arn" : "Mapudungun",
		"arz" : "\u0645\u0635\u0631\u0649",
		"as" : "\u0985\u09b8\u09ae\u09c0\u09af\u09bc\u09be",
		"ast" : "Asturianu",
		"av" : "\u0410\u0432\u0430\u0440",
		"avk" : "Kotava",
		"ay" : "Aymar aru",
		"az" : "Az\u0259rbaycan",
		"ba" : "\u0411\u0430\u0448\u04a1\u043e\u0440\u0442",
		"bar" : "Boarisch",
		"bat-smg" : "\u017demait\u0117\u0161ka",
		"bcc" : "\u0628\u0644\u0648\u0686\u06cc \u0645\u06a9\u0631\u0627\u0646\u06cc",
		"bcl" : "Bikol Central",
		"be" : "\u0411\u0435\u043b\u0430\u0440\u0443\u0441\u043a\u0430\u044f",
		"be-tarask" : "\u0411\u0435\u043b\u0430\u0440\u0443\u0441\u043a\u0430\u044f (\u0442\u0430\u0440\u0430\u0448\u043a\u0435\u0432\u0456\u0446\u0430)",
		"be-x-old" : "\u0411\u0435\u043b\u0430\u0440\u0443\u0441\u043a\u0430\u044f (\u0442\u0430\u0440\u0430\u0448\u043a\u0435\u0432\u0456\u0446\u0430)",
		"bg" : "\u0411\u044a\u043b\u0433\u0430\u0440\u0441\u043a\u0438",
		"bh" : "\u092d\u094b\u091c\u092a\u0941\u0930\u0940",
		"bi" : "Bislama",
		"bm" : "Bamanankan",
		"bn" : "\u09ac\u09be\u0982\u09b2\u09be",
		"bo" : "\u0f56\u0f7c\u0f51\u0f0b\u0f61\u0f72\u0f42",
		"bpy" : "\u0987\u09ae\u09be\u09b0 \u09a0\u09be\u09b0\/\u09ac\u09bf\u09b7\u09cd\u09a3\u09c1\u09aa\u09cd\u09b0\u09bf\u09af\u09bc\u09be \u09ae\u09a3\u09bf\u09aa\u09c1\u09b0\u09c0",
		"bqi" : "\u0628\u062e\u062a\u064a\u0627\u0631\u064a",
		"br" : "Brezhoneg",
		"bs" : "Bosanski",
		"bug" : "\u1a05\u1a14 \u1a15\u1a18\u1a01\u1a17",
		"bxr" : "\u0411\u0443\u0440\u044f\u0430\u0434",
		"ca" : "Catal\u00e0",
		"cbk-zam" : "Chavacano de Zamboanga",
		"cdo" : "M\u00ecng-d\u0115\u0324ng-ng\u1e73\u0304",
		"ce" : "\u041d\u043e\u0445\u0447\u0438\u0439\u043d",
		"ceb" : "Cebuano",
		"ch" : "Chamoru",
		"cho" : "Choctaw",
		"chr" : "\u13e3\u13b3\u13a9",
		"chy" : "Tsets\u00eahest\u00e2hese",
		"ckb" : "Soran\u00ee \/ \u06a9\u0648\u0631\u062f\u06cc",
		"ckb-latn" : "\u202aSoran\u00ee (lat\u00een\u00ee)\u202c",
		"ckb-arab" : "\u202b\u06a9\u0648\u0631\u062f\u06cc (\u0639\u06d5\u0631\u06d5\u0628\u06cc)\u202c",
		"co" : "Corsu",
		"cr" : "N\u0113hiyaw\u0113win \/ \u14c0\u1426\u1403\u152d\u140d\u140f\u1423",
		"crh" : "Q\u0131r\u0131mtatarca",
		"crh-latn" : "\u202aQ\u0131r\u0131mtatarca (Latin)\u202c",
		"crh-cyrl" : "\u202a\u041a\u044a\u044b\u0440\u044b\u043c\u0442\u0430\u0442\u0430\u0440\u0434\u0436\u0430 (\u041a\u0438\u0440\u0438\u043b\u043b)\u202c",
		"cs" : "\u010cesky",
		"csb" : "Kasz\u00ebbsczi",
		"cu" : "\u0421\u043b\u043e\u0432\u0463\u0301\u043d\u044c\u0441\u043a\u044a \/ \u2c14\u2c0e\u2c11\u2c02\u2c21\u2c10\u2c20\u2c14\u2c0d\u2c1f",
		"cv" : "\u0427\u04d1\u0432\u0430\u0448\u043b\u0430",
		"cy" : "Cymraeg",
		"da" : "Dansk",
		"de" : "Deutsch",
		"de-at" : "\u00d6sterreichisches Deutsch",
		"de-ch" : "Schweizer Hochdeutsch",
		"de-formal" : "Deutsch (Sie-Form)",
		"diq" : "Zazaki",
		"dk" : "Dansk (deprecated:da)",
		"dsb" : "Dolnoserbski",
		"dv" : "\u078b\u07a8\u0788\u07ac\u0780\u07a8\u0784\u07a6\u0790\u07b0",
		"dz" : "\u0f47\u0f7c\u0f44\u0f0b\u0f41",
		"ee" : "E\u028begbe",
		"el" : "\u0395\u03bb\u03bb\u03b7\u03bd\u03b9\u03ba\u03ac",
		"eml" : "Emili\u00e0n e rumagn\u00f2l",
		"en" : "English",
		"en-gb" : "British English",
		"eo" : "Esperanto",
		"es" : "Espa\u00f1ol",
		"et" : "Eesti",
		"eu" : "Euskara",
		"ext" : "Estreme\u00f1u",
		"fa" : "\u0641\u0627\u0631\u0633\u06cc",
		"ff" : "Fulfulde",
		"fi" : "Suomi",
		"fiu-vro" : "V\u00f5ro",
		"fj" : "Na Vosa Vakaviti",
		"fo" : "F\u00f8royskt",
		"fr" : "Fran\u00e7ais",
		"frc" : "Fran\u00e7ais cadien",
		"frp" : "Arpetan",
		"fur" : "Furlan",
		"fy" : "Frysk",
		"ga" : "Gaeilge",
		"gag" : "Gagauz",
		"gan" : "\u8d1b\u8a9e",
		"gan-hans" : "\u8d63\u8bed(\u7b80\u4f53)",
		"gan-hant" : "\u8d1b\u8a9e(\u7e41\u9ad4)",
		"gd" : "G\u00e0idhlig",
		"gl" : "Galego",
		"glk" : "\u06af\u06cc\u0644\u06a9\u06cc",
		"gn" : "Ava\u00f1e'\u1ebd",
		"got" : "\ud800\udf32\ud800\udf3f\ud800\udf44\ud800\udf39\ud800\udf43\ud800\udf3a",
		"grc" : "\u1f08\u03c1\u03c7\u03b1\u03af\u03b1 \u1f11\u03bb\u03bb\u03b7\u03bd\u03b9\u03ba\u1f74",
		"gsw" : "Alemannisch",
		"gu" : "\u0a97\u0ac1\u0a9c\u0ab0\u0abe\u0aa4\u0ac0",
		"gv" : "Gaelg",
		"ha" : "\u0647\u064e\u0648\u064f\u0633\u064e",
		"hak" : "Hak-k\u00e2-fa",
		"haw" : "Hawai`i",
		"he" : "\u05e2\u05d1\u05e8\u05d9\u05ea",
		"hi" : "\u0939\u093f\u0928\u094d\u0926\u0940",
		"hif" : "Fiji Hindi",
		"hif-deva" : "\u092b\u093c\u0940\u091c\u0940 \u0939\u093f\u0928\u094d\u0926\u0940",
		"hif-latn" : "Fiji Hindi",
		"hil" : "Ilonggo",
		"ho" : "Hiri Motu",
		"hr" : "Hrvatski",
		"hsb" : "Hornjoserbsce",
		"ht" : "Krey\u00f2l ayisyen",
		"hu" : "Magyar",
		"hy" : "\u0540\u0561\u0575\u0565\u0580\u0565\u0576",
		"hz" : "Otsiherero",
		"ia" : "Interlingua",
		"id" : "Bahasa Indonesia",
		"ie" : "Interlingue",
		"ig" : "Igbo",
		"ii" : "\ua187\ua259",
		"ik" : "I\u00f1upiak",
		"ike-cans" : "\u1403\u14c4\u1483\u144e\u1450\u1466",
		"ike-latn" : "inuktitut",
		"ilo" : "Ilokano",
		"inh" : "\u0413\u0406\u0430\u043b\u0433\u0406\u0430\u0439 \u011eal\u011faj",
		"io" : "Ido",
		"is" : "\u00cdslenska",
		"it" : "Italiano",
		"iu" : "\u1403\u14c4\u1483\u144e\u1450\u1466\/inuktitut",
		"ja" : "\u65e5\u672c\u8a9e",
		"jbo" : "Lojban",
		"jut" : "Jysk",
		"jv" : "Basa Jawa",
		"ka" : "\u10e5\u10d0\u10e0\u10d7\u10e3\u10da\u10d8",
		"kaa" : "Qaraqalpaqsha",
		"kab" : "Taqbaylit",
		"kg" : "Kongo",
		"ki" : "G\u0129k\u0169y\u0169",
		"kiu" : "Kurmanc\u00ee",
		"kj" : "Kwanyama",
		"kk" : "\u049a\u0430\u0437\u0430\u049b\u0448\u0430",
		"kk-arab" : "\u202b\u0642\u0627\u0632\u0627\u0642\u0634\u0627 (\u062a\u0674\u0648\u062a\u06d5)\u202c",
		"kk-cyrl" : "\u202a\u049a\u0430\u0437\u0430\u049b\u0448\u0430 (\u043a\u0438\u0440\u0438\u043b)\u202c",
		"kk-latn" : "\u202aQazaq\u015fa (lat\u0131n)\u202c",
		"kk-cn" : "\u202b\u0642\u0627\u0632\u0627\u0642\u0634\u0627 (\u062c\u06c7\u0646\u06af\u0648)\u202c",
		"kk-kz" : "\u202a\u049a\u0430\u0437\u0430\u049b\u0448\u0430 (\u049a\u0430\u0437\u0430\u049b\u0441\u0442\u0430\u043d)\u202c",
		"kk-tr" : "\u202aQazaq\u015fa (T\u00fcrk\u00efya)\u202c",
		"kl" : "Kalaallisut",
		"km" : "\u1797\u17b6\u179f\u17b6\u1781\u17d2\u1798\u17c2\u179a",
		"kn" : "\u0c95\u0ca8\u0ccd\u0ca8\u0ca1",
		"ko" : "\ud55c\uad6d\uc5b4",
		"ko-kp" : "\ud55c\uad6d\uc5b4 (\uc870\uc120)",
		"kr" : "Kanuri",
		"kri" : "Krio",
		"krj" : "Kinaray-a",
		"ks" : "\u0915\u0936\u094d\u092e\u0940\u0930\u0940 - (\u0643\u0634\u0645\u064a\u0631\u064a)",
		"ksh" : "Ripoarisch",
		"ku" : "Kurd\u00ee \/ \u0643\u0648\u0631\u062f\u06cc",
		"ku-latn" : "\u202aKurd\u00ee (lat\u00een\u00ee)\u202c",
		"ku-arab" : "\u202b\u0643\u0648\u0631\u062f\u064a (\u0639\u06d5\u0631\u06d5\u0628\u06cc)\u202c",
		"kv" : "\u041a\u043e\u043c\u0438",
		"kw" : "Kernowek",
		"ky" : "\u041a\u044b\u0440\u0433\u044b\u0437\u0447\u0430",
		"la" : "Latina",
		"lad" : "Ladino",
		"lb" : "L\u00ebtzebuergesch",
		"lbe" : "\u041b\u0430\u043a\u043a\u0443",
		"lez" : "\u041b\u0435\u0437\u0433\u0438",
		"lfn" : "Lingua Franca Nova",
		"lg" : "Luganda",
		"li" : "Limburgs",
		"lij" : "L\u00edguru",
		"lmo" : "Lumbaart",
		"ln" : "Ling\u00e1la",
		"lo" : "\u0ea5\u0eb2\u0ea7",
		"loz" : "Silozi",
		"lt" : "Lietuvi\u0173",
		"lv" : "Latvie\u0161u",
		"lzh" : "\u6587\u8a00",
		"mai" : "\u092e\u0948\u0925\u093f\u0932\u0940",
		"map-bms" : "Basa Banyumasan",
		"mdf" : "\u041c\u043e\u043a\u0448\u0435\u043d\u044c",
		"mg" : "Malagasy",
		"mh" : "Ebon",
		"mhr" : "\u041e\u043b\u044b\u043a \u041c\u0430\u0440\u0438\u0439",
		"mi" : "M\u0101ori",
		"mk" : "\u041c\u0430\u043a\u0435\u0434\u043e\u043d\u0441\u043a\u0438",
		"ml" : "\u0d2e\u0d32\u0d2f\u0d3e\u0d33\u0d02",
		"mn" : "\u041c\u043e\u043d\u0433\u043e\u043b",
		"mo" : "\u041c\u043e\u043b\u0434\u043e\u0432\u0435\u043d\u044f\u0441\u043a\u044d",
		"mr" : "\u092e\u0930\u093e\u0920\u0940",
		"ms" : "Bahasa Melayu",
		"mt" : "Malti",
		"mus" : "Mvskoke",
		"mwl" : "Mirand\u00e9s",
		"my" : "\u1019\u103c\u1014\u103a\u1019\u102c\u1018\u102c\u101e\u102c",
		"myv" : "\u042d\u0440\u0437\u044f\u043d\u044c",
		"mzn" : "\u0645\u064e\u0632\u0650\u0631\u0648\u0646\u064a",
		"na" : "Dorerin Naoero",
		"nah" : "N\u0101huatl",
		"nan" : "B\u00e2n-l\u00e2m-g\u00fa",
		"nap" : "Nnapulitano",
		"nb" : "\u202aNorsk (bokm\u00e5l)\u202c",
		"nds" : "Plattd\u00fc\u00fctsch",
		"nds-nl" : "Nedersaksisch",
		"ne" : "\u0928\u0947\u092a\u093e\u0932\u0940",
		"new" : "\u0928\u0947\u092a\u093e\u0932 \u092d\u093e\u0937\u093e",
		"ng" : "Oshiwambo",
		"niu" : "Niu\u0113",
		"nl" : "Nederlands",
		"nn" : "\u202aNorsk (nynorsk)\u202c",
		"no" : "\u202aNorsk (bokm\u00e5l)\u202c",
		"nov" : "Novial",
		"nrm" : "Nouormand",
		"nso" : "Sesotho sa Leboa",
		"nv" : "Din\u00e9 bizaad",
		"ny" : "Chi-Chewa",
		"oc" : "Occitan",
		"om" : "Oromoo",
		"or" : "\u0b13\u0b21\u0b3c\u0b3f\u0b06",
		"os" : "\u0418\u0440\u043e\u043d\u0430\u0443",
		"pa" : "\u0a2a\u0a70\u0a1c\u0a3e\u0a2c\u0a40",
		"pag" : "Pangasinan",
		"pam" : "Kapampangan",
		"pap" : "Papiamentu",
		"pcd" : "Picard",
		"pdc" : "Deitsch",
		"pdt" : "Plautdietsch",
		"pfl" : "Pf\u00e4lzisch",
		"pi" : "\u092a\u093e\u093f\u0934",
		"pih" : "Norfuk \/ Pitkern",
		"pl" : "Polski",
		"pms" : "Piemont\u00e8is",
		"pnb" : "\u067e\u0646\u062c\u0627\u0628\u06cc",
		"pnt" : "\u03a0\u03bf\u03bd\u03c4\u03b9\u03b1\u03ba\u03ac",
		"ps" : "\u067e\u069a\u062a\u0648",
		"pt" : "Portugu\u00eas",
		"pt-br" : "Portugu\u00eas do Brasil",
		"qu" : "Runa Simi",
		"rif" : "Tarifit",
		"rm" : "Rumantsch",
		"rmy" : "Romani",
		"rn" : "Kirundi",
		"ro" : "Rom\u00e2n\u0103",
		"roa-rup" : "Arm\u00e3neashce",
		"roa-tara" : "Tarand\u00edne",
		"ru" : "\u0420\u0443\u0441\u0441\u043a\u0438\u0439",
		"ruq" : "Vl\u0103he\u015fte",
		"ruq-cyrl" : "\u0412\u043b\u0430\u0445\u0435\u0441\u0442\u0435",
		"ruq-latn" : "Vl\u0103he\u015fte",
		"rw" : "Kinyarwanda",
		"sa" : "\u0938\u0902\u0938\u094d\u0915\u0943\u0924",
		"sah" : "\u0421\u0430\u0445\u0430 \u0442\u044b\u043b\u0430",
		"sc" : "Sardu",
		"scn" : "Sicilianu",
		"sco" : "Scots",
		"sd" : "\u0633\u0646\u068c\u064a",
		"sdc" : "Sassaresu",
		"se" : "S\u00e1megiella",
		"sei" : "Cmique Itom",
		"sg" : "S\u00e4ng\u00f6",
		"sh" : "Srpskohrvatski \/ \u0421\u0440\u043f\u0441\u043a\u043e\u0445\u0440\u0432\u0430\u0442\u0441\u043a\u0438",
		"shi" : "Ta\u0161l\u1e25iyt",
		"si" : "\u0dc3\u0dd2\u0d82\u0dc4\u0dbd",
		"simple" : "Simple English",
		"sk" : "Sloven\u010dina",
		"sl" : "Sloven\u0161\u010dina",
		"sli" : "Schl\u00e4sch",
		"sm" : "Gagana Samoa",
		"sma" : "\u00c5arjelsaemien",
		"sn" : "chiShona",
		"so" : "Soomaaliga",
		"sq" : "Shqip",
		"sr" : "\u0421\u0440\u043f\u0441\u043a\u0438 \/ Srpski",
		"sr-ec" : "\u0421\u0440\u043f\u0441\u043a\u0438 (\u045b\u0438\u0440\u0438\u043b\u0438\u0446\u0430)",
		"sr-el" : "Srpski (latinica)",
		"srn" : "Sranantongo",
		"ss" : "SiSwati",
		"st" : "Sesotho",
		"stq" : "Seeltersk",
		"su" : "Basa Sunda",
		"sv" : "Svenska",
		"sw" : "Kiswahili",
		"szl" : "\u015al\u016fnski",
		"ta" : "\u0ba4\u0bae\u0bbf\u0bb4\u0bcd",
		"tcy" : "\u0ca4\u0cc1\u0cb3\u0cc1",
		"te" : "\u0c24\u0c46\u0c32\u0c41\u0c17\u0c41",
		"tet" : "Tetun",
		"tg" : "\u0422\u043e\u04b7\u0438\u043a\u04e3",
		"tg-cyrl" : "\u0422\u043e\u04b7\u0438\u043a\u04e3",
		"tg-latn" : "tojik\u012b",
		"th" : "\u0e44\u0e17\u0e22",
		"ti" : "\u1275\u130d\u122d\u129b",
		"tk" : "T\u00fcrkmen\u00e7e",
		"tl" : "Tagalog",
		"tn" : "Setswana",
		"to" : "lea faka-Tonga",
		"tokipona" : "Toki Pona",
		"tp" : "Toki Pona (deprecated:tokipona)",
		"tpi" : "Tok Pisin",
		"tr" : "T\u00fcrk\u00e7e",
		"ts" : "Xitsonga",
		"tt" : "\u0422\u0430\u0442\u0430\u0440\u0447\u0430\/Tatar\u00e7a",
		"tt-cyrl" : "\u0422\u0430\u0442\u0430\u0440\u0447\u0430",
		"tt-latn" : "Tatar\u00e7a",
		"tum" : "chiTumbuka",
		"tw" : "Twi",
		"ty" : "Reo M\u0101`ohi",
		"tyv" : "\u0422\u044b\u0432\u0430 \u0434\u044b\u043b",
		"udm" : "\u0423\u0434\u043c\u0443\u0440\u0442",
		"ug" : "Uyghurche\u200e \/ \u0626\u06c7\u064a\u063a\u06c7\u0631\u0686\u06d5",
		"ug-arab" : "\u0626\u06c7\u064a\u063a\u06c7\u0631\u0686\u06d5",
		"ug-latn" : "Uyghurche\u200e",
		"uk" : "\u0423\u043a\u0440\u0430\u0457\u043d\u0441\u044c\u043a\u0430",
		"ur" : "\u0627\u0631\u062f\u0648",
		"uz" : "O'zbek",
		"ve" : "Tshivenda",
		"vec" : "V\u00e8neto",
		"vep" : "Vepsan kel'",
		"vi" : "Ti\u1ebfng Vi\u1ec7t",
		"vls" : "West-Vlams",
		"vo" : "Volap\u00fck",
		"vro" : "V\u00f5ro",
		"wa" : "Walon",
		"war" : "Winaray",
		"wo" : "Wolof",
		"wuu" : "\u5434\u8bed",
		"xal" : "\u0425\u0430\u043b\u044c\u043c\u0433",
		"xh" : "isiXhosa",
		"xmf" : "\u10db\u10d0\u10e0\u10d2\u10d0\u10da\u10e3\u10e0\u10d8",
		"yi" : "\u05d9\u05d9\u05b4\u05d3\u05d9\u05e9",
		"yo" : "Yor\u00f9b\u00e1",
		"yue" : "\u7cb5\u8a9e",
		"za" : "Vahcuengh",
		"zea" : "Ze\u00eauws",
		"zh" : "\u4e2d\u6587",
		"zh-classical" : "\u6587\u8a00",
		"zh-cn" : "\u202a\u4e2d\u6587(\u4e2d\u56fd\u5927\u9646)\u202c",
		"zh-hans" : "\u202a\u4e2d\u6587(\u7b80\u4f53)\u202c",
		"zh-hant" : "\u202a\u4e2d\u6587(\u7e41\u9ad4)\u202c",
		"zh-hk" : "\u202a\u4e2d\u6587(\u9999\u6e2f)\u202c",
		"zh-min-nan" : "B\u00e2n-l\u00e2m-g\u00fa",
		"zh-mo" : "\u202a\u4e2d\u6587(\u6fb3\u9580)\u202c",
		"zh-my" : "\u202a\u4e2d\u6587(\u9a6c\u6765\u897f\u4e9a)\u202c",
		"zh-sg" : "\u202a\u4e2d\u6587(\u65b0\u52a0\u5761)\u202c",
		"zh-tw" : "\u202a\u4e2d\u6587(\u53f0\u7063)\u202c",
		"zh-yue" : "\u7cb5\u8a9e",
		"zu" : "isiZulu"
	};	
	
	// Language classes ( has a file in /languages/classes/Language{code}.js )
	// ( for languages that overide default transforms ) 
	mw.lang.transformClass = ['en', 'am', 'ar', 'bat_smg', 'be_tarak', 'be', 'bh',
		'bs', 'cs', 'cu', 'cy', 'dsb', 'fr', 'ga', 'gd', 'gv', 'he', 'hi',
		'hr', 'hsb', 'hy', 'ksh', 'ln', 'lt', 'lv', 'mg', 'mk', 'mo', 'mt',
		'nso', 'pl', 'pt_br', 'ro', 'ru', 'se', 'sh', 'sk', 'sl', 'sma',
		'sr_ec', 'sr_el', 'sr', 'ti', 'tl', 'uk', 'wa'
	];
	
	/**
	 * Plural form transformations, needed for some languages.
	 * For example, there are 3 form of plural in Russian and Polish,
	 * depending on "count mod 10". See [[w:Plural]]
	 * For English it is pretty simple.
	 *
	 * Invoked by putting {{plural:count|wordform1|wordform2}}
	 * or {{plural:count|wordform1|wordform2|wordform3}}
	 *
	 * Example: {{plural:{{NUMBEROFARTICLES}}|article|articles}}
	 *
	 * @param count Integer: non-localized number
	 * @param forms Array: different plural forms
	 * @return string Correct form of plural for count in this language
	 */	 
	
	/**
	* Base gender transform function
	*/
	mw.lang.gender = function( gender, forms ) {
		if ( ! forms.length ) { 
			return ''; 
		}
		forms = mw.lang.preConvertPlural( forms, 2 );
		if ( gender === 'male' ) return forms[0];
		if ( gender === 'female' ) return forms[1];
		return ( forms[2] ) ? forms[2] : forms[0];
	}
	
	/**
	* Process the PLURAL template substitution 
	* @param {Object} template Template object 
	* 
	* 	{{Template:argument|params}}
	* 
	* 	Template object should include:
	* 	[arg] The argument sent to the template  
	* 	[params] The template parameters  
	*/
	mw.lang.procPLURAL = function( tObj ) {		
		// Setup shortcuts
		// ( gRuleSet is loaded from script-loader to contains local ruleset )
		var rs = gRuleSet[ 'PLURAL' ];
		
		if( tObj.arg && tObj.param && mw.lang.convertPlural) {
			// Check if we have forms to replace
			if ( tObj.param.length == 0 ) { 
				return '';
			}
			// Restore the count into a Number ( if it got converted earlier )
			var count = mw.lang.convertNumber( tObj.arg, true );
			
			// Do convertPlural call 					
			return mw.lang.convertPlural( parseInt( count ), tObj.param );
			
		}
		// Could not process plural return first form or nothing
		if( tObj.param[0] ) {
			return tObj.param[0];
		}
		return '';		
	};
	/*
	* Base convertPlural function:
	*/
	mw.lang.convertPlural = function( count, forms ){	
		if ( !forms || forms.length == 0 ) { 
			return ''; 
		}	
		return ( parseInt( count ) == 1 ) ? forms[0] : forms[1];
	};
	/**
	 * Checks that convertPlural was given an array and pads it to requested
	 * amount of forms by copying the last one.
	 *
	 * @param {Array} forms Forms given to convertPlural
	 * @param {Integer} count How many forms should there be at least
	 * @return {Array} Padded array of forms or an exception if not an array
	 */
	mw.lang.preConvertPlural = function( forms, count ) {		
		while ( forms.length < count ) {
			forms.push( forms[ forms.length-1 ] );
		}		
		return forms;
	};
	
	/**
	 * Init the digitTransformTable ( populated by language classes where applicable ) 
	 */
	mw.lang.digitTransformTable = null;
	
	/** 
	 * Convert a number using the digitTransformTable 
	 * @param Number number to be converted
	 * @param Bollean typeInt if we should return a number of type int 
	 */
	mw.lang.convertNumber = function( number, typeInt ) {
		if( !mw.lang.digitTransformTable )
			return number;
		
		// Set the target Transform table: 
		var transformTable = mw.lang.digitTransformTable;
		
		// Check if the "restore" to latin number flag is set: 
		if( typeInt ) {			
			if( parseInt( number ) == number )	
				return number;
			var tmp = [];
			for( var i in transformTable ) {
				tmp[ transformTable[ i ] ] = i;
			}
			transformTable = tmp;
		}
		
		var numberString =  '' + number;
		var convertedNumber = '';
		for( var i =0; i < numberString.length; i++) {
			if( transformTable[ numberString[i] ] ) {
				convertedNumber += transformTable[ numberString[i] ];
			}else{
				convertedNumber += numberString[i];
			}
		}
		return ( typeInt )? parseInt( convertedNumber) : convertedNumber;
	}
	
	/**
	 * Checks if a language key is valid ( is part of languageCodeList )
	 * @param {String} langKey Language key to be checked
	 * @return true if valid language, false if not
	 */
	mw.isValidLang = function( langKey ) {
		return ( mw.lang.names[ langKey ] )? true : false;
	}
	/**
	* Checks if a language key has a transform class file
	*/
	mw.hasLangTransform = function( langKey ) {
		for( var i =0; i < mw.lang.transformClass; i++) {
			if( langKey == mw.lang.transformClass[i] ){
				return true;
			}
		} 
		return false;
	}
	
	/**
	 * getRemoteMsg loads remote msg strings
	 *
	 * @param {Mixed} msgSet the set of msg to load remotely
	 * @param function callback  the callback to issue once string is ready
	 */
	mw.getRemoteMsg = function( msgSet, callback ) {
		var ammessages = '';
		if ( typeof msgSet == 'object' ) {
			for ( var i in msgSet ) {
				if( !messageCache[ i ] ) { 
					ammessages += msgSet[i] + '|';
				}
			}
		} else if ( typeof msgSet == 'string' ) {
			if( !messageCache[ i ] ) {
				ammessages += msgSet;
			}
		}
		if ( ammessages == '' ) {
			mw.log( 'no remote msgs to get' );
			callback();
			return false;
		}
		var request = {
			'meta': 'allmessages',
			'ammessages': ammessages
		}
		mw.getJSON( request, function( data ) {
			if ( data.query.allmessages ) {
				var msgs = data.query.allmessages;
				for ( var i in msgs ) {
					var ld = { };
					ld[ msgs[i]['name'] ] = msgs[i]['*'];
					mw.addMessages( ld );
				}
			}
			callback();
		} );
	}
	
	/**
	 * Format a size in bytes for output, using an appropriate
	 * unit (B, KB, MB or GB) according to the magnitude in question
	 *
	 * @param size Size to format
	 * @return string Plain text (not HTML)
	 */
	mw.lang.formatSize = function ( size ) {
		// For small sizes no decimal places are necessary
		var round = 0;
		var msg = '';
		if ( size > 1024 ) {
			size = size / 1024;
			if ( size > 1024 ) {
				size = size / 1024;
				// For MB and bigger two decimal places are smarter
				round = 2;
				if ( size > 1024 ) {
					size = size / 1024;
					msg = 'mwe-size-gigabytes';
				} else {
					msg = 'mwe-size-megabytes';
				}
			} else {
				msg = 'mwe-size-kilobytes';
			}
		} else {
			msg = 'mwe-size-bytes';
		}
		// JavaScript does not let you choose the precision when rounding
		var p = Math.pow( 10, round );
		size = Math.round( size * p ) / p;
		return gM( msg , size );
	};
	
	/**
	 * Format a number
	 * @param {Number} num Number to be formated
	 * NOTE: add il8n support to lanuages/class/Language{langCode}.js
	 */
	mw.lang.formatNumber = function( num ) {
		/*
		*	addSeparatorsNF
		* @param Str: The number to be formatted, as a string or number.		
		* @param outD: The decimal character for the output, such as ',' for the number 100,2
		* @param sep: The separator character for the output, such as ',' for the number 1,000.2
		*/
		function addSeparatorsNF( nStr, outD, sep ) {
			nStr += '';
			var dpos = nStr.indexOf( '.' );
			var nStrEnd = '';
			if ( dpos != -1 ) {
				nStrEnd = outD + nStr.substring( dpos + 1, nStr.length );
				nStr = nStr.substring( 0, dpos );
			}
			var rgx = /(\d+)(\d{3})/;
			while ( rgx.test( nStr ) ) {
				nStr = nStr.replace( rgx, '$1' + sep + '$2' );
			}
			return nStr + nStrEnd;
		}
		// @@todo read language code and give periods or comas: 
		return addSeparatorsNF( num, '.', ',' );
	}	

	// Create a new parser Object	
	var parseObj = function( wikiText, options ) {
		return this.init( wikiText, options )
	}
	parseObj.prototype = {
		// the wikiText "DOM"... stores the parsed wikiText structure
		// wtDOM : {}, (not yet supported )

		pOut : '', // the parser output string container
		init  :function( wikiText ) {
			this.wikiText = wikiText;
		},
		updateText : function( wikiText ) {
			this.wikiText = wikiText;
			// invalidate the output (will force a re-parse )
			this.pOut = '';
		},
		
		/**
		 * Quickly recursive / parse out templates:
		 * This parser is only tested against msg templates see tests/testLang.html
		 */
		parse : function() {
			function rdpp ( txt , cn ) {
				var node = { };
				// Inspect each char
				for ( var a = 0; a < txt.length; a++ ) {
					if ( txt[a] == '{' && txt[a + 1] == '{' ) {
						a = a + 2;
						node['p'] = node;
						if ( !node['c'] )
							node['c'] = new Array();

						node['c'].push( rdpp( txt.substr( a ), true ) );
					} else if ( txt[a] == '}' && txt[a + 1] == '}' ) {
						a++;
						if ( !node['p'] ) {
							return node;
						}
						node = node['p'];
					}
					if ( !node['t'] ) {
						node['t'] = '';
					}
					// Don't put }} closures into output:
					if ( txt[a] &&  txt[a] != '}' ) {
							node['t'] += txt[a];
					}
				}
				return node;
			}
			/**
			 * Parse template text as template name and named params
			 * @param {String} ts Template String to be parsed 
			 */
			function parseTmplTxt( ts ) {
				var tObj = { };
								
				// Get template name:
				tname = ts.split( '\|' ).shift() ;
				tname = tname.split( '\{' ).shift() ;
				tname = tname.replace( /^\s+|\s+$/g, "" ); //trim

				// Check for arguments:
				if ( tname.split( ':' ).length == 1 ) {
					tObj["name"] = tname;
				} else {
					tObj["name"] = tname.split( ':' ).shift();
					tObj["arg"] = tname.split( ':' ).pop();
				}
									
				var pSet = ts.split( '\|' );
				pSet.splice( 0, 1 );
				if ( pSet.length ) {
					tObj.param = new Array();
					for ( var pInx in pSet ) {
						var tStr = pSet[ pInx ];
						// check for empty param
						if ( tStr == '' ) {
							tObj.param[ pInx ] = '';
							continue;
						}
						for ( var b = 0 ; b < tStr.length ; b++ ) {
							if ( tStr[b] == '=' && b > 0 && b < tStr.length && tStr[b - 1] != '\\' ) {
								// named param
								tObj.param[ tStr.split( '=' ).shift() ] =	tStr.split( '=' ).pop();
							} else {
								// indexed param
								tObj.param[ pInx ] = tStr;
							}
						}
					}
				}		
				return tObj;
			}
			
			/**
			 * Get the Magic text from a template node
			 */
			function getMagicTxtFromTempNode( node ) {
				node.tObj = parseTmplTxt ( node.t );
				// Do magic swap if template key found in pMagicSet
				if ( node.tObj.name in pMagicSet ) {
					var nt = pMagicSet[ node.tObj.name ]( node.tObj );
					return nt;
				} else {
					// don't swap just return text
					return node.t;
				}
			}
			
			/**
			 * recurse_magic_swap
			 *
			 * Go last child first swap upward: 
			 */
			var pNode = null;
			function recurse_magic_swap( node ) {
				if ( !pNode )
					pNode = node;

				if ( node['c'] ) {
					// swap all the kids:
					for ( var i in node['c'] ) {
						var nt = recurse_magic_swap( node['c'][i] );
						// swap it into current
						if ( node.t ) {
							node.t = node.t.replace( node['c'][i].t, nt );
						}
						// swap into parent
						pNode.t  = pNode.t.replace( node['c'][i].t, nt );
					}
					// do the current node:
					var nt = getMagicTxtFromTempNode( node );
					pNode.t = pNode.t.replace( node.t , nt );
					// run the swap for the outer most node
					return node.t;
				} else {
					// node.t = getMagicFromTempObj( node.t )
					return getMagicTxtFromTempNode( node );
				}
			}
			
			// Parse out the template node structure:
			this.pNode = rdpp ( this.wikiText );
			
			// Strip out the parent from the root	
			this.pNode['p'] = null;
			
			// Do the recursive magic swap text:
			this.pOut = recurse_magic_swap( this.pNode );
		},
		
		/**
		 * templates
		 * 
		 * Get a requested template from the wikitext (if available)
		 * @param templateName
		 */
		templates: function( tname ) {
			this.parse();
			var tmplSet = new Array();
			function getMatchingTmpl( node ) {
				if ( node['c'] ) {
					for ( var i in node['c'] ) {
						getMatchingTmpl( node['c'] );
					}
				}
				if ( tname && node.tObj ) {
					if ( node.tObj['name'] == tname )
						tmplSet.push( node.tObj );
				} else if ( node.tObj ) {
					tmplSet.push( node.tObj );
				}
			}
			getMatchingTmpl( this.pNode );
			return tmplSet;
		},
		
		/**
		* getTemplateVars
		* returns a set of template values in a given wikitext page
		* 
		* NOTE: should be integrated with the parser
		*/
		getTemplateVars: function() {
			//mw.log('matching against: ' + wikiText);
			templateVars = new Array();
			var tempVars = wikiText.match(/\{\{\{([^\}]*)\}\}\}/gi);
															
			// Clean up results:
			for(var i=0; i < tempVars.length; i++) {
				//match 
				var tvar = tempVars[i].replace('{{{','').replace('}}}','');
				
				// Strip anything after a |
				if(tvar.indexOf('|') != -1) {
					tvar = tvar.substr(0, tvar.indexOf('|'));
				}
				
				// Check for duplicates:
				var do_add=true;
				for(var j=0; j < templateVars.length; j++) {
					if( templateVars[j] == tvar)
						do_add=false;
				}
				
				// Add the template vars to the output obj
				if(do_add)
					templateVars.push( tvar );
			}
			return templateVars;
		},
		
		/**
		 * Returns the transformed wikitext
		 * 
		 * Build output from swappable index 
		 * 		(all transforms must be expanded in parse stage and linearly rebuilt)  
		 * Alternatively we could build output using a place-holder & replace system 
		 * 		(this lets us be slightly more sloppy with ordering and indexes, but probably slower)
		 * 
		 * Ideal: we build a 'wiki DOM' 
		 * 		When editing you update the data structure directly
		 * 		Then in output time you just go DOM->html-ish output without re-parsing anything			   
		 */
		getHTML : function() {
			// wikiText updates should invalidate pOut
			if ( this.pOut == '' ) {
				this.parse();
			}
			return this.pOut;
		}
	};		
	
	/**
	* MediaWiki wikitext "Parser" entry point:
	*
	* @param {String} wikiText the wikitext to be parsed
	* @return {Object} parserObj returns a parser object that has methods for getting at
	* things you would want
	*/
	mw.parser = function( wikiText, options) {
		// return the parserObj
		return new parseObj( wikiText, options ) ;	
	}
	
	var pMagicSet = { };
		
	/**
	 * addTemplateTransform to the parser 
	 *
	 * Lets you add a set template key to be transformed by a callback function
	 *
	 * @param {Object} magicSet key:callback
	 */
	mw.addTemplateTransform = function( magicSet ) {
		for ( var i in magicSet )
			pMagicSet[ i ] = magicSet[i];
	}
	
	/**
	* Add a hook system for a target object / interface	
	*
	* This can be used as an alternative to heavy inheritance systems.
	*
	* @param {Object} targetObj Interface Object to add hook system to.   
	*/
	mw.addHookSystem = function( targetObj ) {		
		// Setup the target object hook holder:
		targetObj[ 'hooks' ] = { };
		 
		/**
		* Adds a hook to the target object
		* 
		* Should be called by clients to setup named hooks
		*
		* @param {String} hookName Name of hook to be added
		* @param {Function} hookFunction Function to be called at hook time
		*/
		targetObj.addHook = function( hookName, hookFunction ) {
			if( ! this.hooks[ hookName ] )
				this.hooks[ hookName ] = [ ];
			this.hooks[ hookName ].push( hookFunction )
		}
		
		/**
		* Runs all the hooks by a given name with reference to the host object
		*
		* Should be called by the host object at named execution points 
		* 
		* @param {String} hookName Name of hook to be called
		* @return Value of hook result 
		* 	true interface should continue function execution
		*	false interface should stop or return from method
		*/
		targetObj.runHook = function( hookName ) {								
			if( this.hooks[ hookName ] ) {
				for( var i in this.hooks[ hookName ]) {
					if( typeof( this.hooks[ hookName ][ i ] ) == 'function') {
						return this.hooks[ hookName ][ i ]( this );
					}
				}
			}
		}
	} 
	
	
	
	/**
	* Top level loader prototype:
	*/
	mw.loader = {
		/*
		* Javascript Module Loader functions 
		* @key Name of Module
		* @value function code to load module 
		*/
		moduleLoaders : { },
		
		/**
		* Javascript Class Paths
		* @key Name of class
		* @value Class file path 
		*/
		classPaths : { }, 						
		
		/**
		* Core load function: 
		* 
		* @param {Mixed} loadRequest:
		* 
		* 	{String} Name of a module to be loaded
		* 		Modules are added via addModuleLoader and can define custom
		* 		code needed to check config and load the module dependencies
		*
		*	{String} Name of a class to loaded. 
		* 		Classes are added via addClassFilePaths function
		*		Using defined class names avoids loading the same class
		*		twice by first checking if the "class variable" is defined
		*	
		*	{String} Absolute or relative to mwEmbed file path. 
		*		The same file won't be loaded twice
		*
		*	{Array} can be an array of any combination of the above strings.
		*		Will be loaded in-order or in a single 
		*		script-loader request if scriptLoader is enabled 
		*
		* 	{Array} {Array} Can be a set of Arrays for loading.		 
		*		Some browsers execute included scripts out of order. 
		* 		This lets you chain sets of request for those browsers.
		*		If using the server side script-loader order is preserved 
		* 			in output and a single request will be used.
		*
		* @param {Function} callback Function called once loading is complete
		*/				
		load: function( loadRequest, instanceCallback ) {
			// Ensure the callback is only called once per load instance 
			var callback = function(){
				if( instanceCallback ){
					instanceCallback( loadRequest );
					instanceCallback = null;
				}
			}
			// Check for empty loadRequest ( directly return the callback ) 
			if( mw.isEmpty( loadRequest ) ) {
				mw.log( 'Empty load request: ' + loadRequest );
				callback( loadRequest );
				return ;
			}									
			
			// Check if its a multi-part request: 
			if( typeof loadRequest == 'object' ) {
			 	if( loadRequest.length > 1 ) {			 							
					this.loadMany ( loadRequest,  callback );
					return ;
				}else{
					// If an array of length 1 set as first element 
					loadRequest = loadRequest[0];
				}				
			}   					
			
			// Check for the module name loader function 
			if( this.moduleLoaders[ loadRequest ] && 
				typeof ( this.moduleLoaders[ loadRequest ] ) == 'function' 
			) {
				mw.log("mw.load: loadModule:" + loadRequest );
				// Run the module with the parent callback 
				this.moduleLoaders[ loadRequest ]( callback );	
				return ;
			}
			
			// Check for javascript class 
			if( this.getClassPath( loadRequest ) ) {		
				mw.log('mw.load: loadClass: ' + loadRequest );
				this.loadClass( loadRequest, callback );																	
				return ;
			}
			
			// Try loading as a "file" or via ScriptLoader
			if( loadRequest ) { 				
				if( loadRequest.indexOf( '.js' ) == -1 && !mw.getScriptLoaderPath() ) {
					mw.log( 'Error: are you sure ' + loadRequest + ' is a file ( is it missing a class path? ) ' );
				}				
				mw.getScript( loadRequest, callback );
				return ;
			}
			
			// Possible error? 
			mw.log( "Error could not handle load request: " + loadRequest  );			
		},
			
		/**
		* Load a set of scripts.
		* Will issue many load requests or package the request for the script-loader
		*
		* @param {Object} loadSet Set of scripts to be loaded
		* @param {Function} callback Function to call once all scripts are loaded.
		*/ 
		loadMany: function( loadSet, callback ) {				
			var _this = this;
			// Setup up the local "loadStates"			
			var loadStates = { };
					
			// Check if we can load via the "script-loader" ( mwEmbed was included via scriptLoader ) 
			if( mw.getScriptLoaderPath() ) {				
				loadStates = this.getGroupLoadState( loadSet );
				if( mw.isEmpty( loadStates ) ) {
					mw.log( 'loadMany:all classes already loaded');
					callback();
					return ;
				}						
			}else{									
				// Check if its a dependency set ( nested objects ) 
				if( typeof loadSet [ 0 ] == 'object' ) {		
					_this.dependencyChainCallFlag[loadSet] = false;
					//Load sets of classes ( to preserver order for some browsers )
					_this.loadDependencyChain( loadSet, callback );
					return ;
				}
				
				// Set the initial load state for every item in the loadSet
				for( var i = 0; i < loadSet.length ; i++ ) {							
					var loadName = loadSet[ i ];				
					loadStates[ loadName ] = 0;					
				}		
			}	
			
			// We are infact loading many:
			mw.log("mw.load: LoadMany:: " + loadSet );
						
			// Issue the load request check check loadStates to see if we are "done"
			for( var loadName in loadStates ) {				
				//mw.log("loadMany: load: " + loadName ); 					
				this.load( loadName, function ( loadName ) {										
					loadStates[ loadName ] = 1;
					//mw.log( loadName + ' finished of: ' + JSON.stringify( loadStates ) );
					//Check if all load request states are set 1					
					var loadDone = true;
					for( var j in loadStates ) {
						if( loadStates[ j ] === 0 )
							loadDone = false;			
					}					
					// Run the parent scope callback for "loadMany" 
					if( loadDone ) {						
						callback( loadName );						
					}
				} );
			}
		},
						
		/**
		* Get grouped load state for script loader.
		* Groups the loadSet into a single sequential array
		* 
		* Groups the scriptRequest where possible: 
		* 	Modules include "loader code" so they are separated
		* 	into pre-condition code to be run for subsequent requests
		*
		* @param {Object} loadSet Loadset to return grouped
		* @return {Object}
		*	grouped loadSet
		*/
		getGroupLoadState: function( loadSet ) {
			var groupedLoadSet = [];			
			var loadStates = { };
			// Merge load set into new groupedLoadSet
			if( typeof loadSet[0] == 'object' ) {
				for( var i = 0; i < loadSet.length ; i++ ) {
					for( var j = 0; j < loadSet[i].length ; j++ ) {
						// Make sure we have not already included it:						
						groupedLoadSet.push( loadSet[i][j] );
					}
				}
			}else{
				// Use the loadSet directly: 
				groupedLoadSet = loadSet;
			}
			
			// Setup grouped loadStates Set:
			var groupClassKey = ''; 
			var coma = '';			
			for( var i=0; i < groupedLoadSet.length; i++ ) {										
				var loadName = groupedLoadSet[ i ];	
				if( this.getClassPath( loadName )  ) {
					// Only add to group request if not already set: 
					if ( !mw.isset( loadName ) ) {
						groupClassKey += coma + loadName
						coma = ',';
					}					
				}else if( this.moduleLoaders[ loadName ] ) {
					// Module loaders break up grouped script requests ( add the current groupClassKey )
					if( groupClassKey != '' ) {
						loadStates[ groupClassKey ] = 0;
						groupClassKey = coma = '';
					}
					// Add the module to the loadSate
					loadStates[ loadName ] = 0;
				}					
			}				
			
			// Add groupClassKey if set: 
			if( groupClassKey != '' ) {
				loadStates [ groupClassKey ] = 0;
			}
			
			return loadStates;
		},
		
				
		/**
		* Load a sets of scripts satisfy dependency order for browsers that execute out of order
		* 
		* @param {Object} loadChain A set of javascript arrays to be loaded. 
		*	Sets are requested in array order. 		   
		*/ 
		dependencyChainCallFlag: { },
		
		loadDependencyChain: function( loadChain, callback ) {
			var _this = this;						
			// Load with dependency checks
			var callSet = loadChain.shift();
			this.load( callSet, function( cbname ) {				
				if ( loadChain.length != 0 ) {
					_this.loadDependencyChain( loadChain, callback );
				} else {
					// NOTE: IE is playing tricks with me 
					//  Need to figure out why this callback gets called twice 
					//  and remove this flag
					if( _this.dependencyChainCallFlag[ callSet ] == callback ) {
						mw.log("... already called this callback for " + callSet );
						return ;
					}
					_this.dependencyChainCallFlag[ callSet ] = callback;										
					callback( );					
				}
			} );
		},
		
		
		/**
		* Loads javascript associated with a className
		*
		* @param {String} className Name of class to load
		* @param {Function} callback Function to run once class is loaded 
		*/
		loadClass: function( className , callback) {		
			var _this = this;			
			// Make sure the class is not already defined:
			if ( mw.isset( className ) ) {
				mw.log( 'Class ( ' + className + ' ) already defined ' );
				callback( className );
				return ; 									
			}
			
			// Setup the Script Request var: 
			var scriptRequest = null;
			
			// If the scriptloader is enabled use the className as the scriptRequest: 
			if( mw.getScriptLoaderPath() ) {
				// replace $j with j since php strips the $ from the request class			
				scriptRequest =  className;
			}else{
				// Get the class url:
				var baseClassPath = this.getClassPath( className );													
				// Add the mwEmbed path if not a root path or a full url
				if( baseClassPath.indexOf( '/' ) !== 0 && 
					baseClassPath.indexOf( '://' ) === -1 ) {
					scriptRequest = mw.getMwEmbedPath() + baseClassPath;
				}else{
					scriptRequest = baseClassPath;
				}				
				if( ! scriptRequest ) {
					mw.log( "Could not get url for class " + className  );						
					return ;
				}	
			}
			
			// Include class defined check for older browsers
			var classDone = false;
			
			// Set the top level load done to the callback				
			mw.setLoadDoneCB( className, callback );
			
			// Issue the request to load the class (include class name in result callback:					
			mw.getScript( scriptRequest, function( scriptRequest ) {
				// Debug output				
				if(! mw.isset( className )  
					&& mwLoadDoneCB[ className ] != 'done' ) {
					mw.log( 'Possible Error: ' + className +' not set in time, or not defined in:' + "\n" +  _this.getClassPath( className ) );
				}
				// Call load done (incase the script did not include a loadDone callback ) 
				mw.loadDone( className );
			} );	
			//mw.log( 'done with running getScript request ' );
			
			/*
			* ( If scriptLoader is not enabled )
			* 
			* Check if the class is ready: 
			* ( not all browsers support onLoad script attribute )
			* In the case of a "class" we can pull the javascript state until its ready
			*/
			if( !mw.getScriptLoaderPath() ) {
				setTimeout( function() {
					mw.waitForObject( className, function( className ) {														
						// Once object is ready run loadDone 
						mw.loadDone( className );
					} );
				}, 25 ); 
			}
		},				
		
		/**
		* Adds a module to the mwLoader object 
		*
		* @param {String} name Name of module
		* @param {Function} moduleLoader Function that
		*	loads dependencies for a module
		*/
		addModuleLoader: function( name, moduleLoader ) {		
			this.moduleLoaders [ name ] = moduleLoader;
		},
		
		/**
		* Adds class file path key value pairs
		*
		* @param {Object} classSet JSON formated list of 
		*  class name file path pairs.
		*
		*  classSet must be strict JSON to allow the 
		*  php scriptLoader to parse the file paths.  
	 	*/
	 	addClassFilePaths: function( classSet ) {
	 		var prefix = ( mw.getConfig( 'loaderContext' ) )?
	 			mw.getConfig( 'loaderContext' ): '';
	 		
	 		for( var i in classSet ) {
				this.classPaths[ i ] = prefix + classSet[ i ];
			}
	 	},
	 	
	 	/**
	 	* Get a class path forom a className 
	 	* if no class found return false
	 	*/
	 	getClassPath: function( className ) {
	 		if( this.classPaths[ className ] )
	 			return this.classPaths[ className ]
	 		return false;
	 	}
	}
	/**
	* Load done callback for script loader
	*  this enables webkit browsers don't have to check if variables are "ready"
	* @param {String} requestName Name of the load request
	*/	
	mw.loadDone =  function( requestName ) {		
		//mw.log( "LoadDone: " + requestName + ' run callback ');
		if( !mwLoadDoneCB[ requestName ] ) {			
			return true;
		}
		while( mwLoadDoneCB[ requestName ].length ) {
			// check if mwLoadDoneCB is already "done" 
			// the function list is not an object
			if( typeof mwLoadDoneCB[ requestName ] != 'object' )
			{
				break;
			}
			var func = mwLoadDoneCB[ requestName ].pop();			
			if( typeof func == 'function' ) {
				func( requestName );
			}else{
				mw.log('mwLoadDoneCB: Error non callback function on stack');
			}
		}
		// Set the load request name to done
		mwLoadDoneCB[ requestName ] = 'done';
	};
	
	/**
	* Set a load done callback 
	* @param {String} requestName Name of class or request set
	* @param {Function} callback Function called once requestName is ready
	*/
	mw.setLoadDoneCB = function( requestName, callback ) {
		// If the requestName is already done loading just callback
		if( mwLoadDoneCB[ requestName ] == 'done' ) {
			callback( requestName )
		}
		// Setup the function queue if unset
		if( typeof mwLoadDoneCB[ requestName ] != 'object' ) {
			mwLoadDoneCB[ requestName ] = [];
		}
		mwLoadDoneCB[ requestName ].push( callback );		
	};
	
	/**
	* Shortcut entry points / convenience functions: 
	* Lets you write mw.load() instead of mw.loader.load()
	* only these entry points should be used. 
	*
	* future closure optimizations could minify internal
	* function names 
	*/
	
	/**
	* Load Object entry point: Loads a requested set of javascript 
	*/	
	mw.load = function( loadRequest, callback ) {
		return mw.loader.load( loadRequest, callback );
	}
	
	/**
	* Add module entry point: Adds a module to the mwLoader object 
	*/
	mw.addModuleLoader = function ( name, loaderFunction ) {
		return mw.loader.addModuleLoader( name, loaderFunction );		
	}
	
	/**
	* Add Class File Paths entry point:  
	*/
	mw.addClassFilePaths = function ( classSet )	{	
		return mw.loader.addClassFilePaths( classSet );
	}
	
	/**
	* Get Class File Path entry point: 
	*/
	mw.getClassPath = function( className ) {
		return mw.loader.getClassPath( className );
	}
	
	
	/**
	* API Helper functions
	*/
	
	/**
	* 
	* Helper function to get revision text for a given title
	* 
	* Assumes "follow redirects" 
	* 
	* $j.getTitleText( [apiUrl], title, callback )
	*  
	* @param {String} url or title key
	* @parma {Mixed} title or callback function
	* @param {Function} callback Function or NULL
	* 
	* @return callback is called with:
	* 	{Boolean} false if no page found 
	* 	{String} text of wiki page	 
	*/
	mw.getTitleText = function( apiUrl, title, callback ) {
		// Check if optional apiURL was not included
		if( !callback ) {
			title = apiUrl;
			callback = title;
			apiUrl = mw.getLocalApiUrl();
		}
		var request = {
			// Normalize the File NS (ie sometimes its present in apiTitleKey other times not
			'titles' : title,
		    'prop' : 'revisions',
		    'rvprop' : 'content'
		};	
		
		mw.getJSON( apiUrl , request, function( data ) {			
			if( !data || !data.query || !data.query.pages ) {
				callback( false );	
			}
			var pages = data.query.pages;			
			for(var i in pages) {
				page = pages[ i ];
				if( page[ 'revisions' ] && page[ 'revisions' ][0]['*'] ) {
					callback( page[ 'revisions' ][0]['*'] );
				}
			}
		} );
	}		
	
	/**
	* Issues the wikitext parse call 
	* 
	* @param {String} wikitext Wiki Text to be parsed by mediaWiki api call
	* @param {String} title Context title of the content to be parsed
	* @param {Function} callback Function called with api parser output 
	*/
	mw.parseWikiText = function( wikitext, title, callback ) {		
		mw.getJSON( mw.getLocalApiUrl(), 
			{
				'action': 'parse',
				'title' : title,
				'text': wikitext
			}, function( data ) {
				callback( data.parse.text['*'] );
			}
		);
	}
	
	/**
	* mediaWiki JSON a wrapper for jQuery getJSON:
	* 
	* The mediaWiki version lets you skip the url part 
	* mw.getJSON( [url], data, callback, [timeoutCallback] ); 
	* 
	* Lets you assume:
	* 	url is optional 
	* 		( If the first argument is not a string we assume a local mediaWiki api request )
	*   callback parameter is not needed for the request data
	* 	url param 'action'=>'query' is assumed ( if not set to something else in the "data" param
	* 	format is set to "json" automatically
	* 	automatically issues request over "POST" if the request requires a post
	*	automatically will setup apiProxy where needed.
	*
	* @param {Mixed} url or data request
	* @param {Mixed} data or callback
	* @param {Function} callbcak function called on success
	* @param {Function} callbackTimeout - optional function called on timeout
	* 	Setting timeout callback also avoids default dialog display for timed-out proxy calls.
	*/	
	mw.getJSON = function() {		
		// Set up the url
			
		var url = false;
		url = ( typeof arguments[0] == 'string' ) ? arguments[0] : mw.getLocalApiUrl();		
		
		// Set up the data: 
		var data = null;
		data = ( typeof arguments[0] == 'object' ) ? arguments[0] : null;
		if( !data && typeof arguments[1] == 'object' ) {
			data = arguments[1];
		} 
		
		// Setup the callback
		var callback = false;
		callback = ( typeof arguments[1] == 'function') ? arguments[1] : false;		
		var cbinx = 1;
		if( ! callback && ( typeof arguments[2] == 'function') ) {
			callback = arguments[2];
			cbinx = 2;	
		}		
		
		// Setup the timeoutCallback ( function after callback index )
		var timeoutCallback = false;
		timeoutCallback = ( typeof arguments[ cbinx + 1 ] == 'function' ) ? arguments[ cbinx + 1 ] : false;		
				
		// Make sure we got a url:
		if( !url ) { 
			mw.log( 'Error: no api url for api request' );
			return false;
		}		
		
		// Add default action if unset:
		if( !data['action'] ) {
			data['action'] = 'query';
		}
		
		// Add default format if not set:
		if( !data['format'] ) { 
			data['format'] = 'json';
		}
		
		// Setup callback wrapper for timeout
		var requestTimeOutFlag = false;
		var ranCallback = false;
		
		/**
		 * local callback function to control timeout
		 * @param {Object} data Result data
		 */
		var myCallback = function( data ){			
			if( ! requestTimeOutFlag ){
				ranCallback = true;
				callback( data );
			}
		} 		
		// Set the local timeout call based on defaultRequestTimeout
		setTimeout( function( ) {
			if( ! ranCallback ) {
				requestTimeOutFlag = true;
				mw.log( "Error:: request timed out: " + url );			
				if( timeoutCallback ){	
					timeoutCallback();
				}
			}
		}, mw.getConfig( 'defaultRequestTimeout' ) * 1000  );
		
		mw.log("run getJSON: " + mw.replaceUrlParams( url, data ) );
				
		// Check if the request requires a "post" 
		if( mw.checkRequestPost( data )  ) {
		
			// Check if we need to setup a proxy
			if( ! mw.isLocalDomain( url ) ) {
					
				//Set local scope ranCallback to true 
				// ( ApiProxy handles timeouts internally )
				ranCallback = true;
		
				// Load the proxy and issue the request
				mw.load( 'ApiProxy', function( ) {
					mw.ApiProxy.doRequest( url, data, callback, timeoutCallback);				
				} );
								
			} else {
							
				// Do the request an ajax post 
				$j.post( url, data, myCallback, 'json');				
			}
			return ;
		}
		
		// If cross domain setup a callback: 
		if( ! mw.isLocalDomain( url ) ) {				 
			if( url.indexOf( 'callback=' ) == -1 || data[ 'callback' ] == -1 ) {
				// jQuery specific: ( second ? is replaced with the callback ) 
				url += ( url.indexOf('?') == -1 ) ? '?callback=?' : '&callback=?';
			}				 
		}
		
		// Pass off the jQuery getJSON request:
		$j.getJSON( url, data, myCallback );			
	}
	
	/**
	* Checks if a mw request data requires a post request or not
	* @param {Object} 
	* @return {Boolean}
	*	true if the request requires a post request
	* 	false if the request does not
	*/		
	mw.checkRequestPost = function ( data ) {		
		if( $j.inArray( data['action'],  mw.getConfig( 'apiPostActions' ) ) != -1 ) {
			return true;
		}
		if( data['prop'] == 'info' && data['intoken'] ) {
			return true;			
		}
		if( data['meta'] == 'userinfo' ) {
			return true;
		}
		return false;
	}
	
	/**
	* Check if the url is a request for the local domain
	*  relative paths are "local" domain
	* @param {String} url Url for local domain
	* @return 
	*	true if url domain is local or relative
	* 	false if the domain is
	* @type {Boolean} 	
	*/
	mw.isLocalDomain = function( url ) {
		if( mw.parseUri( document.URL ).host == mw.parseUri( url ).host 
			|| url.indexOf( '://' ) == -1 ) 
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Api helper to grab an edit token
	 *
	 * @param {String} [apiUrl] Optional target API URL (uses default local api if unset) 
	 * @param {String} title The wiki page title you want to edit	 
	 * @param {callback} callback Function to pass the token to returns false if token not retrived
	 */
	mw.getToken = function( apiUrl, title, callback ) {
		// Make the apiUrl be optional: 
		if( typeof title == 'function' ) {
			callback = title;
			title = apiUrl;
			apiUrl = mw.getLocalApiUrl();	
		}		
		
		mw.log( 'mw:getToken' );		
		
		var request = {			
			'prop': 'info',
			'intoken': 'edit',
			'titles': title
		};
		mw.getJSON( apiUrl, request, function( data ) {
			for ( var i in data.query.pages ) {
				if ( data.query.pages[i]['edittoken'] ) {
					callback ( data.query.pages[i]['edittoken'] );	
					return ;				
				}
			}
			// No token found:
			callback ( false );
		} );
	}
	
	/**
	 * Api helper to grab the username
	 * @param {String} [apiUrl] Optional target API url (uses default local api if unset) 
	 * @param {Function} callback Function to callback with username or false if not found	 	
	 */
	 // Stub feature apiUserNameCache to avoid multiple calls 
	 // ( a more general api cache framework should be devloped ) 
	 var apiUserNameCache = {};
	 mw.getUserName = function( apiUrl, callback, fresh ){	 		 	
	 	if( typeof apiUrl == 'function' ){
	 		var callback = apiUrl;
	 		var apiUrl =  mw.getLocalApiUrl();	 		
	 	}
	 	
	 	// If apiUrl is local check wgUserName global
	 	//  before issuing the api request.
	 	if( mw.isLocalDomain( apiUrl ) ){	 		
	 		if( typeof wgUserName != 'undefined' &&  wgUserName !== null ) {
	 			callback( wgUserName )
	 			return ;
	 		}
	 	}
	 	if( ! fresh && apiUserNameCache[ apiUrl ]  ) {
	 		callback( apiUserNameCache[ apiUrl ]  );
	 		return ; 
	 	}
	 	
	 	// Setup the api request
		var request = {
			'action':'query',
			'meta':'userinfo'
		}
		
		// Do request 
		mw.getJSON( apiUrl, request, function( data ) {
			if( !data || !data.query || !data.query.userinfo || !data.query.userinfo.name ){
				// Could not get user name user is not-logged in
				mw.log( " No userName in response " );
				callback( false );
				return ;
			}
			// Check for "not logged in" id == 0
			if( data.query.userinfo.id == 0 ){
				callback( false );
				return ;
			}
			apiUserNameCache[ apiUrl ] = data.query.userinfo.name;
			// Else return the username: 
			callback( data.query.userinfo.name );				
		}, function(){
			// Timeout also results in callback( false ) ( no user found) 
			callback( false );
		} );
	}
	
	/**
	* Utility Functions
	*/		
	
	/**
	* addLoaderDialog
	*  small helper for displaying a loading dialog
	*
	* @param msg text text of the loader msg
	*/
	mw.addLoaderDialog = function( msg_txt ) {
		mw.addDialog( msg_txt, msg_txt + '<br>' + mw.loading_spinner() );
	}
		
	/*mw.status = function( status )
	
	
	var Status = function() {
		
	}*/
	
	/**
	* Add a (temporary) dialog window:
	* @param {String} title Title string for the dialog
	* @param {String} msg_html String to be inserted in msg box
	* @param {Mixed} buttons A button object for the dialog 
	*					Can be 'ok' for oky button.
	*/
	mw.addDialog = function ( title, msg_html, buttons ) {
		$j( '#mwe_tmp_loader' ).remove();
		// Append the style free loader ontop: 
		$j( 'body' ).append( 
			$j('<div />') 
			.attr( {
				'id' : "mwe_tmp_loader",
				'title' : title
			})
			.css('display', 'none')
			.html( msg_html )
		);
		// Special buttons == ok gives empty give a single "oky" -> "close"
		if ( buttons == 'ok' ) {
			buttons = { };
			buttons[ gM( 'mwe-ok' ) ] = function() {
				$j( '#mwe_tmp_loader' ).close();
			}
		}
		// Load the dialog classes
		mw.load([
			[
				'$j.ui'
			],
			[
				'$j.ui.dialog'
			]
		], function() {
			$j( '#mwe_tmp_loader' ).dialog( {
				'bgiframe': true,
				'draggable': false,
				'resizable': false,
				'modal': true,
				'width':400,
				'buttons': buttons
			} );
		} );
	}
	
	/**
	 * Close the loader dialog created with addLoaderDialog
	 */
	mw.closeLoaderDialog = function() {
		mw.load( [
			[
				'$j.ui'
			],
			[
				'$j.ui.dialog'
			]
		], function() {
			$j( '#mwe_tmp_loader' ).dialog( 'destroy' ).remove();
		} );
	}
	
	
	/**
	* Similar to php isset function checks if the variable exists.
	* Does a safe check of a descendent method or variable
	*
	* @param {String} objectPath
	* @return {Boolean}
	* 	true if objectPath exists
	*	false if objectPath is undefined
	*/	
	mw.isset = function( objectPath ) {
		if ( !objectPath )
			return false;
			
		var pathSet = objectPath.split( '.' );
		var cur_path = '';
				
		for ( var p = 0; p < pathSet.length; p++ ) {
			cur_path = ( cur_path == '' ) ? cur_path + pathSet[p] : cur_path + '.' + pathSet[p];
			eval( 'var ptest = typeof ( ' + cur_path + ' ); ' );
			if ( ptest == 'undefined' ) {				
				return false;
			}
		}
		return true;
	}
	
	/**
	* Wait for a object to be defined and the call the callback
	*
	* @param {Object} objectName Name of object to be defined
	* @param {Function} callback Function to call once object is defined
	* @param {Null} callNumber Used internally to keep track of 
	*	number of times waitForObject has been called 
	*/
	var waitTime = 1200; // About 30 seconds 
	mw.waitForObject = function( objectName, callback, _callNumber) {	
		//mw.log( 'waitForObject: ' + objectName  + ' cn: ' + _callNumber);		
				
		// Increment callNumber: 
		if( !_callNumber ) { 
			_callNumber = 1;
		} else {
			_callNumber++;
		}
		
		if( _callNumber > waitTime ) {
			mw.log( "Error: waiting for object: " + objectName + ' timeout ' );
			callback( false ); 
			return ;
		}
		
		// If the object is defined ( or we are done loading from a callback )
		if ( mw.isset( objectName ) || mwLoadDoneCB[ objectName ] == 'done' ) {			
			callback( objectName )
		}else{
			setTimeout( function( ) {
				mw.waitForObject( objectName, callback, _callNumber);
			}, 25);
		}
	}
	
	/**
	* Check if an object is empty or if its an empty string. 
	*
	* @param {Object} object Object to be checked
	*/ 
	mw.isEmpty = function( object ) {		
		if( typeof object == 'string' ) { 
			if( object == '' ) return true;
			// Non empty string: 
			return false;
		}
		
		// If an array check length:
		if( Object.prototype.toString.call( object ) === "[object Array]"
			&& object.length == 0 ) {
			return true;
		}
		
		// Else check as an object: 
		for( var i in object ) { return false; }
		
		// Else object is empty:
		return true;
	}
	
	/**
	* Log a string msg to the console
	* 
	* all mw.log statements will be removed on minification so
	* lots of mw.log calls will not impact performance in non debug mode
	*
	* @param {String} string String to output to console
	*/
	mw.log = function( string ) {
		// Add any prepend debug strings if necessary 
		
		if ( mw.getConfig( 'pre-append-log' ) )
			string = mw.getConfig( 'pre-append-log' ) + string;
				
		if ( window.console ) {
			window.console.log( string );
		} else {	
			/**
			 * Old IE and non-Firebug debug: ( commented out for now ) 
			 */
			/*

			var log_elm = document.getElementById('mv_js_log');
			if(!log_elm) {
				document.getElementsByTagName("body")[0].innerHTML = document.getElementsByTagName("body")[0].innerHTML +
					'<div style="position:absolute;z-index:500;bottom:0px;left:0px;right:0px;height:200px;">'+
					'<textarea id="mv_js_log" cols="120" rows="12"></textarea>'+
					'</div>';
	
				var log_elm = document.getElementById('mv_js_log');
			}
			if(log_elm) {
				log_elm.value+=string+"\n";
			}
			*/
			
		}
	}
	
	/**
	* Get a loading spinner html
	* NOTE: this is depreciated use jQuery binding $j(target).loadingSpinner()" instead 
	*
	* @param {String} [Optional] style Style string to apply to the spinner 
	*/
	mw.loading_spinner = function( style ) {
		var style_txt = ( style ) ? style : '';
		return '<div class="loading_spinner" style="' + style_txt + '"></div>';
	}
	
	
	//Setup the local mwOnLoadFunctions array: 
	var mwOnLoadFunctions = [];
	
	//mw Ready flag ( set once mwEmbed is ready ) 
	var mwReadyFlag = false;
	
	/**
	* Enables load hooks to run once DOM is "ready" 
	* Will ensure jQuery is available, is in the $j namespace 
	* and mw interfaces and configuration has been loaded and applied
	* 
	* This is different from jQuery(document).ready() 
	* ( jQuery ready is not friendly with dynamic includes
	*  and core interface asynchronous build out. ) 
	*
	* @param {Function} callback Function to run once DOM and jQuery are ready
	*/
	mw.ready = function( callback ) {						
		if( mwReadyFlag === false ) {
		
			// Add the callbcak to the onLoad function stack
			mwOnLoadFunctions.push ( callback );
						
			// Set the mwSetup flag. So that onLoad functions can 
			// be called once mwEmbed interfaces are setup.
			if( !mwDomReadyFlag ) { 
				//mw.log( 'set config flag' );
				mw.setConfig( 'runSetupMwEmbed', true );
			}else{
				mw.log( 'run setup directly' );
				//DOM is already ready run setup directly ( will run mwOnLoadFunctions on finish )
				mw.setupMwEmbed(); 
			} 			
			
			return ;
		}
		// If mwReadyFlag is already "true" issue the callback directly:
		callback();		
	}	
	
	/**
	* Runs all the queued functions
	*/ 
	mw.runReadyHooks = function ( ) {		
		// Run all the queued functions: 
		while( mwOnLoadFunctions.length ) {
			mwOnLoadFunctions.pop()();
		}
		
		// Sets mwReadyFlag to true so that future addOnLoadHook calls 
		//  know to call the callback directly
		mwReadyFlag = true;
	}
	
	
	/**
	* Wrapper for jQuery getScript, 
	* Uses the scriptLoader if enabled
	* 
	*
	* @param {String} scriptRequest The requested path or classNames for the scriptLoader
	* @param {Function} callback Function to call once script is loaded   
	*/
	mw.getScript = function( scriptRequest, callback ) {
		// Setup the local callback 
		var myCallback = function(){
			if( callback )
				callback( scriptRequest );
		}
		// Set the base url based scriptLoader availability & type of scriptRequest
		// ( presently script loader only handles "classes" not relative urls: 
		var scriptLoaderPath = mw.getScriptLoaderPath();
		
		// Check if its a class name, ( ie does not start with "/" and does not include :// 
		var isClassName = ( scriptRequest.indexOf('://') == -1 && scriptRequest.indexOf('/') !== 0 )? true : false; 
		
		var ext = scriptRequest.substr( scriptRequest.lastIndexOf( '.' ), 4 ).toLowerCase();
		var isCssFile = ( ext == '.css') ? true : false ;
		
		if( scriptLoaderPath &&  isClassName ) {
			url = scriptLoaderPath + '?class=' + scriptRequest;				
		} else {
			// Add the mwEmbed path if a relative path request
			url = ( isClassName ) ? mw.getMwEmbedPath() : '';
			url+= scriptRequest; 
		}
	
		// Add on the request parameters to the url:
		url += ( url.indexOf( '?' ) == -1 )? '?' : '&';				
		url += mw.getUrlParam();		
				
				
		mw.log( 'mw.getScript: ' + url );
		
		// If jQuery is available and debug is off load the scirpt via jQuery 
		//( will use XHR if on same domain ) 
		if( mw.isset( 'window.jQuery' ) 
			&& mw.getConfig( 'debug' ) === false 
			&& !isCssFile ) 
		{	
			$j.getScript( url, myCallback); 		
			return ;
		}	
				
		/**
		* No jQuery 
		*  OR 
		* In debug mode
		*  OR
		* Is css file
		*
		* :: inject the script instead of doing an XHR eval
		*/			
		
		// load sytle sheet directly if requested loading css
		if( isCssFile ){
			mw.getStyleSheet( url, myCallback);
			return ;
		}
		
		// Load and bind manually:  ( copied from jQuery ajax function )
		var head = document.getElementsByTagName("head")[ 0 ];
		var script = document.createElement("script");
		script.setAttribute( 'src', url );		
			
		// Attach handlers ( if using script loader it issues onDone callback as well )	 		
		script.onload = script.onreadystatechange = function() {		
			if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
				myCallback();
			}
		};
		//mw.log(" append script: " + script.src );
		// Append the script to the DOM:
		head.appendChild( script );			
	};
	
	/**
	* Add a style sheet string to the document head
	*
	* @param {String} cssClassName Name of style sheet that has been defined
	* @param {String} cssString Css Payload to be added to head of document
	*/
	mw.addStyleString = function( cssClassName,  cssString ) {
		// Set the style to true ( to not request it again )
		mw.style[ cssClassName ] = true;
		mw.log(" Style: " + cssClassName + ' has been set' );
		// Wait for the DOM to be ready before adding in the css:
		mw.ready( function() {
			$j( 'head' ).append(
				$j( '<style/>' )
				.attr( {
					'type' : 'text/css',
					'media': 'all'
				})
				.text(
					cssString
				)
			);
		} );
	};
	
	/**
	* Get a style sheet and append the style sheet to the DOM
	*
	* @param {Mixed}
	*	{String} url Url of the style sheet to be loaded
	* 	{Function} callback Function called once sheet is ready 
	*/
	mw.getStyleSheet = function( url , callback) {		
		// Add URL params ( if not already included )
		if ( url.indexOf( '?' ) == -1 ) {
			url += '?' + mw.getUrlParam();
		}
		
		// Check if style sheet is already included:
		var foundSheet = false; 
		$j( 'link' ).each( function() {
			var currentSheet = $j( this) .attr( 'href' );
			var sheetParts = currentSheet.split('?');		
			var urlParts = url.split('?');
			//if the base url's match check the parameters:
			if( sheetParts[0] == urlParts[0] && sheetParts[1]) {
				//mw.log(" sheet compare: " + sheetParts[1].split( '&' ).sort().join('') + ' != ' + urlParts[1].split('&').sort().join(''));
				//Check if url params match ( sort to do string compare )						
				if( sheetParts[1].split( '&' ).sort().join('') ==
						urlParts[1].split('&').sort().join('') ) {	 
					foundSheet = true;
				}
			}
		} );					
		if( foundSheet ) {
			mw.log( 'skiped sheet: ' + url);
			if( callback) { 
				callback();
			}
			return ;
		}
		
		mw.log( ' add css: ' + url );		
		$j( 'head' ).append( 
			$j('<link />').attr( {
				'rel' : 'stylesheet',
				'type' : 'text/css',
				'href' : url
			} )
		);
		// Precently no easy way to check css "onLoad" attribute 
		// In genneral sheets are loaded via script-loader. 
		if( callback ) {
			callback();
		}
	};
	
	/**
	* Get the api url for a given content provider key
	* @return {Mixed}
	*	url for the provider
	* 	local wiki api if no apiProvider is set
	*/ 
	mw.getApiProviderURL = function( providerId ) {		
		if( mw.getConfig( providerId + '_apiurl') ) {
			return mw.getConfig( providerId + '_apiurl');
		}
		return mw.getLocalApiUrl(); 
	};
	
	/** 
	* Get Api URL from mediaWiki page defined variables
	* @return {Mixed}
	* 	api url
	* 	false
	*/
	mw.getLocalApiUrl = function() {
		if ( typeof wgServer != 'undefined' && typeof wgScriptPath  != 'undefined' ) {
			return wgServer + wgScriptPath + '/api.php';
		}
		return false;
	};
	
	// Local mwEmbedPath variable ( for cache of mw.getMwEmbedPath )
	var mwEmbedPath = null;
				
	/**
	* Get the path to the mwEmbed folder
	*/
	mw.getMwEmbedPath = function() {
		if ( mwEmbedPath ) {
			return mwEmbedPath;
		}	
			
		// Get mwEmbed src:
		var src = mw.getMwEmbedSrc();		
		var mwpath = null;
		
		// Check for direct include of the mwEmbed.js
		if ( src.indexOf( 'mwEmbed.js' ) !== -1 ) {
			mwpath =  src.substr( 0, src.indexOf( 'mwEmbed.js' ) );			
		}
		
		// Check for scriptLoader include of mwEmbed: 
		if ( src.indexOf( 'mwScriptLoader.php' ) !== -1 ) {
			// Script loader is in the root of MediaWiki, Include the default mwEmbed extension path:
			mwpath =  src.substr( 0, src.indexOf( 'mwScriptLoader.php' ) ) + mw.getConfig( 'mediaWikiEmbedPath' );						
		}
		
		// Script-loader has jsScriptLoader name when local:
		if( src.indexOf( 'jsScriptLoader.php' ) !== -1 ) {
			mwpath = src.substr( 0, src.indexOf( 'jsScriptLoader.php' ) );			
		}	
		
		// Error out if we could not get the path:
		if( mwpath === null ) {
			mw.log( "Error could not get mwEmbed path " );
			return ;
		}
		
		// Update the cached var with the absolute path: 
		mwEmbedPath = mw.absoluteUrl( mwpath )	;			
		return mwEmbedPath;
	}
	
	/**
	* Get Script loader path 
	*
	* @returns {String}|{Boolean}
	* 	Url of the scriptLodaer
	*	false if the scriptLoader is not used
	*/
	mw.getScriptLoaderPath = function( ) {		
		var src = mw.getMwEmbedSrc();
		if ( src.indexOf( 'mwScriptLoader.php' ) !== -1  ||
			src.indexOf( 'jsScriptLoader.php' ) !== -1 )
		{
			// Return just the script part of the url
			return src.split('?')[0];						
		}
		return false;
	}

	/**
	 * Given a float number of seconds, returns npt format response.
	 *
	 * @param {Float} sec Seconds
	 * @param {Boolean} show_ms If milliseconds should be displayed.
	 * @return String npt format  
	 * @type {Float} 
	 */
	mw.seconds2npt = function( sec, show_ms ) {
		if ( isNaN( sec ) ) {
			// mw.log("warning: trying to get npt time on NaN:" + sec);
			return '0:0:0';
		}
		var hours = Math.floor( sec / 3600 );
		var minutes = Math.floor( ( sec / 60 ) % 60 );
		var seconds = sec % 60;
		// Round the number of seconds to the required number of significant digits
		if ( show_ms ) {
			seconds = Math.round( seconds * 1000 ) / 1000;
		} else {
			seconds = Math.round( seconds );
		}
		if ( seconds < 10 )
			seconds = '0' +	seconds;
		if ( minutes < 10 )
			minutes = '0' + minutes;
	
		return hours + ":" + minutes + ":" + seconds;
	}
	
	/**
	* Take hh:mm:ss,ms or hh:mm:ss.ms input, return the number of seconds
	*
	* @param {String} npt_str NPT time string
	* @return Number of seconds 
	* @type {Float} 
	*/
	mw.npt2seconds = function ( npt_str ) {
		if ( !npt_str ) {
			// mw.log('npt2seconds:not valid ntp:'+ntp);
			return false;
		}
		// Strip {npt:}01:02:20 or 32{s} from time  if present
		npt_str = npt_str.replace( /npt:|s/g, '' );
	
		var hour = 0;
		var min = 0;
		var sec = 0;
	
		times = npt_str.split( ':' );
		if ( times.length == 3 ) {
			sec = times[2];
			min = times[1];
			hour = times[0];
		} else if ( times.length == 2 ) {
			sec = times[1];
			min = times[0];
		} else {
			sec = times[0];
		}
		// Sometimes a comma is used instead of period for ms
		sec = sec.replace( /,\s?/, '.' );
		// Return seconds float
		return parseInt( hour * 3600 ) + parseInt( min * 60 ) + parseFloat( sec );
	}	
	
	// Local mwEmbedSrc variable ( for cache of mw.getMwEmbedSrc )
	var mwEmbedSrc = null; 
	
	/**
	* Gets the mwEmbed script src attribute
	*/
	mw.getMwEmbedSrc = function() {
		if ( mwEmbedSrc ) {
			return mwEmbedSrc;
		}
			
		// Get all the javascript includes:
		var js_elements = document.getElementsByTagName( "script" );
		for ( var i = 0; i < js_elements.length; i++ ) {
			// Check for mwEmbed.js and/or script loader
			var src = js_elements[i].getAttribute( "src" );
			if ( src ) {
				if ( 
					( src.indexOf( 'mwEmbed.js' ) !== -1 &&  src.indexOf( 'MediaWiki:Gadget') == -1 )
				 	|| 
				 	( 
				 		( src.indexOf( 'mwScriptLoader.php' ) !== -1 || src.indexOf( 'jsScriptLoader.php' ) !== -1 )
						&& 
						src.indexOf( 'mwEmbed' ) !== -1 
					) 
				) {
					mwEmbedSrc = src;
					return mwEmbedSrc;
				}
			}
		}
		mw.log( 'Error: getMwEmbedScriptURL failed to get script path' );
		return false;
	}	
	
	// Local mwUrlParam variable ( for cache of mw.getUrlParam )
	var mwUrlParam = null;
	
	/**
	* Get URL Parameters per parameters in the host script include
	*/
	mw.getUrlParam = function() {
		if ( mwUrlParam )
			return mwUrlParam;
			
		var mwEmbedSrc = mw.getMwEmbedSrc();		
		var req_param = '';
		
		// If we already have a URI, add it to the param request:
		var urid = mw.parseUri( mwEmbedSrc ).queryKey['urid']
		
		// If we're in debug mode, get a fresh unique request key and pass on "debug" param
		if ( mw.parseUri( mwEmbedSrc ).queryKey['debug'] == 'true' ) {		
			mw.setConfig( 'debug', true );			
			var d = new Date();
			req_param += 'urid=' + d.getTime() + '&debug=true';			
				
		} else if ( urid ) {
			 // Just pass on the existing urid:							
			req_param += 'urid=' + urid;			
		} else {
			// Otherwise, Use the mwEmbed version
			req_param += 'urid=' + mw.version;
		}
		
		// Add the language param if present:
		var langKey = mw.parseUri( mwEmbedSrc ).queryKey['uselang'];
		if ( langKey )
			req_param += '&uselang=' + langKey;
		
		// Update the local cache and return the value	
		mwUrlParam = req_param;			
		return mwUrlParam;
	}
	
	/** 
	* Replace url parameters via newParams key value pairs
	* 
	* @param {String} url Source url to be updated
	* @param {Object} newParams key, value paris to swap in
	* @return {String}
	*	the updated url
	*/  
	mw.replaceUrlParams = function( url, newParams ) {
		var parsedUrl = mw.parseUri( url );			
		
		if ( parsedUrl.protocol != '' ) {
			var new_url = parsedUrl.protocol + '://' + parsedUrl.authority + parsedUrl.path + '?';
		} else {
			var new_url = parsedUrl.path + '?';
		}
				
		// Merge new params: 
		for( var key in newParams ) {
			parsedUrl.queryKey[ key ] = newParams[ key ];  
		}
				
		// Output to new_url
		var amp = '';
		for ( var key in  parsedUrl.queryKey ) {
			var val = parsedUrl.queryKey[ key ];		
			new_url += amp + key + '=' + val;
			amp = '&';
		}
		return new_url;
	}
	
	/**
	* parseUri 1.2.2
	* (c) Steven Levithan <stevenlevithan.com>
	*  MIT License
	*/		
	mw.parseUri = function (str) {
		var	o   = mw.parseUri.options,
			m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
			uri = {},
			i   = 14;
	
		while (i--) uri[o.key[i]] = m[i] || "";
	
		uri[o.q.name] = {};
		uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
			if ($1) uri[o.q.name][$1] = $2;
		});
	
		return uri;
	};
	
	/**
	* Parse URI function
	*
	* For documentation on its usage see: 
	* http://stevenlevithan.com/demo/parseuri/js/
	*/
	mw.parseUri.options = {
		strictMode: false,
		key: ["source", "protocol", "authority", "userInfo", "user","password","host","port","relative","path","directory","file","query","anchor"],
		q:   {
			name:   "queryKey",
			parser: /(?:^|&)([^&=]*)=?([^&]*)/g
		},
		parser: {
			strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
			loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
		}
	};	
	
	/**
	* getAbsoluteUrl takes a src and returns the absolute location given the document.URL
	*
	* @param {String} src path or url
	* @return {String} absolute url
	*/
	mw.absoluteUrl = function( src, contextUrl ) {
		var parsedSrc =  mw.parseUri( src );		
		// Source is already absolute return:
		if( parsedSrc.protocol != '')
			return src;				
		
		// Get parent Url location the context URL	
		if( contextUrl) {	
			var parsedUrl = mw.parseUri( contextUrl );			
		} else {
			var parsedUrl = mw.parseUri( document.URL );
		}
		
		// Check for leading slash: 
		if( src.indexOf( '/' ) === 0 ) {
			return parsedUrl.protocol + '://' + parsedUrl.authority + src;
		}else{
			return parsedUrl.protocol + '://' + parsedUrl.authority + parsedUrl.directory + src;
		}
	};	
	
	/**
	 * Escape quotes in a text string
	 * @param {String} text String to be escaped
	 * @return {string} 
	 * 	escaped text string  
	 */
	mw.escapeQuotes = function( text ) {
		var re = new RegExp("'","g");
		text = text.replace(re,"\\'");
		re = new RegExp("\\n","g");
		text = text.replace(re,"\\n");
		return mw.escapeQuotesHTML(text);
	};
	
	/**
	 * Escape an HTML text string
	 * @param {String} text String to be escaped
	 * @return {string} 
	 * 	escaped text html string  
	 */
	mw.escapeQuotesHTML = function( text ) {
		var re = new RegExp('&',"g");
		text = text.replace(re,"&amp;");
		re = new RegExp('"',"g");
		text = text.replace(re,"&quot;");
		re = new RegExp('<',"g");
		text = text.replace(re,"&lt;");
		re = new RegExp('>',"g");
		text = text.replace(re,"&gt;");
		return text;
	};
	
	/**
	* Takes in a string returns an xml dom object 
	* 
	* NOTE: this should be depreciated in favor of jquery xml parsing
	* $j( xml_string )
	*
	* @param {String} str String of XML content to be parsed
	* @return 
	* 	{Object} XML
	*	false If XML could not be parsed 
	*
	*/
	mw.parseXML = function ( str ) {
		if ( $j.browser.msie ) {
			// Attempt to parse as XML for IE
			var xmldata = new ActiveXObject( "Microsoft.XMLDOM" );
			xmldata.async = "false";
			try{
				xmldata.loadXML( str );
				return xmldata;
			} catch (e) {
				mw.log( 'XML parse ERROR: ' + e.message );
				return false;
			}
		}
		
		// For others (Firefox, Safari etc, older browsers 
		// Some don't have native DOMParser either fallback defined bellow.
		try {
			var xmldata = ( new DOMParser() ).parseFromString( str, "text/xml" );
		} catch ( e ) {
			mw.log( 'XML parse ERROR: ' + e.message );
			return false;
		}		
		return xmldata;
	}
		
	// Array of setup functions
	var mwSetupFunctions = [];
	
	/**
	* Add a function to be run durring setup ( prior to mw.ready) 
	* this is usefull for building out interfaces that 
	* should be ready before mw.ready is called. 
	*
	* @param {callback} Function Callback function must
	* 	 accept a ready function callback to be called once 
	* 	 setup is done    
	*/
	mw.addSetupHook = function( callback ) {
		mwSetupFunctions.push ( callback ) ;
	};
	
	/**
	* One time "setup" for mwEmbed 
	* run onDomReady ( so calls to setConfg apply to setup )
	*/
	// Flag to ensure setup is only run once:
	var mwSetupFlag = false;	
	mw.setupMwEmbed = function ( ) {			
		// Only run the setup once: 
		if( mwSetupFlag )
			return ;			
			  
		mwSetupFlag = true;
		
		mw.log( 'mw:setupMwEmbed :: ' + mw.getMwEmbedSrc() );			
		
		// Set the User language
		if( typeof wgUserLanguage != 'undefined' && mw.isValidLang( wgUserLanguage) ) {				
			mw.setConfig( 'userLanguage', wgUserLanguage )
		}else{
			// Grab it from the included url
			var langKey = mw.parseUri( mw.getMwEmbedSrc() ).queryKey['uselang'];
			if ( langKey && mw.isValidLang( langKey ) ) {	
				mw.setConfig( 'userLanguage', langKey);
			}
		}
	
		// Make sure we have jQuery and the common skin
		// NOTE mw.style.common should be factored out into 
		// seperate module specifc classes 
		mw.load( 'window.jQuery', function() {							
			if ( ! window[ '$j' ] ) {
				window[ '$j' ] = jQuery.noConflict();				
			}
			
			mw.setConfig( 'images_path', mw.getMwEmbedPath() + 'skins/common/images/' );										
			
			// Set up AJAX to not send dynamic URLs for loading scripts
			$j.ajaxSetup( {
				cache: true
			} );
			
			// Update the magic keywords 		
			mw.lang.magicSetup();
			
			// Set up mvEmbed utility jQuery bindings
			mw.dojQueryBindings();						
			
			// Make sure style sheets are loaded: 
			mw.load( [
				'mw.style.common',
				'mw.style.' + mw.getConfig( 'jQueryUISkin' )				 
			], function(){	
				// Run all the setup function hooks
				// Once complete we can run .ready queued functions  
				function runSetupFunctions() {
					if( mwSetupFunctions.length ) {
						mwSetupFunctions.pop()( function() {
							runSetupFunctions();
						} );
					}else{
						mw.runReadyHooks();
					}
				}
				runSetupFunctions();	
			});
		});		
	};
	
	/**
	* Check for module loaders, and localization
	* 
	* Note if using a scriptLoader all the loaders and localization converters 
	*  are included automatically. 
	*/
	mw.moduleLoaderCheck = function( callback ) {
		mw.log( 'doLoaderCheck::' );
		
		// Check if we are using scriptloader ( handles loader include automatically ) 
		if( mw.getScriptLoaderPath() ) {
			// Do a async call to callback in cases where DOM is ready before we get to 
			// loader config code in the same file. 
			setTimeout(function() {
				callback();				
			}, 1000);
			return ;
		}
		
		// Add the Core loader to the request
		mw.load( 'loader.js', function() {					
			// Load all the "loaders" of the enabled modules:
			var loaderRequest = [];			
			var enabledModules = mw.getConfig( 'enabledModules' );		
			for(var i=0; i < enabledModules.length; i++ ) {
				loaderRequest.push( 'modules/' + enabledModules[ i ] + '/loader.js' );
			};	
			
			// Add the language ( if set )
			if( mw.getConfig( 'userLanguage' ) ) {
				var langCode = mw.getConfig( 'userLanguage' );
				
				// Grab the language if language class if not default 'en' and 
				// the langCode has a transform Class 
				if( langCode != 'en' && mw.hasLangTransform( langCode ) ){				
					// Upper case the first letter:
					langCode = langCode.substr(0,1).toUpperCase() + langCode.substr( 1, langCode.length );
					loaderRequest.push( 'languages/classes/Language' +
						langCode + '.js' );
				}
			}
								 
			mw.setConfig('loaderContext', '' );
			mw.load( loaderRequest, function() {
				mw.log( 'Done moduleLoaderCheck request' );
				// Set the mwModuleLoaderCheckFlag flag to true
				mwModuleLoaderCheckFlag = true;
				callback();
			} );
		} );				
	}
	
	/**
	* Checks if a css style rule exists 
	*
	* On a page with lots of rules it can take some time 
	* so avoid calling this function where possible and 
	* cache its result
	*
	* NOTE: this only works for style sheets on the same domain :(
	* 
	* @param {String} styleRule Style rule name to check
	* @return 
	*	true if the rule exists
	*	false if the rule does not exist
	* @type {Boolean}
	*/
	mw.styleRuleExists = function ( styleRule ) {
		// Set up the skin paths configuration		
		for( var i=0 ; i < document.styleSheets.length ; i++ ) {
			var rules = null;			
			try{
				if ( document.styleSheets[i].cssRules )
					rules = document.styleSheets[i].cssRules
				else if (document.styleSheets[0].rules)
					rules = document.styleSheets[i].rules
				for(var j=0 ; j < rules.length ; j++ ) {
					var rule = rules[j].selectorText;											
					if( rule && rule.indexOf( styleRule ) != -1 ) {
						return true;
					}		
				}
			}catch ( e ) {
				mw.log( 'Error: cant check rule on cross domain style sheet:' + document.styleSheets[i].href );
			}
		}
		return false;	
	}
	
	// Flag to register the domReady has been called
	var mwDomReadyFlag = false;
	
	// Flag to register if the domreadyHooks have been called
	var mwModuleLoaderCheckFlag = false;
	
	// Functions to run on DOM ready
	var mwOnDOMReadyFunctions = [];
	
	/**
	* Dom ready hooks are for module loaders that want to conditionally
	* set setup hooks. 
	*
	* This enables modules to build out interfaces asynchronously 
	* to be "ready" at mw.ready call time.  
	*
	* @param {Function} callback Function to be called at dom ready
	*/
	mw.addDOMReadyHook = function( callback ) {	
		if ( mwModuleLoaderCheckFlag ) {
			mw.log( "Possible Error: calling mw.addDOMReadyHook after moduleLoader check" );		
			callback ( );
		} else {							
			// Add the dom ready check to the function queue: 
			mwOnDOMReadyFunctions.push( callback );
		}
	}

	/**
 	* This will get called when the DOM is ready 
 	* Will check configuration and issue a mw.setupMwEmbed call if needed
	*/
	mw.domReady = function ( ) {
		if( mwDomReadyFlag ) {
			return ;		
		}	
		mw.log( 'run:domReady:: ' + document.getElementsByTagName('video').length );
		// Set the onDomReady Flag
		mwDomReadyFlag = true;	
			
		// Make sure we have all the module loader.js files included 
		// ( where we are not using the script-loader )
		mw.moduleLoaderCheck( function( ) {	
				
			// Run dom ready hooks: 
			while( mwOnDOMReadyFunctions.length ) {
				mwOnDOMReadyFunctions.pop()();
			}
												
			// Check for the force setup flag:
			if ( mw.getConfig( 'runSetupMwEmbed' ) ) {
				mw.setupMwEmbed();
				return ;
			}				
			
			// Check for queued functions that use mw interfaces: 
			if ( mwOnLoadFunctions.length ) {
				mw.setupMwEmbed();
				return ;
			}	
		});
	}	
	
	/**
	* A version comparison utility function
	* Handles version of types {Major}.{MinorN}.{Patch}
	*
	* Note this just handles version numbers not patch letters.
	*
	* @param {String} minVersion Minnium version needed
	* @param {String} clientVersion Client version to be checked
		
	* @return 
	* 	true if the version is at least of minVersion
	* 	false if the version is less than minVersion
	*/
	mw.versionIsAtLeast = function( minVersion, clientVersion ) {
		var minVersionParts = minVersion.split('.')
		var clientVersionParts = clientVersion.split('.');
		for( var i =0; i <  minVersionParts.length; i++ ) {
			if( parseInt( clientVersionParts[i] ) > parseInt( minVersionParts[i] ) ) {
				return true;
			}
			if( parseInt( clientVersionParts[i] ) < parseInt( minVersionParts[i] ) ) {
				return false;
			}
		}
		// Same version:
		return true;
	}
	 
	/**
	 * Utility jQuery bindings
	 *  Setup after jQuery is available ). 
	 */
	mw.dojQueryBindings = function() {
		mw.log( 'mw.dojQueryBindings' );
		( function( $ ) {
		
			/**
			* Set a given selector html to the loading spinner:
			*/
			$.fn.loadingSpinner = function( ) {
				if ( this ) {
					$j( this ).html(
						$j( '<div />' )
						.addClass( "loading_spinner" )  
					 );
				}			
				return this;
			}
			
			/**
			* dragDrop file loader 
			*/
			$.fn.dragFileUpload = function ( conf ) {
				if ( this.selector ) {
					var _this = this;
					// load the dragger and "setup"
					mw.load( ['$j.fn.dragDropFile'], function() {
						$j( _this.selector ).dragDropFile();
					} );
				}
			}							
	
			/**
			 *  Shortcut to a themed button
			 *  Should be depreciated for $.button bellow
			 */
			$.btnHtml = function( msg, className, iconId, opt ) {
				if ( !opt )
					opt = { };
				var href = ( opt.href ) ? opt.href : '#';
				var target_attr = ( opt.target ) ? ' target="' + opt.target + '" ' : '';
				var style_attr = ( opt.style ) ? ' style="' + opt.style + '" ' : '';
				return '<a href="' + href + '" ' + target_attr + style_attr +
					' class="ui-state-default ui-corner-all ui-icon_link ' +
					className + '"><span class="ui-icon ui-icon-' + iconId + '" ></span>' +
					'<span class="btnText">' + msg + '</span></a>';
			}
			
			// Shortcut to jQuery button ( should replace all btnHtml with button )
			var mw_default_button_options = {
				// The class name for the button link
				'class' : '',
				
				// The style properties for the button link
				'style' : { },
				
				// The text of the button link
				'text' : '',
				
				// The icon id that precceeds the button link:
				'icon_id' : 'carat-1-n' 
			}
			$.button = function( options ) {
				var options = $j.extend( mw_default_button_options, options);
				
				// Button: 
				var $btn = $j('<a />')			
					.attr('href', '#')
					.addClass( 'ui-state-default ui-corner-all ui-icon_link' );
				// Add css if set: 
				if( options.css ) {
					$btn.css( options.css )
				}
									
				if( options['class'] ) {
					$btn.addClass( options['class'] )
				}	
								
				$btn.append(
					$j('<span />').addClass( 'ui-icon ui-icon-' + options.icon_id ),
					$j('<span />').addClass( 'btnText' )
						.text( options.text )
				);
				return $btn;					
			}
			
			// Shortcut to bind hover state
			$.fn.buttonHover = function() {
				$j( this ).hover(
					function() {
						$j( this ).addClass( 'ui-state-hover' );
					},
					function() {
						$j( this ).removeClass( 'ui-state-hover' );
					}
				)
				return this;
			}
			
			/**
			* Resize a dialog to fit the window
			* @param {Object} options horizontal and vertical space ( default 50 )
			*/
			$.fn.dialogFitWindow = function( options ) {
				var opt_default = { 'hspace':50, 'vspace':50 };
				if ( !options )
					var options = { };
				options = $j.extend( opt_default, options );
				$j( this.selector ).dialog( 'option', 'width', $j( window ).width() - options.hspace );
				$j( this.selector ).dialog( 'option', 'height', $j( window ).height() - options.vspace );
				$j( this.selector ).dialog( 'option', 'position', 'center' );
					// update the child position: (some of this should be pushed up-stream via dialog config options
				$j( this.selector + '~ .ui-dialog-buttonpane' ).css( {
					'position':'absolute',
					'left':'0px',
					'right':'0px',
					'bottom':'0px'
				} );
			}	
			
		} )( jQuery );
	}	
	
} )( window.mw );


// Load in js2 stopgap global msgs into proper location: 
if ( typeof gMsg != 'undefined' ) {
	mw.addMessages( gMsg )
}

// Set global gM shortcut:
window[ 'gM' ] = mw.getMsg;


/**
* Add the core mvEmbed Messages ( will be localized by script server )
*/ 
mw.addMessages( {
	"mwe-loading_txt" : "Loading ...",
	"mwe-size-gigabytes" : "$1 GB",
	"mwe-size-megabytes" : "$1 MB",
	"mwe-size-kilobytes" : "$1 K",
	"mwe-size-bytes" : "$1 B",
	"mwe-error_load_lib" : "Error: JavaScript $1 was not retrievable or does not define $2",
	"mwe-apiproxy-setup" : "Setting up API proxy",
	"mwe-load-drag-item" : "Loading dragged item",
	"mwe-ok" : "OK",
	"mwe-cancel" : "Cancel",
	"mwe-enable-gadget" : "Enable multimedia beta ( mwEmbed ) for all pages",
	"mwe-enable-gadget-done" : "multimedia beta gadget has been enabled",
	"mwe-must-login-gadget" : "To enable gadget you must <a target=\"_new\" href=\"$1\">login</a>",
	"mwe-test-plural" : "I ran {{PLURAL:$1|$1 test|$1 tests}}"
} );


/**
* Set DOM-ready call 
*
* Does not use jQuery( document ).ready( ) because 
*  * mwEmbed could have been included without jQuery.
*  * and jQuery( document ).ready( ) does not work 
* 	well with dynamic includes
*/
function domReadyCheck() {
  mw.domReady();
}
( function( i ) {
  var u = navigator.userAgent.toLowerCase();
  var ie = /*@cc_on!@*/false;
  if (/webkit/.test(u)) {
    // safari
    timeout = setTimeout(function() {
			if ( document.readyState == "loaded" || 
				document.readyState == "complete" ) {
				i();
			} else {
			  setTimeout(arguments.callee,10);
			}
		}, 10); 
  } else if ((/mozilla/.test(u) && !/(compatible)/.test(u)) ||
             (/opera/.test(u))) {
    // opera/moz
    document.addEventListener("DOMContentLoaded", i, false);
  } else if ( ie ) {
    // IE
    (function ( ) { 
      var tempNode = document.createElement('document:ready'); 
      try {
        tempNode.doScroll('left'); 
        i(); 
        tempNode = null; 
      } catch(e) { 
        setTimeout(arguments.callee, 0); 
      } 
    })();
  } else {
    window.onload = i;
  }
})( domReadyCheck );

// As a backup check if "body" is not null ( for dynamic inserts )
// ( mw.domReady ignores multiple ready calls )
var mwCheckBody = function( ) {
	if( document.getElementsByTagName( 'body' )[0] ) {
		 mw.domReady();
	}else{
		setTimeout( function( ) {
			mwCheckBody();
		}, 25);
	}
} 
// Call with substatial timeout of 250ms
// ( This is just fallback method for 
//  dynamic inserts of mwEmbed ( rare ) )
setTimeout( function( ) {
	mwCheckBody();
}, 250);

// Somewhat weird hack to keep jQuery in $ when its
// already there, but also use noConflict to get $j. 
if( window.jQuery ){
	var dollarFlag = false;	
	if( $ && $.fn && $.fn.jquery ){
		// NOTE we could check the version of
		// jQuery and do a removal call if too old
		dollarFlag = true;		
	}
	window['$j'] = jQuery.noConflict();
	if( dollarFlag ) {
		window['$'] = jQuery.noConflict();
	}
}
