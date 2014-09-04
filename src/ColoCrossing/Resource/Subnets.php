<?php

class ColoCrossing_Resource_Subnets extends ColoCrossing_Resource_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client, 'subnet', '/subnets');
	}

	public function findAllLikeIpAddress($ip_address, array $options = null)
	{
		if(!filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
		{
			return array();
		}

		$options = isset($options) && is_array($options) ? $options : array();
		$options['filters'] = array(
			'ip_address' => $ip_address
		);

		return $this->findAll($options);
	}

}
