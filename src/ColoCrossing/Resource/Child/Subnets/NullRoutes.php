<?php

/**
 * Handles retrieving data from the API's subnet null routes sub-resource
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Resource
 * @subpackage ColoCrossing_Resource_Child_Subnets
 */
class ColoCrossing_Resource_Child_Subnets_NullRoutes extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->subnets, $client, 'null_route', '/null-routes');
	}

	public function findAllByIpAddress($parent_id, $ip_address, array $options = null)
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
