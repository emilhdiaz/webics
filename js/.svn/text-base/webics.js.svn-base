/**
 * FireBug debug console logging.
 */
function log(message) {
	if(LOG == true) {
		console.log(message);
	}	
}

var processResponse = function(request, normalCallBack, normalMessage, dispatchEvent) {
	var delay = 2000;
	var dispatch = new Dispatch();
	banner =  new Banner(); 
	banner.showClose('Close');
	
//	log(request.response);
	response = request.response;

	switch(request.status) {
	case 'normal':		
		/* Service Request Callbacks */
		$splat(normalCallBack).each( function( callback ) {
			if( $type(callback) == 'function') callback.attempt(request.response);
			else log('NOT A FUNCTION');
		});
		
		/* Notify the Dispatch */
		if( $defined(dispatchEvent) ) {
//			log('Dispath: notifying dispatch of event: '+dispatchEvent);
			dispatch.notify(dispatchEvent, request.response);
		}
		
		/* Success Message Banner */
		if( $defined(normalMessage) ) {
			banner.addClass('Normal');
			banner.setHeader(normalMessage);
			banner.reveal();
			banner.nix.delay(delay);
		} else {
			banner.nix(true);
		}
		break;
		
	case 'warning':
		banner.addClass('Warning');
		banner.setHeader(request.response.message);
		banner.reveal();
		banner.nix.delay(delay);
		break;
		
	case 'error':
		var messages = '';
		banner.addClass('Error');
		request.response.each( function(message) {
			messages = messages + message +' - ';
		});
		banner.setHeader(messages);
		banner.reveal();
		banner.nix.delay(delay);
		break;
		
	case 'exception':
		banner.addClass('Error');
		banner.setHeader(request.response.message);
		banner.reveal();
		banner.nix.delay(delay);
		break;
		
	case 'authenticate':
//		new Webics.Request(WS_ENDPOINT, 'authenticate', {AuthenticationScheme: 'HTTPBasic'});
		APP.login();
		banner.nix(true);
		break;
	}
	
	return request.response;
};

Array.implement({
	toHash : function() {
		i = 0;
		keys = [];
		this.each( function(item) {
			keys[i] = i + 1;
		});
		return this.associate(keys);
	}
});

Element.implement({
	insert : function(el, where) {
		switch($type(el)) {
			case 'textnode':
			case 'number':
			case 'string':
				this.appendText(el, where);
			break;
			
			case 'element':
			case 'object':
				this.grab($(el), where);
			break;
			
			case 'hash':
			case 'array':
				el.each( function(_el) {
					this.insert(_el, where);
				});
			break;
		}
		
		return this;
	}
});


/*
 * Base Classes
 */

var Runnable = new Class({
	run: function() {}
});

var ElementContext = new Class({

	Binds	: true,
	element	: null,
	
	initialize: function( element ) {
		this.element = element;
	},
	
	toElement: function() {
		return this.element;
	}
});

/**
 * Base Organizer Class
 */
var Organizer = new Class({
	
	Extends	: ElementContext,
	
	addLine: function( key, items ) {},
	
	removeLine: function( key ) {},
	
	clearLines: function() {},
	
	replaceLine: function( oldKey, newKey, items ) {}
});

/**
 * Text Class
 */
var Text = new Class({
	
	Extends	: ElementContext,
	
	initialize: function( text ) {
		this.parent($defined(text) ? text : '');
	}
});

/**
 * Base SimpleElementContext Class
 * 
 * The ElementContext class provide general methods to modify the 
 * underlying element and its attributes while buffering it from 
 * direct use in the rest of the application. 
 * 
 * General Getters/Setters
 * It supports the general getters and setters for the element's 
 * styles, properties, classes, and events. 
 * 
 * Standard Attribute Getters/Setters
 * It supports the setting of WWWC standard element attributes 
 * (dir, id, lang, and title). Additionally, it supports setting the
 * element's context name, which is used in CSS styles to provide more 
 * fine-grained control over CSS selectors.
 * 
 * Mootools toElement Hook
 * The toElement method is implemented to hook directly into the Mootools 
 * framework and allow ElementContext objects to be used wherever Element 
 * objects are expected. 
 * 
 * Object Lifespan Methods
 * It supports standard object lifespan methods to manage clones and 
 * destroy the element. Additionally it supports some visual properties
 * such as the visibility of the element. 
 * 
 * Information
 * It supports the return of object information, such as whether the 
 * element is equal to another element, is visible, its dimensions, 
 * and its coordinates (optionally relative to another element).
 * 
 * @param String	tag		- The HTML tag of the element object
 * @param Hash		options	- Optional options to pass to the element object
 */
var SimpleElementContext = new Class({
	
	Extends	: ElementContext,
	id		: null,
	tag		: null,
	title	: null,
	context : null,
	language: null,
	direction: null,
	
	/**
	 * Constructor
	 */
	initialize: function( tag, options ) {
		if( $type(tag) != 'string' ) 
			throw TypeError("'tag' must be a string");
		if( ($type(options) != false) && !(options instanceof Object) ) 
			throw TypeError("'options' must be an Object of properties");
	
		this.parent(new Element(tag, options));
		this.setContext('SimpleElementContext');
		this.tag = tag;
	},
	
	/**
	 * To native Element
	 */
	toElement: function() {
		return this.element;
	},
	
	/**
	 * Get Styles
	 */
	getStyle: function( style  ) {
		return this.element.getStyle(style);
	},
	
	getStyles: function( styles ) {
		return this.element.getStyles.run(styles, this);
	},	
	
	/**
	 * Set Styles
	 */
	setStyle: function( style, value  ) {
		this.element.setStyle(style, value);
		return this;
	},
	
	setStyles: function( styles  ) {
		this.element.setStyles(styles);
		return this;
	},
	
	/**
	 * Remove Styles
	 */
	removeStyle: function( style ) {
		this.element.setStyle(style, null);
		return this;
	},
	
	removeStyles: function( styles ) {
		$each(styles, function(style) { this.removeStyle(style); }, this);
		return this;
	},
	
	/**
	 * Get Properties 
	 */
	getProperty: function( property ) {
		return this.element.getProperty(property);
	},
	
	getProperties: function( properties ) {
		return this.element.getProperties.run(properties, this);
	},	
	
	/**
	 * Set Properties
	 */
	setProperty: function( property, value  ) {
		this.element.setProperty(property, value);
		return this;
	},
	
	setProperties: function( properties  ) {
		this.element.setProperties(properties);
		return this;
	},	
	
	/**
	 * Remove Properties
	 */
	removeProperty: function( property ) {
		this.element.setProperty(property, null);
		return this;
	},
	
	removeProperties: function( properties ) {
		$each(properties, function(property) { this.removeProperty(property); }, this);
		return this;
	},
	
	/**
	 * Add/Remove/Replace Classes
	 */
	addClass: function( className ) {
		this.element.addClass(className);
		return this;
	},
	
	addClasses: function( classNames ) {
		$each(classNames, function(className) { this.addClass(className); }, this);
		return this;
	},
	
	removeClass: function( className ) {
		this.element.removeClass(className);
		return this;
	},	
	
	removeClasses: function( classNames ) {
		$each(classNames, function(className) { this.removeClass(className); }, this);
		return this;
	},
	
	toggleClass: function( className ) {
		this.element.toggleClass(className);
		return this;
	},	
	
	replaceClass: function( oldClassName, newClassName ) {
		this.element.swapClass(oldClassName, newClassName);
		return this;
	},
	
	clearClasses: function() {
		return this.removeProperty('class');
	},
	
	/**
	 * Set Events
	 */
	addEvent: function( type, fn ) {
		this.element.addEvent(type, fn);
		return this;
	},
	
	addEvents: function( events ) {
		this.element.addEvents(events);
		return this;
	},
	
	removeEvent: function( type, fn ) {
		this.element.removeEvent(type, fn);
		return this;
	},	
	
	removeEvents: function( events ) {
		this.element.removeEvents(events);
		return this;
	},
	
	fireEvent: function( type, args, delay ) {
		this.element.fireEvent(type, args, delay);
		return this;
	},	
	
	clearEvents: function( type ) {
		return this.removeEvents(type);
	},
	
	/** 
	 * Set Standard Attributes
	 */
	setID: function( id ) {
		this.id = id;
		return this.setProperty('id', id);
	},
	
	setTitle: function( title ) {
		this.title = title;
		return this.setProperty('title', title);
	},
	
	setDirection: function( direction ) {
		this.direction = direction;
		return this.setProperty('dir', direction);
	},
	
	setLanguage: function( language ) {
		this.language = language;
		return this.setProperty('lang', language);
	},
	
	setContext: function( context ) {
		this.context = context;
		return this.setProperty('context', context);
	},

	/**
	 * Manage Lifespan 
	 */
	replaces: function( element ) {
		this.element.replaces(element);
		return this;
	},
	
	clone: function( contents, keepid ) {
		return $merge(this, {element:this.element.clone(contents, keepid)});
	},
	
	dispose: function() {
		this.element.dispose();
		return this;
	},
	
	destroy: function() {
		this.element.destroy();
		return this;
	},
	
	hide: function() {
		this.element.hide();
		return this;
	},
	
	show: function() {
		this.element.show();
		return this;
	},
	
	toggle: function() {
		this.element.toggle();
		return this;
	},
	
	position: function( options ) {
		this.element.position(options);
		return this;
	},
	
	center: function() {
		this.element.position();
		return this;
	},
	
	fade: function( mask ) {
		this.element.fade(mask);
		return this;
	},
	
	move: function( options ) {
		this.element.move(options);
		return this;
	},
	
	centralize: function() {
		this.element.move();
		return this;
	},
		
	draggable: function( handle ) {
		this.element.makeDraggable({handle: $defined(handle) ? $(handle) : this.element});
		return this;
	},
	
	reveal: function( options ) {
		this.element.reveal(options);
		return this;
	},
	
	dissolve: function() {
		this.element.dissolve();
		return this;
	},
	
	nix: function( destroy ) {
		this.element.nix();
		return this;
	},
	
	/**
	 * Information 
	 */
	isEqual: function( element ) {
		return !!(this.element === $(element));
	},
	
	isA: function( object ) {
		return !!this.element.match(tag);
	},
	
	isDisplayed: function() {
		return !!this.element.isDisplayed();
	},
	
	getDimensions: function() {
		return this.element.getDimensions();
	}, 
	
	getCoordinates: function( relative ) {
		return this.element.getCoordinates($(relative));
	}
	
});

/**
 * Base TextElementContext Class
 */
var TextElementContext = new Class({
	
	Extends	: SimpleElementContext,
	text	: null,

	/**
	 * Constructor
	 */
	initialize: function( tag, options ) {
		this.parent(tag, options);
		this.setContext('CompositeElementContext');
		this.text = '';
	},
	
	/**
	 * Add/Remove/Replace Text
	 */
	addText: function( text ) {
		this.text += text;
		this.element.appendText(text);
		return this;
	},
	
	removeText: function() {
		this.text = '';
		return this.removeProperty('text');
	},

	setText: function( text ) {
		this.text = text;
		return this.setProperty('text', text);
	}
});

/**
 * Base CompositeElementContext
 * 
 * The CompositeElementContext provides methods to manage the lifespan 
 * of the compositions of root element. This base class is intended to
 * be used with HTML Elements such as <table>, <form>, <img>, etc...
 * 
 * Elements Get/Add/Remove/Replace Methods
 * It provides methods to add, 
 * get (search), remove, and replace child elements.
 * 
 * Conviniece Methods
 * It also provides a few convinience methods such as insert, wrap, and 
 * empty to faciliate the the user.
 * 
 * Information
 * It extends the support for information that is provided by 
 * ElementContext by providing information about the child elements
 * that it has.
 *  
 * @param String	tag		- The HTML tag of the element object
 * @param Hash		options	- Optional options to pass to the element object
 */
