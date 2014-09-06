<?php

/**
 * Represents an instance of a Device's Note resource from the API.
 * Holds data for a Device's Note and provides methods to retrive
 * objects related to the note such as its User or Device.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 * @subpackage ColoCrossing_Object_Device
 */
class ColoCrossing_Object_Device_Note extends ColoCrossing_Resource_Object
{

	public function getUser()
	{
		return $this->getObject('user');
	}

	public function getDevice()
	{
		$client = $this->getClient();

		return $this->getObject('device', $client->devices);
	}

	public function getTime()
	{
		$time = $this->getValue('time');

		return $time && isset($time) ? strtotime($time) : null;
	}

}
