<?php

class ColoCrossing_Object_Device_PowerPort extends ColoCrossing_Object
{

	public function getDevice()
	{
		$client = $this->getClient();

		return $this->getObject('device', $client->devices);
	}

}