var CompositeElementContext = new Class({
	
	Extends	: SimpleElementContext,
	elements: null,

	/**
	 * Constructor
	 */
	initialize: function( tag, options ) {
		this.parent(tag, options);
		this.setContext('CompositeElementContext');
		this.elements = new Array();
	},
	
	/**
	 * Find Elements
	 */
	findElement: function( tag ) {
		return this.element.getElement(tag);
	},
	
	findElements: function( tag ) {
		return this.element.getElements(tag);
	},
	
	/**
	 * Add Elements
	 */
	addElement: function( element, where ) {
		if( !(element instanceof Element) && !(element instanceof ElementContext) ) {
			throw TypeError("'element' must be an instance of Element or ElementContext");
		}
		if( !['string', false].contains($type(where)) ) 
			throw TypeError("'where' must be a string");

		this.element.insert($(element), where);
		this.elements.include(element);
		return this;
	},
	
	addElements: function ( elements, where ) {
		if( !(elements instanceof Array) ) 
			throw TypeError("'elements' must be an Array of Element or ElementContext instances");
		
		$each(elements, function(element) { this.addElement(element, where); }, this);
		return this;
	},
	
	wrapElement: function( element, where ) {
		if( !(element instanceof Element) && !(element instanceof ElementContext) ) 
			throw TypeError("'element' must be an instance of Element or ElementContext");
		if( !['string', false].contains($type(where)) ) 
			throw TypeError("'where' must be a string");
		
		this.element.wraps($(element), where);
		this.elements.include(element);
		return this;
	},
	
	/**
	 * Remove Elements
	 */
	removeElement: function ( element ) {
		if ( !this.hasElement(element) ) throw ReferenceError;
		
		$(element).dispose();
		this.elements.erase(element);
		return this;
	},
	
	removeElements: function( elements ) {
		$each(elements, function(element) { this.removeElement(element); }, this);
		return this;
	},

	clearElements: function() {
		this.element.empty();
		this.elements.empty();
		return this;
	},
	
	disposeElements: function() {
		$each(this.elements, function(element) { $(element).dispose(); }, this);
		this.elements.empty();
		return this;
	},

	/**
	 * Replace Elements
	 */
	replaceElement: function( oldElement, newElement ) {
		if ( !this.hasElement(oldElement) ) throw ReferenceError;
		
		$(newElement).replaces($(oldElement));
		this.elements[this.elements.indexOf(oldElement)] = newElement;
		return this;
	},
	
	/**
	 * Information
	 */
	isEmpty: function() {
		return !!((this.element.getChildren().length == 0) && (this.element.get('text').length == 0));
	},
	
	hasElement: function( element ) {
		return !!this.element.hasChild($(element));
	}
	
});

/**
 * Base ComplexElementContext
 * 
 * The ComplexElementContect provides methods to manage the lifespan 
 * of the compositions of root element. This base class is intended to 
 * be used with built-up HTML composite forms. 
 * 
 * @param String	tag		- The HTML tag of the element object
 * @param Hash		options	- Optional options to pass to the element object
 */
var ComplexElementContext = new Class({
	
	Extends	: CompositeElementContext,
	
	/**
	 * Constructor
	 */
	initialize: function( tag, options ) {
		this.parent(tag, options);
		this.setContext('ComplexElementContext');
	}
});

/**
 * Dispatch Class
 */
var Dispatch = new Class({
	
	Binds		: true,
	Singleton	: true,
	observers	: null,
	persistent	: null,
	
	initialize: function() {
		this.observers = new Hash();
		this.persistent = new Array();
	},
		
	notify: function( service, value, persist ) {
		if( $type(service) != 'string')
			throw TypeError("'service' must be a string");
		if( !this.observers.has(service) ) {
//			log("no subscribers of service: '"+service+"'");
			return this;
		}

//		log("notifying subscribers of services: '"+service+"'");
		
		this.observers.get(service).each( function(observer) {	
			observer.run(value);
			if( this.persistent.contains(observer) == false ) {
				this.observers.get(service).erase(observer);
			}
		}.bind(this));
		return this;
	},
	
	subscribe: function( service, observer, persist ) {
		if( $type(service) != 'string')
			throw TypeError("'name' must be a string");
		if( $type(observer) != 'function')
			throw TypeError("'observer' must be a function");
		if( !this.observers.has(service) )
			this.observers.set(service, new Array());

//		log("subscribing observer to service: '"+service+"'");
		
		this.observers.get(service).include(observer);
		
		if( persist = true ) this.persistent.include(observer);
		
		return this;
	}
}); 

/**
 * Goto Class
 */
var Goto = new Class({
	
	Extends	: Runnable, 
	uri		: null,
	
	initialize: function( uri, data ) {
		this.uri = new URI(uri).setData(data);
	},
	
	run: function() {
		log(this);
		this.uri.go();
	}
});

/**
 * Button Class
 */
var Button = new Class({
	
	Extends	: CompositeElementContext,
	name	: null,
	type	: null,
	value	: null,
	disabled: null,
	
	/**
	 * Constructor
	 */
	initialize: function( action, options ) {
		this.parent('button', options);
		this.setContext('Button');
		this.setAction(action);
	},
	
	setAction: function( action ) {
		if( ($type(action) != 'function') && !(action instanceof Runnable ) )
			throw TypeError("'action' must be a function");
		
		this.action = action;
		this.clearEvents('click');
		this.addEvent('click', (action instanceof Runnable ) ? action.run.bind(action) : action.pass(this) );
		return this;
	},
	
	setName: function( name ) {
		if( $type(name) != 'string' ) 
			throw TypeError("'name' must be a string");
		
		this.name = name;
		return this.setProperty('name', name);
	},
	
	setType: function( type ) {
		if( $type(type) != 'string' ) 
			throw TypeError("'type' must be a string");
		
		this.type = type;
		return this.setProperty('type', type);
	},
	
	setValue: function( value ) {
		if( !['string', false].contains($type(value)) ) 
			throw TypeError("'value' must be a string");
		
		this.value = value;
		return this.setProperty('value', value);
	},
	
	setDisabled: function( disabled ) {
		if( $type(disabled) != 'boolean' ) 
			throw TypeError("'disabled' must be a boolean");
		
		this.disabled = disabled;
		return this.setProperty('disabled', disabled);
	}
});

var Actionable = new Class({
	
	Extends		: Button,
	alternate	: null,
	
	initialize: function( action, options ) {
		this.parent(action, options);
		this.setContext('Actionable');
	},
	
	setAlternate: function( alternate ) {
		if( alternate.func ) { 
			this.setAction(alternate.func);
		}
		if( alternate.content ) {
			this.clearElements();
			this.addElement(alternate.content);
		}
		return this;
	}
});

/**
 * Image Class
 */
var Image = new Class({
	
	Extends	: SimpleElementContext, 
	alt		: null,
	src		: null,
	height	: null, 
	width	: null,
	
	/**
	 * Constructor
	 */
	initialize: function(alt, src, options) {
		this.parent('img', options);
		this.setContext('Image');
		this.setAlt(alt);
		this.setSrc(src);
	},
	
	setAlt: function( alt ) {
		if( $type(alt) != 'string' ) 
			throw TypeError("'alt' must be a string");
		
		this.alt = alt;
		return this.setProperty('alt', alt);
	},
	
	setSrc: function( src ) {
		if( $type(src) != 'string' ) 
			throw TypeError("'src' must be a string");
		
		this.src = src;
		return this.setProperty('src', src);
	},
	
	setHeight: function( height ) {
		if( !['string', 'number'].contains($type(height)) )
			throw TypeError("'height' must be a string or number");
		
		this.height = height;
		return this.setProperty('height', height);
	},
	
	setWidth: function( width ) {
		if( !['string', 'number'].contains($type(width)) )
			throw TypeError("'width' must be a string or number");
		
		this.width = width;
		return this.setProperty('width', width);
	},
	
	setSize: function (height, width) {
		this.setHeight(height);
		this.setWidth(width);
		
		return this;
	}
});

/**
 * Span Class
 */
var Span = new Class({
	
	Extends	: TextElementContext, 
	
	initialize: function( options ) {
		this.parent('span', options);
		this.setContext('Span');
	}
});

/**
 * A Class
 */
var A = new Class({
	
	Extends	: TextElementContext, 
	href	: null,
	
	initialize: function( href, options ) {
		this.parent('a', options);
		this.setContext('A');
		this.setHref(href);
	},
	
	setHref: function( href ) {
		this.href = href;
		return this.setProperty('href', href);
	}
});

/**
 * Div Class
 */
var Div = new Class({
	
	Extends : CompositeElementContext, 
	
	initialize: function( options ) {
		this.parent('div', options);
		this.setContext('Div');
	}
});

/**
 * Clear Class
 */
var Clear = new Class({

	Extends	: SimpleElementContext,
	
	initialize: function( options ) {
		this.parent('div', options);
		this.setContext('Clear');
		this.setStyle('clear', 'both');
	}
});

/**
 * Table Class
 */
var Table = new Class({
	
	Extends	: CompositeElementContext,
	width	: null,
	border	: null,
	cellpadding: null, 
	cellspacing: null, 
	caption	: null,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('table', options);
		this.setContext('Table');
		this.caption = new Table.Caption();
	},
	
	setCaption: function( caption ) {
		if( !this.hasElement(this.caption) )
			this.element.insert(this.caption, 'top');
		
		this.caption.setText(caption);
	},
	
	setWidth: function( width ) {
		if( $type(width) != 'number' ) 
			throw TypeError("'width' must be a number");
		
		this.width = width;
		return this.setProperty('width', width);
	},
	
	setCellpadding: function( cellpadding ) {
		if( $type(cellpadding) != 'number' ) 
			throw TypeError("'cellpadding' must be a number");
		
		this.cellpadding = cellpadding;
		return this.setProperty('cellpadding', cellpadding);
	},
	
	setCellspacing: function( cellspacing ) {
		if( $type(cellspacing) != 'number' ) 
			throw TypeError("'cellspacing' must be a number");
		
		this.cellspacing = cellspacing;
		return this.setProperty('cellspacing', cellspacing);
	},
	
	addElement: function( section, where ) {
		if( !(section instanceof Table.Section) ) 
			throw TypeError("'section' must be an instance of Table.Section");
		
		return this.parent(section, where);
	},
	
	wrapElement: function( section, where ) {
		if( !(section instanceof Table.Section) ) 
			throw TypeError("'section' must be an instance of Table.Section");
		
		return this.parent(section, where);
	},
	
	replaceElement: function( oldSection, newSection ) {
		if( !(oldSection instanceof Table.Section) ) 
			throw TypeError("'oldSection' must be an instance of Table.Section");
		if( !(newSection instanceof Table.Section) ) 
			throw TypeError("'newSection' must be an instance of Table.Section");
		
		return this.parent(oldSection, newSection);
	}
});

/**
 * TableSection Class
 */
