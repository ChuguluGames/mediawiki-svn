/**
 * Creates an es.ContentView object.
 * 
 * A content view flows text into a DOM element and provides methods to get information about the
 * rendered output. HTML serialized specifically for rendering into and editing surface.
 * 
 * Rendering occurs automatically when content is modified, by responding to "insert", "remove",
 * "clear" and "annotate" events. Rendering is iterative and interruptable to reduce user feedback
 * latency.
 * 
 * TODO: Cleanup code and comments
 * 
 * @class
 * @constructor
 * @extends {es.EventEmitter}
 * @param $container {jQuery} Element to render into
 * @param model {es.ContentModel} Content model to view
 * @property $ {jQuery}
 * @property model {es.ContentModel}
 * @property boundaries {Array}
 * @property lines {Array}
 * @property width {Integer}
 * @property bondaryTest {RegExp}
 * @property widthCache {Object}
 * @property renderState {Object}
 */
es.ContentView = function( $container, model ) {
	es.EventEmitter.call( this );
	this.$ = $container;
	this.model = model || new es.ContentModel();
	this.boundaries = [];
	this.lines = [];
	this.width = null;
	this.boundaryTest = /([ \-\t\r\n\f])/g;
	this.widthCache = {};
	this.renderState = {};
	var that = this;
	function render( args ) {
		that.scanBoundaries();
		that.render( args ? args.offset : 0 );
	}
	this.model.on( 'insert', render );
	this.model.on( 'remove', render );
	this.model.on( 'clear', render );
	this.model.on( 'annotate', render );
	this.scanBoundaries();
};

/* Static Members */

/**
 * List of annotation rendering implementations.
 * 
 * Each supported annotation renderer must have an open and close property, each either a string or
 * a function which accepts a data argument.
 * 
 * @static
 * @member
 */
es.ContentView.annotationRenderers = {
	'template': {
		'open': function( data ) {
			return '<span class="editSurface-format-object">' + data.html;
		},
		'close': '</span>',
		'float': function( data ) {
			console.log( data.html );
			return $( data.html ).css( 'float' );
		}
	},
	'bold': {
		'open': '<span class="editSurface-format-bold">',
		'close': '</span>',
		'float': false
	},
	'italic': {
		'open': '<span class="editSurface-format-italic">',
		'close': '</span>',
		'float': false
	},
	'size': {
		'open': function( data ) {
			return '<span class="editSurface-format-' + data.type + '">';
		},
		'close': '</span>',
		'float': false
	},
	'script': {
		'open': function( data ) {
			return '<span class="editSurface-format-' + data.type + '">';
		},
		'close': '</span>',
		'float': false
	},
	'xlink': {
		'open': function( data ) {
			return '<span class="editSurface-format-link" data-href="' + data.href + '">';
		},
		'close': '</span>',
		'float': false
	},
	'ilink': {
		'open': function( data ) {
			return '<span class="editSurface-format-link" data-title="' + data.title + '">';
		},
		'close': '</span>',
		'float': false
	}
};

/**
 * Mapping of character and HTML entities or renderings.
 * 
 * @static
 * @member
 */
es.ContentView.htmlCharacters = {
	'&': '&amp;',
	'<': '&lt;',
	'>': '&gt;',
	'\'': '&#039;',
	'"': '&quot;',
	' ': '&nbsp;',
	'\n': '<span class="editSurface-whitespace">&#182;</span>',
	'\t': '<span class="editSurface-whitespace">&#8702;</span>'
};

/* Static Methods */

/**
 * Gets a rendered opening or closing of an annotation.
 * 
 * Tag nesting is handled using a stack, which keeps track of what is currently open. A common stack
 * argument should be used while rendering content.
 * 
 * @static
 * @method
 * @param bias {String} Which side of the annotation to render, either "open" or "close"
 * @param annotation {Object} Annotation to render
 * @param stack {Array} List of currently open annotations
 * @returns {String} Rendered annotation
 */
