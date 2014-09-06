<?php

/**
 * Represents an instance of a Rack resource that is owned by
 * the user from the API. Holds data for a Rack and provides
 * methods to retrieve objects related to the rack such as its Devices.
 * Racks are the most common example of this type.
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
