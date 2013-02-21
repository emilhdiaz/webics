
<?php
/*
 * DAOEntity uses the Bridge Pattern to let DataAccessObject
 * abstraction evolve independently of implementation
 *
 * DAOEntity uses the Composite Pattern to manage compositions
 * of other DAOEntity(s)
 */

abstract class DAOEntity extends Object implements Iterable, Dependable {

	const source = false;
	const isView = false;
	const reflector_class = 'DAOEntityReflector';
	
	private $base = false;
	private $loaded = false;
	private $entities = array();
	
	public static $cache;
	
	/**
	 * @var Integer
	 * @key auto 
	 */
	protected $ID;
	
	/**
	 * @var Timestamp
	 * @internal
	 */
	protected $CreatedOn;
	
	/**
	 * @var Timestamp
	 * @internal
	 */
	protected $ModifiedOn;
	
	/*
	 * Constructors
	 */

	public function __construct( array $properties ) {
		parent::__construct();
		$class = static::getClass();
		$base = $class->getParentClass();

		// initiate Entity cache
		if( is_null(self::$cache) )
			self::$cache = new Cache();
			
		// check for extension
		if( $base->isSubclassOf('\DAOEntity') )
			$this->base = $base->newInstance();

		// set defaults
		foreach( $class->getProperties() as $property ) {
			if( $default = $property->getAnnotation('default') ) {
				$this->set($property->getName(), $default);
			}
		}
		
		if( $properties ) 
			$this->properties = $properties;

		return $this;
	}

	
	/*
	 * Mutator/Accessor Methods
	 */

	public function __get( $property ) {
		$class = static::getClass();

		if( strtolower($property) == 'properties' ) {
			return $class->getValues($this);
		}
		
		// check for extension
		$base = $this->base;
		if( $base && $base::getClass()->hasProperty($property) )
			return $this->base->__get($property, $value);
		
		// check for a valid property
		$class->checkUnknownProperty($property);

		// check for an alias
		if( $class->getProperty($property)->hasAnnotation('alias') ) {
			$alias = $class->getProperty($property)->getAnnotation('alias');
			return $this->__get($alias);
		}
		
		return $this->get($property);
	}

	public function __set( $property, $value ) {
		$class = static::getClass();

		if( static::isView ) 
			throw new UnknownMethodException('create');
		
		if( strtolower($property) == 'properties' ) {
			$class->checkUnknownProperties($value);
			$class->checkPropertyRestrictions($value, $class->isLoaded($this));
			$class->checkPropertyValues($value);
			
			foreach( $value as $property=>$value ) {
				$this->set($property, $value);				
			}
			return $this;	
		}
		
		// check for extension
		$base = $this->base;
		if( $base && $base::getClass()->hasProperty($property) )
			return $this->base->__set($property, $value);
		
		// check for a valid property
		$class->checkUnknownProperty($property);

		// check for an alias
		if( $class->getProperty($property)->hasAnnotation('alias') ) {
			$alias = $class->getProperty($property)->getAnnotation('alias');
			return $this->__set($alias, $value);
		}
			
		$class->checkPropertyRestriction($property, $class->isLoaded($this));
		
		return $this->set($property, $value);
	}

	public function __sleep() {
		return array("\0DAOEntity\0base", "\0DAOEntity\0loaded","\0DAOEntity\0properties");
	}

	public function __wakeup() {
		parent::__wakeup();
	}

	public function __toArray() {
		$class = static::getClass();
		$values = $class->getValues($this);

		if( $this->base )
			return array_merge($values, $this->base->__toArray());
		else
			return $values;
	}

	public function __toString() {
		$class = static::getClass();
		return $class->getSource() . ' : ' . $class->getKeyString($this);
	}
	
	public function get( $property ) {
		restrict_method_access(array('DAOEntity', 'DAOEntityReflector'));
		$class = static::getClass();
		
		// check for multiple properties
		if( is_array($property) ) {
			foreach( $property as $prop )
				$str .= $this->get($prop).' ';
			return $str;
		}

		// check for extension
		$base = $this->base;
		if( $base && $base::getClass()->hasProperty($property) )
			return $this->base->get($property);

		// check for a valid property
		$class->checkUnknownProperty($property);
			
		// check for an alias
		if( $class->getProperty($property)->hasAnnotation('alias') ) {
			$alias = $class->getProperty($property)->getAnnotation('alias');
			return $this->get($alias);
		}

		$type = $class->getProperty($property)->getType();
		
		// check for entity 
		if( $class->getProperty($property)->isEntity() ) {
			// check for a collection (dependents, relationships)
			if( $class->getProperty($property)->isCollection() ) {
				$collection = $type::find(array_prefix_keys($class->getSource(), $class->getKey($this)));
				return $collection;
			} 
			else {
				$key = array_prefix_keys(strtolower($property), $type::getClass()->getKey());
				$key = array_extract($this->entities, array_keys($key));
				$key = array_unprefix_keys(strtolower($property), $key);
				
				if( in_array(null, $key) )
					return null;
				
				return $type::load($key);
			}
		}

		return $this->$property;
	}

