<?php

class ColoCrossing_Object_Factory
{

	public static function createObject(ColoCrossing_Client $client, ColoCrossing_Resource $resource = null, array $values = array(), $type = null)
	{
		if(empty($resource))
		{
			switch ($type)
			{
				case 'network_port':
					require_once(dirname(__FILE__) . '/Device/NetworkPort.php');
					return new ColoCrossing_Object_Device_NetworkPort($client, $values);
				case 'power_port':
					require_once(dirname(__FILE__) . '/Device/PowerPort.php');
					return new ColoCrossing_Object_Device_PowerPort($client, $values);
				case 'type':
					require_once(dirname(__FILE__) . '/Device/Type.php');
					return new ColoCrossing_Object_Device_Type($client, $values);
			}
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
					case 'pdu':
					case 'switch':
						return self::createDeviceChildObject($client, $child_resource, $values);
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
						return new ColoCrossing_Object_Subnet_ReverseDNSRecord($client, $child_resource, $values);
				}
				break;
		}

		return new ColoCrossing_Object($client, $values);
	}

	public static function createObjectArray(ColoCrossing_Client $client, ColoCrossing_Resource $resource = null, array $objects_values = array(), $type = null, array $additional_data = null)
	{
		$objects = [];

		foreach ($objects_values as $index => $values)
		{
			if(isset($additional_data))
			{
				$values = array_merge($values, $additional_data);
			}

			$objects[] = self::createObject($client, $resource, $values, $type);
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

		require_once(dirname(__FILE__) . '/Device/Type/Racked.php');

		if($type['is_rack']) //Rack
		{
			require_once(dirname(__FILE__) . '/Device/Type/Rack.php');
			return new ColoCrossing_Object_Device_Type_Rack($client, $resource, $values);
		}
		else if($type['is_virtual']) //VPS
		{
			require_once(dirname(__FILE__) . '/Device/Type/Virtual.php');
			return new ColoCrossing_Object_Device_Type_Virtual($client, $resource, $values);
		}
		else if($type['network'] == 'distribution' && $type['power'] == 'endpoint') //Switch
		{
			require_once(dirname(__FILE__) . '/Device/Type/Switch.php');
			return new ColoCrossing_Object_Device_Type_Switch($client, $resource, $values);
		}
		else if($type['network'] == 'endpoint' && $type['power'] == 'distribution') //PDU
		{
			require_once(dirname(__FILE__) . '/Device/Type/PowerDistributionUnit.php');
			return new ColoCrossing_Object_Device_Type_PowerDistributionUnit($client, $resource, $values);
		}
		else if($type['network'] == 'endpoint' && $type['power'] == 'endpoint') //Server, KVM
		{
			require_once(dirname(__FILE__) . '/Device/Type/NetworkPowerEndpoint.php');
			return new ColoCrossing_Object_Device_Type_NetworkPowerEndpoint($client, $resource, $values);
		}
		else if($type['network'] == 'endpoint' && !$type['power']) //Cross Connect
		{
			require_once(dirname(__FILE__) . '/Device/Type/NetworkEndpoint.php');
			return new ColoCrossing_Object_Device_Type_NetworkEndpoint($client, $resource, $values);
		}

		return new ColoCrossing_Object_Device($client, $resource, $values);
	}

	public static function createDeviceChildObject(ColoCrossing_Client $client, ColoCrossing_Resource $child_resource = null, array $values = array())
	{
		$child_type = $child_resource->getName(false);

		switch ($child_type) {
			case 'pdu':
				require_once(dirname(__FILE__) . '/Device/PowerDistributionUnit.php');
				return new ColoCrossing_Object_Device_PowerDistributionUnit($client, $child_resource, $values);
			case 'switch':
				require_once(dirname(__FILE__) . '/Device/Switch.php');
				return new ColoCrossing_Object_Device_Switch($client, $child_resource, $values);
		}

		return new ColoCrossing_Object_Device($client, $child_resource, $values);
	}

}
