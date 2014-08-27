<?php

class ColoCrossing_Resource_Subnets extends ColoCrossing_Resource_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client, 'subnet', '/subnets');
	}

}
