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

}