var TableSection = new Class({
	
	Extends	: CompositeElementContext, 
	align	: null,
	valign	: null,
	
	/**
	 * Constructor
	 */
	initialize: function( tag, options ) {
		this.parent(tag, options);
		this.setContext('Table.Section');
	},
	
	setAlign: function( align ) {
		if( $type(align) != 'string' ) 
			throw TypeError("'align' must be a string");
		
		this.align = align;
		return this.setProperty('align', align);
	},
	
	setValign: function( valign ) {
		if( $type(valign) != 'string' ) 
			throw TypeError("'valign' must be a string");
		
		this.valign = valign;
		return this.setProperty('valign', valign);
	},
	
	addElement: function( row, where ) {
		if( !(row instanceof Table.Tr) ) 
			throw TypeError("'row' must be an instance of Table.Tr");
		
		return this.parent(row, where);
	},
	
	wrapElement: function( row, where ) {
		if( !(row instanceof Table.Tr) ) 
			throw TypeError("'row' must be an instance of Table.Tr");
		
		return this.parent(row, where);
	},
	
	replaceElement: function( oldRow, newRow ) {
		if( !(oldRow instanceof Table.Tr) ) 
			throw TypeError("'oldRow' must be an instance of Table.Tr");
		if( !(newRow instanceof Table.Tr) ) 
			throw TypeError("'newRow' must be an instance of Table.Tr");
		
		return this.parent(oldRow, newRow);
	}
});
Table.Section = TableSection;

/**
 * TableCell Class
 */
var TableCell = new Class({
	
	Extends	: CompositeElementContext,
	align	: null,
	valign	: null,
	colspan	: null, 
	rowspan	: null,
	
	/**
	 * Constructor
	 */
	initialize: function( tag, options ) {
		this.parent(tag, options);
		this.setContext('Table.Cell');
	},
	
	setAlign: function( align ) {
		if( $type(align) != 'string' ) 
			throw TypeError("'align' must be a string");
		
		this.align = align;
		return this.setProperty('align', align);
	},
	
	setValign: function( valign ) {
		if( $type(valign) != 'string' ) 
			throw TypeError("'valign' must be a string");
		
		this.valign = valign;
		return this.setProperty('valign', valign);
	},
	
	setColspan: function( colspan ) {
		if( $type(colspan) != 'number' ) 
			throw TypeError("'colspan' must be a number");
		
		this.colspan = colspan;
		return this.setProperty('colspan', colspan);
	},
	
	setRowspan: function( rowspan ) {
		if( $type(rowspan) != 'number' ) 
			throw TypeError("'rowspan' must be a number");
		
		this.rowspan = rowspan;
		return this.setProperty('rowspan', rowspan);
	}
});
Table.Cell = TableCell;

/**
 * TableThead Class
 */
var TableThead = new Class({
	
	Extends	: Table.Section,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('thead', options);
		this.setContext('Table.Thead');
	}
});
Table.Thead = TableThead;

/**
 * TableTbody Class
 */
var TableTbody = new Class({
	
	Extends	: Table.Section,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('tbody', options);
		this.setContext('Table.Tbody');
	}
});
Table.Tbody = TableTbody;

/**
 * TableTfoot Class
 */
var TableTfoot = new Class({
	
	Extends	: Table.Section,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('tfoot', options);
		this.setContext('Table.Tfoot');
	}
});
Table.Tfoot = TableTfoot;

/**
 * TableTr Class
 */
var TableTr = new Class({
	
	Extends	: CompositeElementContext,
	align	: null,
	valign	: null,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('tr', options);
		this.setContext('Table.Tr');
	},
	
	setAlign: function( align ) {
		if( $type(align) != 'string' ) 
			throw TypeError("'align' must be a number");
		
		this.align = align;
		return this.setProperty('align', align);
	},
	
	setValign: function( valign ) {
		if( $type(valign) != 'string' ) 
			throw TypeError("'valign' must be a number");
		
		this.valign = valign;
		return this.setProperty('valign', valign);
	},
	
	addElement: function( cell, where ) {
		if( !(cell instanceof Table.Cell) ) 
			throw TypeError("'cell' must be an instance of Table.Cell");
		
		return this.parent(cell, where);
	},
	
	wrapElement: function( cell, where ) {
		if( !(cell instanceof Table.Cell) ) 
			throw TypeError("'cell' must be an instance of Table.Cell");
		
		return this.parent(cell, where);
	},
	
	replaceElement: function( oldCell, newCell ) {
		if( !(oldCell instanceof Table.Cell) ) 
			throw TypeError("'oldCell' must be an instance of Table.Cell");
		if( !(newCell instanceof Table.Cell) ) 
			throw TypeError("'newCell' must be an instance of Table.Cell");
		
		return this.parent(oldCell, newCell);
	}
});
Table.Tr = TableTr;

/**
 * TableTh Class
 */
var TableTh = new Class({
	
	Extends	: Table.Cell,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('th', options);
		this.setContext('Table.Th');
	}
});
Table.Th = TableTh;

/**
 * TableTd Class
 */
var TableTd = new Class({
	
	Extends	: Table.Cell,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('td', options);
		this.setContext('Table.Td');
	}
});
Table.Td = TableTd;

/**
 * TableCaption Class
 */
var TableCaption = new Class({
	
	Extends	: TextElementContext,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('caption', options);
		this.setContext('Table.Caption');
	}
});
Table.Caption = TableCaption;


/**
 * Form Class
 */
var Form = new Class({
	
	Extends	: CompositeElementContext, 
	name	: null,
	action	: null,
	method	: null, 
	charset	: null, 
	enctype	: null,
	
	/**
	 * Constructor
	 */
	initialize: function( action, options ) {
		this.parent('form', options);
		this.setContext('Form');
		this.setAction(action);
	},
	
	setName: function( name ) {
		if( $type(name) != 'string' ) 
			throw TypeError("'name' must be a string");
		
		this.name = name;
		return this.setProperty('name', name);
	},
	
	setAction: function( action ) {
		if( $type(action) != 'string' ) 
			throw TypeError("'action' must be a string");
		
		this.action = action; 
		return this.setProperty('action', action);
	},
	
	setMethod: function( method ) {
		if( $type(method) != 'string' ) 
			throw TypeError("'method' must be a string");
		
		this.method = method;
		return this.setProperty('method', method);
	},
	
	setCharset: function( charset ) {
		if( $type(charset) != 'string' ) 
			throw TypeError("'charset' must be a string");
		
		this.charset = charset;
		return this.setProperty('accept-charset', charset);
	},
	
	setEnctype: function( enctype ) {
		if( $type(enctype) != 'string' ) 
			throw TypeError("'enctype' must be a string");
		
		this.enctype = enctype;
		return this.setProperty('enctype', enctype);
	},
	
	asynchronous: function( options ) {
		if( ($type(options) != false) && !(options instanceof Object) ) 
			throw TypeError("'options' must be an Object of properties");

		this.element.set('send', options);
		this.clearEvents('submit');
		this.addEvent('submit', function(e) {
			if(e) e.stop();
			this.send();
		}.bind(this));
		return this;
	},
	
	synchronous: function() {
		this.clearEvents('submit');
		this.addEvent('submit', function(e) {
			if(e) e.stop();
			this.submit();
		});
		return this;
	},
	
	submit: function() {
		this.fireEvent('submit');
		return this;
	},
	
	post: function() {
		this.synchronous();
		this.setMethod('post');
		this.submit();
		return this;
	},
	
	get: function() {
		this.synchronous();
		this.setMethod('get');
		this.submit();
		return this;
	},
	
	send: function( queue ) {
		if( ($type(queue) != false) && !(queue instanceof Webics.Queue) ) 
			throw TypeError("'queue' must be an instance of Queue");

		if(queue) {
			queue.dispatch(this.element.get('send'));
		} else {
			this.element.send();
		}
		return this;
	}
});

/**
 * FormSimpleInput Class
 */
var FormSimpleInput = new Class({
	
	Extends	: SimpleElementContext,
	name	: null,
	type	: null,
	size	: null,
	value	: null,
	disabled: null,
	
	/**
	 * Constructor
	 */
	initialize: function( tag, type, name, options ) {
		this.parent(tag, options);
		this.setContext('Form.SimpleInput');
		this.setName(name);
		this.setType(type);
	},
	
	setName: function( name ) {
		if( $type(name) != 'string' ) 
			throw TypeError("'name' must be a string");
		
		this.name = name;
		return this.setProperty('name', name);
	},
	
	setType: function( type ) {
		if( $type(type) != 'string' ) 
			throw TypeError("'type' must be a string");
		
		this.type = type;
		return this.setProperty('type', type);
	},
	
	setSize: function( size ) {
		if( $type(size) != 'number' ) 
			throw TypeError("'size' must be a number");
		
		this.size = size;
		return this.setProperty('size', size);
	},

	setValue: function( value ) {
		if( !['string', 'number', false].contains($type(value)) ) 
			throw TypeError("'value' must be a string");
		
		this.value = value;
		return this.setProperty('value', value);
	},
	
	setDisabled: function( disabled ) {
		if( $type(disabled) != 'boolean' ) 
			throw TypeError("'disabled' must be a boolean");
		
		this.disabled = disabled;
		return this.setProperty('disabled', disabled);
	}
});
Form.SimpleInput = FormSimpleInput;

/**
 * FormCompositeInput Class
 */
var FormCompositeInput = new Class({
	
	Extends	: CompositeElementContext,
	name	: null,
	size	: null,
	value	: null,
	disabled: null,
	
	/**
	 * Constructor
	 */
	initialize: function( tag, name, options ) {
		this.parent(tag, options);
		this.setContext('Form.SimpleInput');
		this.setName(name);
	},
	
	setName: function( name ) {
		if( $type(name) != 'string' ) 
			throw TypeError("'name' must be a string");
		
		this.name = name;
		return this.setProperty('name', name);
	},
	
	setSize: function( size ) {
		if( $type(size) != 'number' ) 
			throw TypeError("'size' must be a number");
		
		this.size = size;
		return this.setProperty('size', size);
	},

	setValue: function( value ) {
		if( !['string', 'number', false].contains($type(value)) ) 
			throw TypeError("'value' must be a string");
		
		this.value = value;
		return this.setProperty('value', value);
	},
	
	setDisabled: function( disabled ) {
		if( $type(disabled) != 'boolean' ) 
			throw TypeError("'disabled' must be a boolean");
		
		this.disabled = disabled;
		return this.setProperty('disabled', disabled);
	}
});
Form.CompositeInput = FormCompositeInput;

/**
 * FormTextfield Class
 */
var FormTextfield = new Class({
	
	Extends	: Form.SimpleInput,
	readonly: null,
	maxlength: null, 
	
	/**
	 * Constructor
	 */
	initialize: function( name, options ) {
		this.parent('input', 'text', name, options);
		this.setContext('Form.Textfield');
	},
	
	setReadonly: function( readonly ) {
		if( $type(readonly) != 'boolean' ) 
			throw TypeError("'readonly' must be a boolean");
		
		this.readonly = readonly;
		return this.setProperty('readonly', readonly);
	},
	
	setMaxLength: function( maxlength ) {
		if( $type(maxlength) != 'number' ) 
			throw TypeError("'maxlength' must be a number");
		
		this.maxlenght = maxlength;
		return this.setProperty('maxlength', maxlength);
	}
});
Form.Textfield = FormTextfield;

/**
 * FormPassword Class
 */
var FormPassword = new Class({
	
	Extends	: Form.SimpleInput,
	readonly: null,
	maxlength: null,
	
	/**
	 * Constructor
	 */
	initialize: function( name, options ) {
		this.parent('input', 'password', name, options);
		this.setContext('Form.Password');
	},
	
	setReadonly: function( readonly ) {
		if( $type(readonly) != 'boolean' ) 
			throw TypeError("'readonly' must be a boolean");
		
		this.readonly = readonly;
		return this.setProperty('readonly', readonly);
	},
	
	setMaxLength: function( maxlength ) {
		if( $type(maxlength) != 'number' ) 
			throw TypeError("'maxlength' must be a number");
		
		this.maxlenght = maxlength;
		return this.setProperty('maxlength', maxlength);
	}
});
Form.Password = FormPassword;

/**
 * FormCheckbox Class
 */
