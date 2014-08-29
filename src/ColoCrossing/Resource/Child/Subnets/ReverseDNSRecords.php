<?php

class ColoCrossing_Resource_Child_Subnets_ReverseDNSRecords extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->subnets, $client, 'rdns_record', '/rdns-records');
	}

}
