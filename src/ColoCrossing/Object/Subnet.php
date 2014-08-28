<?php

class ColoCrossing_Object_Subnet extends ColoCrossing_Resource_Object
{

	public function getNetwork()
	{
		$client = $this->getClient();

		return $this->getObject('network');
	}

	public function getDevice()
	{
		$client = $this->getClient();

		return $this->getObject('device', $client->devices);
	}

}
