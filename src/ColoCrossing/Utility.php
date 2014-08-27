<?php

class ColoCrossing_Utility
{

	public static function convertCamelCaseToSnakeCase($string)
	{
		$string = preg_replace('/(?<=\\w)(?=[A-Z])/', "_$1", $string);
		return strtolower($string);
	}

}
