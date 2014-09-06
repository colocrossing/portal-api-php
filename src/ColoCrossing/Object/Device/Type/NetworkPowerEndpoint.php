<?php

/**
 * Represents an instance of a Network and Power Endpoint Device
 * resource that is owned by the user from the API. Holds data for a
 * Network and Power Endpoint Device and provides methods to retrieve
 * objects related to the device such as its Subnets, PDUs or Switches.
 * Colocated Servers, Dedicated Servers, and KVMs are the most common
 * examples of this type.
 *
 * In order to retrieve a device of this type, the device must
 * be assigned to you and not be a shared device. Trying to create
 * a shared device of this type will result in and Authorization_Error
 * to be thrown.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 * @subpackage ColoCrossing_Object_Device_Type
 */
class ColoCrossing_Object_Device_Type_NetworkPowerEndpoint extends ColoCrossing_Object_Device_Type_Racked
{

	public function getSubnets(array $options = null)
	{
		return $this->getResourceChildCollection('subnets', $options);
	}

	public function getSubnet($id)
	{
		return $this->getResourceChildObject('subnets', $id);
	}

	public function getSwitches(array $options = null)
	{
		return $this->getResourceChildCollection('switches', $options);
	}

	public function getSwitch($id)
	{
		return $this->getResourceChildObject('switches', $id);
	}

	public function getPowerDistributionUnits(array $options = null)
	{
		return $this->getResourceChildCollection('pdus', $options);
	}

	public function getPowerDistributionUnit($id)
	{
		return $this->getResourceChildObject('pdus', $id);
	}

}
