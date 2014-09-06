<?php

/**
 * Represents an instance of a Racked Device resource that is owned by
 * the user from the API. Holds data for a Racked Device and provides a
 * method to get the Rack object this device is assigned to.
 * Dedicated/Colo Servers, Switches, or PDUs are the most common
 * example of this type.
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
class ColoCrossing_Object_Device_Type_Racked extends ColoCrossing_Object_Device
{

	public function getRack()
	{
		//TODO Return Full Rack Object when Rack is Owned By Client
		$client = $this->getClient();

		return $this->getObject('rack');
	}

}