	public function set( $property, $value ) {
		restrict_method_access(array('DAOEntity', 'DAOEntityReflector'));
		$class = static::getClass();
		
		// check for extension
		$base = $this->base;
		if( $base && $base::getClass()->hasProperty($property) )
			return $this->base->set($property, $value);

		// check for a valid property
		if( !$class->hasProperty($property) ) {
			$this->entities[$property] = $value;
			return $this;
		}

		// check for an alias
		if( $class->getProperty($property)->hasAnnotation('alias') ) {
			$alias = $class->getProperty($property)->getAnnotation('alias');
			return $this->set($alias, $value);
		}

		$class->checkPropertyValue($property, $value);

		$type = $class->getProperty($property)->getType();

		// check for entity
		if( $class->getProperty($property)->isEntity() ) {

			// check for collection
			if( $class->getProperty($property)->isCollection() ) {

				if( !$class->isLoaded($this) || is_null($value) )
					throw new RestrictedPropertyException($property);
				
				// dependents
				if( $class->getProperty($property)->hasAnnotation('dependent') ) {
					$value->set($class->getName(), $this);
					return $value;
				}
				
				// relationships
				if( $class->getProperty($property)->hasAnnotation('relationship') ) {
					#TODO: cannot return from __set(), need to find another solution
					$relationship = new $type;
					$relationship->set($class->getName(), $this);
					foreach( a($value) as $entity ) {
						$relationship->set($entity::getClass()->getName(), $entity);
					}
					return $relationship;
				}
			}
			else {
				$key = $class->mapEntityToKey($property, $value);					
				$this->entities = array_merge($this->entities, $key);
			}
			return $this;
		}
		else {
			// check for scalar assignment
			if( !is_object($value) && !is_null($value) ) {
				$value = new $type($value);
			}
			
			$this->$property = $value;
		}
		return $this;
	}
	
	/*
	 * Lifecycle Methods
	 */

	public function save( $properties = array() ) {
		$class = static::getClass();
		$base = $this->base;
		
		if( static::isView ) 
			throw new UnknownMethodException('save');
				
		// check for extension
		if( $base )
			$base->save();
				
		// check fail-over to create mode
		if( !$class->isLoaded($this) ) {
			// check for extension
			if( $base ) {
				$properties = array_merge($properties, $base::getKey($base));
			}

			// property filters
			$exclude = array('key=auto','alias','readonly','restricted','internal');
			$properties = array_merge($class->getValues($this, $exclude), $properties);
			$properties = static::create($properties);
		}
		else {
			// property filters
			$exclude = array('key','alias','readonly','constant','restricted','internal');
			$properties = array_merge($class->getValues($this, $exclude), $properties);
			$properties = static::update($class->getKey($this), $properties);
		}
		
		// refresh properties
		foreach(  $properties as $property=>$value ) {
			$this->set($property,$value);
		}
		
		if( !$this->loaded ) {
			$this->loaded = true;
			self::$cache->store($class->getFullName(), $class->getKeyString($this), $this);
		}
		
		return $this;
	}

	public function delete() {
		$class = static::getClass();
		if( !$class->isLoaded($this) )
			return;

		// delete entity
		static::remove( $class->getKey($this) );

		// mark as unloaded
		$this->loaded = false;

		// check for extensions
		if( $this->base )
			$this->base->delete();
	}	

	/*
	 * Static Loading Methods
	 */

	public static function all() {
		$class = static::getClass();
		
		// load entity properties
		$entity_properties = Application::dao()->all($class->getSource());
		
		$entities = new Hash();

		foreach( $entity_properties as $properties ) {
			// create new entity
			$entity = self::createLoadedEntity($properties);

			// add to hash
			$entities->{$class->getKeyString($entity)} = $entity;
		}
		return $entities;
	}
	
	public static function find( array $properties, $full_text_search = false ) {
		$class = static::getClass();
		
		$class->checkUnknownProperties($properties);
		$class->checkPropertyValues($properties);
		$properties = $class->mapEntitiesToKeys($properties);
		
		// load entity properties
		if( $full_text_search )
			$entity_properties = Application::dao()->search($class->getSource(), new Hash($properties));
		else 
			$entity_properties = Application::dao()->find($class->getSource(), new Hash($properties));

		$entities = new Hash();
		
		foreach( $entity_properties as $properties ) {
			// create new entity
			$entity = self::createLoadedEntity($properties);

			// add to hash
			$entities->{$class->getKeyString($entity)} = $entity;
		}
		return $entities;
	}