es.ContentView.renderAnnotation = function( bias, annotation, stack ) {
	var renderers = es.ContentView.annotationRenderers,
		type = annotation.type,
		out = '';
	if ( type in renderers ) {
		if ( bias === 'open' ) {
			// Add annotation to the top of the stack
			stack.push( annotation );
			// Open annotation
			out += typeof renderers[type]['open'] === 'function'
				? renderers[type]['open']( annotation.data )
				: renderers[type]['open'];
		} else {
			if ( stack[stack.length - 1] === annotation ) {
				// Remove annotation from top of the stack
				stack.pop();
				// Close annotation
				out += typeof renderers[type]['close'] === 'function'
					? renderers[type]['close']( annotation.data )
					: renderers[type]['close'];
			} else {
				// Find the annotation in the stack
				var depth = stack.indexOf( annotation );
				if ( depth === -1 ) {
					throw 'Invalid stack error. An element is missing from the stack.';
				}
				// Close each already opened annotation
				for ( var i = stack.length - 1; i >= depth + 1; i-- ) {
					out += typeof renderers[stack[i].type]['close'] === 'function'
						? renderers[stack[i].type]['close']( stack[i].data )
						: renderers[stack[i].type]['close'];
				}
				// Close the buried annotation
				out += typeof renderers[type]['close'] === 'function'
					? renderers[type]['close']( annotation.data )
					: renderers[type]['close'];
				// Re-open each previously opened annotation
				for ( var i = depth + 1; i < stack.length; i++ ) {
					out += typeof renderers[stack[i].type]['open'] === 'function'
						? renderers[stack[i].type]['open']( stack[i].data )
						: renderers[stack[i].type]['open'];
				}
				// Remove the annotation from the middle of the stack
				stack.splice( depth, 1 );
			}
		}
	}
	return out;
};

es.ContentView.prototype.getLineIndex = function( offset ) {
	for ( var i = 0; i < this.lines.length; i++ ) {
		if ( this.lines[i].range.containsOffset( offset ) ) {
			return i;
		}
	}
	return this.lines.length - 1;
};

/**
 * Gets offset within content model closest to of a given position.
 * 
 * Position is assumed to be local to the container the text is being flowed in.
 * 
 * @param position {Object} Position to find offset for
 * @param position.left {Integer} Horizontal position in pixels
 * @param position.top {Integer} Vertical position in pixels
 * @return {Integer} Offset within content model nearest the given coordinates
 */
es.ContentView.prototype.getOffset = function( position ) {
	// Empty content model shortcut
	if ( this.model.getLength() === 0 ) {
		return 0;
	}
	/*
	 * Line finding
	 * 
	 * If the position is above the first line, the offset will always be 0, and if the position is
	 * below the last line the offset will always be {this.model.length}. All other vertical
	 * vertical positions will fall inside of one of the lines.
	 */
	var lineCount = this.lines.length;
	// Positions above the first line always jump to the first offset
	if ( !lineCount || position.top < 0 ) {
		return 0;
	}
	// Find which line the position is inside of
	var i = 0,
		top = 0;
	while ( i < lineCount ) {
		top += this.lines[i].height;
		if ( position.top <= top ) {
			break;
		}
		i++;
	}
	// Positions below the last line always jump to the last offset
	if ( i == lineCount ) {
		return this.model.getLength();
	}
	// Alias current line object
	var line = this.lines[i];
	/*
	 * Offset finding
	 * 
	 * Now that we know which line we are on, we can just use the "fitCharacters" method to get the
	 * last offset before "position.left".
	 * 
	 * TODO: The offset needs to be chosen based on nearest offset to the cursor, not offset before
	 * the cursor.
	 */
	var $ruler = $( '<div class="editSurface-ruler"></div>' ).appendTo( this.$ ),
		ruler = $ruler[0],
		fit = this.fitCharacters( line.range, ruler, position.left );
	ruler.innerHTML = this.serialize( new es.Range( line.range.start, fit.end ) );
	var left = ruler.clientWidth;
	ruler.innerHTML = this.serialize( new es.Range( line.range.start, fit.end + 1 ) );
	var right = ruler.clientWidth;
	var center = Math.round( left + ( ( right - left ) / 2 ) );
	$ruler.remove();
	// Reset RegExp object's state
	this.boundaryTest.lastIndex = 0;
	return Math.min(
		// If the position is right of the center of the character it's on top of, increment offset
		fit.end + ( position.left >= center ? 1 : 0 ),
		// If the line ends in a non-boundary character, decrement offset
		line.range.end + ( this.boundaryTest.exec( line.text.substr( -1 ) ) ? -1 : 0 )
	);
};

