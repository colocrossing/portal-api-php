<?php

class ColoCrossing_Resource_Child_Networks_Subnets extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->networks, $client, 'subnet', '/subnets');
	}

}
