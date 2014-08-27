<?php

class ColoCrossing_Object_Factory
{

	public static function createObject(ColoCrossing_Resource $resource, array $values = array())
	{
		$type = $resource->getName(false);

		switch ($type)
		{
			case 'device':
				require_once(dirname(__FILE__) . '/Device.php');
				return new ColoCrossing_Object_Device($resource, $values);
			case 'subnet':
				require_once(dirname(__FILE__) . '/Subnet.php');
				return new ColoCrossing_Object_Subnet($resource, $values);
		}

		return new ColoCrossing_Object($resource, $values);
	}

	public static function createObjectArray(ColoCrossing_Resource $resource, array $objects_values = array())
	{
		$type = $resource->getName(false);
		$objects = [];

		foreach ($objects_values as $index => $values)
		{
			$objects[] = self::createObject($resource, $values);
		}

		return $objects;
	}

}
