<?php

/**
 * Represents an instance of a Switch Device resource that is owned by
 * the user from the API. Holds data for a Switch Device and provides
 * methods to retrieve objects related to the device such as its Subnets,
 * PDUs or Switch Ports.
 * Switches and Firewalls are the most common examples of this type.
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
class ColoCrossing_Object_Device_Type_Switch extends ColoCrossing_Object_Device_Type_Racked
{

	public function getSubnets(array $options = null)
	{
		return $this->getResourceChildCollection('subnets', $options);
	}

	public function getSubnet($id)
	{
		return $this->getResourceChildObject('subnets', $id);
	}

	public function getPowerDistributionUnits(array $options = null)
	{
		return $this->getResourceChildCollection('pdus', $options);
	}

	public function getPowerDistributionUnit($id)
	{
		return $this->getResourceChildObject('pdus', $id);
	}

	public function getPorts()
	{
		$additional_data = array(
			'switch' => $this
		);

		return $this->getObjectArray('ports', null, 'network_port', array(), $additional_data);
	}

	public function getPort($id)
	{
		$ports = $this->getPorts();

		return ColoCrossing_Utility::getObjectFromCollectionById($ports, $id);
	}

}
