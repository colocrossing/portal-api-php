<?php

class ColoCrossing_Object_Device extends ColoCrossing_Resource_Object
{

	public function getType()
	{
		return $this->getObject('type');
	}

	public function getOwner()
	{
		return $this->getObject('owner');
	}

	public function getSubusers()
	{
		return $this->getObjectArray('subusers');
	}

	public function getAssets(array $options = null)
	{
		return $this->getResourceChildCollection('assets', $options);
	}

	public function getNotes(array $options = null)
	{
		return $this->getResourceChildCollection('notes', $options);
	}

}
