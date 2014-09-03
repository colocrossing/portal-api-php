<?php

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
