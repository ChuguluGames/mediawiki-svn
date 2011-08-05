/**
 * jQuery Form Builder
 * Written by Salvatore Ingala in 2011
 * Released under the MIT and GPL licenses.
 */

(function($, mw) {

	var idPrefix = "mw-gadgets-dialog-";

	//Preprocesses strings end possibly replaces them with messages.
	//If str starts with "@" the rest of the string is assumed to be
	//a message, and the result of mw.msg is returned.
	//Two "@@" at the beginning escape for a single "@".
	function preproc( prefix, str ) {
		if ( str.length <= 1 || str[0] !== '@' ) {
			return str;
		} else if ( str.substr( 0, 2 ) == '@@' ) {
			return str.substr( 1 );
		} else {
			return mw.message( prefix + str.substr( 1 ) ).plain();
		}
	}

	//Commodity function to avoid id conflicts
	var getIncrementalCounter = ( function() {
		var cnt = 0;
		return function() {
			return cnt++;
		};
	} )();

	function pad( n, len ) {
		var res = '' + n;
		while ( res.length < len ) {
			res = '0' + res;
		}
		return res;
	}

	//Returns an object with only one key and the corresponding value given in arguments;
	function pair( key, val ) {
		var res = {};
		res[key] = val;
		return res;
	}

	function testOptional( value, element ) {
		var rules = $( element ).rules();
		if ( typeof rules.required == 'undefined' || rules.required === false ) {
			if ( value.length == 0 ) {
				return true;
			}
		}
		return false;
	}

	//validator for "required" fields (without trimming whitespaces)
	$.validator.addMethod( "requiredStrict", function( value, element ) {
		return value.length > 0;
	}, mw.msg( 'gadgets-formbuilder-required' ) );

	//validator for "minlength" fields (without trimming whitespaces)
	$.validator.addMethod( "minlengthStrict", function( value, element, param ) {
		return testOptional( value, element ) || value.length >= param;
	} );

	//validator for "maxlength" fields (without trimming whitespaces)
	$.validator.addMethod( "maxlengthStrict", function( value, element, param ) {
		return testOptional( value, element ) || value.length <= param;
	} );

	//validator for integer fields
	$.validator.addMethod( "integer", function( value, element ) {
		return testOptional( value, element ) || /^-?\d+$/.test(value);
	}, mw.msg( 'gadgets-formbuilder-integer' ) );

	//validator for datepicker fields
	$.validator.addMethod( "datePicker", function( value, element ) {
		var format = $( element ).datepicker( 'option', 'dateFormat' );
		try {
			var date = $.datepicker.parseDate( format, value );
			return true;
		} catch ( e ) {
			return false;
		}
	}, mw.msg( 'gadgets-formbuilder-date' ) );

	//validator for colorpicker fields
	$.validator.addMethod( "color", function( value, element ) {
		return $.colorUtil.getRGB( value ) !== undefined;
	}, mw.msg( 'gadgets-formbuilder-color' ) );

	//Helper function for inheritance, see http://javascript.crockford.com/prototypal.html
	function object(o) {
		function F() {}
		F.prototype = o;
		return new F();
	}


	//Field types that can be referred to by preference descriptions
	var validFieldTypes = {};


	//Describes 'name' and 'label' field members
	var simpleField = [
		{
			"name": "name",
			"type": "string",
			"label": "name",
			"required": true,
			"maxlength": 40,
			"default": ""
		},
		{
			"name": "label",
			"type": "string",
			"label": "label",
			"required": false,
			"default": ""
		}
	];

	//Used by preference editor to build field properties dialogs
	var prefsDescriptionSpecifications = {
		"boolean": simpleField,
		"string" : simpleField.concat( [
			{
				"name": "required",
				"type": "boolean",
				"label": "required",
				"default": false
			},
			{
				"name": "minlength",
				"type": "number",
				"label": "minlength",
				"integer": true,
				"min": 0,
				"required": false,
				"default": null
			},
			{
				"name": "maxlength",
				"type": "number",
				"label": "maxlength",
				"integer": true,
				"min": 0,
				"required": false,
				"default": null
			}
		] ),
		"number" : simpleField.concat( [
			{
				"name": "required",
				"type": "boolean",
				"label": "required",
				"default": true
			},
			{
				"name": "integer",
				"type": "boolean",
				"label": "integer",
				"default": false
			},
			{
				"name": "min",
				"type": "number",
				"label": "min",
				"required": false,
				"default": null
			},
			{
				"name": "max",
				"type": "number",
				"label": "max",
				"required": false,
				"default": null
			}
			//TODO: other fields
		] )
	};

	/* Basic interface for fields */
	function Field( desc, options ) {
		this.prefix = options.prefix;
		this.desc = desc;
		this.options = options;
	}

	Field.prototype.getDesc = function( useValuesAsDefaults ) {
		return this.desc;
	};

	//Override expected
	Field.prototype.getValues = function() {
		return {};
	};

	//Override expected
	Field.prototype.getElement = function() {
		return null;
	};
	
	//Override expected
	Field.prototype.getValidationSettings = function() {
		return {
			rules: {},
			messages: {}
		};
	};

	/* A field with no content, generating an empty container */
	EmptyField.prototype = object( Field.prototype );
	EmptyField.prototype.constructor = EmptyField;
	function EmptyField( desc, options ) {
		Field.call( this, desc, options );
		
		//Check existence and type of the "type" field
		if ( !this.desc.type || typeof this.desc.type != 'string' ) {
			$.error( "Missing 'type' parameter" );
		}

		this.$div = $( '<div/>' ).data( 'field', this );
	}

	EmptyField.prototype.getElement = function() {
		return this.$div;
	};

	/* A field with just a label */
	LabelField.prototype = object( EmptyField.prototype );
	LabelField.prototype.constructor = LabelField;
	function LabelField( desc, options ) {
		EmptyField.call( this, desc, options );

		//Check existence and type of the "label" field
		if ( typeof this.desc.label != 'string' ) {
			$.error( "Missing or wrong 'label' parameter" );
		}

		var $label = $( '<label/>' )
			.text( preproc( this.prefix, this.desc.label ) )
			.attr('for', idPrefix + this.desc.name );

		this.$div.append( $label );
	}

	/* Abstract base class for all "simple" fields. Should not be instantiated. */
	SimpleField.prototype = object( LabelField.prototype );
	SimpleField.prototype.constructor = SimpleField;
	function SimpleField( desc, options ){ 
		LabelField.call( this, desc, options );
	}
	
	SimpleField.prototype.getDesc = function( useValuesAsDefaults ) {
		var desc = LabelField.prototype.getDesc.call( this, useValuesAsDefaults );
		if ( useValuesAsDefaults === true ) {
			//set 'default' to current value.
			var values = this.getValues();
			desc['default'] = values[this.desc.name];
		}
		
		return desc;
	};


	/* A field with a label and a checkbox */
	BooleanField.prototype = object( SimpleField.prototype );
	BooleanField.prototype.constructor = BooleanField;
	function BooleanField( desc, options ){ 
		SimpleField.call( this, desc, options );

		this.$c = $( '<input/>' ).attr( {
			type: 'checkbox',
			id: idPrefix + this.desc.name,
			name: idPrefix + this.desc.name
		} );

		var value = options.values && options.values[this.desc.name];
		if ( typeof value != 'undefined' ) {
			if ( typeof value != 'boolean' ) {
				$.error( "value is invalid" );
			}
			
			this.$c.attr( 'checked', value );
		}

		this.$div.append( this.$c );
	}
	
	BooleanField.prototype.getValues = function() {
		return pair( this.desc.name, this.$c.is( ':checked' ) );
	};

	validFieldTypes["boolean"] = BooleanField;

	/* A field with a textbox accepting string values */
	StringField.prototype = object( SimpleField.prototype );
	StringField.prototype.constructor = StringField;
	function StringField( desc, options ){ 
		SimpleField.call( this, desc, options );

		this.$text = $( '<input/>' ).attr( {
			type: 'text',
			id: idPrefix + this.desc.name,
			name: idPrefix + this.desc.name
		} );
		
		var value = options.values && options.values[this.desc.name];
		if ( typeof value != 'undefined' ) {
			if ( typeof value != 'string' ) {
				$.error( "value is invalid" );
			}
			
			this.$text.val( value );
		}

		this.$div.append( this.$text );
	}
	
	StringField.prototype.getValues = function() {
		return pair( this.desc.name, this.$text.val() );
	};

	StringField.prototype.getValidationSettings = function() {
		var	settings = SimpleField.prototype.getValidationSettings.call( this ),
			fieldId = idPrefix + this.desc.name;
		
		settings.rules[fieldId] = {};
		var	fieldRules = settings.rules[fieldId],
			desc = this.desc;

		if ( desc.required === true ) {
			fieldRules.requiredStrict = true;
		}
		
		if ( typeof desc.minlength != 'undefined' ) {
			fieldRules.minlengthStrict = desc.minlength;
		}
		if ( typeof desc.maxlength != 'undefined' ) {
			fieldRules.maxlengthStrict = desc.maxlength;
		}
		
		settings.messages = {};
		
		settings.messages[fieldId] = {
			"minlengthStrict": mw.msg( 'gadgets-formbuilder-minlength', desc.minlength ),
			"maxlengthStrict": mw.msg( 'gadgets-formbuilder-maxlength', desc.maxlength )
		};
				
		return settings;
	};

	validFieldTypes["string"] = StringField;


	/* A field with a textbox accepting numeric values */
	NumberField.prototype = object( SimpleField.prototype );
	NumberField.prototype.constructor = NumberField;
	function NumberField( desc, options ){ 
		SimpleField.call( this, desc, options );

		this.$text = $( '<input/>' ).attr( {
			type: 'text',
			id: idPrefix + this.desc.name,
			name: idPrefix + this.desc.name
		} );

		var value = options.values && options.values[this.desc.name];
		if ( typeof value != 'undefined' ) {
			if ( value !== null && typeof value != 'number' ) {
				$.error( "value is invalid" );
			}
			
			this.$text.val( value );
		}

		this.$div.append( this.$text );
	}
	
	NumberField.prototype.getValues = function() {
		var val = parseFloat( this.$text.val() );
		return pair( this.desc.name, isNaN( val ) ? null : val );
	};

	NumberField.prototype.getValidationSettings = function() {
		var	settings = SimpleField.prototype.getValidationSettings.call( this ),
			fieldId = idPrefix + this.desc.name;
		
		settings.rules[fieldId] = {};
		var	fieldRules = settings.rules[fieldId],
			desc = this.desc;

		if ( desc.required !== false ) {
			fieldRules.requiredStrict = true;
		}

		if ( desc.integer === true ) {
			fieldRules.integer = true;
		}

		
		if ( typeof desc.min != 'undefined' ) {
			fieldRules.min = desc.min;
		}
		if ( typeof desc.max != 'undefined' ) {
			fieldRules.max = desc.max;
		}
		
		settings.messages = {};
		
		settings.messages[fieldId] = {
			"required": mw.msg( 'gadgets-formbuilder-required' ),
			"min": mw.msg( 'gadgets-formbuilder-min', desc.min ),
			"max": mw.msg( 'gadgets-formbuilder-max', desc.max )
		};
				
		return settings;
	};

	validFieldTypes["number"] = NumberField;

	/* A field with a drop-down list */
	SelectField.prototype = object( SimpleField.prototype );
	SelectField.prototype.constructor = SelectField;
	function SelectField( desc, options ){ 
		SimpleField.call( this, desc, options );

		var $select = this.$select = $( '<select/>' ).attr( {
			id: idPrefix + this.desc.name,
			name: idPrefix + this.desc.name
		} );
		
		var validValues = [];
		var self = this;
		$.each( this.desc.options, function( idx, option ) {
			var i = validValues.length;
			$( '<option/>' )
				.text( preproc( self.prefix, option.name ) )
				.val( i )
				.appendTo( $select );
			validValues.push( option.value );
		} );

		this.validValues = validValues;

		var value = options.values && options.values[this.desc.name];
		if ( typeof value != 'undefined' ) {
			if ( $.inArray( value, validValues ) == -1 ) {
				$.error( "value is not in the list of possible values" );
			}

			var i = $.inArray( value, validValues );
			$select.val( i ).prop( 'selected', 'selected' );
		}

		this.$div.append( $select );
	}
	
	SelectField.prototype.getValues = function() {
		var i = parseInt( this.$select.val(), 10 );
		return pair( this.desc.name, this.validValues[i] );
	};

	validFieldTypes["select"] = SelectField;

	/* A field with a slider, representing ranges of numbers */
	RangeField.prototype = object( SimpleField.prototype );
	RangeField.prototype.constructor = RangeField;
	function RangeField( desc, options ){ 
		SimpleField.call( this, desc, options );

		if ( typeof this.desc.min != 'number' ) {
			$.error( "desc.min is invalid" );
		}

		if ( typeof this.desc.max != 'number' ) {
			$.error( "desc.max is invalid" );
		}

		if ( typeof this.desc.step != 'undefined' && typeof this.desc.step != 'number' ) {
			$.error( "desc.step is invalid" );
		}

		var value = options.values && options.values[this.desc.name];
		if ( typeof value != 'undefined' ) {
			if ( typeof value != 'number' ) {
				$.error( "value is invalid" );
			}
			if ( value < this.desc.min || value > this.desc.max ) {
				$.error( "value is out of range" );
			}
		}

		var $slider = this.$slider = $( '<div/>' )
			.attr( 'id', idPrefix + this.desc.name );

		var rangeOptions = {
			min: this.desc.min,
			max: this.desc.max
		};

		if ( typeof value != 'undefined' ) {
			rangeOptions['value'] = value;
		}

		if ( typeof this.desc.step != 'undefined' ) {
			rangeOptions['step'] = this.desc.step;
		}

		$slider.slider( rangeOptions );

		this.$div.append( $slider );
	}
	
	RangeField.prototype.getValues = function() {
		return pair( this.desc.name, this.$slider.slider( 'value' ) );
	};

	validFieldTypes["range"] = RangeField;	
	
	/* A field with a textbox with a datepicker */
	DateField.prototype = object( SimpleField.prototype );
	DateField.prototype.constructor = DateField;
	function DateField( desc, options ){ 
		SimpleField.call( this, desc, options );

		this.$text = $( '<input/>' ).attr( {
			type: 'text',
			id: idPrefix + this.desc.name,
			name: idPrefix + this.desc.name
		} ).datepicker( {
				onSelect: function() {
					//Force validation, so that a previous 'invalid' state is removed
					$( this ).valid();
				}
			} );

		var value = options.values && options.values[this.desc.name];
		var date;
		if ( typeof value != 'undefined' && value !== null ) {
			date = new Date( value );
			
			if ( !isFinite( date ) ) {
				$.error( "value is invalid" );
			}

			this.$text.datepicker( 'setDate', date );
		}

		this.$div.append( this.$text );
	}
	
	DateField.prototype.getValues = function() {
		var d = this.$text.datepicker( 'getDate' ),
			res = {};
		
		if ( d === null ) {
			return null;
		}

		//UTC date in ISO 8601 format [YYYY]-[MM]-[DD]T[hh]:[mm]:[ss]Z
		return pair( this.desc.name, '' +
			pad( d.getUTCFullYear(), 4 ) + '-' +
			pad( d.getUTCMonth() + 1, 2 ) + '-' +
			pad( d.getUTCDate(), 2 ) + 'T' +
			pad( d.getUTCHours(), 2 ) + ':' +
			pad( d.getUTCMinutes(), 2 ) + ':' +
			pad( d.getUTCSeconds(), 2 ) + 'Z' );
	};

	DateField.prototype.getValidationSettings = function() {
		var	settings = SimpleField.prototype.getValidationSettings.call( this ),
			fieldId = idPrefix + this.desc.name;
		
		settings.rules[fieldId] = {
				"datePicker": true
			};
		return settings;
	};

	validFieldTypes["date"] = DateField;

	/* A field with color picker */
	
	function closeColorPicker() {
		$( '#colorpicker' ).fadeOut( 'fast', function() {
			$( this ).remove();
		} );
	}

	//If a click happens outside the colorpicker while it is showed, remove it
	$( document ).mousedown( function( event ) {
		var $target = $( event.target );
		if ( $target.parents( '#colorpicker' ).length == 0 ) {
			closeColorPicker();
		}
	} );
	
	ColorField.prototype = object( SimpleField.prototype );
	ColorField.prototype.constructor = ColorField;
	function ColorField( desc, options ){ 
		SimpleField.call( this, desc, options );

		var value = ( options.values && options.values[this.desc.name] ) || '';

		this.$text = $( '<input/>' ).attr( {
			type: 'text',
			id: idPrefix + this.desc.name,
			name: idPrefix + this.desc.name
		} )
			.addClass( 'colorpicker-input' )
			.val( value )
			.css( 'background-color', value )
			.focus( function() {
				$( '<div/>' )
					.addClass( 'ui-widget ui-widget-content' )
					.attr( 'id', 'colorpicker' )
					.css( 'position', 'absolute' )
					.hide()
					.appendTo( document.body )
					.zIndex( $( this ).zIndex() + 1 )
					.farbtastic( this )
					.position( {
						my: 'left bottom',
						at: 'left top',
						of: this,
						collision: 'none'
					} )
					.fadeIn( 'fast' );
			} )
			.keydown( function( event ) {
				if ( event.keyCode == 13 || event.keyCode == 27 ) {
					closeColorPicker();
					event.preventDefault();
					event.stopPropagation();
				}
			} )
			.change( function() {
				//Force validation
				$( this ).valid();
			} )
			.blur( closeColorPicker );

		this.$div.append( this.$text );
	}
	
	ColorField.prototype.getValidationSettings = function() {
		var	settings = SimpleField.prototype.getValidationSettings.call( this ),
			fieldId = idPrefix + this.desc.name;
		
		settings.rules[fieldId] = {
				"color": true
			};
		return settings;
	};
	
	ColorField.prototype.getValues = function() {
		var color = $.colorUtil.getRGB( this.$text.val() );
		return pair( this.desc.name, '#' + pad( color[0].toString( 16 ), 2 ) +
			pad( color[1].toString( 16 ), 2 ) + pad( color[2].toString( 16 ), 2 ) );
	};

	validFieldTypes["color"] = ColorField;
	
	
	/* A field that represent a section (group of fields) */

	function deleteFieldRules( field ) {
		//Remove all its validation rules
		var validationSettings = field.getValidationSettings();
		if ( validationSettings.rules ) {
			$.each( validationSettings.rules, function( name, value ) {
				var $input = $( '#' + name );
				if ( $input.length > 0 ) {
					$( '#' + name ).rules( 'remove' );
				}
			} );
		}
	}

	function addFieldRules( field ) {
		var validationSettings = field.getValidationSettings();
		if ( validationSettings.rules ) {
			$.each( validationSettings.rules, function( name, rules ) {
				var $input = $( '#' + name );
				
				//Find messages associated to this rule, if any
				if ( typeof validationSettings.messages != 'undefined' && 
					typeof validationSettings.messages[name] != 'undefined')
				{
					rules.messages = validationSettings.messages[name];
				}
				
				if ( $input.length > 0 ) {
					$( '#' + name ).rules( 'add', rules );
				}
			} );
		}
	}
	

	SectionField.prototype = object( Field.prototype );
	SectionField.prototype.constructor = SectionField;
	function SectionField( desc, options, id ) {
		Field.call( this, desc, options );
		
		this.$div = $( '<div/>' ).data( 'field', this );
		
		if ( id !== undefined ) {
			this.$div.attr( 'id', id );
		}

		//If there is an "intro", adds it to the section as a label
		//TODO: kill "intro"s and make "label" fields, instead?
		if ( typeof this.desc.intro == 'string' ) {
			$( '<p/>' )
				.text( preproc( this.prefix, this.desc.intro ) )
				.addClass( 'formBuilder-intro' )
				.appendTo( this.$div );
		}

		for ( var i = 0; i < this.desc.fields.length; i++ ) {
			//TODO: validate fieldName

			if ( options.editable === true ) {
				//add an empty slot
				this._createSlot( true ).appendTo( this.$div );
			}

			var field = this.desc.fields[i],
				FieldConstructor = validFieldTypes[field.type];

			if ( typeof FieldConstructor != 'function' ) {
				$.error( "field with invalid type: " + field.type );
			}

			var f = new FieldConstructor( field, options ),
				$slot = this._createSlot( options.editable === true, f );
			
			$slot.appendTo( this.$div );
		}
		
		if ( options.editable === true ) {
			//add an empty slot
			this._createSlot( true ).appendTo( this.$div );
		}
	}
	
	SectionField.prototype.getElement = function() {
		return this.$div;
	};

	SectionField.prototype.getDesc = function( useValuesAsDefaults ) {
		var desc = this.desc;
		desc.fields = [];
		this.$div.children().each( function( idx, slot ) {
			var field = $( slot ).data( 'field' );
			if ( field !== undefined ) {
				desc.fields.push( field.getDesc( useValuesAsDefaults ) );
			}
		} );
		return desc;
	};

	SectionField.prototype.setTitle = function( newTitle ) {
		this.desc.title = newTitle;
	};

	SectionField.prototype.getValues = function() {
		var values = {};
		this.$div.children().each( function( idx, slot ) {
			var field = $( slot ).data( 'field' );
			if ( field !== undefined ) {
				$.extend( values, field.getValues() );
			}
		} );
		return values;
	};

	SectionField.prototype.getValidationSettings = function() {
		var settings = {};
		this.$div.children().each( function( idx, slot ) {
			var field = $( slot ).data( 'field' );
			if ( field !== undefined ) {
				var fieldSettings = $( slot ).data( 'field' ).getValidationSettings();
				if ( fieldSettings ) {
					$.extend( true, settings, fieldSettings );
				}
			}
		} );

		return settings;
	};

	SectionField.prototype._createFieldDialog = function( params ) {
		var self = this;
		
		if ( typeof params.callback != 'function' ) {
			$.error( 'createFieldDialog: missing or wrong "callback" parameter' );
		}
		
		var type, description, values;
		if ( typeof params.description == 'undefined' && typeof params.type == 'undefined' ) {
			//Create a dialog to choose the type of field to create
			var selectOptions = [];
			$.each( validFieldTypes, function( fieldType ) {
				selectOptions.push( {
					name: fieldType,
					value: fieldType
				} );
			} );
			
			$( {
				fields: [ {
					'name': "type",
					'type': "select",
					'label': mw.msg( 'gadgets-formbuilder-editor-chose-field' ),
					'options': selectOptions,
					'default': selectOptions[0].value
				} ]
			} ).formBuilder( {} ).dialog( {
				width: 450,
				modal: true,
				resizable: false,
				title: mw.msg( 'gadgets-formbuilder-editor-chose-field-title' ),
				close: function() {
					$( this ).remove();
				},
				buttons: [
					{
						text: mw.msg( 'gadgets-formbuilder-editor-ok' ),
						click: function() {
							var values = $( this ).formBuilder( 'getValues' );
							$( this ).dialog( "close" );
							self._createFieldDialog( {
								type: values.type,
								callback: params.callback
							} );
						}
					},
					{
						text: mw.msg( 'gadgets-formbuilder-editor-cancel' ),
						click: function() {
							$( this ).dialog( "close" );
						}
					}
				]
			} );
			
			return;
		} else {
			type = params.type;
			if ( typeof prefsDescriptionSpecifications[type] == 'undefined' ) {
				$.error( 'createFieldDialog: invalid type: ' + type );
			}
			
			description = {
				fields: prefsDescriptionSpecifications[type]
			};
		}
		
		if ( typeof params.values != 'undefined' ) {
			values = params.values;
		} else {
			values = {};
			//Set defaults (if given) as starting values
			//TODO: should field constructors just use default if no value is given?
			$.each( description.fields, function( idx, field ) {
				if ( typeof field['default'] != 'undefined' ) {
					values[field.name] = field['default'];
				}
			} );
		}
		
		//Create the dialog to set field properties
		var dlg = $( '<div/>' );
		var form = $( description ).formBuilder( {
			values: values
		} ).appendTo( dlg );
		
		dlg.dialog( {
			modal: true,
			width: 550,
			resizable: false,
			title: mw.msg( 'gadgets-formbuilder-editor-create-field-title' ),
			close: function() {
				$( this ).remove();
			},
			buttons: [
				{
					text: mw.msg( 'gadgets-formbuilder-editor-ok' ),
					click: function() {
						var isValid = $( form ).formBuilder( 'validate' );
							
						if ( isValid ) {
							var fieldDescription = $( form ).formBuilder( 'getValues' );
							
							if ( typeof type != 'undefined' ) {
								//Remove properties the equal their default
								$.each( description.fields, function( index, fieldSpec ) {
									var property = fieldSpec.name;
									if ( fieldDescription[property] === fieldSpec['default'] ) {
										delete fieldDescription[property];
									}
								} );
							}
							
							//Try to create the field. In case of error, warn the user.
							fieldDescription.type = type;
							
							var FieldConstructor = validFieldTypes[type];
							var field;
							
							try {
								field = new FieldConstructor( fieldDescription, self.options );
							} catch ( err ) {
								alert( "Invalid field options: " + err ); //TODO: i18n
								return;
							}

							if ( params.callback( field ) === true ) {
								$( this ).dialog( "close" );
							}
						}
					}
				},
				{
					text: mw.msg( 'gadgets-formbuilder-editor-cancel' ),
					click: function() {
						$( this ).dialog( "close" );
						params.callback( null );
					}
				}
			]
		} );
	};

	SectionField.prototype._deleteSlot = function( $slot ) {
		var field = $slot.data( 'field' );
		if ( field !== undefined ) {
			//Slot with a field
			deleteFieldRules( field );
		}
		
		//Delete it
		$slot.remove();
	};
	
	SectionField.prototype._createSlot = function( editable, field ) {
		var self = this,
			$slot = $( '<div/>' ).addClass( 'formbuilder-slot ui-widget' ),
			$divButtons;
		
		if ( editable ) {
			$slot.addClass( 'formbuilder-slot-editable' );

			$divButtons = $( '<div/>' )
				.addClass( 'formbuilder-editor-slot-buttons' )
				.appendTo( $slot );
		}
		
		if ( typeof field != 'undefined' ) {
			//Nonempty slot
			$slot.prepend( field.getElement() )
				.data( 'field', field );
			
			if ( editable ) {
				$slot.addClass( 'formbuilder-slot-nonempty' );
				
				//Add the handle for moving slots
				$( '<span />' )
					.addClass( 'formbuilder-editor-button formbuilder-editor-button-move ui-icon ui-icon-arrow-4' )
					.attr( 'title', mw.msg( 'gadgets-formbuilder-editor-move' ) )
					.mousedown( function() {
						$( this ).focus();
					} )
					.appendTo( $divButtons );
				
				//Add the button for changing existing slots
				$( '<a href="javascript:;" />' )
					.addClass( 'formbuilder-editor-button formbuilder-editor-button-edit ui-icon ui-icon-gear' )
					.attr( 'title', mw.msg( 'gadgets-formbuilder-editor-edit-field' ) )
					.click( function() {
						self._createFieldDialog( {
							type: field.getDesc().type,
							values: field.getDesc(),
							callback: function( newField ) {
								if ( newField !== null ) {
									//check that there are no duplicate preference names
									var existingValues = self.$div.closest( 'form' ).formBuilder( 'getValues' ),
										removedValues = field.getValues(),
										duplicateName = null;
									$.each( field.getValues(), function( name, val ) {
										//Only complain for preference names that are not in names for the field being replaced
										if ( typeof existingValues[name] != 'undefined' && removedValues[name] == 'undefined'  ) {
											duplicateName = name;
											return false;
										}
									} );
									
									if ( duplicateName !== null ) {
										alert( mw.msg( 'gadgets-formbuilder-editor-duplicate-name', duplicateName ) );
										return false;
									}
									
									var $newSlot = self._createSlot( true, newField );
									
									deleteFieldRules( field );
									
									$slot.replaceWith( $newSlot );
									
									//Add field's validation rules
									addFieldRules( newField );
								}
								return true;
							}
						} );
					} )
					.appendTo( $divButtons );
				
				//Add the button to delete slots
				$( '<a href="javascript:;" />' )
					.addClass( 'formbuilder-editor-button formbuilder-editor-button-delete ui-icon ui-icon-trash' )
					.attr( 'title', mw.msg( 'gadgets-formbuilder-editor-delete-field' ) )
					.click( function( event, ui ) {
						//Make both slots disappear, then delete them 
						$.each( [$slot, $slot.prev()], function( idx, $s ) {
							$s.slideUp( function() {
								self._deleteSlot( $s );
							} );
						} );
					} ) 
					.appendTo( $divButtons );

				//Make this slot draggable to allow moving it
				$slot.draggable( {
					revert: true,
					handle: ".formbuilder-editor-button-move",
					helper: "original",
					zIndex: $slot.closest( 'form' ).zIndex() + 1000, //TODO: ugly, find a better way
					opacity: 0.8,
					cursor: "move",
					cursorAt: {
						top: -5,
						left: -5
					}
				} );
			}
		} else {
			//Create empty slot
			$slot.addClass( 'formbuilder-slot-empty' )
				.droppable( {
					hoverClass: 'formbuilder-slot-can-drop',
					tolerance: 'pointer',
					drop: function( event, ui ) {
						var srcSlot = ui.draggable, dstSlot = this;
						
						//Remove one empty slot surrounding source
						$( srcSlot ).prev().remove();
						
						//Replace dstSlot with srcSlot:
						$( dstSlot ).replaceWith( srcSlot );
						
						//Add one empty slot before and one after the new position
						self._createSlot( true ).insertBefore( srcSlot );
						self._createSlot( true ).insertAfter( srcSlot );
					},
					accept: function( draggable ) {
						//All non empty slots accepted, except for closest siblings
						return $( draggable ).hasClass( 'formbuilder-slot-nonempty' ) &&
							$( draggable ).prev().get( 0 ) !== $slot.get( 0 ) &&
							$( draggable ).next().get( 0 ) !== $slot.get( 0 );
					}
				} );
			
			//The button to create a new field
			$( '<a href="javascript:;" />' )
				.addClass( 'formbuilder-editor-button formbuilder-editor-button-new ui-icon ui-icon-plus' )
				.attr( 'title', mw.msg( 'gadgets-formbuilder-editor-insert-field' ) )
				.click( function() {
					self._createFieldDialog( {
						callback: function( field ) {
							if ( field !== null ) {
								//check that there are no duplicate preference names
								var existingValues = $slot.closest( 'form' ).formBuilder( 'getValues' ),
									duplicateName = null;
								$.each( field.getValues(), function( name, val ) {
									if ( typeof existingValues[name] != 'undefined' ) {
										duplicateName = name;
										return false;
									}
								} );
								
								if ( duplicateName !== null ) {
									alert( mw.msg( 'gadgets-formbuilder-editor-duplicate-name' , duplicateName ) );
									return false;
								}

								var $newSlot = self._createSlot( true, field ).hide(),
									$newEmptySlot = self._createSlot( true ).hide();
								
								$slot.after( $newSlot, $newEmptySlot );
								
								$newSlot.slideDown();
								$newEmptySlot.slideDown();
								
								//Add field's validation rules
								addFieldRules( field );
							}
							return true;
						}
					} );
				} )
				.appendTo( $divButtons );
		}
		
		return $slot;
	};

	
	/* A field for 'bundle's */
	BundleField.prototype = object( EmptyField.prototype );
	BundleField.prototype.constructor = BundleField;
	function BundleField( desc, options ) {
		EmptyField.call( this, desc, options );

		//Create tabs
		var $tabs = this.$tabs = $( '<div><ul></ul></div>' )
			.attr( 'id', idPrefix + 'tab-' + getIncrementalCounter() )
			.tabs( {
				add: function( event, ui ) {
					//Links the anchor to the panel
					$( ui.tab ).data( 'panel', ui.panel );
					
					if ( options.editable === true ) {
						//Add "delete section" button
						$( '<span />' )
							.addClass( 'formbuilder-editor-button formbuilder-editor-button-delete-section ui-icon ui-icon-trash' )
							.attr( 'title', mw.msg( 'gadgets-formbuilder-editor-delete-section' ) )
							.click( function() {
								var sectionField = $( ui.panel ).data( 'field' );
								deleteFieldRules( sectionField );

								var index = $( "li", $tabs ).index( $( this ).closest( "li" ) );
								index -= 1; //Don't count the "add section" button
								
								$tabs.tabs( 'remove', index );
							} )
							.appendTo( ui.tab );

						//Add "edit section" button
						$( '<span />' )
							.addClass( 'formbuilder-editor-button formbuilder-editor-button-edit-section ui-icon ui-icon-gear' )
							.attr( 'title', mw.msg( 'gadgets-formbuilder-editor-edit-section' ) )
							.click( function() {
								var button = this,
									sectionField = $( ui.panel ).data( 'field' );
									
								$( {
									fields: [ {
										'name': "title",
										'type': "string",
										'label': mw.msg( 'gadgets-formbuilder-editor-chose-title' )
									} ]
								} ).formBuilder( {
									values: {
										title: sectionField.getDesc().title
									}
								} ).dialog( {
									modal: true,
									resizable: false,
									title: mw.msg( 'gadgets-formbuilder-editor-chose-title-title' ),
									close: function() {
										$( this ).remove(); //completely destroy on close
									},
									buttons: [
										{
											text: mw.msg( 'gadgets-formbuilder-editor-ok' ),
											click: function() {
												var title = $( this ).formBuilder( 'getValues' ).title;
												
												//Update field description
												sectionField.setTitle( title );
												
												//Update tab's title
												$( button ).parent().find( ':first-child' ).text( title );
												
												$( this ).dialog( "close" );
											}
										},
										{
											text: mw.msg( 'gadgets-formbuilder-editor-cancel' ),
											click: function() {
												$( this ).dialog( "close" );
											}
										}
									]
								} );
							} )
							.appendTo( ui.tab );
					}
				}
			} );

		var self = this;
		$.each( this.desc.sections, function( index, sectionDescription ) {
			var id = idPrefix + 'section-' + getIncrementalCounter(),
				sec = new SectionField( sectionDescription, options, id );
			
			$tabs.append( sec.getElement() )
				.tabs( 'add', '#' + id, preproc( options.prefix, sectionDescription.title ) ); 
		} );

		if ( options.editable === true ) {
			//Add the button to create a new section
			$( '<span>' )
				.addClass( 'formbuilder-editor-button formbuilder-editor-button-new-section ui-icon ui-icon-plus' )
				.attr( 'title', mw.msg( 'gadgets-formbuilder-editor-new-section' ) )
				.click( function() {
					$( {
						fields: [ {
							'name': "title",
							'type': "string",
							'label': mw.msg( 'gadgets-formbuilder-editor-chose-title' )
						} ]
					} ).formBuilder( {} ).dialog( {
						modal: true,
						resizable: false,
						title: mw.msg( 'gadgets-formbuilder-editor-chose-title-title' ),
						close: function() {
							$( this ).remove();
						},
						buttons: [
							{
								text: mw.msg( 'gadgets-formbuilder-editor-ok' ),
								click: function() {
									var title = $( this ).formBuilder( 'getValues' ).title,
										id = idPrefix + 'section-' + getIncrementalCounter(),
										newSectionDescription = {
											title: title,
											fields: []
										},
										newSection = new SectionField( newSectionDescription, options, id );
									
									$tabs.append( newSection.getElement() )
										.tabs( 'add', '#' + id, preproc( options.prefix, title ) );
									
									$( this ).dialog( "close" );
								}
							},
							{
								text: mw.msg( 'gadgets-formbuilder-editor-cancel' ),
								click: function() {
									$( this ).dialog( "close" );
								}
							}
						]
					} );
				} )
				.wrap( '<li />' ).parent()
				.prependTo( $tabs.find('.ui-tabs-nav' ) );
	
			//Make the tabs sortable
			$tabs.tabs().find( '.ui-tabs-nav' ).sortable( {
				axis: 'x',
				items: 'li:not(:has(.formbuilder-editor-button-new-section))'
			} );
		}

		this.$div.append( $tabs );
	}
	
	BundleField.prototype.getValidationSettings = function() {
		var settings = {};
		this.$div.find( '.ui-tabs-nav a' ).each( function( idx, anchor ) {
			var panel = $( anchor ).data( 'panel' ),
				field = $( panel ).data( 'field' );
				
			$.extend( true, settings, field.getValidationSettings() );
		} );
		return settings;
	};

	BundleField.prototype.getDesc = function( useValuesAsDefaults ) {
		var desc = this.desc;
		desc.sections = [];
		this.$div.find( '.ui-tabs-nav a' ).each( function( idx, anchor ) {
			var panel = $( anchor ).data( 'panel' ),
				field = $( panel ).data( 'field' );
				
			desc.sections.push( field.getDesc( useValuesAsDefaults ) );
		} );
		return desc;
	};

	BundleField.prototype.getValues = function() {
		var values = {};
		this.$div.find( '.ui-tabs-nav a' ).each( function( idx, anchor ) {
			var panel = $( anchor ).data( 'panel' ),
				field = $( panel ).data( 'field' );
				
			$.extend( values, field.getValues() );
		} );
		return values;
	};

	validFieldTypes["bundle"] = BundleField;

	/* Public methods */
	
	/**
	 * Main method; takes the given preferences description object and builds
	 * the body of the form with the requested fields.
	 * 
	 * @param {Object} options
	 * @return {Element} the object with the requested form body.
	 */
	function buildFormBody( options ) {		
		var description = this.get( 0 );
		if ( typeof description != 'object' ) {
			mw.log( "description should be an object, instead of a " + typeof description );
			return null;
		}

		var $form = $( '<form/>' ).addClass( 'formbuilder' );
		var prefix = options.gadget === undefined ? '' : ( 'Gadget-' + options.gadget + '-' );

		if ( typeof description.fields != 'object' ) {
			mw.log( "description.fields should be an object, instead of a " + typeof description.fields );
			return null;
		}

		var section = new SectionField( description, { 
			prefix: prefix,
			values: options.values,
			editable: options.editable === true
		} );
		
		section.getElement().appendTo( $form );

		var validator = $form.validate( section.getValidationSettings() );

		$form.data( 'formBuilder', {
			mainSection: section,
			validator: validator
		} );

		return $form;
	}

	var methods = {
		
		/**
		 * Returns a dictionary of field names and field values.
		 * Returned values are not warranted to pass field validation.
		 * 
		 * @return {Object}
		 */
		getValues: function() {
			var data = this.data( 'formBuilder' );
			return data.mainSection.getValues();
		},

		/**
		 * Returns the current description, where current values as set for 'default' values.
		 * Used by the preference editor.
		 * 
		 * NOTE: it is responsibility of the caller to call 'validate' and ensure that
		 * current values pass validation before calling this method.
		 * 
		 * @return {Object}
		 */
		getDescription: function() {
			var data = this.data( 'formBuilder' );
			return data.mainSection.getDesc( true );
		},

		/**
		 * Do validation of form fields and warn the user about wrong values, if any.
		 * 
		 * @return {Boolean} true if all fields pass validation, false otherwise.
		 */
		validate: function() {
			var data = this.data( 'formBuilder' );
			return data.validator.form();
		}
	};

	$.fn.formBuilder = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || !method ) {
			return buildFormBody.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.formBuilder' );
		}
	};
})( jQuery, mediaWiki );

