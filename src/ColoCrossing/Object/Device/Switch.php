<?php

class ColoCrossing_Object_Device_Switch extends ColoCrossing_Resource_Object
{

	public function getPorts()
	{
		return $this->getObjectArray('ports', null, 'network_port', array());
	}

	public function getOwner()
	{
		return $this->getObject('owner');
	}

	public function getDetailedDevice()
	{
		$owner = $this->getOwner();

		if(empty($owner))
		{
			return null;
		}

		$device_id = $this->getId();
		$client = $this->getClient();

		return $this->getObjectById($device_id, 'detailed_device', $client->devices);
	}

}
