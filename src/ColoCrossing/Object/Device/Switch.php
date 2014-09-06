<?php

/**
 * Represents an instance of a Switch assigned to a Device resource from
 * the API. Holds only the data for the Switch that is associated with the
 * assigned device from which this object was retrieved. It provides methods
 * to retrieve objects related to the Switch such as its Type, Owner, or
 * Ports. The Ports retrieved from this object are only the one's assigned
 * to the Device from which this Switch object was retrieved.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 * @subpackage ColoCrossing_Object_Device
 */
class ColoCrossing_Object_Device_Switch extends ColoCrossing_Resource_Object
{

	public function getType()
	{
		return $this->getObject('type', null, 'type');
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

	public function getOwner()
	{
		return $this->getObject('owner');
	}

	public function isDetailedDeviceAvailable()
	{
		$owner = $this->getOwner();

		return empty($owner);
	}

	public function getDetailedDevice()
	{
		if (!$this->isDetailedDeviceAvailable())
		{
			return null;
		}

		$device_id = $this->getId();
		$client = $this->getClient();

		return $this->getObjectById($device_id, 'detailed_device', $client->devices);
	}

}
