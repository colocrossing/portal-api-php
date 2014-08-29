<?php

class ColoCrossing_Object_Device_Switch extends ColoCrossing_Resource_Object
{

	public function getPorts()
	{
		return $this->getObjectArray('ports', null, 'network_port', array());
	}

}
