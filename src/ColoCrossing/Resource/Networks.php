<?php

/**
 * Handles retrieving data from the API's networks resource
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Resource
 */
class ColoCrossing_Resource_Networks extends ColoCrossing_Resource_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client, 'network', '/networks');
	}

}
