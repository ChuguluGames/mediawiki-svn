/**
 * A media element corresponding to a <video> element.
 *
 * It is implemented as a collection of mediaSource objects. The media sources
 * will be initialized from the <video> element, its child <source> elements,
 * and/or the ROE file referenced by the <video> element.
 *
 * @param {element}
 *      videoElement <video> element used for initialization.
 * @constructor
 */
function mediaElement( element ) {
	this.init( element );
}

mediaElement.prototype = {

	// The array of mediaSource elements.
	sources: null,

	// flag for ROE data being added.
	addedROEData: false,

	// Selected mediaSource element.
	selectedSource: null,

	/**
	 * Media Element constructor
	 *
	 * Sets up a mediaElement from a provided top level "video" element adds any
	 * child sources that are found
	 *
	 * @param {Element}
	 *      videoElement Element that has src attribute or has children
	 *      source elements
	 */
	init: function( videoElement ) {
		var _this = this;
		mw.log( "EmbedPlayer::mediaElement:init:" + videoElement.id );
		this.sources = new Array();

		// Process the videoElement as a source element:
		if ( $( videoElement ).attr( "src" ) ) {
			_this.tryAddSource( videoElement );
		}

		// Process elements source children
		$( videoElement ).find( 'source,track' ).each( function( ) {
			_this.tryAddSource( this );
		} );
	},

	/**
	 * Updates the time request for all sources that have a standard time
	 * request argument (ie &t=start_time/end_time)
	 *
	 * @param {String}
	 *      start_npt Start time in npt format
	 * @param {String}
	 *      end_npt End time in npt format
	 */
	updateSourceTimes: function( start_npt, end_npt ) {
		var _this = this;
		$j.each( this.sources, function( inx, mediaSource ) {
			mediaSource.updateSrcTime( start_npt, end_npt );
		} );
	},

	/**
	 * Check for Timed Text tracks
	 *
	 * @return {Boolean} True if text tracks exist, false if no text tracks are
	 *     found
	 */
	textSourceExists: function() {
		for ( var i = 0; i < this.sources.length; i++ ) {
			if ( this.sources[i].mimeType == 'text/cmml' ||
				 this.sources[i].mimeType == 'text/x-srt' )
			{
					return true;
			}
		};
		return false;
	},

	/**
	 * Returns the array of mediaSources of this element.
	 *
	 * @param {String}
	 *      [mimeFilter] Filter criteria for set of mediaSources to return
	 * @return {Array} mediaSource elements.
	 */
	getSources: function( mimeFilter ) {
		if ( !mimeFilter ) {
			return this.sources;
		}
		// Apply mime filter:
		var source_set = new Array();
		for ( var i = 0; i < this.sources.length ; i++ ) {
			if ( this.sources[i].mimeType &&
				 this.sources[i].mimeType.indexOf( mimeFilter ) != -1 )
			{
				source_set.push( this.sources[i] );
			}
		}
		return source_set;
	},

	/**
	 * Selects a source by id
	 *
	 * @param {String}
	 *      source_id Id of the source to select.
	 * @return {MediaSource} The selected mediaSource or null if not found
	 */
	getSourceById:function( source_id ) {
		for ( var i = 0; i < this.sources.length ; i++ ) {
			if ( this.sources[i].id == source_id ) {
				return this.sources[i];
			}
		}
		return null;
	},

	/**
	 * Selects a particular source for playback updating the "selectedSource"
	 *
	 * @param {Number}
	 *      index Index of source element to set as selectedSource
	 */
	selectSource:function( index ) {
		mw.log( 'EmbedPlayer::mediaElement:selectSource:' + index );
		var playableSources = this.getPlayableSources();
		for ( var i = 0; i < playableSources.length; i++ ) {
			if ( i == index ) {
				this.selectedSource = playableSources[i];
				// Update the user selected format:
				mw.EmbedTypes.getMediaPlayers().setFormatPreference( playableSources[i].mimeType );
				break;
			}
		}
	},

	/**
	 * Selects the default source via cookie preference, default marked, or by
	 * id order
	 */
	autoSelectSource: function() {
		mw.log( 'EmbedPlayer::mediaElement::autoSelectSource' );
		var _this = this;
		// Select the default source
		var playableSources = this.getPlayableSources();
		var flash_flag = ogg_flag = false;

		// Check if there are any playableSources
		if( playableSources.length == 0 ){
			return false;
		}
		var setSelectedSource = function( source ){
			_this.selectedSource = source;
		};

		// Set via user-preference
		for ( var source = 0; source < playableSources.length; source++ ) {
			var mimeType = playableSources[source].mimeType;
			if ( mw.EmbedTypes.getMediaPlayers().preference[ 'format_preference' ] == mimeType ) {
				 mw.log( 'EmbedPlayer::autoSelectSource: Set via preference: ' + playableSources[source].mimeType );
				 setSelectedSource( playableSources[source] );
				 return true;
			}
		}
		
		// Set via module driven preference:
		$(this).trigger( 'AutoSelectSource', [ playableSources ] );
		if( _this.selectedSource ){
			return true;
		}

		// Set via marked default:
		for ( var source = 0; source < playableSources.length; source++ ) {
			if ( playableSources[ source ].markedDefault ) {
				mw.log( 'EmbedPlayer::autoSelectSource: Set via marked default: ' + playableSources[source].markedDefault );
				setSelectedSource( playableSources[source] );
				return true;
			}
		}
		
		// Prefer native playback ( and prefer WebM over ogg and h.264 )
		var namedSources = [];
		for ( var source = 0; source < playableSources.length; source++ ) {
			var mimeType = playableSources[source].mimeType;
			var player = mw.EmbedTypes.getMediaPlayers().defaultPlayer( mimeType );			
			if ( player && player.library == 'Native'	) {
				switch( player.id	){
					case 'oggNative': 
						namedSources['ogg'] = playableSources[ source ]; 
						break;
					case 'webmNative':
						namedSources['webm'] = playableSources[ source ]; 
						break;
					case 'h264Native':
						namedSources['h264'] = playableSources[ source ]; 
						break;
				}
			}
		}
		var codecPref =mw.getConfig( 'EmbedPlayer.CodecPreference');
		for(var i =0; i < codecPref.length; i++){
			var codec = codecPref[ i ];
			if( namedSources[ codec ]){
				setSelectedSource( namedSources[ codec ] );
				return true;
			}
		};
		

		// Set h264 via native or flash fallback
		for ( var source = 0; source < playableSources.length; source++ ) {
			var mimeType = playableSources[source].mimeType;
			var player = mw.EmbedTypes.getMediaPlayers().defaultPlayer( mimeType );
			if ( mimeType == 'video/h264'
				&& player
				&& (
					player.library == 'Native'
					||
					player.library == 'Kplayer'
				)
			) {
				mw.log('EmbedPlayer::autoSelectSource: Set h264 via native or flash fallback');
				 setSelectedSource( playableSources[ source ] );
				return true;
			}
		};

		// Else just select first source
		if ( !this.selectedSource ) {
			mw.log( 'EmbedPlayer::autoSelectSource: Set via first source:' + playableSources[0] );
			 setSelectedSource( playableSources[0] );
			return true;
		}
		// No Source found so no source selected
		return false;
	},

	/**
	 * check if the mime is ogg
	 */
	isOgg: function( mimeType ){
		if ( mimeType == 'video/ogg'
			|| mimeType == 'ogg/video'
			|| mimeType == 'video/annodex'
			|| mimeType == 'application/ogg'
		) {
			return true;
		}
		return false;
	},

	/**
	 * Returns the thumbnail URL for the media element.
	 *
	 * @returns {String} thumbnail URL
	 */
	getPosterSrc: function( ) {
		return this.poster;
	},

	/**
	 * Checks whether there is a stream of a specified MIME type.
	 *
	 * @param {String}
	 *      mimeType MIME type to check.
	 * @return {Boolean} true if sources include MIME false if not.
	 */
	hasStreamOfMIMEType: function( mimeType )
	{
		for ( var i = 0; i < this.sources.length; i++ )
		{
			if ( this.sources[i].getMIMEType() == mimeType ){
				return true;
			}
		}
		return false;
	},

	/**
	 * Checks if media is a playable type
	 */
	isPlayableType: function( mimeType ) {
		if ( mw.EmbedTypes.getMediaPlayers().defaultPlayer( mimeType ) ) {
			return true;
		} else {
			return false;
		}
	},

	/**
	 * Adds a single mediaSource using the provided element if the element has a
	 * 'src' attribute.
	 *
	 * @param {Element}
	 *      element <video>, <source> or <mediaSource> <text> element.
	 */
	tryAddSource: function( element ) {
		// mw.log( 'f:tryAddSource:' + $( element ).attr( "src" ) );
		var newSrc = $( element ).attr( 'src' );
		if ( newSrc ) {
			// make sure an existing element with the same src does not already
			// exist:
			for ( var i = 0; i < this.sources.length; i++ ) {
				if ( this.sources[i].src == newSrc ) {
					// Source already exists update any new attr:
					this.sources[i].updateSource( element );
					return this.sources[i];
				}
			}
		}
		// Create a new source
		var source = new mediaSource( element );

		this.sources.push( source );
		// mw.log( 'tryAddSource: added source ::' + source + 'sl:' +
		// this.sources.length );
		return source;
	},

	/**
	 * Get playable sources
	 *
	 * @returns {Array} of playable sources
	 */
	getPlayableSources: function() {
		 var playableSources = [];
		 for ( var i = 0; i < this.sources.length; i++ ) {
			 if ( this.isPlayableType( this.sources[i].mimeType ) ) {
				 playableSources.push( this.sources[i] );
			 } else {
				 mw.log( "type " + this.sources[i].mimeType + ' is not playable' );
			 }
		 };
		 return playableSources;
	}	
};