	public static function load( $key ) {
		$class = static::getClass();
		
		// check for supplied key and set
		$key = $class->checkKey($key);
		$keyString = $class->getKeyString($key);
		
		if( !($entity = self::$cache->retrieve($class->getFullName(), $keyString)) ) {
			// load property values from data source			
			$properties = Application::dao()->load($class->getSource(), $key);
			$entity = self::createLoadedEntity($properties);
		}
		return  $entity;
	}
	
	public static function exists( $key ) {
		$class = static::getClass();

		// check for supplied key
		$key = $class->checkKey($key);
		$keyString = $class->getKeyString($key);

		// check the cache first, then the database
		if( !($found = self::$cache->has($class->getFullName(), $keyString)) ) {
			$found = Application::dao()->exists($class->getSource(),new Hash($key));
		}
		
		return (bool) $found;
	}
	
	public static function create( array $properties ) {
		$class = static::getClass();
		
		if( static::isView ) 
			throw new UnknownMethodException('create');

		// set defaults
		foreach( $class->getProperties() as $property ) {
			$type = $property->getType();
			if( $default = $property->getAnnotation('default') ) {
				$value = $properties[$property->getName()];
				$properties[$property->getName()] = $value ? $value : new $type($default);
			}
		}
		$class->checkUnknownProperties($properties);
		$class->checkPropertyRestrictions($properties, false);
		$class->checkRequiredProperties($properties, array('key','constant','required'));
		$class->checkPropertyValues($properties);
		$properties = $class->mapEntitiesToKeys($properties);
		$key = array_extract($properties, array_keys($class->getKey()));
		
		if( empty($properties) )
			return $properties;
			
//		$properties['createdOn'] = new Timestamp();
		$properties = Application::dao()->create($class->getSource(), new Hash($key), new Hash($properties));
		
		if( get_caller_class() == 'DAOEntity' )
			return $properties;
		else
			return self::createLoadedEntity($properties);
	}
	
	public static function update( $key, array $properties ) {
		$class = static::getClass();
		
		if( static::isView ) 
			throw new UnknownMethodException('create');

		// check for supplied key and set
		$key = $class->checkKey($key);
		$keyString = $class->getKeyString($key);
		
		// check for cached entity
		if( (get_caller_class() != 'DAOEntity') && ($entity = self::$cache->retrieve($class->getFullName(), $keyString)) ) {
			// load property values from data source			
			return $entity->save($properties);
		}
				
		// check for supplied key and set
		$class->checkUnknownProperties($properties);
		$class->checkPropertyRestrictions($properties, true);
		$class->checkRequiredProperties($properties, array('constant','required'), false);
		$class->checkPropertyValues($properties);
		$properties = $class->mapEntitiesToKeys($properties);
		
		if( empty($properties) )
			return $properties;
		
//		$properties['modifiedOn'] = new Timestamp();
		$properties = Application::dao()->update($class->getSource(), new Hash($key), new Hash($properties));

		if( get_caller_class() == 'DAOEntity' )
			return $properties;
		else
			return self::createLoadedEntity($properties);
	}

	public static function remove( $key ) {
		$class = static::getClass();
		
		if( static::isView ) 
			throw new UnknownMethodException('remove');
		
		$key = $class->checkKey($key);
		$keyString = $class->getKeyString($key);
					
		// delete entity
		Application::dao()->delete($class->getSource(), new Hash($key));
		
		if( $entity = self::$cache->remove($class->getFullName(), $keyString) ) {
			$entity->loaded = false;
		}
	}
	
	public static function dependencies() {
		$class = static::getClass();
		$dependencies = array();
		foreach( $class->getProperties() as $property ) {
			if( $property->isEntity() ) {
				$dependencies[] = $property->getType();
			}
		}
		$base = $class->getParentClass();
		if( $base->isSubclassOf('\DAOEntity') ) $dependencies[] = $base->getName();

		return $dependencies; 
	}
	
	private static function createLoadedEntity($properties) {
		$class = static::getClass();
		
		$keyString = $class->getKeyString($properties);
		
		// create new instance
		if( !($entity = self::$cache->retrieve($class->getFullName(), $keyString)) ) {
			$entity = $class->newInstance();
		}
		
		if( $entity->base ) {
			$base = $entity->base;
			if( $base = self::$cache->retrieve($base::getClass()->getFullName(), $keyString) )
				$entity->base = $base;
		}
		
		// set properties
		foreach(  $properties as $property=>$value ) {
			$entity->set($property,$value);
		}
		
		$entity->loaded = true;
		
		self::$cache->store($class->getFullName(), $keyString, $entity);
		
		return $entity;
	}
}
?>