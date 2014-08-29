<?php

class ColoCrossing_Object_Factory
{

	public static function createObject(ColoCrossing_Client $client, ColoCrossing_Resource $resource = null, array $values = array())
	{
		if(empty($resource))
		{
			return new ColoCrossing_Object($client, $values);
		}

		if(is_a($resource, 'ColoCrossing_Resource_Child_Abstract'))
		{
			return self::createChildObject($client, $resource, $values);
		}

		switch ($resource->getName(false))
		{
			case 'device':
				return self::createDeviceObject($client, $resource, $values);
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

	private static function createChildObject(ColoCrossing_Client $client, ColoCrossing_Resource $child_resource, array $values = array())
	{
		$child_type = $child_resource->getName(false);

		$parent_resource = $child_resource->getParentResource();
		$parent_type = $parent_resource->getName(false);

		switch ($parent_type)
		{
			case 'device':
				switch ($child_type)
				{
					case 'asset':
						require_once(dirname(__FILE__) . '/Device/Asset.php');
						return new ColoCrossing_Object_Device_Asset($client, $child_resource, $values);
					case 'note':
						require_once(dirname(__FILE__) . '/Device/Note.php');
						return new ColoCrossing_Object_Device_Note($client, $child_resource, $values);
					case 'subnet':
						require_once(dirname(__FILE__) . '/Subnet.php');
						return new ColoCrossing_Object_Subnet($client, $child_resource, $values);
				}
				break;
			case 'network':
				switch ($child_type)
				{
					case 'subnet':
						require_once(dirname(__FILE__) . '/Subnet.php');
						return new ColoCrossing_Object_Subnet($client, $child_resource, $values);
					case 'null_route':
						require_once(dirname(__FILE__) . '/NullRoute.php');
						return new ColoCrossing_Object_NullRoute($client, $child_resource, $values);
				}
				break;
			case 'subnet':
				switch ($child_type)
				{
					case 'null_route':
						require_once(dirname(__FILE__) . '/NullRoute.php');
						return new ColoCrossing_Object_NullRoute($client, $child_resource, $values);
					case 'rdns_record':
						require_once(dirname(__FILE__) . '/Subnet/ReverseDNSRecord.php');
						return new ColoCrossing_Object__Subnet_ReverseDNSRecord($client, $child_resource, $values);
				}
				break;
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

	public static function createDeviceObject(ColoCrossing_Client $client, ColoCrossing_Resource $resource = null, array $values = array())
	{
		require_once(dirname(__FILE__) . '/Device.php');

		$type = isset($values) && is_array($values) && isset($values['type']) && is_array($values['type']) ? $values['type'] : null;

		if(empty($type))
		{
			return new ColoCrossing_Object_Device($client, $resource, $values);
		}

		require_once(dirname(__FILE__) . '/Device/Racked.php');

		if($type['network'] == 'distribution') //Switch
		{
			require_once(dirname(__FILE__) . '/Device/Switch.php');
			return new ColoCrossing_Object_Device_Switch($client, $resource, $values);
		}
		else if($type['power'] == 'distribution') //PDU
		{
			require_once(dirname(__FILE__) . '/Device/PowerDistributionUnit.php');
			return new ColoCrossing_Object_Device_PowerDistributionUnit($client, $resource, $values);
		}
		else if($type['is_rack']) //Rack
		{
			require_once(dirname(__FILE__) . '/Device/Rack.php');
			return new ColoCrossing_Object_Device_Rack($client, $resource, $values);
		}

		return new ColoCrossing_Object_Device($client, $resource, $values);
	}

}
