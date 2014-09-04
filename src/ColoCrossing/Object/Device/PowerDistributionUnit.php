<?php

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
		return $this->getObject('owner');
	}

	public function isDetailedDeviceAvailable()
	{
		$owner = $this->getOwner();

		return empty($owner);
	}

	public function getDetailedDevice()
	{
		if(!$this->isDetailedDeviceAvailable())
		{
			return null;
		}

		$client = $this->getClient();

		return $this->getObjectById($this->getId(), 'detailed_device', $client->devices);
	}

}
