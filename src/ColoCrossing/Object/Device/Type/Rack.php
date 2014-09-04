<?php

class ColoCrossing_Object_Device_Type_Rack extends ColoCrossing_Object_Device
{

	public function getDevices()
	{
		$rack_devices = $this->getRackDevices();
		$devices = array();

		foreach ($rack_devices as $key => $rack_device)
		{
			$devices[] = array(
				'id' => $rack_device['id']
			);
		}

		//Remove Duplicates
		$devices = array_map("unserialize", array_unique(array_map("serialize", $devices)));

		$this->setValue('devices', $devices);

		$client = $this->getClient();

		return $this->getObjectArray('devices', $client->devices);
	}

	public function getDevice($id)
	{
		$devices = $this->getDevices();

		return ColoCrossing_Utility::getObjectFromCollectionById($devices, $id);
	}

}
