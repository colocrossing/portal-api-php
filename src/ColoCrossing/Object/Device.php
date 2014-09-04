<?php

class ColoCrossing_Object_Device extends ColoCrossing_Resource_Object
{

	public function getType()
	{
		return $this->getObject('type', null, 'type');
	}

	public function getOwner()
	{
		return $this->getObject('owner');
	}

	public function getSubusers()
	{
		return $this->getObjectArray('subusers');
	}

	public function getSubuser($id)
	{
		$subusers = $this->getSubusers();

		return ColoCrossing_Utility::getObjectFromCollectionById($subusers, $id);
	}

	public function getAssets(array $options = null)
	{
		return $this->getResourceChildCollection('assets', $options);
	}

	public function getAsset($id)
	{
		return $this->getResourceChildObject('assets', $id);
	}

	public function getNotes(array $options = null)
	{
		return $this->getResourceChildCollection('notes', $options);
	}

	public function getNote($id)
	{
		return $this->getResourceChildObject('notes', $id);
	}

}
