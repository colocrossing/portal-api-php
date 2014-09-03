<?php

class ColoCrossing_Resource_Child_Devices_Switches extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->devices, $client, array('singular' => 'switch', 'plural' => 'switches'), '/networks');
	}

	public function getBandwidthGraph($switch_id, $port_id, $device_id, $start = null, $end = null)
	{
		$switch = $this->find($device_id, $switch_id);

		if(empty($switch))
		{
			return null;
		}

		$port = $switch->getPort($port_id);

		if(empty($port) || !$port->hasBandwidthGraph())
		{
			return null;
		}

		$url = $this->createObjectUrl($switch_id, $device_id) . '/graphs/' . urlencode($port_id);
		$data = array();

		$response = $this->sendRequest($url, 'GET', $data);

		if(empty($response) || $response->getContentType() != 'image/png')
		{
			return null;
		}

		return $response->getContent();
	}

}
