<?php

/**
 * Represents an instance of a PDU assigned to a Device resource from
 * the API. Holds only the data for the PDU that is associated with the
 * assigned device. It provides methods to retrieve objects related to
 * the PDU such as its Type, Owner, or Ports. The Ports retrieved from
 * this object are only the one's assigned to the Device from which this
 * PDU object was retrieved.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 * @subpackage ColoCrossing_Object_Device
 */
class ColoCrossing_Object_Device_PowerDistributionUnit extends ColoCrossing_Resource_Object
{

	public function getType()
	{
		return $this->getObject('type', null, 'type');
	}

	public function getPorts()
	{
		$additional_data = array(
			'power_distribution_unit' => $this
		);

		return $this->getObjectArray('ports', null, 'power_port', array(), $additional_data);
	}

	public function getPort($id)
	{
		$ports = $this->getPorts();

		return ColoCrossing_Utility::getObjectFromCollectionById($ports, $id);
	}

	public function getOwner()
	{
		return $this->getObject('owner', null, 'user');
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

		$client = $this->getClient();

		return $this->getObjectById($this->getId(), 'detailed_device', $client->devices);
	}

}