var FormCheckbox = new Class({
	
	Extends	: Form.SimpleInput,
	checked	: null,
	
	/**
	 * Constructor
	 */
	initialize: function( name, value, options ) {
		this.parent('input', 'checkbox', name, options);
		this.setContext('Form.Checkbox');
		this.setValue(value);
	},
	
	setChecked: function( checked ) {
		if( $type(checked) != 'boolean' ) 
			throw TypeError("'checked' must be a boolean");
		
		this.checked = checked;
		return this.setProperty('checked', checked);
	}
});
Form.Checkbox = FormCheckbox;

/**
 * FormRadio Class
 */
var FormRadio = new Class({
	
	Extends	: Form.SimpleInput,
	checked	: null,
	
	/**
	 * Constructor
	 */
	initialize: function( name, value, options ) {
		this.parent('input', 'radio', name, options);
		this.setContext('Form.Radio');
		this.setValue(value);
	},
	
	setChecked: function( checked ) {
		if( $type(checked) != 'boolean' ) 
			throw TypeError("'checked' must be a boolean");
		
		this.checked = checked;
		return this.setProperty('checked', checked);
	}
});
Form.Radio = FormRadio;

/**
 * FormFile Class
 */
var FormFile = new Class({
	
	Extends	: Form.SimpleInput,
	accept  : null,
	
	/**
	 * Constructor
	 */
	initialize: function( name, options ) {
		this.parent('input', 'file', name, options);
		this.setContext('Form.File');
	},
	
	setAccept: function( accept ) {
		if( $type(accept) != 'string' ) 
			throw TypeError("'accept' must be a string");
		
		this.accept = accept;
		return this.setProperty('accept', accept);
	}
});
Form.File = FormFile;

/**
 * FormHidden Class
 */
var FormHidden = new Class({
	
	Extends	: Form.SimpleInput,
	
	/**
	 * Constructor
	 */
	initialize: function( name, options ) {
		this.parent('input', 'hidden', name, options);
		this.setContext('Form.Hidden');
	}
});
Form.Hidden = FormHidden;

/**
 * FormSubmit Class
 */
var FormSubmit = new Class({
	
	Extends	: Form.SimpleInput,
	
	/**
	 * Constructor
	 */
	initialize: function( name, options ) {
		this.parent('input', 'submit', name, options);
		this.setContext('Form.Submit');
	}
});
Form.Submit = FormSubmit;

/**
 * FormReset Class
 */
var FormReset = new Class({
	
	Extends	: Form.SimpleInput,
	
	/**
	 * Constructor
	 */
	initialize: function( name, options ) {
		this.parent('input', 'reset', name, options);
		this.setContext('Form.Reset');
	}
});
Form.Reset = FormReset;

/**
 * FormImage Class
 */
var FormImage = new Class({
	
	Extends	: Form.SimpleInput,
	alt		: null,
	src		: null,
	
	/**
	 * Constructor
	 */
	initialize: function( name, src, options ) {
		this.parent('input', 'image', name, options);
		this.setContext('Form.Image');
		this.setSrc(src);
	},
	
	setAlt: function( alt ) {
		if( $type(alt) != 'string' ) 
			throw TypeError("'alt' must be a string");
		
		this.alt = alt;
		return this.setProperty('alt', alt);
	},
	
	setSrc: function( src ) {
		if( $type(src) != 'string' ) 
			throw TypeError("'src' must be a string");
		
		this.src = src;
		return this.setProperty('src', src);
	}
});
Form.Image = FormImage;

/**
 * FormTextarea Class
 */
var FormTextarea = new Class({
	
	Extends	: Form.SimpleInput,
	cols	: null, 
	rows	: null,
	readonly: null,
	
	
	/**
	 * Constructor
	 */
	initialize: function( name, cols, rows, options ) {
		this.parent('textarea', null, name, options);
		this.setContext('Form.Textarea');
		this.setCols(cols);
		this.setRows(rows);
	},
	
	setCols: function( cols ) {
		if( $type(cols) != 'number' ) 
			throw TypeError("'cols' must be a number");
		
		this.cols = cols;
		return this.setProperty('cols', cols);
	},
	
	setRows: function( rows ) {
		if( $type(rows) != 'number' ) 
			throw TypeError("'rows' must be a number");
		
		this.rows = rows;
		return this.setProperty('rows', rows);
	},
	
	setSize: function( size ) {
		if( !(size instanceof Object) ) 
			throw TypeError("'size' must be an Object with cols and rows properties");
		
		this.setCols(size.cols);
		this.setRows(size.rows);
		return this;
	},
	
	setType: function( type ) {
		return this;
	},
	
	setReadonly: function( readonly ) {
		if( $type(readonly) != 'boolean' ) 
			throw TypeError("'readonly' must be a boolean");
		
		this.readonly = readonly;
		return this.setProperty('readonly', readonly);
	}
});
Form.Textarea = FormTextarea;

/**
 * FormSelect Class
 */
var FormSelect = new Class({
	
	Extends	: Form.CompositeInput,
	multiple: null,
	
	/**
	 * Constructor
	 */
	initialize: function( name, options ) {
		this.parent('select', name, options);
		this.setContext('Form.Select');
	},
	
	setMultiple: function( multiple ) {
		if( $type(multiple) != 'boolean' ) 
			throw TypeError("'multiple' must be a boolean");
		
		this.multiple = multiple;
		return this.setProperty('multiple', multiple);
	},
	
	addElememet: function( option, where ) {
		if( !(option instanceof Form.Select.Option) )
			throw TypeError("'option' must be an instance of Form.Select.Option");
		
		this.parent(option, where);
		return this;
	},
	
	wrapElement: function( option, where ) {
		if( !(option instanceof Form.Select.Option) )
			throw TypeError("'option' must be an instance of Form.Select.Option");
		
		return this.parent(option, where);
	},
	
	replaceElement: function( oldOption, newOption ) {
		if( !(oldOption instanceof Form.Select.Option) )
			throw TypeError("'oldOption' must be an instance of Form.Select.Option");
		if( !(newOption instanceof Form.Select.Option) )
			throw TypeError("'newOption' must be an instance of Form.Select.Option");
		
		return this.parent(oldOption, newOption);
	}
});
Form.Select = FormSelect;

/**
 * FormSelectOption
 */
var FormSelectOption = new Class({
	
	Extends	: TextElementContext,
	value	: null,
	disabled: null,
	selected: null,
	
	initialize: function( options ) {
		this.parent('option', options);
		this.setContext('Form.Select.Option');
	},
	
	setValue: function( value ) {
		if( !['string', false].contains($type(value)) ) 
			throw TypeError("'value' must be a string");
		
		this.value = value;
		return this.setProperty('value', value);
	},
	
	setDisabled: function( disabled ) {
		if( $type(disabled) != 'boolean' ) 
			throw TypeError("'disabled' must be a boolean");
		
		this.disabled = disabled;
		return this.setProperty('disabled', disabled);
	},
	
	setSelected: function( selected ) {
		if( $type(selected) != 'boolean' ) 
			throw TypeError("'selected' must be a boolean");
		
		this.selected = selected;
		return this.setProperty('selected', selected);
	}
});
Form.Select.Option = FormSelectOption;

/**
 * FormLabel Class
 */
var FormLabel = new Class({
	
	Extends	: TextElementContext,
	value	: null,
	disabled: null,
	selected: null,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('label', options);
		this.setContext('Form.Label');
	},
	
	setValue: function( value ) {
		if( !['string', false].contains($type(value)) ) 
			throw TypeError("'value' must be a string");
		
		this.value = value;
		return this.setProperty('value', value);
	},
	
	setDisabled: function( disabled ) {
		if( $type(disabled) != 'boolean' ) 
			throw TypeError("'disabled' must be a boolean");
		
		this.disabled = disabled;
		return this.setProperty('disabled', disabled);
	},
	
	setSelected: function( selected ) {
		if( $type(selected) != 'boolean' ) 
			throw TypeError("'selected' must be a boolean");
		
		this.disabled = selected;
		return this.setProperty('selected', selected);
	}
});
Form.Label = FormLabel;

/**
 * Container Class
 */
var Container = new Class({
	
	Extends	: Div, 
	clear	: null,
	
	/**
	 * Constructor
	 */
	initialize: function(options) {
		this.parent(options);
		this.setContext('Container');
		this.clear = new Clear();
	},
	
	addElement: function( element, where ) {
		this.parent(element, where);
		this.parent(this.clear, 'bottom');
		return this;
	},
	
	wrapElement: function( element, where ) {
		this.parent(element, where);
		this.parent(this.clear, 'bottom');
		return this;
	}
});

var Section = new Class({
	
	Extends	: ComplexElementContext, 
	header	: null, 
	content	: null, 
	footer	: null, 
	
	initialize: function(options) {
		this.parent('div', options);
		this.setContext('Section');
		
		this.header = new Div();
		this.content = new Container();
		this.footer = new Div();
		
		this.addElement(this.content);
	},
	
	setHeader: function( item ) {
		if( !this.hasElement(this.header) )
			this.addElement(this.header, 'top');
		
		this.header.disposeElements();
		this.header.addElement(item);
		
		return this;
	},
	
	showHeader: function() {
		this.header.show();
		return this;
	},
	
	hideHeader: function() {
		this.header.hide();
		return this;
	},
	
	setFooter: function( item ) {
		if( !this.hasElement(this.footer) )
			this.addElement(this.footer, 'bottom');
		
		this.footer.clearElements();
		this.footer.addElement(item);
		
		return this;
	},
	
	showFooter: function() {
		this.header.show();
		return this;
	},
	
	hideFooter: function() {
		this.header.hide();
		return this;
	},
	
	addContent: function( item ) {
		this.content.addElement(item);
		return this;
	},
	
	addContents: function( items ) {
		this.content.addElements(items);
		return this;
	},
	
	removeContent: function( item ) {
		this.content.removeElement(item);
		return this;
	},
	
	removeContents: function( items ) {
		this.content.removeElements(items);
		return this;
	},
	
	clearContents: function() {
		this.content.clearElements();
		return this;
	},
	
	replaceContent: function( oldContent, newContent ) {
		this.content.replaceElement(oldContent, newContent);
		return this;
	},
	
	replaceContents: function( items ) {
		this.clearContents();
		this.addContents(items);
		return this;
	},
	
	disposeContents: function() {
		this.content.disposeElements();
		return this;
	}
});

var Sections = new Class({
	
	Extends		: ComplexElementContext, 
	headers		: null, 
	contents	: null,
	accordion	: null,
	sections	: null,
	prototypes	: null,
	dispatch	: new Dispatch(),
	
	initialize: function( prototypes, options ) {
		this.parent('div', options);
		this.setContext('Sections');
		
		this.prototypes = prototypes;
		this.headers = new Array();
		this.contents = new Array();
		this.sections = new ContextOrganizer(this);
	},
	
	addSection: function( name, item ) {
		return this.sections.addLine(name, item);
	},
	
	addSections: function( items ) {
		return this.sections.addLines(items);
	},
	
	removeSection: function( name ) {
		return this.sections.removeLine(name);
	},
	
	removeSections: function( names ) {
		if( $type(names) == 'object' ) names = $H(names).getKeys();
		return this.sections.removeLines(names);
	},
	
	newLine: function( name, item ) {
		var section = new Section();
		section.setHeader( $defined(item['NAME']) ? new Text(item['NAME']) : new Text(name) );
		
		this.headers.include( $(section.header) );
		this.contents.include( $(section.content) );
		
		$each(this.prototypes, function(prototype) {
			var args = new Array();
			if( prototype.args ) {
				prototype.args.each( function(arg) {
					args.extend( [item[arg.toUpperCase()]] );
				});
			} else {
				args = item;
			}
			var content = prototype.func.run(args);
			if( $type(content) == 'array' )
				section.addContents( content );
			else 
				section.addContent( content );	 
		});
		
		return section;
	},
	
	source: function( source, inquiry, loaders ) {
		new Webics.Request( source, inquiry, loaders, [this.addSections, this.accordionable] );			
		return this;
	},
	
	accordionable: function( options ) {
		this.accordion = new Accordion(this.headers, this.contents, {display:-1, alwaysHide:true});
		return this;
	}
});

