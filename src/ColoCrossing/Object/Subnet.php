<?php

class ColoCrossing_Object_Subnet extends ColoCrossing_Resource_Object
{

	public function getNetwork()
	{
		$client = $this->getClient();
		$network = $this->getValue('network');

		if(empty($network) || !is_array($network))
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

	public function getReverseDNSRecords(array $options = null)
	{
		if(!$this->isReverseDnsEnabled())
		{
			return null;
		}

		return $this->getResourceChildCollection('rdns_records', $options);
	}

	public function getIpAddresses()
	{
		$start_ip = $this->getIpAddress();
		$ip_parts = split('\.', $start_ip);
		$last_ip_part = intval(array_pop($ip_parts));
		$ip_prefix = implode('.', $ip_parts);

		$cidr = intval($this->getCidr());
		$num_ips = pow(2, 32 - $cidr);

		$ips = array();
		for ($i = 0; $i < $num_ips; $i++)
		{
			$ip_suffix = $last_ip_part + $i;
			$ips[] = $ip_prefix . '.' . $ip_suffix;
		}
		return $ips;
	}

}
