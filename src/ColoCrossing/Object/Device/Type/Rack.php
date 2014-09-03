<?php

class ColoCrossing_Object_Device_Type_Rack extends ColoCrossing_Object_Device
{

	public function getDevices()
	{
		$client = $this->getClient();

		return $this->getObjectArray('rack_devices', $client->devices);
	}

	public function getDevice($id)
	{
		$devices = $this->getDevices();

		return ColoCrossing_Utility::getObjectFromCollectionById($devices, $id);
	}

}
