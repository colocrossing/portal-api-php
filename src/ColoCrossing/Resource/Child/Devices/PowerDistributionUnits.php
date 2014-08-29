<?php

class ColoCrossing_Resource_Child_Devices_PowerDistributionUnits extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->devices, $client, 'pdu', '/power');
	}

}
