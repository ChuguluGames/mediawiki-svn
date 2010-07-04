/*
* Handles driving the firefogg render system 
*/

/*
* Set the jQuery bindings: 
*/ 
( function( $ ) {
	$.fn.firefoggRender = function( options, callback ) {
		if(!options)
			options = {};
		options.playerTarget = this.selector;		
		var myFogg = new mw.FirefoggRender( options );
		return myFogg;
	}		
} )( jQuery );


mw.FirefoggRender = function( options ) {
	return this.init( options );
};
// Set up the mvPlaylist object
mw.FirefoggRender.prototype = {
	
	// Default render options: 
	renderOptions: { 	
		"videoQuality" : 8,
		"framerate"	: 30
	},
	
	// Render time
	renderTime: null,
	
	// The interval time ( set via requested framerate) 
	interval: null,
	
	// Continue rendering
	continueRendering:false,

	// Start time for rendering
	startTime: 0,
		
	// Constructor 
	init:function( options ) {
		var _this = this;
		
		// Grab the mvFirefogg object to do basic tests
		this.myFogg = new mw.Firefogg( {
			'only_fogg':true
		});
		
		// Check for firefogg:
		if ( this.myFogg.getFirefogg() ) {
			this.enabled = true;
		} else {
			this.enabled = false;
			mw.log('Error firefogg not installed');
			return this;
		}
		
		// Setup local fogg pointer: 
		this.fogg = this.myFogg.fogg;
		
		// Setup player instance		
		this.playerTarget = options.playerTarget;		
		
		// Extend the render options with any provided details
		if( options['renderOptions'] ){
			this.renderOptions = $j.extend( this.renderOptions, options['renderOptions'] );
		}
		
		if( options ['statusTarget']){
			this.statusTarget = options ['statusTarget'];
		}
	
		
		// If no height width provided use target DOM width/height
		if( !this.renderOptions.width && !this.renderOptions.height ) {
			this.renderOptions.width = $j(this.playerTarget).width();
			this.renderOptions.height = $j(this.playerTarget).height();
		}		
		
		
	},
	
	// Start rendering
	doRender: function() {
		var _this = this;
		
		// Set the render time to "startTime" of the render request
		this.renderTime = this.startTime;
		
		// Get the interval from renderOptions framerate
		this.interval =  1 / this.renderOptions.framerate
		
		// Set the continue rendering flag to true:
		this.continueRendering = true;
		
		// Get the player:
		this.player = $j( this.playerTarget ).get( 0 );

		// Set a target file:
		mw.log( "Firefogg Render Settings:" + JSON.stringify( _this.renderOptions ) );
		this.fogg.initRender(  JSON.stringify( _this.renderOptions ), 'foggRender.ogv' );				
			
		// add audio if we had any:

		//now issue the save video as call
		_this.fogg.saveVideoAs();		
		_this.doNextFrame();		
	},
	
	/**
	* Do the next frame in the render target
	*/
	doNextFrame: function() {
		var _this = this;
		// internal function to handle updates:						
		mw.log( "FirefoggRender::doNextFrame: on " + ( Math.round( _this.renderTime * 10 ) / 10 ) + " of " +
			( Math.round( _this.player.getDuration() * 10 ) / 10 ) );
		
		_this.player.setCurrentTime( _this.renderTime, function() {								
			
			_this.fogg.addFrame( $j( _this.playerTarget ).attr( 'id' ) );
			$j( _this.statusTarget ).text( "AddFrame::" + ( Math.round( _this.renderTime * 1000 ) / 1000 ) );
			
			_this.renderTime += _this.interval;
			 
			if ( _this.renderTime >= _this.player.getDuration() || ! _this.continueRendering ) {
				_this.doFinalRender();
			} else {			
				// Don't block on render
				setTimeout(function(){
					_this.doNextFrame();
				},10 )
			}
		} );
	},
	
	/**	
	* Stop the current render process on the next frame
	*/
	stopRender: function() {
		this.continueRendering = false;
	},
	
	/**
	* Issue the call to firefogg to render out the ogg video
	*/ 
	doFinalRender: function() {
		mw.log("FirefoggRender:: doFinalRenderr" );
		this.fogg.render();
		this.updateStatus();
	},
	
	/**
	* Update the render status
	*/
	updateStatus: function() {
		var _this = this;
		var rstatus = _this.fogg.renderstatus();
	    $j( _this.statusTarget ).text( rstatus );
	    if ( rstatus != 'done' && rstatus != 'rendering failed' ) {
	        setTimeout( function() {
	        	_this.updateStatus();
	        }, 100 );
	    }
	}
}