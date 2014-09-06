<?php

/**
 * Represents an instance of a Device's Asset resource from the API.
 * Holds data for a Device's Asset and provides methods to retrive
 * objects related to the asset such as its Group.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 * @subpackage ColoCrossing_Object_Device
 */
class ColoCrossing_Object_Device_Asset extends ColoCrossing_Resource_Object
{

	public function getGroups()
	{
		return $this->getObjectArray('groups');
	}

	public function getGroup($id)
	{
		$groups = $this->getGroups();

		return ColoCrossing_Utility::getObjectFromCollectionById($groups, $id);
	}

}
