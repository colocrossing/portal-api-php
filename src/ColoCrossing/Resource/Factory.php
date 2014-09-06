<?php

class ColoCrossing_Resource_Factory
{

	private static $AVAILABLE_RESOURCES = array(
		'devices' => '/Devices.php',
		'networks' => '/Networks.php',
		'null_routes' => '/NullRoutes.php',
		'subnets' => '/Subnets.php'
	);

	public static function createResource($type, ColoCrossing_Client $client)
	{
		$available_resources = self::getAvailableResources();

		if (isset($available_resources[$type]))
		{
			require_once(dirname(__FILE__) . $available_resources[$type]);
		}

		switch ($type)
		{
			case 'devices':
				return new ColoCrossing_Resource_Devices($client);
			case 'networks':
				return new ColoCrossing_Resource_Networks($client);
			case 'null_routes':
				return new ColoCrossing_Resource_NullRoutes($client);
			case 'subnets':
				return new ColoCrossing_Resource_Subnets($client);
		}

		throw new ColoCrossing_Error('ColoCrossing API Resource not found.');
	}

	public static function getAvailableResources()
	{
		return self::$AVAILABLE_RESOURCES;
	}

}
