<?php

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
