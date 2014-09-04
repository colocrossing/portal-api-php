<?php

class ColoCrossing_Resource_Child_Devices_Switches extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->devices, $client, array('singular' => 'switch', 'plural' => 'switches'), '/networks');
	}

	public function getBandwidthGraph($switch_id, $port_id, $device_id, $start = null, $end = null)
	{
		$start = isset($start) ? $start : strtotime(date('Y').'-'.date('m').'-01'.' '.date('h').':'.date('i').':00');
		$end = isset($end) ? $end : strtotime(date('Y').'-'.date('m').'-'.date('d').' '.date('h').':'.date('i').':59');

		if($start >= $end)
		{
			return null;
		}

		$switch = $this->find($device_id, $switch_id);

		if(empty($switch) || !$switch->getType()->isNetworkDistribution())
		{
			return null;
		}

		$port = $switch->getPort($port_id);

		if(empty($port) || !$port->isBandwidthGraphAvailable())
		{
			return null;
		}

		$url = $this->createObjectUrl($switch_id, $device_id) . '/graphs/' . urlencode($port_id);
		$data = array(
			'start' => date('c', $start),
			'end' => date('c', $end)
		);

		$response = $this->sendRequest($url, 'GET', $data);

		if(empty($response) || $response->getContentType() != 'image/png')
		{
			return null;
		}

		return $response->getContent();
	}

	public function setPortStatus($switch_id, $port_id, $device_id, $status)
	{
		$status = strtolower($status);

		if($status != 'on' && $status != 'off')
		{
			return false;
		}

		$switch = $this->find($device_id, $switch_id);

		if(empty($switch) || !$switch->getType()->isNetworkDistribution())
		{
			return false;
		}

		$port = $switch->getPort($port_id);

		if(empty($port) || !$port->isControllable())
		{
			return false;
		}

		$url = $this->createObjectUrl($switch_id, $device_id);
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
