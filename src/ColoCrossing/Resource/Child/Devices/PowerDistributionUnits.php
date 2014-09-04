<?php

class ColoCrossing_Resource_Child_Devices_PowerDistributionUnits extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->devices, $client, 'pdu', '/power');
	}

	public function setPortStatus($pdu_id, $port_id, $device_id, $status)
	{
		$status = strtolower($status);

		if($status != 'on' && $status != 'off' && $status != 'restart')
		{
			return false;
		}

		$pdu = $this->find($device_id, $pdu_id);

		if(empty($pdu) || !$pdu->getType()->isPowerDistribution())
		{
			return false;
		}

		$port = $pdu->getPort($port_id);

		if(empty($port) || !$port->isControllable())
		{
			return false;
		}

		$url = $this->createObjectUrl($pdu_id, $device_id);
		$data = array(
			'status' => $status,
			'port_id' => $port_id
		);

		$response = $this->sendRequest($url, 'PUT', $data);

		if(empty($response))
		{
			return false;
		}

		$content = $response->getContent();

		return isset($content) && isset($content['status']) && $content['status'] == 'ok';
	}

}
