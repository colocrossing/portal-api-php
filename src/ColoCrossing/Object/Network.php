<?php

/**
 * Represents an instance of a Network resource from the API.
 * Holds data for a Network and provides methods to retrive
 * objects related to the subnet such as its Subnets or Null Routes.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 */
class ColoCrossing_Object_Network extends ColoCrossing_Resource_Object
{

	public function getSubnets(array $options = null)
	{
		return $this->getResourceChildCollection('subnets', $options);
	}

	public function getSubnet($id)
	{
		return $this->getResourceChildObject('subnets', $id);
	}

	public function getSubnetByIpAddress($ip_address)
	{
		$client = $this->getClient();
		$subnets = $client->networks->subnets->findAllLikeIpAddress($this->getId(), $ip_address, array('page_size' => 100));

		foreach ($subnets as $key => $subnet)
		{
			if ($subnet->isIpAddressInSubnet($ip_address))
			{
				return $subnet;
			}
		}

		return null;
	}

	public function getNullRoutes(array $options = null)
	{
		return $this->getResourceChildCollection('null_routes', $options);
	}

	public function getNullRoutesByIpAddress($ip_address, array $options = null)
	{
		$client = $this->getClient();

		return $client->networks->null_routes->findAllByIpAddress($this->getId(), $ip_address, $options);
	}

	public function getNullRoute($id)
	{
		$null_routes = $this->getNullRoutes();

		return ColoCrossing_Utility::getObjectFromCollectionById($null_routes, $id);
	}

	public function getNumberOfIpAddresses()
	{
		$cidr = intval($this->getCidr());
		return pow(2, 32 - $cidr);
	}

}
