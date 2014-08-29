<?php

class ColoCrossing_Resource_Child_Networks_NullRoutes extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->networks, $client, 'null_route', '/null-routes');
	}

}