/**
 * Gets position coordinates of a given offset.
 * 
 * Offsets are boundaries between plain or annotated characters within content model. Results are given in
 * left, top and bottom positions, which could be used to draw a cursor, highlighting, etc.
 * 
 * @param offset {Integer} Offset within content model
 * @return {Object} Object containing left, top and bottom properties, each positions in pixels as
 * well as a line index
 */
es.ContentView.prototype.getPosition = function( offset ) {
	/*
	 * Range validation
	 * 
	 * Rather than clamping the range, which can hide errors, exceptions will be thrown if offset is
	 * less than 0 or greater than the length of the content model.
	 */
	if ( offset < 0 ) {
		throw 'Out of range error. Offset is expected to be greater than or equal to 0.';
	} else if ( offset > this.model.getLength() ) {
		throw 'Out of range error. Offset is expected to be less than or equal to text length.';
	}
	/*
	 * Line finding
	 * 
	 * It's possible that a more efficient method could be used here, but the number of lines to be
	 * iterated through will rarely be over 100, so it's unlikely that any significant gains will be
	 * had. Plus, as long as we are iterating over each line, we can also sum up the top and bottom
	 * positions, which is a nice benefit of this method.
	 */
	var line,
		lineCount = this.lines.length,
		lineIndex = 0,
		position = {
			'left': 0,
			'top': 0,
			'bottom': 0
		};
	while ( lineIndex < lineCount ) {
		line = this.lines[lineIndex];
		if ( line.range.containsOffset( offset ) ) {
			position.bottom = position.top + line.height;
			break;
		}
		position.top += line.height;
		lineIndex++;
	}
	/*
	 * Virtual n+1 position
	 * 
	 * To allow access to position information of the right side of the last character on the last
	 * line, a virtual n+1 position is supported. Offsets beyond this virtual position will cause
	 * an exception to be thrown.
	 */
	if ( lineIndex === lineCount ) {
		position.bottom = position.top;
		position.top -= line.height;
	}
	/*
	 * Offset measuring
	 * 
	 * Since the left position will be zero for the first character in the line, so we can skip
	 * measuring for those cases.
	 */
	if ( line.range.start < offset ) {
		var $ruler = $( '<div class="editSurface-ruler"></div>' ).appendTo( this.$ ),
			ruler = $ruler[0];
		ruler.innerHTML = this.serialize( new es.Range( line.range.start, offset ) );
		position.left = ruler.clientWidth;
		$ruler.remove();
	}
	return position;
};

/**
 * Updates the word boundary cache, which is used for word fitting.
 */
es.ContentView.prototype.scanBoundaries = function() {
	/*
	 * Word boundary scan
	 * 
	 * To perform binary-search on words, rather than characters, we need to collect word boundary
	 * offsets into an array. The offset of the right side of the breaking character is stored, so
	 * the gaps between stored offsets always include the breaking character at the end.
	 * 
	 * To avoid encoding the same words as HTML over and over while fitting text to lines, we also
	 * build a list of HTML escaped strings for each gap between the offsets stored in the
	 * "boundaries" array. Slices of the "words" array can be joined, producing the escaped HTML of
	 * the words.
	 */
	var text = this.model.getText();
	// Purge "boundaries" and "words" arrays
	this.boundaries = [0];
	// Reset RegExp object's state
	this.boundaryTest.lastIndex = 0;
	// Iterate over each word+boundary sequence, capturing offsets and encoding text as we go
	var match,
		end;
	while ( match = this.boundaryTest.exec( text ) ) {
		// Include the boundary character in the range
		end = match.index + 1;
		// Store the boundary offset
		this.boundaries.push( end );
	}
	// If the last character is not a boundary character, we need to append the final range to the
	// "boundaries" and "words" arrays
	if ( end < text.length || this.boundaries.length === 1 ) {
		this.boundaries.push( text.length );
	}
};

/**
 * Renders a batch of lines and then yields execution before rendering another batch.
 * 
 * In cases where a single word is too long to fit on a line, the word will be "virtually" wrapped,
 * causing them to be fragmented. Word fragments are rendered on their own lines, except for their
 * remainder, which is combined with whatever proceeding words can fit on the same line.
 */