var ListManager = new Class({
	
	Extends	: Sections,
	toggler	: null,
	togglers: null,
	
	initialize: function( prototypes, toggler, options ) {
		this.parent(prototypes, options);
		
		this.toggler = toggler;
		this.togglers = new Hash();
	},
	
	disable: function( name ) {
		if( $type(name) == 'object' ) 
			name = $H(name).getKeys()[0];
		
		if( this.sections.hasLine(name) )
			this.sections.getLine(name).replaceClass('enabled','disabled');
		
		if( this.togglers.has(name) )
			this.togglers.get(name).changeState(0);
		return this;
	},
	
	enable: function( name ) {
		if( $type(name) == 'object' ) 
			name = $H(name).getKeys()[0];
		
		if( this.sections.hasLine(name) )
			this.sections.getLine(name).replaceClass('disabled','enabled');
		
		if( this.togglers.has(name) )
			this.togglers.get(name).changeState(1);
		return this;
	},
	
	newLine: function( name, item ) {
		var section = this.parent(name, item);
		var args = new Array();
		
		if( this.toggler.args ) {
			this.toggler.args.each( function(arg) {
				args.extend( [item[arg.toUpperCase()]] );
			});
		}
		
		var toggler = this.toggler.func.run(args);
		section.setHeader(toggler);
		this.togglers.set(name,toggler);
		
		if( item['ISVALID'] ) {
			this.enable(name);
			section.replaceClass('disabled','enabled');
		} else {
			this.disable(name);
			section.replaceClass('enabled','disabled');
		}
		return section;
	}
});

var Navigation = new Class({
	
	Extends		: Sections,
	
	initialize: function( options ) {
		this.parent(null, options);
		this.setContext('Navigation');
	},
	
	newLine: function( name, item ) {
		var section = new Section();
		section.setHeader( new Span().setText(name) );
		
		this.headers.include( $(section.header) );
		this.contents.include( $(section.content) );
		
		section.addEvent('click', item.action);
		
		if( $defined(item.submenu) ) {
			$each(item.submenu, function(action, name) {
				var submenu = new Div();
				submenu.addElement( new Span().setText(name) );
				$each(action, function( callback, event) {
					submenu.addEvent(event, callback);
				});
				section.addContent(submenu);
			});
		}
		
		return section;
	},
	
	accordionable: function( options ) {
		this.accordion = new Accordion(this.headers, this.contents, {display:-1, alwaysHide:true, trigger:'click'});
		return this;
	}
});

var Menu = new Class({
	
	Extends		: Sections,
	
	initialize: function( options ) {
		this.parent(null, options);
		this.setContext('Menu');
	},
	
	newLine: function( name, item ) {
		var section = new Section();
		section.setHeader( new Text(name) );
		
		this.headers.include( $(section.header) );
		this.contents.include( $(section.content) );
		
		var submenus = new Array();
		$each(item, function(href, name) {
			var submenu = new Div().addElement(new A(href).setText(name));
			submenus.include(submenu);
		});
		section.addContents( submenus );
		
		return section;
	},
	
	accordionable: function( options ) {
		this.accordion = new Accordion(this.headers, this.contents, {display:-1, alwaysHide:true, trigger:'click'});
		return this;
	}
});

var Window = new Class({
	
	Extends	: Section, 
	closer	: null, 
	mask	: null,
	
	initialize: function(options) {
		this.parent(options);
		this.setContext('Window');
		
		this.mask = new Mask('content');
		this.closer = new Button(this.hide);
		
		this.hide();
		$(document.body).insert(this);
	},
	
	setHeader: function( text ) {
		this.parent( new Span().setText(text) );	
		return this;
	},
	
	showClose: function( text, image ) {
		if( this.hasElement(this.closer) )
			return this;
		
		this.addElement(this.closer);
		
		if( $defined(image) ) {
			this.closer.addElement( new Image(text, image) );
		} else {
			this.closer.addElement( new Text(image) );
		}
	},
	
	show: function() {
		this.mask.show();
		return this.fade('in');
	},
	
	hide: function() {
		this.mask.hide();
		return this.fade('out');
	},
	
	close: function() {
		this.mask.destroy();
		this.element.set('tween', {
			onComplete: function() { 
				this.dispose();
			}.bind(this)
		}).fade('out');
		return this;
	},
	
	autoclose: function( delay ) {
		return this.close.delay(delay);
	},
	
	center: function( anchor ) {
		return this.position({relativeTo: anchor, position: 'center'} );
	}, 
	
	drag: function() {
		this.draggable(this.header);
	}
});

var Banner = new Class({
	
	Extends	: Section, 
	closer	: null, 
	
	initialize: function(options) {
		this.parent(options);
		this.setContext('Banner');
		
		this.closer = new Button(this.nix.pass(true));
		
		this.hide();
		$(document.body).insert(this);
	},
	
	setHeader: function( text ) {
		this.parent( new Span().setText(text) );	
		return this;
	},
	
	showClose: function( text, image ) {
		if( this.hasElement(this.closer) )
			return this;
		
		this.addElement(this.closer);
		
		if( $defined(image) ) {
			this.closer.addElement( new Image(text, image) );
		} else {
			this.closer.addElement( new Text(image) );
		}
	}
});

/*
 * Request
 */
var Webics = new Class({});

var WebicsQueue = new Class({
	
	Extends	: Request.Queue,
	
	dispatch: function( request ) {
		var random = $randomLetters(10);
		this.addRequest('request-'+random, request);
		request.send();
	}
});
Webics.Queue = WebicsQueue;

var WebicsRequest = new Class({
	
	Extends	: Request.JSON,
	
	initialize: function( source, inquiry, loaders, callback, message, showSpinner ) {		
		if( $type(source) != 'string' ) 
			throw TypeError("'source' must be a string");
		
		if( $type(inquiry) != 'string' ) 
			throw TypeError("'inquiry' must be a string");
		
		if( ($type(loaders) != false ) && ($type(loaders) != 'object') ) 
			throw TypeError("'loaders' must be an Object of properties");
		
		if( ($type(callback) != false ) && ($type(callback) != 'array') ) 
			throw TypeError("'callback' must be an Object of properties");

		if( ($type(message) != false ) && ($type(message) != 'string') ) 
			throw TypeError("'message' must be a string");
		
		if( $defined(showSpinner) ) {
			var spinner = new Spinner(showSpinner, {message:'Loading ...'});
			spinner.show();
		}
		
		this.parent({
			url			: source,
			data		: {request: inquiry, arguments: loaders, 'return': 'JSON'},
			onSuccess 	: function(response) {
				processResponse(response, callback, message, inquiry);
				if( $defined(spinner) ) spinner.destroy();
			}
		});
				
		//new Webics.Queue({autoAdvance:true}).dispatch(this);
		this.post();
	}
});
Webics.Request = WebicsRequest;

/*
 * Inquiry
 */

/**
 * Inquiry Class
 */
var Inquiry = new Class({
	
	Extends		: Form,
	spin		: null,
	clear		: null,
	caption		: null,
	inputs		: null,
	inquiry		: null,
	buttons		: null,
	organizer	: null,
	message 	: null, 
	callback 	: null,
	dispatch	: new Dispatch(),
	
	/**
	 * Constructor
	 */
	initialize: function( action, organizer, options ) {
		this.parent(action, options);
		this.setContext('Inquiry');
		
		this.inputs = new Hash();
		this.buttons = new Hash();
		this.clear = new Clear();
		this.caption = new Caption();
		this.organizer = organizer ? organizer : new Organizer.Tabulation();
		this.addElement(this.organizer);
	},
	
	setCaption: function( caption ) {
		if( !this.hasElement(this.caption) )
			this.addElement(this.caption, 'top');

		this.caption.setText(caption);
	},
	
	addElement: function( element, where ) {
		this.parent(element, where);
		this.parent(this.clear, 'bottom');
		return this;
	},
	
	wrapElement: function( element, where ) {
		this.parent(element, where);
		this.parent(this.clear, 'bottom');
		return this;
	},
	
	setInquiry: function( inquiry ) {
		this.inquiry = inquiry;
		return this;
	},
	
	setMessage: function( message ) {
		this.message = message;
		return this;
	},
	
	/**
	 * Get Inputs
	 */
	getInput: function( name ) {
		if( $type(name) != 'string' ) 
			throw TypeError("'name' must be a string");
		
		return this.inputs.get(name);
	},
	
	
	getInputs: function() {
		inputs = {};
		this.inputs.each( function(input) {
			inputs[input.name] = input.value;
		});
		return inputs;
	},
	
	/**
	 * Add Inputs
	 */
	addInput: function( input ) {
		if( !(input instanceof Form.SimpleInput) && !(input instanceof Form.CompositeInput) ) 
			throw TypeError("'input' must be an instance of Form.SimpleInput or Form.CompositeInput");
		
		if( input instanceof Form.Hidden ) {
			this.addElement(input, 'top');
		} else {
			this.organizer.addLine(input.name, this.newLine(input));
		}
		
		this.inputs.set(input.name, input);
		return this;
	},
	
	addInputs: function( inputs ) {
		if( !(inputs instanceof Array) ) 
			throw TypeError("'inputs' must be an Array of Form.SimpleInput or Form.CompositeInput instances");
		
		$each(inputs, function(input) { this.addInput(input); }, this);
		return this;
	},
	
	/**
	 * Remove Inputs
	 */
	removeInput: function( input ) {
		if( !(input instanceof Form.SimpleInput) && !(input instanceof Form.CompositeInput) ) 
			throw TypeError("'input' must be an instance of Form.SimpleInput or Form.CompositeInput");
		
		if( input instanceof Form.Hidden ) {
			this.removeElement(input);
		} else {
			this.organizer.removeLine(input.name);
		}
		
		this.inputs.erase(input.name);
		return this;
	},
	
	removeInputs: function( inputs ) {
		if( !(inputs instanceof Array) ) 
			throw TypeError("'inputs' must be an Array of Form.SimpleInput or Form.CompositeInput instances");
		
		$each(inputs, function(input) { this.removeInput(input); }, this);
		return this;
	},
	
	/**
	 * Clear Inputs
	 */
	clearInputs: function() {
		this.organizer.clearLines();
		this.inputs.empty();
		return this;
	},	
	
	resetInputs: function() {
		this.inputs.each( function(input) {
			log("RESETTING"+input.name);
			input.reset();
		});
	},
	
	/**
	 * Replace Input
	 */
	replaceInput: function( oldInput, newInput ) {
		if( oldInput instanceof Form.Hidden && newInput instanceof Form.Hidden ) {
			this.replaceElement( oldInput, newInput );
		} else {
			this.organizer.replaceLine(oldInput.name, newInput.name, this.newLine(newInput));
		}
		
		this.inputs.erase(oldInput.name);
		this.inputs.set(newInput.name, newInput);
		return this;
	},
	
	/**
	 * Refresh Inputs
	 */
	refreshInput: function( input ) {
		return this.replaceInput(input,input);
	},
	
	refreshInputs: function() {
		this.inputs.each( function(input) { this.refreshInput(input); }, this);
		return this;
	},
	
	newLine: function( input ) {
		if( !(input instanceof Form.SimpleInput) && !(input instanceof Form.CompositeInput) ) 
			throw TypeError("'input' must be an instance of Form.SimpleInput or Form.CompositeInput");
		
		var line = new Array();
		
		if( input.label ) {
			line.include(input.label);
		}
		if( input ) {
			line.include(input);
		}
		if( input.info ) {
			line.include(input.info);
		}
		if( input.validate ) {
			line.include(input.validate);
		}
		return line;
	},
	
	setValues: function(data) {
		this.inputs.each( function(input, field) {
			input.setValue(data[field.toUpperCase()]);
		});
		return this;
	},
	
	source: function( source, inquiry, loaders ) {
		new Webics.Request( source, inquiry, loaders, [this.setValues] );
		return this;
	},
	
	refresh: function() {
		log('refreshing');
	},
	
	asynchronous: function( inquiry, message, refresh ) {
		this.setInquiry(inquiry);
		this.setMessage(message);
		if( refresh ) {
			this.callback = this.setValues;
		} else {
			this.callback = null;
		}
		this.parent();
	},
	
	showSubmit: function( text, image ) {
		var submit;
		
		if( image ) {
			submit = new Form.Image('submit', image);
			submit.setAlt(text);
		} else {
			submit = new Form.Submit('submit');
			submit.setValue(text);
		}
		
		if( this.buttons.has(submit.name) ) {
			this.replaceElement(this.buttons.get(submit.name), submit);
		} else {
			this.addElement(submit, 'bottom');
		}
		
		this.buttons.set(submit.name, submit);
		return this;
	},
	
	showReset: function( text ) {
		var reset = new Form.Reset('reset');
		reset.setValue(text);
		
		if( this.buttons.has(reset.name) ) {
			this.replaceElement(this.buttons.get(reset.name), reset);
		} else {
			this.addElement(reset, 'bottom');
		}
		
		this.buttons.set(reset.name, reset);
		return this;
	},
	
	showSpinner: function ( element ) {
		this.spin = element;
	},
	
	send: function() {
		new Webics.Request( this.action, this.inquiry, this.getInputs(), [this.callback], this.message, this.spin );
		return this;
	}
});

