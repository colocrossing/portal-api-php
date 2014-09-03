<?php

class ColoCrossing_Utility
{

	public static function convertCamelCaseToSnakeCase($string)
	{
		$string = preg_replace('/(?<=\\w)(?=[A-Z])/', "_$1", $string);
		return strtolower($string);
	}

	public static function getObjectFromCollectionById($objects, $id)
	{
		foreach ($objects as $key => $object)
		{
			if($object->getId() == $id)
			{
				return $object;
			}
		}

		return null;
	}

}
