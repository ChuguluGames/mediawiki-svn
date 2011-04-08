// Simple kdpClientIframe
( function( mw, $ ) {
	
var kdpClientIframe = function( replaceTargetId, kEmbedSettings , options ){
	// Create a Player Manager
	return this.init(replaceTargetId, kEmbedSettings , options);
};
kdpClientIframe.prototype = {
	// Stores all the registered callbacks 
	//( to avoid letting the iframe call arbitrary global js functions)
	globalCallbackRegister:{
		'jsCallbackReady': true
	},
	
	// Similar to jQuery.fn.kalturaIframePlayer in KalturaSupport/loader.js
	'init': function( replaceTargetId, kEmbedSettings , options ){
		var _this = this;
		// Update options via target size if not set
		this.width = (options.width) ? options.width : $( '#' + replaceTargetId ).width();
		this.height = (options.height) ? options.height : $( '#' + replaceTargetId ).height();
		this.kEmbedSettings = kEmbedSettings;	
		this.targetId = replaceTargetId;

				
		// Replace the target with an iframe player:
		$( '#' + replaceTargetId ).replaceWith( this.getIframe() );
		
		// Now add the player proxy		
		$( this.getIframe() ).after( 
			$('<div />').attr( 'id', this.targetId )
		);
		this.iFrameProxy = $('#' + this.targetId).get(0);

		// Set the iframe server
		var srcParts = mw.parseUri( mw.absoluteUrl( this.getIframeSrc() ) );
		this.iframeServer = srcParts.protocol + '://' + srcParts.authority;

		// Add exported kdp methods to iframe proxy: 
		this.addIframeKDPMethods();
		
		// Add hanldeReciveMsg binding: 
		$j.receiveMessage( function( event ){
			_this.hanldeReciveMsg( event );
		}, this.iframeServer);
				
	},
	'kdpExportedMethods': [ 'addJsListener', 'removeJsListener', 'sendNotification', 'setKDPAttribute' ],
	'addIframeKDPMethods': function(){
		var _this = this;
		// Setup local ref to iframe proxy: 
		var proxy = this.iFrameProxy;
		$j.each( this.kdpExportedMethods, function( inx, method ){
			proxy[method] = function(){
				mw.log( "KdpClient proxy method : " + method);
				var args = $j.makeArray( arguments );
				// Special local register of globals in addJsListener callbacks 
				// ( to limit what javascript the iframe can call )
				if( method == 'addJsListener'){					
					if( args[1] ){
						_this.globalCallbackRegister[ args[1] ] = true;
					}
				}
				$j.postMessage(
					JSON.stringify( {
						'method' : method,
						'args' : args
					} ), 
					mw.absoluteUrl( $( _this.iframe ).attr('src') ), 
					_this.iframe.contentWindow
				);
			};
		});
		// Evaluate needs local copy of all attributes that could be requested
		proxy.evaluate = function( objectString ){
			return _this.evaluate( objectString );
		};
	},
	'evaluate': function( objectString  ){		
		objectString = objectString.replace( /\{|\}/g, '' );
		var objectPath = objectString.split('.');
		// kaltura properties have up 3 levels deep
		if( this.evaluateData[ objectPath[0] ] && ! objectPath[1] ){
			return this.evaluateData[ objectPath[0] ];
		}
		if( this.evaluateData[ objectPath[0] ][ objectPath[1] ] && !objectPath[2] ){
			return this.evaluateData[ objectPath[0] ][ objectPath[1] ];
		}
		if( this.evaluateData[ objectPath[0] ][ objectPath[1] ][ objectPath[2] ] ){
			return this.evaluateData[ objectPath[0] ][ objectPath[1] ][ objectPath[2] ];
		}
		mw.log("Error: kdpClientFrame could not get property: " + objectString );
		return false;
	},
	/**
	 * Handle received events
	 */
	'hanldeReciveMsg': function( event ){
		var _this = this;		
		// Confirm the event is coming for the target host:
		if( event.origin != this.iframeServer){
			mw.log("kdpClientIframe:: Skip msg from host does not match iFrame player: " + event.origin + 
					' != iframe Server: ' + this.iframeServer );
			return ;
		};
		// Decode the message 
		var msgObject = JSON.parse( event.data );
		mw.log("KdpApiClient:: hanldeReciveMsg: " + msgObject.callbackName );
				
		// Update evaluateData
		if( msgObject.evaluateData ){
			this.evaluateData =  msgObject.evaluateData;
		};
		
		// We hash global functions to avoid the iframe calling arbitrary code. 
		if( msgObject.callbackName ) {
			var callbackArgs = ( msgObject.callbackArgs )? msgObject.callbackArgs : [];
			if( ! _this.globalCallbackRegister[ msgObject.callbackName ] ){
				mw.log("Error unregistered global callback from iframe");
				return ;
			}
			window[ msgObject.callbackName ].apply(this, msgObject.callbackArgs );
		}
	},
	'getIframeSrc': function(){
		var iframeSrc = SCRIPT_LOADER_URL.replace( 'ResourceLoader.php', 'mwEmbedFrame.php' );
		var kalturaAttributeList = { 'uiconf_id':1, 'entry_id':1, 'wid':1, 'p':1};
		for(var attrKey in this.kEmbedSettings ){
			if( attrKey in kalturaAttributeList ){
				iframeSrc+= '/' + attrKey + '/' + encodeURIComponent( this.kEmbedSettings[attrKey] );  
			}
		}			
		// Add configuration to the hash tag:
		iframeSrc+= mw.getIframeHash();
		return iframeSrc;
	},
	'getIframe': function(){
		if(!this.iframe ){
			this.iframe = $('<iframe />').attr({
				'src' : this.getIframeSrc(),
				'id' :  this.targetId + '_iframe',
				'width' : this.width,
				'height' : 	this.height
			})
			.css('border', '0px')
			.get(0);
		}
		return this.iframe;
	}
};

} )( window.mediaWiki, window.jQuery );