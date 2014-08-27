<?php

class ColoCrossing_Object_Subnet extends ColoCrossing_Object
{
	public function getDevice()
	{
		return 'Device #' . $this->getValue('device')['id'];
	}
}
