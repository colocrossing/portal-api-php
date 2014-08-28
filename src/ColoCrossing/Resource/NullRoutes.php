<?php

class ColoCrossing_Resource_NullRoutes extends ColoCrossing_Resource_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client, 'null_route', '/null-routes');
	}

}