es.ContentView.prototype.renderIteration = function( limit ) {
	var rs = this.renderState,
		iteration = 0,
		fractional = false,
		lineStart = this.boundaries[rs.wordOffset],
		lineEnd,
		wordFit = null,
		charOffset = 0,
		charFit = null,
		wordCount = this.boundaries.length;
	while ( ++iteration <= limit && rs.wordOffset < wordCount - 1 ) {
		wordFit = this.fitWords( new es.Range( rs.wordOffset, wordCount - 1 ), rs.ruler, rs.width );
		fractional = false;
		if ( wordFit.width > rs.width ) {
			// The first word didn't fit, we need to split it up
			charOffset = lineStart;
			var lineOffset = rs.wordOffset;
			rs.wordOffset++;
			lineEnd = this.boundaries[rs.wordOffset];
			do {
				charFit = this.fitCharacters(
					new es.Range( charOffset, lineEnd ), rs.ruler, rs.width
				);
				// If we were able to get the rest of the characters on the line OK
				if ( charFit.end === lineEnd) {
					// Try to fit more words on the line
					wordFit = this.fitWords(
						new es.Range( rs.wordOffset, wordCount - 1 ),
						rs.ruler,
						rs.width - charFit.width
					);
					if ( wordFit.end > rs.wordOffset ) {
						lineOffset = rs.wordOffset;
						rs.wordOffset = wordFit.end;
						charFit.end = lineEnd = this.boundaries[rs.wordOffset];
					}
				}
				this.appendLine( new es.Range( charOffset, charFit.end ), lineOffset, fractional );
				// Move on to another line
				charOffset = charFit.end;
				// Mark the next line as fractional
				fractional = true;
			} while ( charOffset < lineEnd );
		} else {
			lineEnd = this.boundaries[wordFit.end];
			this.appendLine( new es.Range( lineStart, lineEnd ), rs.wordOffset, fractional );
			rs.wordOffset = wordFit.end;
		}
		lineStart = lineEnd;
	}
	// Only perform on actual last iteration
	if ( rs.wordOffset >= wordCount - 1 ) {
		// Cleanup
		rs.$ruler.remove();
		this.lines = rs.lines;
		this.$.find( '.editSurface-line[line-index=' + ( this.lines.length - 1 ) + ']' )
			.nextAll()
			.remove();
		rs.timeout = undefined;
		this.emit( 'update' );
	} else {
		rs.ruler.innerHTML = '';
		var that = this;
		rs.timeout = setTimeout( function() {
			that.renderIteration( 3 );
		}, 0 );
	}
};

/**
 * Renders text into a series of HTML elements, each a single line of wrapped text.
 * 
 * The offset parameter can be used to reduce the amount of work involved in re-rendering the same
 * text, but will be automatically ignored if the text or width of the container has changed.
 * 
 * Rendering happens asynchronously, and yields execution between iterations. Iterative rendering
 * provides the JavaScript engine an ability to process events between rendering batches of lines,
 * allowing rendering to be interrupted and restarted if changes to content model are happening before
 * rendering of all lines is complete.
 * 
 * @param offset {Integer} Offset to re-render from, if possible (not yet implemented)
 */
es.ContentView.prototype.render = function( offset ) {
	var rs = this.renderState;
	// Check if rendering is currently underway
	if ( rs.timeout !== undefined ) {
		// Cancel the active rendering process
		clearTimeout( rs.timeout );
		// Cleanup
		rs.$ruler.remove();
	}
	// Clear caches that were specific to the previous render
	this.widthCache = {};
	// In case of empty content model we still want to display empty with non-breaking space inside
	// This is very important for lists
	if(this.model.getLength() === 0) {
		var $line = $( '<div class="editSurface-line" line-index="0">&nbsp;</div>' );
		this.$.empty().append( $line );
		this.lines = [{
			'text': ' ',
			'range': new es.Range( 0,0 ),
			'width': 0,
			'height': $line.outerHeight(),
			'wordOffset': 0,
			'fractional': false
		}];
		this.emit( 'update' );
		return;
	}
	/*
	 * Container measurement
	 * 
	 * To get an accurate measurement of the inside of the container, without having to deal with
	 * inconsistencies between browsers and box models, we can just create an element inside the
	 * container and measure it.
	 */
	rs.$ruler = $( '<div>&nbsp;</div>' ).appendTo( this.$ );
	rs.width = rs.$ruler.innerWidth();
	rs.ruler = rs.$ruler.addClass('editSurface-ruler')[0];
	// Ignore offset optimization if the width has changed or the text has never been flowed before
	if (this.width !== rs.width) {
		offset = undefined;
	}
	this.width = rs.width;
	// Reset the render state
	if ( offset ) {
		var gap,
			currentLine = this.lines.length - 1;
		for ( var i = this.lines.length - 1; i >= 0; i-- ) {
			var line = this.lines[i];
			if ( line.range.start < offset && line.range.end > offset ) {
				currentLine = i;
			}
			if ( ( line.range.end < offset && !line.fractional ) || i === 0 ) {
				rs.lines = this.lines.slice( 0, i );
				rs.wordOffset = line.wordOffset;
				gap = currentLine - i;
				break;
			}
		}
		this.renderIteration( 2 + gap );
	} else {
		rs.lines = [];
		rs.wordOffset = 0;
		this.renderIteration( 3 );
	}
};

