<?php

class ColoCrossing_Object_Device_Racked extends ColoCrossing_Object_Device
{

	public function getRack()
	{
		$client = $this->getClient();

		return $this->getObject('rack', $client->devices);
	}

}
