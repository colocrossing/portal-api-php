<?php

/**
 * Handles retrieving data from the API's network subnets sub-resource
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Resource
 * @subpackage ColoCrossing_Resource_Child_Networks
 */
class ColoCrossing_Resource_Child_Networks_Subnets extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->networks, $client, 'subnet', '/subnets');
	}

	public function findAllLikeIpAddress($parent_id, $ip_address, array $options = null)
	{
		if (!filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
		{
			return array();
		}

		$options = isset($options) && is_array($options) ? $options : array();
		$options['filters'] = array(
			'ip_address' => $ip_address
		);

		return $this->findAll($parent_id, $options);
	}

}
