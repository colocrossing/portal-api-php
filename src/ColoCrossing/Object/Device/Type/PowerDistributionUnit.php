<?php

class ColoCrossing_Object_Device_Type_PowerDistributionUnit extends ColoCrossing_Object_Device_Type_Racked
{

	public function getSubnets(array $options = null)
	{
		return $this->getResourceChildCollection('subnets', $options);
	}

	public function getSwitches(array $options = null)
	{
		return $this->getResourceChildCollection('switches', $options);
	}

	public function getPorts()
	{
		return $this->getObjectArray('ports', null, 'power_port', array());
	}

}
