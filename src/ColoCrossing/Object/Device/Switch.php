<?php

class ColoCrossing_Object_Device_Switch extends ColoCrossing_Resource_Object
{

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
		if(!$this->isDetailedDeviceAvailable())
		{
			return null;
		}

		$device_id = $this->getId();
		$client = $this->getClient();

		return $this->getObjectById($device_id, 'detailed_device', $client->devices);
	}

}
