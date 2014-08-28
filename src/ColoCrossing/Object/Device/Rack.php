<?php

class ColoCrossing_Object_Device_Rack extends ColoCrossing_Object_Device
{

	public function getRack()
	{
		return null;
	}

	public function getDevices()
	{
		$client = $this->getClient();
		return $this->getObjectArray('rack_devices', $this->client->client->devices);
	}

}
