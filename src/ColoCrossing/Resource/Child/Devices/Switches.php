<?php

/**
 * Handles retrieving data from the API's device switches sub-resource.
 * Also Allows for controlling the port of the Switch and retrieving a
 * port's Bandwidth Graphs.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Resource
 * @subpackage ColoCrossing_Resource_Child_Devices
 */
class ColoCrossing_Resource_Child_Devices_Switches extends ColoCrossing_Resource_Child_Abstract
{

	/**
	 * @param ColoCrossing_Client $client The API Client
	 */
	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->devices, $client, array('singular' => 'switch', 'plural' => 'switches'), '/networks');
	}

	/**
	 * Retrieves the Bandwidth Graph of the provided Port on the provided Switch
	 * that is assigned to the provided Device.
	 * @param  int $switch_id 	The Switch Id
	 * @param  int $port_id   	The Port Id
	 * @param  int $device_id 	The Device Id
	 * @param  int $start     	The Unix Timestamp that is the start time of the graph range.
	 * @param  int $end      	The Unix Timestamp that is the end time of the graph range.
	 * @return resource|null	An PNG Image Resource if it is available, null otherwise
	 */
	public function getBandwidthGraph($switch_id, $port_id, $device_id, $start = null, $end = null)
	{
		$start = isset($start) ? $start : strtotime(date('Y').'-'.date('m').'-01'.' '.date('h').':'.date('i').':00');
		$end = isset($end) ? $end : strtotime(date('Y').'-'.date('m').'-'.date('d').' '.date('h').':'.date('i').':59');

		if ($start >= $end)
		{
			return null;
		}

		$switch = $this->find($switch_id, $device_id);

		if (empty($switch) || !$switch->getType()->isNetworkDistribution())
		{
			return null;
		}

		$port = $switch->getPort($port_id);

		if (empty($port) || !$port->isBandwidthGraphAvailable())
		{
			return null;
		}

		$url = $this->createObjectUrl($switch_id, $device_id) . '/graphs/' . urlencode($port_id);
		$data = array(
			'start' => date('c', $start),
			'end' => date('c', $end)
		);

		$response = $this->sendRequest($url, 'GET', $data);

		if (empty($response) || $response->getContentType() != 'image/png')
		{
			return null;
		}

		return $response->getContent();
	}

	/**
	 * Retrieves the Bandwidth Usage of the provided Port on the provided Switch
	 * that is assigned to the provided Device.
	 * @param  int $switch_id 		The Switch Id
	 * @param  int $port_id   		The Port Id
	 * @param  int $device_id 		The Device Id
	 * @return ColoCrossing_Object	The Bandwidth Usage
	 */
	public function getBandwidthUsage($switch_id, $port_id, $device_id, $start = null, $end = null)
	{
		$switch = $this->find($switch_id, $device_id);

		if (empty($switch) || !$switch->getType()->isNetworkDistribution())
		{
			return null;
		}

		$port = $switch->getPort($port_id);

		if (empty($port) || !$port->isBandwidthUsageAvailable())
		{
			return null;
		}

		$url = $this->createObjectUrl($switch_id, $device_id) . '/bandwidths/' . urlencode($port_id);

		$response = $this->sendRequest($url);

		if (empty($response))
		{
			return null;
		}

		$content = $response->getContent();
		$content = isset($content) && isset($content['bandwidth']) && is_array($content['bandwidth']) ? $content['bandwidth'] : null;

		if (empty($content))
		{
			return null;
		}

		return ColoCrossing_Object_Factory::createObject($this->getClient(), null, $content, 'bandwidth_usage');
	}

	/**
	 * Set the status of the provided port on the provided switch that
	 * is connected to the provided device.
	 * @param  int 		$switch_id  The Id of Switch the Port is on
	 * @param  int 		$port_id   	The Id of the Port to control
	 * @param  int 		$device_id 	The Id of the Device the Port is assigned to
	 * @param  string 	$status    	The new Port status. 'on' or 'off'
	 * @return boolean  		   	True if succeeds, false otherwise.
	 */
	public function setPortStatus($switch_id, $port_id, $device_id, $status)
	{
		$status = strtolower($status);

		if ($status != 'on' && $status != 'off')
		{
			return false;
		}

		$switch = $this->find($switch_id, $device_id);

		if (empty($switch) || !$switch->getType()->isNetworkDistribution())
		{
			return false;
		}

		$port = $switch->getPort($port_id);

		if (empty($port) || !$port->isControllable())
		{
			return false;
		}

		$url = $this->createObjectUrl($switch_id, $device_id);
		$data = array(
			'status' => $status,
			'port_id' => $port_id
		);

		$response = $this->sendRequest($url, 'PUT', $data);

		if (empty($response))
		{
			return false;
		}

		$content = $response->getContent();

		return isset($content) && isset($content['status']) && $content['status'] == 'ok';
	}

}
