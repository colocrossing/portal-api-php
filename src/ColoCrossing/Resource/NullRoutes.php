<?php

class ColoCrossing_Resource_NullRoutes extends ColoCrossing_Resource_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client, 'null_route', '/null-routes');
	}

	public function findAllByIpAddress($ip_address, array $options = null)
	{
		if(filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
		{
			$options = isset($options) && is_array($options) ? $options : array();
			$options['filters'] = array(
				'ip_address' => $ip_address
			);
		}

		return $this->findAll($options);
	}

	public function add($subnet_id, $ip_address, $comment = '', $expire_date = null)
	{
		$client = $this->getClient();
		$subnet = $client->subnets->find($subnet_id);

		if(empty($subnet) || !$subnet->isIpAddressInSubnet($ip_address))
		{
			return false;
		}

		$data = array(
			'subnet_id' => $subnet_id,
			'ip_address' => $ip_address,
			'comment' => $comment
		);

		if(isset($expire_date) && is_int($expire_date))
		{
			$data['expire_date'] = $expire_date;
			if($expire_date > strtotime("+30 days"))
			{
				return false;
			}
		}

		$null_routes = $this->findAllByIpAddress($ip_address);

		foreach ($null_routes as $key => $null_route)
		{
			$subnet = $null_route->getSubnet();

			if(isset($subnet) && $subnet->getId() == $subnet_id)
			{
				return false;
			}
		}

		$url = $this->createCollectionUrl();

		$response = $this->sendRequest($url, 'POST', $data);

		if(empty($response))
		{
			return null;
		}

		$content = $response->getContent();

		if(empty($content) || empty($content['status']) || $content['status'] == 'error' || empty($content['null_route']) || empty($content['null_route']['id']))
		{
			return null;
		}

		return $this->find($content['null_route']['id']);
	}

	public function remove($id)
	{
		$null_route = $this->find($id);

		if(empty($null_route) || !$null_route->isRemovable())
		{
			return false;
		}

		$url = $this->createObjectUrl($id);

		$response = $this->sendRequest($url, 'DELETE');

		if(empty($response))
		{
			return false;
		}

		$content = $response->getContent();

		return isset($content) && isset($content['status']) && $content['status'] == 'ok';
	}

}
