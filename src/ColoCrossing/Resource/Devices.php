<?php

/**
 * Handles retrieving data from the API's devices resource
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Resource
 */
class ColoCrossing_Resource_Devices extends ColoCrossing_Resource_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client, 'device', '/devices');
	}

}
