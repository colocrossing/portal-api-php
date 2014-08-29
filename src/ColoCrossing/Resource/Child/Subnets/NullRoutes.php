<?php

class ColoCrossing_Resource_Child_Subnets_NullRoutes extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->subnets, $client, 'null_route', '/null-routes');
	}

}