var FormSimpleInput = Class.refactor(Form.SimpleInput, {
	
	unique	: null,
	label 	: null,
	
	initialize: function( tag, type, name, options ) {
		this.previous(tag, type, name, options);
		
		this.unique = name+"-"+$random(0, 999);
		this.label = new Form.Label();
		
		this.addEvent('change', function() {
			this.value = this.getProperty('value');
		}.bind(this));
	},
	
	setValue: function( value ) {
		this.previous(value);
		this.fireEvent('change');
		return this;
	},
	
	setLabel: function( label ) {
		this.label.setText(label);
		return this;
	},
	
	reset: function() {
		this.setValue();
	}
});
Form.SimpleInput = FormSimpleInput;

var FormCompositeInput = Class.refactor(Form.CompositeInput, {
	
	unique	: null,
	label	: null, 
	
	initialize: function( tag, name, options ) {
		this.previous(tag, name, options);
		
		this.unique = name+"-"+$random(0, 999);
		this.label = new Form.Label();
		
		this.addEvent('change', function() {
			this.value = this.getProperty('value');
		}.bind(this));
	},
	
	setValue: function( value ) {
		this.previous(value);
		this.fireEvent('change');
		return this;
	},
	
	setLabel: function( label ) {
		this.label.setText(label);
		return this;
	},
	
	reset: function() {
		this.setValue();
	}
});
Form.CompositeInput = FormCompositeInput;

/**
 * InquirySelect Class
 */
var InquirySelect = new Class({
	
	Extends		: Form.Select,
	display		: null,
	options		: null,
	dispatch	: new Dispatch(),
	
	initialize: function( name, options ) {
		this.parent(name, options);
		this.setContext('Inquiry.Select');
		this.options = new ContextOrganizer(this);
	},
	
//	setDisplay: function( display ) {
//		this.display = display;
//		return this.setProperty('display', display);
//	},
	
	addOption: function( name, item ) {
		return this.options.addLine(name, item);
	},
	
	addOptions: function( items ) {
		return this.options.addLines(items);
	},
	
	removeOption: function( name ) {
		return this.options.removeLine(name);
	},
	
	removeOptions: function( names ) {
		return this.options.removeLines(names);
	},
	
	clearOptions: function() {
		return this.options.clearLines();
	},	
	
	replaceOption: function( name, item ) {
		return this.options.replaceLine(name, item);
	},
	
	setValue: function( option ) {
		if( this.options.hasLine(option) ) {
			this.options.getLine(option).setSelected(true);
			this.fireEvent('change');
		}
		return this;
	},
	
	setOptions: function( items ) {
		this.clearOptions();
		this.addOptions(items);
		return this;
	},
	
	newLine: function( name, item ) {
		var option = new Form.Select.Option();
		//var display = this.display ? this.display : this.name;
		option.setValue(name);
		option.addText(item);
		//if( $chk(item['ISVALID']) ) option.setDisabled(!item['ISVALID']);
		return option;
	},
	
	source: function( source, inquiry, loaders ) {
		this.clearOptions();
		this.addOption('loading', 'Loading ...');
		new Webics.Request( source, inquiry, loaders, [this.setOptions] );
		return this;
	},
	
	reset: function() {
		this.elements.each( function(option){
			option.setSelected(false);
		});
		this.fireEvent('change');
		return this;
	}
});
Inquiry.Select = InquirySelect;

var InquiryBuilder = new Class({
	
	initiatize: function() {
	
	},

	build: function( service ) {
		var form = new Inquiry(WS_ENDPOINT, new Organizer.Planner());
		new Webics.Request(WS_ENDPOINT, 'definition', {service: service}, [
		   function( parameters ) {
				$H(parameters).each( function(signature, parameter) {
					switch(signature.type) {
					case 'String':
						if( signature.length <= 128 ) 
							form.addInput( new Form.Textfield(parameter).setMaxLength(signature.length).setLabel(parameter) );
						else 
							form.addInput( new Form.Textarea(parameter, 20, 20).setLabel(parameter) );
					default:
						if( signature.isEntity )
							form.addInput( new Inquiry.Select(parameter).source(WS_ENDPOINT, 'load').setLabel(parameter) );
						else 
							form.addInput( new Form.Textfield(parameter).setMaxLength(signature.length).setLabel(parameter) );
					}
					
				});
		   }
		]);
		return form;
	}
});

var Caption = new Class({
	
	Extends	: TextElementContext,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('div', options);
		this.setContext('Caption');
	}
});

var Toggler = new Class({
	
	Extends		: Inquiry, 
	state0		: null,
	state1		: null,
	current		: null,
	
	initialize: function( action, state0, state1, organizer, options ) {
		this.parent(action, state0.inquiry, organizer, options);
		this.setContext('Toggler');
		this.state0 = state0;
		this.state1 = state1;
		this.current = 1;
	},
	
	changeState: function( state ) {
		switch(state) {
		case 0:
			this.setInquiry(this.state0.inquiry);
			if( this.state0.submit ) 
				this.showSubmit(this.state0.submit.text, this.state0.submit.image);
			break;
		case 1:
			this.setInquiry(this.state1.inquiry);
			if( this.state1.submit ) 
				this.showSubmit(this.state1.submit.text, this.state1.submit.image);
			break;
		}
		return this;
	}
});

/*
 * DynamicInquiry
 */

var DynamicInquiry = new Class({
	
	Extends			: Inquiry,
	registers		: null,
	followers		: null,
	currentRegister	: null,
	
	initialize: function( action, inquiry, organizer, options ) {
		this.parent(action, inquiry, organizer, options);
		this.setContext('DynamicInquiry');
		this.registers = new Hash();
		this.followers = new Hash();
		this.currentRegister = new Hash();
	},
	
	updateFollowers: function( leaderInput ) {
		if( !(leaderInput instanceof Form.SimpleInput) && !(leaderInput instanceof Form.CompositeInput) )
			throw TypeError("'leaderInput' must be an instance of Form.SimpleInput or Form.CompositeInput");
		
		var followers = this.followers.get(leaderInput.unique);
		followers.each( function( follower ) {
			follower.run(leaderInput.value);
		});
		return this;
	},
	
	followInput: function( leaderInput, callback ) {
		if( !(leaderInput instanceof Form.SimpleInput) && !(leaderInput instanceof Form.CompositeInput) )
			throw TypeError("'leaderIput' must be an instance of Form.SimpleInput or Form.CompositeInput");
	
		if( !this.followers.has(leaderInput.unique) ) {
			leaderInput.addEvent('change', function() {
				this.updateFollowers(leaderInput);
			}.bind(this));
			
			this.followers.set(leaderInput.unique, new Array());
		};
		
		this.followers.get(leaderInput.unique).include(callback);
		return this;
	},
	
	updateRegisters: function( leaderInput ) {
		if( !(leaderInput instanceof Form.SimpleInput) && !(leaderInput instanceof Form.CompositeInput) )
			throw TypeError("'leaderInput' must be an instance of Form.SimpleInput or Form.CompositeInput");
		
		var oldInput = this.currentRegister.get(leaderInput.unique);
		var newInput = this.registers.get(leaderInput.unique).get(leaderInput.value);
		
		if( $defined(newInput) ) {
			this.hasElement(oldInput) ? this.replaceInput(oldInput, newInput) : this.addInput(newInput);
		} else {
			this.hasElement(oldInput) ? this.removeInput(oldInput) : null;
		}
		this.currentRegister.set(leaderInput.unique, newInput);
		return this;
	},
	
	registerInput: function( leaderInput, value, input ) {
		if( !(leaderInput instanceof Form.SimpleInput) && !(leaderInput instanceof Form.CompositeInput) )
			throw TypeError("'leaderIput' must be an instance of Form.SimpleInput or Form.CompositeInput");
		if( !(input instanceof Form.SimpleInput) && !(input instanceof Form.CompositeInput) )
			throw TypeError("'input' must be an instance of Form.SimpleInput or Form.CompositeInput");
		log(value);
		if( !this.registers.has(leaderInput.unique) ) {
			leaderInput.addEvent('change', function() {
				this.updateRegisters(leaderInput);
			}.bind(this));
			
			this.currentRegister.set(leaderInput.unique, input);
			this.registers.set(leaderInput.unique, new Hash());
		};
		
		this.registers.get(leaderInput.unique).set(value, input);
		return this;
	}
	
});

/*
 * Tabulation
 */

