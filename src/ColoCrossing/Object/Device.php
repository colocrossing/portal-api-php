<?php

/**
 * Represents an instance of a Generic Base Device resource
 * that is owned by the user from the API. Holds data for a
 * Generic Base Device and provides methods to retrive
 * objects related to the device such as its Type, Owner,
 * Subusers, Assets, or Notes.
 *
 * In order to retrieve a device of this type, the device must
 * be assigned to you and not be a shared device. Trying to create
 * a shared device of this type will result in and Authorization_Error
 * to be thrown.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 */
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
