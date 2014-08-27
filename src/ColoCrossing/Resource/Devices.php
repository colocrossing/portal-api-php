<?php

class ColoCrossing_Resource_Devices extends ColoCrossing_Resource_Abstract
{

	public function __construct(ColoCrossing_Client $client, $name, $url)
	{
		parent::__construct($client, 'device', '/devices');
	}

}