/**
 * Adds a line containing a given range of text to the end of the DOM and the "lines" array.
 * 
 * @param range {es.Range} Range of data within content model to append
 * @param start {Integer} Beginning of text range for line
 * @param end {Integer} Ending of text range for line
 * @param wordOffset {Integer} Index within this.words which the line begins with
 * @param fractional {Boolean} If the line begins in the middle of a word
 */
es.ContentView.prototype.appendLine = function( range, wordOffset, fractional ) {
	var rs = this.renderState,
		lineCount = rs.lines.length,
		$line = this.$.children( '[line-index=' + lineCount + ']' );
	if ( !$line.length ) {
		$line = $( '<div class="editSurface-line" line-index="' + lineCount + '"></div>' );
		this.$.append( $line );
	}
	$line[0].innerHTML = this.serialize( range );
	// Collect line information
	rs.lines.push({
		'text': this.model.getText( range ),
		'range': range,
		'width': $line.outerWidth(),
		'height': $line.outerHeight(),
		'wordOffset': wordOffset,
		'fractional': fractional
	});
	// Disable links within rendered content
	$line.find( '.editSurface-format-object a' )
		.mousedown( function( e ) {
			e.preventDefault();
		} )
		.click( function( e ) {
			e.preventDefault();
		} );
};

/**
 * Gets the index of the boundary of last word that fits inside the line
 * 
 * The "words" and "boundaries" arrays provide linear access to the offsets around non-breakable
 * areas within the text. Using these, we can perform a binary-search for the best fit of words
 * within a line, just as we would with characters.
 * 
 * Results are given as an object containing both an index and a width, the later of which can be
 * used to detect when the first word was too long to fit on a line. In such cases the result will
 * contain the index of the boundary of the first word and it's width.
 * 
 * TODO: Because limit is most likely given as "words.length", it may be possible to improve the
 * efficiency of this code by making a best guess and working from there, rather than always
 * starting with [offset .. limit], which usually results in reducing the end position in all but
 * the last line, and in most cases more than 3 times, before changing directions.
 * 
 * @param range {es.Range} Range of data within content model to try to fit
 * @param ruler {HTMLElement} Element to take measurements with
 * @param width {Integer} Maximum width to allow the line to extend to
 * @return {Integer} Last index within "words" that contains a word that fits
 */
es.ContentView.prototype.fitWords = function( range, ruler, width ) {
	var offset = range.start,
		start = range.start,
		end = range.end,
		charOffset = this.boundaries[offset],
		middle,
		charMiddle,
		lineWidth,
		cacheKey;
	do {
		// Place "middle" directly in the center of "start" and "end"
		middle = Math.ceil( ( start + end ) / 2 );
		charMiddle = this.boundaries[middle];
		// Measure and cache width of substring
		cacheKey = charOffset + ':' + charMiddle;
		// Prepare the line for measurement using pre-escaped HTML
		ruler.innerHTML = this.serialize( new es.Range( charOffset, charMiddle ) );
		// Test for over/under using width of the rendered line
		this.widthCache[cacheKey] = lineWidth = ruler.clientWidth;
		// Test for over/under using width of the rendered line
		if ( lineWidth > width ) {
			// Detect impossible fit (the first word won't fit by itself)
			if (middle - offset === 1) {
				start = middle;
				break;
			}
			// Words after "middle" won't fit
			end = middle - 1;
		} else {
			// Words before "middle" will fit
			start = middle;
		}
	} while ( start < end );
	// Check if we ended by moving end to the left of middle
	if ( end === middle - 1 ) {
		// A final measurement is required
		var charStart = this.boundaries[start];
		ruler.innerHTML = this.serialize( new es.Range( charOffset, charStart ) );
		lineWidth = this.widthCache[charOffset + ':' + charStart] = ruler.clientWidth;
	}
	return { 'end': start, 'width': lineWidth };
};

