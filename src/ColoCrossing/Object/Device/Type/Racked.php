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

	/**
	 * Retrieves the Rack object that this Device is assigned to.
	 * If the Rack is assigned to you, then the Detailed Rack object is
	 * returned. Otherwise a generic object is returned that holds the Id,
	 * Name, and USize.
	 * @return ColoCrossing_Object_Device_Type_Rack|ColoCrossing_Object|null	The Rack
	 */
	public function getRack()
	{
		$client = $this->getClient();
		$rack = $this->getValue('rack');

		if (empty($rack) || !is_array($rack))
		{
			return null;
		}

		$resource = isset($rack['owner']) && is_array($rack['owner']) ? $client->devices : null;

		return $this->getObject('rack', $resource);
	}

}
