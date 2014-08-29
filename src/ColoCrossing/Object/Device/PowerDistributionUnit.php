<?php

class ColoCrossing_Object_Device_PowerDistributionUnit extends ColoCrossing_Resource_Object
{

	public function getPorts()
	{
		return $this->getObjectArray('ports', null, 'power_port', array());
	}

}