/**
 * Gets the index of the boundary of the last character that fits inside the line
 * 
 * Results are given as an object containing both an index and a width, the later of which can be
 * used to detect when the first character was too long to fit on a line. In such cases the result
 * will contain the index of the first character and it's width.
 * 
 * @param range {es.Range} Range of data within content model to try to fit
 * @param ruler {HTMLElement} Element to take measurements with
 * @param width {Integer} Maximum width to allow the line to extend to
 * @return {Integer} Last index within "text" that contains a character that fits
 */
es.ContentView.prototype.fitCharacters = function( range, ruler, width ) {
	var offset = range.start,
		start = range.start,
		end = range.end,
		middle,
		lineWidth,
		cacheKey;
	do {
		// Place "middle" directly in the center of "start" and "end"
		middle = Math.ceil( ( start + end ) / 2 );
		// Measure and cache width of substring
		cacheKey = offset + ':' + middle;
		if ( cacheKey in this.widthCache ) {
			lineWidth = this.widthCache[cacheKey];
		} else {
			// Fill the line with a portion of the text, escaped as HTML
			ruler.innerHTML = this.serialize( new es.Range( offset, middle ) );
			// Test for over/under using width of the rendered line
			this.widthCache[cacheKey] = lineWidth = ruler.clientWidth;
		}
		if ( lineWidth > width ) {
			// Detect impossible fit (the first character won't fit by itself)
			if (middle - offset === 1) {
				start = middle - 1;
				break;
			}
			// Words after "middle" won't fit
			end = middle - 1;
		} else {
			// Words before "middle" will fit
			start = middle;
		}
	} while ( start < end );
	// Check if we ended by moving end to the left of middle
	if ( end === middle - 1 ) {
		// Try for cache hit
		cacheKey = offset + ':' + start;
		if ( cacheKey in this.widthCache ) {
			lineWidth = this.widthCache[cacheKey];
		} else {
			// A final measurement is required
			ruler.innerHTML = this.serialize( new es.Range( offset, start ) );
			lineWidth = this.widthCache[cacheKey] = ruler.clientWidth;
		}
	}
	return { 'end': start, 'width': lineWidth };
};

/**
 * Gets an HTML serialization of a range of data within content model.
 * 
 * @method
 * @param start {Integer} Beginning of range
 * @param end {Integer} End of range
 * @param {String} Rendered HTML of data within content model
 */
es.ContentView.prototype.serialize = function( range ) {
	var data = this.model.getData( range ),
		render = es.ContentView.renderAnnotation,
		htmlChars = es.ContentView.htmlCharacters;
	var out = '',
		left = '',
		right,
		leftPlain,
		rightPlain,
		stack = [];
	for ( var i = 0; i < data.length; i++ ) {
		right = data[i];
		leftPlain = typeof left === 'string';
		rightPlain = typeof right === 'string';
		if ( !leftPlain && rightPlain ) {
			// [formatted][plain] pair, close any annotations for left
			for ( var j = 1; j < left.length; j++ ) {
				out += render( 'close', left[j], stack );
			}
		} else if ( leftPlain && !rightPlain ) {
			// [plain][formatted] pair, open any annotations for right
			for ( var j = 1; j < right.length; j++ ) {
				out += render( 'open', right[j], stack );
			}
		} else if ( !leftPlain && !rightPlain ) {
			// [formatted][formatted] pair, open/close any differences
			for ( var j = 1; j < left.length; j++ ) {
				if ( right.indexOf( left[j] ) === -1 ) {
					out += render( 'close', left[j], stack );
				}
			}
			for ( var j = 1; j < right.length; j++ ) {
				if ( left.indexOf( right[j] ) === -1 ) {
					out += render( 'open', right[j], stack );
				}
			}
		}
		out += right[0] in htmlChars ? htmlChars[right[0]] : right[0];
		left = right;		
	}
	// Close all remaining tags at the end of the content
	if ( !rightPlain && right ) {
		for ( var j = 1; j < right.length; j++ ) {
			out += render( 'close', right[j], stack );
		}
	}
	return out;
};

es.extend( es.ContentView, es.EventEmitter );
