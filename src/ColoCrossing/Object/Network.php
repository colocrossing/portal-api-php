<?php

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

	public function getNullRoutes(array $options = null)
	{
		return $this->getResourceChildCollection('null_routes', $options);
	}

	public function getNullRoute($id)
	{
		return $this->getResourceChildObject('null_routes', $id);
	}

	public function getNumberOfIpAddresses()
	{
		$cidr = intval($this->getCidr());
		return pow(2, 32 - $cidr);
	}

}
