<?php

class ColoCrossing_Object_Device extends ColoCrossing_Resource_Object
{

	public function getType()
	{
		return $this->getObject('type');
	}

	public function getOwner()
	{
		return $this->getObject('owner');
	}

	public function getSubusers()
	{
		return $this->getObjectArray('subusers');
	}

	public function getRack()
	{
		return $this->getObject('rack', $this->client->devices);
	}

	public function getRackDevices()
	{
		$client = $this->getClient();
		return $this->getObjectArray('rack_devices', $this->client->client->devices);
	}

}