var Tabulation = new Class({
	
	Extends		: Table,
	prototypes	: null,
	filters		: null,
	thead		: null, 
	tbody		: null,
	tfoot		: null,
	dispatch	: new Dispatch(),
	select_callback	: null,
	
	initialize: function( options ) {
		this.parent(options);
		this.setContext('Tabulation');
		this.thead = new Tabulation.Thead();
		this.tbody = new Tabulation.Tbody();
		this.tfoot = new Tabulation.Tfoot();
		this.prototypes = new Hash();
		this.filters = new Array();
	},
	
	setHeader: function( items ) {
		if( !this.hasElement(this.thead) )
			this.addElement(this.thead, 'top');
		
		if( this.thead.isEmpty() ) 
			this.thead.addRow('head', items);
		else 
			this.thead.replaceRow('head', 'head', items);
		
		return this;
	},
	
	showHeader: function() {
		this.thead.show();
		return this;
	},
	
	hideHeader: function() {
		this.thead.hide();
		return this;
	},
	
	setFooter: function( items ) {
		if( !this.hasElement(this.tfoot) ) 
			this.addElement(this.tfoot, 'top');
		
		if( this.tfoot.isEmpty() )
			this.tfoot.addRow('foot', items);
		else 
			this.tfoot.replaceRow('foot', 'foot', items);
		
		return this;
	},
	
	showFooter: function() {
		this.tfoot.show();
		return this;
	},
	
	hideFooter: function() {
		this.tfoot.hide();
		return this;
	},
	
	addRow: function( name, items ) {
		if( !this.hasElement(this.tbody) ) 
			this.addElement(this.tbody, 'bottom');
		
		var row = this.tbody.addRow(name, this.map(items, name));
		if( $type(this.select_callback) == 'function' ) {
			row.addEvent('click', this.select_callback.pass(key) );
		}
		this.striped();
		return this;
	},
	
	addRows: function( items ) {
		if( !this.hasElement(this.tbody) ) 
			this.addElement(this.tbody, 'bottom');
	
		if( $type(items) == 'object' ) items = $H(items);
		
		var rows = this.tbody.addRows( items.map(this.map, this) );
		
		if( $type(this.select_callback) == 'function' ) {
			select_callback = this.select_callback;
			$each(rows, function(row, key) {
				row.addEvent('click', select_callback.pass(items[key]));
			});
		}
		this.striped();
		return this;
	},
	
	removeRow: function( name ) {
		this.tbody.removeRow(name);
		this.striped();
		
		if( this.tbody.isEmpty() )
			this.removeElement(this.tbody);
		
		return this;
	},
	
	removeRows: function( names ) {
		if( $type(names) == 'object' ) names = $H(names).getKeys();
		
		this.tbody.removeRows(names);
		this.striped();
		
		if( this.tbody.isEmpty() )
			this.removeElement(this.tbody);
		
		return this;
	},
	
	clearRows: function() {
		if( this.hasElement(this.tbody) ) 
			this.removeElement(this.tbody);
		
		this.tbody.clearRows();
		
		return this;
	},
	
	replaceRow: function( oldName, newName, items ) {
		this.tbody.replaceRow(oldName, newName, this.map(items, newName));
		this.striped();
		return this;
	},
	
	replaceRows: function( items ) {
		this.clearRows();
		this.addRows(items);
		return this;
	},
	
	setFilter: function( filters ) {
		this.removeFilter();
		this.filters.combine(filters);
		return this;
	},
	
	removeFilter: function() {
		this.filters.empty();
	},
	
	registerPrototype: function( name, prototype ) {
		this.prototypes.set(name, prototype);
		return this;
	},
	
	unregisterPrototype: function( name, prototype ) {
		this.prototypes.erase(name);
		return this;
	},
	
	source: function( source, inquiry, loaders ) {
		new Webics.Request( source, inquiry, loaders, [this.addRows] );
		return this;
	},
	
	selectable: function( callback ) {
		this.select_callback = callback;
		return this;
	},
	
	refresh: function() {
		log('refreshing');
	},
	
	map: function( item, key ) {
		var row = new Hash();
		
		if( $type(item) == 'array' ) {
			return item;
		}
		
		if( this.filters ) {
			this.filters.each( function(filter) {
				row.set( filter, new Text(item[filter.toUpperCase()]) );
			}, this);
		}
		
		if( this.prototypes ) {
			this.prototypes.each( function(prototype, name) {
				var args = new Array();
				if( prototype.args ) {
					prototype.args.each( function(arg) {
						args.extend( [item[arg.toUpperCase()]] );
					});
				}
				row.set( name, prototype.func.run(args) );	
			});
		}
		return row.getValues();
	},
	
	striped: function() {
		this.tbody.striped();
		return this;
	}
});

/**
 * TabulationSection Class
 */
var TabulationSection = new Class({
	
	Extends			: Table.Section,
	rows			: null,
	
	initialize: function( tag, options ) {
		this.parent(tag, options);
		this.setContext('Tabulation.Section');
		this.rows = new ContextOrganizer(this);
	},
	
	getItems: function( name ) {
		return this.rows.getItems(name);
	},
	
	getRow: function( name ) {
		return this.rows.getLine(name);
	},
	
	addRow: function( name, item ) {
		return this.rows.addLine(name, item);
	},
	
	addRows: function( items ) {
		return this.rows.addLines(items);
	},
	
	removeRow: function( name ) {
		return this.rows.removeLine(name);
	},
	
	removeRows: function( names ) {
		return this.rows.removeLines(names);
	},
	
	clearRows: function() {
		return this.rows.clearLines();
	},
	
	replaceRow: function( oldName, newName, item ) {
		return this.rows.replaceLine(oldName, newName, item);
	},
	
	replaceRows: function( items ) {
		return this.rows.replaceLines(items);
	},
	
	hasRow: function( name ) {
		return this.rows.hasLine(name);
	},
	
	striped: function() {
		this.findElements('tr:even').each( function(td) {
			td.swapClass('odd', 'even');
		});
		this.findElements('tr:odd').each( function(td) {
			td.swapClass('even', 'odd');
		});
		return this;
	},
	
	newLine: function( key, items ) {
		var row = new Table.Tr();
		var cell = null;
		$each(items, function(item) {
			item = ['string', 'number'].contains($type(item)) ? new Text(item) : item;
			cell = new Table.Td();
			cell.addElement(item);
			row.addElement(cell);
		});

		return row;
	}
});
Tabulation.Section = TabulationSection;

/**
 * TabulationThead Class
 */
var TabulationThead = new Class({
	
	Extends	: Tabulation.Section,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('thead', options);
		this.setContext('Tabulation.Thead');
	},
	
	newLine: function( key, items ) {
		var row = new Table.Tr();
		var cell = null;
		$each(items, function(item) {
			item = ['string', 'number'].contains($type(item)) ? new Text(item) : item;
			cell = new Table.Th();
			cell.addElement(item);
			row.addElement(cell);
		});
		return row;
	}
});
Tabulation.Thead = TabulationThead;

/**
 * TabulationTbody Class
 */
var TabulationTbody = new Class({
	
	Extends	: Tabulation.Section,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('tbody', options);
		this.setContext('Tabulation.Tbody');
	}
});
Tabulation.Tbody = TabulationTbody;

/**
 * TabulationTfoot Class
 */
var TabulationTfoot = new Class({
	
	Extends	: Tabulation.Section,
	
	/**
	 * Constructor
	 */
	initialize: function( options ) {
		this.parent('tfoot', options);
		this.setContext('Tabulation.Tfoot');
	}
}); 
Tabulation.Tfoot = TabulationTfoot;


/*
 * Roster
 */

var Roster = new Class({
	
	Extends		: Table,
	prototypes	: null,
	names		: null,
	tbody		: null,
	dispatch	: new Dispatch(),
	
	initialize: function( names, options ) {
		this.parent(options);
		this.setContext('Roster');
		this.tbody = new Tabulation.Tbody();
		this.names = names;
		this.prototypes = new Hash();
	},
	
	setHeader: function( items ) {
		if( !this.hasElement(this.tbody) )
			this.addElement(this.tbody, 'bottom');
		
		var headers = items.associate(this.names);
		
		$each(headers, function(header, name) {
			if( this.tbody.hasRow(name) ) 
				this.tbody.replaceRow(name, name, this.map(name, header));
			else
				this.tbody.addRow(name, this.map(null, header));
		}, this);
		return this;
	},
	
	showHeader: function() {
		if( !this.hasElement(this.tbody) )
			return; 
		
		$each(this.names, function(name) { this.tbody.getRow(name).findElement('td').show(); }, this);
		return this;
	},
	
	hideHeader: function() {
		if( !this.hasElement(this.tbody) )
			return; 
		
		$each(this.names, function(name) { this.tbody.getRow(name).findElement('td').hide();}, this);
		return this;
	},
	
	setRow: function( name, items ) {
		if( !this.names.contains(name) )
			this.names.extend([name]);
		
		if( !this.hasElement(this.tbody) ) 
			this.addElement(this.tbody, 'bottom');

		if( this.tbody.hasRow(name) ) 
			this.tbody.replaceRow(name, name, this.map(name, null, items));
		else 
			this.tbody.addRow(name, this.map(null, null, items));
		
		return this;
	},
	
	setRows: function( items ) {
		if( !(items instanceof Object) && !(items instanceof Hash) ) 
			throw TypeError("'items' must be an Object of Object instances");

		$each(this.names, function(name) { this.setRow(name, items[name.toUpperCase()]); }, this);
		return this;
	},
	
	removeRow: function( name ) {
		this.tbody.removeRow(name);
		
		if( this.tbody.isEmpty() )
			this.removeElement(this.tbody);
		
		return this;
	},
	
	removeRows: function( names ) {
		if( $type(names) == 'object' ) names = $H(names).getKeys();
		
		this.tbody.removeRows(names);
		
		if( this.hasElement(this.tbody) && this.tbody.isEmpty() )
			this.removeElement(this.tbody);
		
		return this;
	},
	
	clearRows: function( names ) {
		if( this.hasElement(this.tbody) ) 
			this.removeElement(this.tbody);
		
		this.tbody.clearRows();
		
		return this;
	},
	
	registerPrototype: function( name, prototype ) {
		this.prototypes.set(name, prototype);
		return this;
	},
	
	unregisterPrototype: function( name, prototype ) {
		this.prototypes.erase(name);
		return this;
	},
	
	source: function( source, inquiry, loaders ) {
		new Webics.Request( source, inquiry, loaders, [this.setRows] );
		return this;
	},
	
	refresh: function() {
		log('refreshing');
	},
	
	map: function( key, header, items ) {
		// if replacing an existing row
		if(key) {
			var oldItems = this.tbody.getItems(key);
			if( !header ) header = oldItems[0];
			if( !items ) items = [];
			if( this.prototypes.has(key) ) {
				items = [this.prototypes.get(key).attempt(key)];
			}
		} 
		// else new row
		else {
			if( !header ) header = '';
			if( !items ) items = [];
		}
		return [header].extend($splat(items));
	}
});


/*
 * Planner
 */

