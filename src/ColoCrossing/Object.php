<?php

class ColoCrossing_Object
{

	private $values;

	public function __construct(array $values = array())
	{
		$this->values = $values;
	}

	public function getValues()
	{
		return $this->values;
	}

	public function setValues($values)
	{
		$this->values = $values;
	}

	public function getValue($key)
	{
		return isset($this->values[$key]) ? $this->values[$key] : false;
	}

	public function setValue($key, $value)
	{
		return $this->values[$key] = $value;
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
    	$name = ltrim(ColoCrossing_Utility::convertCamelCaseToSnakeCase($name), 'get_');
        if (isset($this->values[$name]) || array_key_exists($name, $this->values))
        {
            return $this->values[$name];
        }

        return null;
    }
}
