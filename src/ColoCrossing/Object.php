<?php

class ColoCrossing_Object
{

	private $client;

	private $values;

	private $objects;

	private $object_arrays;

	public function __construct(ColoCrossing_Client $client, array $values = array())
	{
		$this->client = $client;
		$this->values = $values;

		$this->objects = array();
		$this->object_arrays = array();
	}

	public function getClient()
	{
		return $this->client;
	}

	public function getValues()
	{
		return $this->values;
	}

	public function getValue($key)
	{
		return isset($this->values[$key]) ? $this->values[$key] : false;
	}

	public function getId()
	{
		$id = $this->getValue('id');
		return $id && isset($id) ? intval($id) : null;
	}

	public function __toJSON()
	{
		if (defined('JSON_PRETTY_PRINT'))
		{
      		return json_encode($this->__toArray(), JSON_PRETTY_PRINT);
    	}

    	return json_encode($this->__toArray());
	}

	public function __toString()
	{
    	$class = get_class($this);
    	return $class . ' JSON: ' . $this->__toJSON();
	}

	public function __toArray()
	{
		return $this->values;
	}

	public function __call($name, $arguments)
    {
    	$name = ColoCrossing_Utility::convertCamelCaseToSnakeCase($name);
    	$name_parts = explode('_', $name);

    	if(count($name_parts) <= 1)
    	{
    		return null;
    	}

    	$type = array_shift($name_parts);
    	$name = implode('_', $name_parts);

    	if (!isset($this->values[$name]) && !array_key_exists($name, $this->values))
        {
        	return null;
        }

    	switch ($type) {
    		case 'get':
    			return $this->values[$name];
    		case 'is':
    			return !!$this->values[$name];
    	}

        return null;
    }

	protected function getObjects()
	{
		return $this->objects;
	}

	protected function getObject($key, ColoCrossing_Resource $resource = null, $type = null, $default = null)
	{
		if(isset($this->objects[$key]))
		{
			return $this->objects[$key];
		}

		$value = $this->getValue($key);

		if($value && is_array($value))
		{
			if(isset($resource) && isset($value['id']))
			{
				return $this->objects[$key] = $resource->find($value['id']);
			}
			return $this->objects[$key] = ColoCrossing_Object_Factory::createObject($this->client, $resource, $value, $type);
		}

		return $default;
	}

	protected function getObjectArrays()
	{
		return $this->object_arrays;
	}

	protected function getObjectArray($key, ColoCrossing_Resource $resource = null, $type = null, $default = null)
	{
		if(isset($this->object_arrays[$key]))
		{
			return $this->object_arrays[$key];
		}

		$value = $this->getValue($key);

		if($value && is_array($value))
		{
			if(empty($resource))
			{
				return $this->object_arrays[$key] = ColoCrossing_Object_Factory::createObjectArray($this->client, $resource, $value, $type);
			}

			$this->object_arrays[$key] = array();
			foreach ($value as $index => $content)
			{
				$this->object_arrays[$key][] = $resource->find($content['id']);
			}
			return $this->object_arrays[$key];
		}

		return $default;
	}

}
