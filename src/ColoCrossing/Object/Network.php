<?php

class ColoCrossing_Object_Network extends ColoCrossing_Resource_Object
{

	public function getSubnets(array $options = null)
	{
		return $this->getResourceChildCollection('subnets', $options);
	}

	public function getNullRoutes(array $options = null)
	{
		return $this->getResourceChildCollection('null_routes', $options);
	}

}
