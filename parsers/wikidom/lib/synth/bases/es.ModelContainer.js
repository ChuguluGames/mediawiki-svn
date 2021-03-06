/**
 * Creates an es.ModelContainer object.
 * 
 * Child objects must extend es.ModelContainerItem.
 * 
 * @class
 * @constructor
 * @extends {es.EventEmitter}
 * @param listName {String} Property name for list of items
 * @property [listName] {Array} list of items
 */
es.ModelContainer = function( listName ) {
	es.EventEmitter.call( this );
	if ( typeof listName !== 'string' ) {
		listName = 'items';
	}
	this._listName = listName;
	this[this._listName] = [];
	var container = this;
	this.relayUpdate = function() {
		container.emit( 'update' );
	};
};

/* Methods */

/**
 * Gets an item at a specific index.
 * 
 * @method
 * @returns {Object} Child object at index
 */
es.ModelContainer.prototype.get = function( index ) {
	return this[this._listName][index] || null;
};

/**
 * Gets all items.
 * 
 * @method
 * @returns {Array} List of all items.
 */
es.ModelContainer.prototype.all = function() {
	return this[this._listName];
};

/**
 * Gets the number of items in container.
 * 
 * @method
 * @returns {Integer} Number of items in container
 */
es.ModelContainer.prototype.getLength = function() {
	return this[this._listName].length
};

/**
 * Gets the index of an item.
 * 
 * @method
 * @returns {Integer} Index of item, -1 if item is not in container
 */
es.ModelContainer.prototype.indexOf = function( item ) {
	return this[this._listName].indexOf( item );
};

/**
 * Gets the first item in the container.
 * 
 * @method
 * @returns {Object} First item
 */
es.ModelContainer.prototype.first = function() {
	return this[this._listName].length ? this[this._listName][0] : null;
};

/**
 * Gets the last item in the container.
 * 
 * @method
 * @returns {Object} Last item
 */
es.ModelContainer.prototype.last = function() {
	return this[this._listName].length
		? this[this._listName][this[this._listName].length - 1] : null;
};

/**
 * Iterates over items, executing a callback for each.
 * 
 * Returning false in the callback will stop iteration.
 * 
 * @method
 * @param callback {Function} Function to call on each item which takes item and index arguments
 */
es.ModelContainer.prototype.each = function( callback ) {
	for ( var i = 0; i < this[this._listName].length; i++ ) {
		if ( callback( this[this._listName][i], i ) === false ) {
			break;
		}
	}
};

/**
 * Adds an item to the end of the container.
 * 
 * Also inserts item's Element object to the DOM and adds a listener to its "update" events.
 * 
 * @method
 * @param item {Object} Item to append
 * @emits "update"
 */
es.ModelContainer.prototype.append = function( item ) {
	var parent = item.parent();
	if ( parent === this ) {
		this[this._listName].splice( this.indexOf( item ), 1 );
	} else if ( parent ) {
		parent.remove( item );
	}
	this[this._listName].push( item );
	item.on( 'update', this.relayUpdate );
	item.attach( this );
	this.emit( 'append', item );
	this.emit( 'update' );
};

/**
 * Adds an item to the beginning of the container.
 * 
 * Also inserts item's Element object to the DOM and adds a listener to its "update" events.
 * 
 * @method
 * @param item {Object} Item to prepend
 * @emits "update"
 */
es.ModelContainer.prototype.prepend = function( item ) {
	var parent = item.parent();
	if ( parent === this ) {
		this[this._listName].splice( this.indexOf( item ), 1 );
	} else if ( parent ) {
		parent.remove( item );
	}
	this[this._listName].unshift( item );
	item.on( 'update', this.relayUpdate );
	item.attach( this );
	this.emit( 'prepend', item );
	this.emit( 'update' );
};

/**
 * Adds an item to the container after an existing item.
 * 
 * Also inserts item's Element object to the DOM and adds a listener to its "update" events.
 * 
 * @method
 * @param item {Object} Item to insert
 * @param before {Object} Item to insert before, if null then item will be inserted at the end
 * @emits "update"
 */
es.ModelContainer.prototype.insertBefore = function( item, before ) {
	var parent = item.parent();
	if ( parent === this ) {
		this[this._listName].splice( this.indexOf( item ), 1 );
	} else if ( parent ) {
		parent.remove( item );
	}
	if ( before ) {
		this[this._listName].splice( this[this._listName].indexOf( before ), 0, item );
	} else {
		this[this._listName].unshift( item );
	}
	item.on( 'update', this.relayUpdate );
	item.attach( this );
	this.emit( 'insertBefore', item, before );
	this.emit( 'update' );
};

/**
 * Adds an item to the container after an existing item.
 * 
 * Also inserts item's Element object to the DOM and adds a listener to its "update" events.
 * 
 * @method
 * @param item {Object} Item to insert
 * @param after {Object} Item to insert after, if null item will be inserted at the end
 * @emits "update"
 */
es.ModelContainer.prototype.insertAfter = function( item, after ) {
	var parent = item.parent();
	if ( parent === this ) {
		this[this._listName].splice( this.indexOf( item ), 1 );
	} else if ( parent ) {
		parent.remove( item );
	}
	if ( after ) {
		this[this._listName].splice( this[this._listName].indexOf( after ) + 1, 0, item );
	} else {
		this[this._listName].push( item );
	}
	item.on( 'update', this.relayUpdate );
	item.attach( this );
	this.emit( 'insertAfter', item, after );
	this.emit( 'update' );
};

/**
 * Removes an item from the container.
 * 
 * Also detaches item's Element object to the DOM and removes all listeners its "update" events.
 * 
 * @method
 * @param item {Object} Item to remove
 * @emits "update"
 */
es.ModelContainer.prototype.remove = function( item ) {
	item.removeListener( 'update', this.relayUpdate );
	this[this._listName].splice( this.indexOf( item ), 1 );
	item.detach();
	this.emit( 'remove', item );
	this.emit( 'update' );
};

/* Inheritance */

es.extend( es.ModelContainer, es.EventEmitter );
