/**
 * Creates an es.ViewContainer object.
 * 
 * View containers follow the operations performed on a model container and keep a list of views,
 * each correlating to a model in the model container.
 * 
 * @class
 * @constructor
 * @extends {es.EventEmitter}
 * @param containerModel {es.ModelContainer} Property name for list of items
 * @param typeName {String} Name to use in CSS classes and HTML element data
 * @param tagName {String} HTML element name to use (optional, default: "div")
 * @property $ {jQuery} Container element
 * @property views {Array} List of views, correlating to models in the model container
 */
es.ViewContainer = function( containerModel, typeName, tagName ) {
	es.EventEmitter.call( this );
	this.containerModel = containerModel;
	if ( !this.containerModel ) {
		return;
	}
	this.views = [];
	if ( typeof typeName !== 'string' ) {
		typeName = 'viewContainer';
	}
	if ( typeof tagName !== 'string' ) {
		tagName = 'div';
	}
	if ( !this.$ ) {
		this.$ = $( '<' + tagName + '/>' );
	}
	this.$.addClass( 'editSurface-' + typeName ).data( typeName, this );
	var container = this;
	this.relayUpdate = function() {
		container.emit( 'update' );
	};
	function recycleItemView( itemModel, autoCreate ) {
		var itemView = container.lookupItemView( itemModel );
		if ( itemView ) {
			container.views.splice( container.views.indexOf( itemView ), 1 );
			itemView.$.detach();
		}
		if ( autoCreate && itemView === null ) {
			itemView = itemModel.createView();
		}
		return itemView;
	}
	this.containerModel.on( 'prepend', function( itemModel ) {
		var itemView = recycleItemView( itemModel, true );
		itemView.on( 'update', container.relayUpdate );
		container.views.unshift( itemView );
		container.$.prepend( itemView.$ );
		container.emit( 'prepend', itemView );
		container.emit( 'update' );
	} );
	this.containerModel.on( 'append', function( itemModel ) {
		var itemView = recycleItemView( itemModel, true );
		itemView.on( 'update', container.relayUpdate );
		container.views.push( itemView );
		container.$.append( itemView.$ );
		container.emit( 'append', itemView );
		container.emit( 'update' );
	} );
	this.containerModel.on( 'insertBefore', function( itemModel, beforeModel ) {
		var beforeView = container.lookupItemView( beforeModel ),
			itemView = recycleItemView( itemModel, true );
		itemView.on( 'update', container.relayUpdate );
		if ( beforeView ) {
			container.views.splice( container.views.indexOf( beforeView ), 0, itemView );
			itemView.$.insertBefore( beforeView.$ );
		} else {
			container.views.unshift( itemView );
			container.$.prepend( itemView.$ );
		}
		container.emit( 'insertBefore', itemView, beforeView );
		container.emit( 'update' );
	} );
	this.containerModel.on( 'insertAfter', function( itemModel, afterModel ) {
		var afterView = container.lookupItemView( afterModel ),
			itemView = recycleItemView( itemModel, true );
		itemView.on( 'update', container.relayUpdate );
		if ( afterView ) {
			container.views.splice( container.views.indexOf( afterView ) + 1, 0, itemView );
			itemView.$.insertAfter( afterView.$ );
		} else {
			container.views.push( itemView );
			container.$.append( itemView.$ );
		}
		container.emit( 'insertAfter', itemView, afterView );
		container.emit( 'update' );
	} );
	this.containerModel.on( 'remove', function( itemModel ) {
		var itemView = recycleItemView( itemModel );
		itemView.removeListener( 'update', container.relayUpdate );
		container.emit( 'remove', itemView );
		container.emit( 'update' );
	} );
	// Auto-add views for existing items
	var itemModels = this.containerModel.all();
	for ( var i = 0; i < itemModels.length; i++ ) {
		var itemView = itemModels[i].createView();
		itemView.on( 'update', container.relayUpdate );
		this.views.push( itemView );
		this.$.append( itemView.$ );
	}
};

es.ViewContainer.prototype.lookupItemView = function( itemModel ) {
	for ( var i = 0; i < this.views.length; i++ ) {
		if ( this.views[i].getModel() === itemModel ) {
			return this.views[i];
		}
	}
	return null;
};

/* Inheritance */

es.extend( es.ViewContainer, es.EventEmitter );