var Planner = new Class({
	
	Extends		: ComplexElementContext,
	prototypes	: null,
	filters		: null,
	thead		: null, 
	tbody		: null,
	tfoot		: null,
	dispatch	: new Dispatch(),
	
	initialize: function( options ) {
		this.parent('div', options);
		this.setContext('Planner');
		this.thead = new Planner.Section();
		this.tbody = new Planner.Section();
		this.tfoot = new Planner.Section();
		this.prototypes = new Hash();
		this.filters = new Array();
	},
	
	setHeader: function( items ) {
		if( !this.hasElement(this.thead) )
			this.addElement(this.thead, 'top');
		
		if( this.thead.isEmpty() ) 
			this.thead.addRow('head', items);
		else 
			this.thead.replaceRow('head', 'head', items);
		
		return this;
	},
	
	showHeader: function() {
		this.thead.show();
		return this;
	},
	
	hideHeader: function() {
		this.thead.hide();
		return this;
	},
	
	setFooter: function( items ) {
		if( !this.hasElement(this.tfoot) ) 
			this.addElement(this.tfoot, 'top');
		
		if( this.tfoot.isEmpty() )
			this.tfoot.addRow('foot', items);
		else 
			this.tfoot.replaceRow('foot', 'foot', items);
		
		return this;
	},
	
	showFooter: function() {
		this.tfoot.show();
		return this;
	},
	
	hideFooter: function() {
		this.tfoot.hide();
		return this;
	},
	
	addRow: function( name, items ) {
		if( !this.hasElement(this.tbody) ) 
			this.addElement(this.tbody, 'bottom');
		
		this.tbody.addRow(name, this.map(items, name));
		this.striped();
		return this;
	},
	
	addRows: function( items ) {
		if( !this.hasElement(this.tbody) ) 
			this.addElement(this.tbody, 'bottom');
	
		if( $type(items) == 'object' ) items = $H(items);
		
		this.tbody.addRows( items.map(this.map, this) );
		this.striped();
		return this;
	},
	
	removeRow: function( name ) {
		this.tbody.removeRow(name);
		this.striped();
		
		if( this.tbody.isEmpty() )
			this.removeElement(this.tbody);
		
		return this;
	},
	
	removeRows: function( names ) {
		if( $type(names) == 'object' ) names = $H(names).getKeys();
		
		this.tbody.removeRows(names);
		this.striped();
		
		if( this.tbody.isEmpty() )
			this.removeElement(this.tbody);
		
		return this;
	},
	
	clearRows: function() {
		if( this.hasElement(this.tbody) ) 
			this.removeElement(this.tbody);
		
		this.tbody.clearRows();
		
		return this;
	},
	
	replaceRow: function( oldName, newName, items ) {
		this.tbody.replaceRow(oldName, newName, this.map(items, newName));
		this.striped();
		return this;
	},
	
	replaceRows: function( items ) {
		this.clearRows();
		this.addRows(items);
		return this;
	},
	
	setFilter: function( filters ) {
		this.removeFilter();
		this.filters.combine(filters);
		return this;
	},
	
	removeFilter: function() {
		this.filters.empty();
	},
	
	registerPrototype: function( name, prototype ) {
		this.prototypes.set(name, prototype);
		return this;
	},
	
	unregisterPrototype: function( name, prototype ) {
		this.prototypes.erase(name);
		return this;
	},
	
	source: function( source, inquiry, loaders ) {
		new Webics.Request( source, inquiry, loaders, [this.addRows] );
		return this;
	},
	
	refresh: function() {
		log('refreshing');
	},
	
	map: function( item, key ) {
		var row = new Hash();
		
		if( $type(item) == 'array' ) {
			return item;
		}
		
		if( this.filters ) {
			this.filters.each( function(filter) {
				row.set( filter, new Text(item[filter.toUpperCase()]) );
			}, this);
		}
		
		if( this.prototypes ) {
			this.prototypes.each( function(prototype, name) {
				var args = new Array();
				if( prototype.args ) {
					prototype.args.each( function(arg) {
						args.extend( [item[arg.toUpperCase()]] );
					});
				}
				row.set( name, prototype.func.run(args) );	
			});
		}
		return row.getValues();
	},
	
	striped: function() {
		this.tbody.striped();
	}
});

/**
 * PlannerSection Class
 */
var PlannerSection = new Class({
	
	Extends	: Container,
	rows	: null,
	
	initialize: function( options ) {
		this.parent(options);
		this.setContext('Planner.Section');
		this.rows = new ContextOrganizer(this);
	},
	
	getItems: function( name ) {
		return this.rows.getItems(name);
	},
	
	getRow: function( name ) {
		return this.rows.getLine(name);
	},
	
	addRow: function( name, item ) {
		return this.rows.addLine(name, item);
	},
	
	addRows: function( items ) {
		return this.rows.addLines(items);
	},
	
	removeRow: function( name ) {
		return this.rows.removeLine(name);
	},
	
	removeRows: function( names ) {
		return this.rows.removeLines(names);
	},
	
	clearRows: function() {
		return this.rows.clearLines();
	},
	
	replaceRow: function( oldName, newName, item ) {
		return this.rows.replaceLine(oldName, newName, item);
	},
	
	replaceRows: function( items ) {
		return this.rows.replaceLines(items);
	},
	
	hasRow: function( name ) {
		return this.rows.hasLine(name);
	},
	
	striped: function() {
		this.findElements('div[context=Container]:even').each( function(td) {
			td.swapClass('odd', 'even');
		});
		this.findElements('div[context=Container]:odd').each( function(td) {
			td.swapClass('even', 'odd');
		});
	},
	
	newLine: function( key, items ) {
		var row = new Container();
		var cell = null;
		$each(items, function(item) {
			item = ['string', 'number'].contains($type(item)) ? new Text(item) : item;
			cell = new Div();
			cell.addElement(item);
			row.addElement(cell);
		});
		return row;
	}
});
Planner.Section = PlannerSection;

/*
 * Organizers
 */

/**
 * ContextOrganizer Class
 */
var ContextOrganizer = new Class({
	
	Extends	: Organizer,
	context	: null,
	items	: null,
	elements: null,
	
	initialize: function( context, options ) {
		this.context = context;
		this.items = new Hash();
		this.elements = new Hash();
	},
	
	toElement: function() {
		return this.context.toElement();
	},
	
	/**
	 * Get Items
	 */
	getItems: function( key ) {
		if( !['string', 'number'].contains($type(key)) )
			throw TypeError("'key' must be a string");
		if( !this.items.has(key) )
			throw ReferenceError("key doesn't exist");
		
		return this.items.get(key);
	},
	
	/**
	 * Get Line
	 */
	getLine: function( key ) {
		if( !['string', 'number'].contains($type(key)) )
			throw TypeError("'key' must be a string");
		if( !this.elements.has(key) )
			throw ReferenceError("key doesn't exist");
		
		return this.elements.get(key);
	},
	
	/**
	 * Add Lines
	 */
	addLine: function( key, item ) {
		if( !['string', 'number'].contains($type(key)) )
			throw TypeError("'key' must be a string");
		if( this.elements.has(key) )
			throw ReferenceError("key is already in use");
		
		var element = this.newLine(key, item); 
		this.context.addElement(element);
		this.elements.set(key, element);
		this.items.set(key, item);
		return element;
	},
	
	addLines: function( items ) {
		if( !(items instanceof Object) && !(items instanceof Hash) ) 
			throw TypeError("'items' must be an Object of Object instances");
		var lines = new Hash();
		$each(items, function(item, key) { 
			lines.set(key, this.addLine(key, item));
		}, this);
		return lines;
	},
	
	/**
	 * Remove Lines
	 */
	removeLine: function( key ) {
		if( !['string', 'number'].contains($type(key)) )
			throw TypeError("'key' must be a string");
		if( !this.elements.has(key) )
			throw ReferenceError("key doesn't exist");
		
		var element = this.getLine(key);
		this.context.removeElement(element);
		this.elements.erase(key);
		this.items.erase(key);
		return this.context;
	},
	
	removeLines: function( keys ) {
		if( !(keys instanceof Array) ) 
			throw TypeError("'keys' must be an Array of strings");
		
		$each(keys, function(key) { this.removeLine(key); }, this);
		return this.context;
	},
	
	/**
	 * Clear Lines
	 */
	clearLines: function() {
		this.context.disposeElements();
		this.elements.empty();
		this.items.empty();
		return this.context;
	},
	
	/**
	 * Replace Line
	 */
	replaceLine: function( oldKey, newKey, item ) {
		if( !['string', 'number'].contains($type(oldKey)) )
			throw TypeError("'oldKey' must be a string");
		if( !['string', 'number'].contains($type(newKey)) )
			throw TypeError("'newKey' must be a string");
		if( !this.elements.has(oldKey) )
			throw ReferenceError("oldKey doesn't exist");
		
		var oldElement = this.getLine(oldKey);
		var newElement = this.newLine(newKey, item);
		this.context.replaceElement(oldElement, newElement);
		this.elements.erase(oldKey);
		this.elements.set(newKey, newElement);
		this.items.erase(oldKey);
		this.items.set(newKey, item);
		return this.context;
	},
	
	replaceLines: function( items ) {
		this.clearLines();
		this.addLines(items);
		return this.context;
	},
	
	hasLine: function( key ) {
		return this.elements.has(key);
	},
	
	newLine: function(key, item) {
		return this.context.newLine(key, item);
	}
});

var OrganizerTabulation = new Class({
	
	Extends	: Organizer,
	tabulation: null,
	
	initialize: function(options) {
		this.tabulation = new Tabulation(options);
	},
	
	toElement: function() {
		return this.tabulation.toElement();
	},
	
	addLine: function( key, items ) {
		this.tabulation.addRow(key, items);
		return this;
	},
	
	removeLine: function( key ) {
		this.tabulation.removeRow(key);
		return this;
	},
	
	clearLines: function() {
		this.tabulation.clearRows();
		return this;
	},
	
	replaceLine: function( oldKey, newKey, items ) {
		this.tabulation.replaceRow(oldKey, newKey, items);
		return this;
	}
});
Organizer.Tabulation = OrganizerTabulation;

var OrganizerPlanner = new Class({
	
	Extends	: Organizer,
	planner	: null,
	
	initialize: function(options) {
		this.planner = new Planner(options);
	},
	
	toElement: function() {
		return this.planner.toElement();
	},
	
	addLine: function( key, items ) {
		this.planner.addRow(key, items);
		return this;
	},
	
	removeLine: function( key ) {
		this.planner.removeRow(key);
		return this;
	},
	
	clearLines: function() {
		this.planner.clearRows();
		return this;
	},
	
	replaceLine: function( oldKey, newKey, items ) {
		this.planner.replaceRow(oldKey, newKey, items);
		return this;
	}
});
Organizer.Planner = OrganizerPlanner;


/*
 * Dispatch
 */

var InputDispatch = new Class({
	
	Singleton	: true,
	dispatch	: new Dispatch(),
	services	: new Hash(),
	root		: '-InputChange',
	
	notify: function( serviceInput ) {
		if( (!serviceInput instanceof Form.SimpleInput) && !(serviceInput instanceof Form.CompositeInput) )
			throw TypeError("'input' must be an instance of Form.SimpleInputor or Form.CompositeInput");

		this.dispatch.notify(serviceInput.unique+this.root, serviceInput.value);
		return this;
	},
	
	subscribe: function( serviceInput, observer ) {
		if( !(serviceInput instanceof Form.SimpleInput) && !(serviceInput instanceof Form.CompositeInput) )
			throw TypeError("'serviceInput' must be an instance of Form.SimpleInputor or Form.CompositeInput");
		if( !this.services.has(serviceInput.unique+this.root) ) {
			serviceInput.addEvent('change', function() {
				this.notify(serviceInput);
			}.bind(this));
			this.services.set(serviceInput.unique+this.root, serviceInput);
		}
		
		this.dispatch.subscribe(serviceInput.unique+this.root, observer);
		return this;
	}
});

var DynamicEnumeration = new Class({

	Extends		: ComplexElementContext,
	current		: null,
	followers	: null,
	key			: null,
	
	initialize: function( key, options ) {
		this.parent('div', options);
		this.setContext('DynamicEnumaration');
		this.followers = new Hash();
		this.key = key;
	},
	
	updateFollowers: function( leader ) {
		var oldFollower = this.current;
		var newFollower = this.followers.get(leader);

		if( !newFollower ) {
			this.removeElement(oldFollower);
		}
		else if( !this.hasElement(oldFollower) ) {
			this.addElement(newFollower);
		} else {
			this.replaceElement(oldFollower, newFollower);
		} 
		
		this.current = newFollower;
		return this;
	},
	
	registerFollower: function( leader, follower ) {
		if( !(follower instanceof ElementContext) )
			throw TypeError("'follower' must be an instance of ElementContext");
		
		this.followers.set(leader, follower);
		return this;
	},
	
	source: function( source, inquiry, loaders ) {
		callback = function(data) {
			var leader = $H(data).getValues()[0][this.key.toUpperCase()];
			this.updateFollowers(leader);
		}.bind(this);
		
		new Webics.Request( source, inquiry, loaders, [callback] );
		return this;
	}
	
});

var Refresher = new Class({

	Extends		: ComplexElementContext,
	current		: null,
	followers	: null,
	key			: null,
	
	initialize: function( options ) {
		this.parent('div', options);
		this.setContext('Refresher');
	},
	
	refresh: function() {
		this.elements.each( function(element) {
			log(element);
			//element.refresh();
		});
	}
});

Element.Events.controlclick = {
	base: 'click', //we set a base type
	condition: function(event){ //and a function to perform additional checks.
	    return (event.control == true); //this means the event is free to fire
	}
};