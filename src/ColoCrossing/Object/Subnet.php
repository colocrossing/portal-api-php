<?php

/**
 * Represents an instance of a Subnet resource from the API.
 * Holds data for a Subnet and provides methods to retrive
 * objects related to the subnet such as its Network, Device,
 * Null Routes, or Reverse DNS Records.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 */
class ColoCrossing_Object_Subnet extends ColoCrossing_Resource_Object
{

	public function getNetwork()
	{
		$client = $this->getClient();
		$network = $this->getValue('network');

		if (empty($network) || !is_array($network))
		{
			return null;
		}

		$resource = isset($network['owner']) && is_array($network['owner']) ? $client->networks : null;

		return $this->getObject('network', $resource);
	}

	public function getDevice()
	{
		$client = $this->getClient();

		return $this->getObject('device', $client->devices);
	}

	public function getNullRoutes(array $options = null)
	{
		return $this->getResourceChildCollection('null_routes', $options);
	}

	public function getNullRoutesByIpAddress($ip_address, array $options = null)
	{
		$client = $this->getClient();

		return $client->subnets->null_routes->findAllByIpAddress($this->getId(), $ip_address, $options);
	}

	public function getNullRoute($id)
	{
		$null_routes = $this->getNullRoutes();

		return ColoCrossing_Utility::getObjectFromCollectionById($null_routes, $id);
	}

	public function addNullRoute($ip_address, $comment = '', $expire_date = null)
	{
		$client = $this->getClient();

		return $client->null_routes->add($this->getId(), $ip_address, $comment, $expire_date);
	}

	public function getReverseDNSRecords(array $options = null)
	{
		if (!$this->isReverseDnsEnabled())
		{
			return array();
		}

		return $this->getResourceChildCollection('rdns_records', $options);
	}

	public function getReverseDNSRecord($id)
	{
		if (!$this->isReverseDnsEnabled())
		{
			return null;
		}

		return $this->getResourceChildObject('rdns_records', $id);
	}

	public function updateReverseDNSRecords(array $rdns_records)
	{
		$resource = $this->getResource();

		return $resource->rdns_records->updateAll($this->getId(), $rdns_records);
	}


	public function getNumberOfIpAddresses()
	{
		$cidr = intval($this->getCidr());
		return pow(2, 32 - $cidr);
	}

	public function getIpAddresses()
	{
		$start_ip = $this->getIpAddress();
		$ip_parts = split('\.', $start_ip);
		$last_ip_part = intval(array_pop($ip_parts));
		$ip_prefix = implode('.', $ip_parts);

		$num_ips = $this->getNumberOfIpAddresses();
		$ips = array();

		for ($i = 0; $i < $num_ips; $i++)
		{
			$ip_suffix = $last_ip_part + $i;
			$ips[] = $ip_prefix . '.' . $ip_suffix;
		}

		return $ips;
	}

	public function isIpAddressInSubnet($ip_address)
	{
        $start_ip = ip2long($this->getIpAddress());
        $end_ip = $start_ip + $this->getNumberOfIpAddresses() - 1;

        $ip_address = ip2long($ip_address);

        return $start_ip <= $ip_address && $end_ip >= $ip_address;
	}

}
