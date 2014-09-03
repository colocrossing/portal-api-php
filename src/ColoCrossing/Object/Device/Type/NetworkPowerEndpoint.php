<?php

class ColoCrossing_Object_Device_Type_NetworkPowerEndpoint extends ColoCrossing_Object_Device_Type_Racked
{

	public function getSubnets(array $options = null)
	{
		return $this->getResourceChildCollection('subnets', $options);
	}

	public function getSubnet($id)
	{
		return $this->getResourceChildObject('subnets', $id);
	}

	public function getSwitches(array $options = null)
	{
		return $this->getResourceChildCollection('switches', $options);
	}

	public function getSwitch($id)
	{
		return $this->getResourceChildObject('switches', $id);
	}

	public function getPowerDistributionUnits(array $options = null)
	{
		return $this->getResourceChildCollection('pdus', $options);
	}

	public function getPowerDistributionUnit($id)
	{
		return $this->getResourceChildObject('pdus', $id);
	}

}
