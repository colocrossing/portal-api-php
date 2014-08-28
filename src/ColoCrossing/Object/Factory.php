<?php

class ColoCrossing_Object_Factory
{

	public static function createObject(ColoCrossing_Client $client, ColoCrossing_Resource $resource = null, array $values = array())
	{
		$type = isset($resource) ? $resource->getName(false) : null;

		switch ($type)
		{
			case 'device':
				require_once(dirname(__FILE__) . '/Device.php');
				return new ColoCrossing_Object_Device($client, $resource, $values);
			case 'network':
				require_once(dirname(__FILE__) . '/Network.php');
				return new ColoCrossing_Object_Network($client, $resource, $values);
			case 'null_route':
				require_once(dirname(__FILE__) . '/NullRoute.php');
				return new ColoCrossing_Object_NullRoute($client, $resource, $values);
			case 'subnet':
				require_once(dirname(__FILE__) . '/Subnet.php');
				return new ColoCrossing_Object_Subnet($client, $resource, $values);
		}

		return new ColoCrossing_Object($client, $values);
	}

	public static function createObjectArray(ColoCrossing_Client $client, ColoCrossing_Resource $resource = null, array $objects_values = array())
	{
		$objects = [];

		foreach ($objects_values as $index => $values)
		{
			$objects[] = self::createObject($client, $resource, $values);
		}

		return $objects;
	}

}
