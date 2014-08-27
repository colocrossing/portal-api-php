<?php

//Verify the Needed Extensions Are Available
if (!function_exists('curl_init'))
{
  throw new Exception('ColoCrossing API Client needs the CURL PHP extension.');
}

if (!function_exists('json_decode'))
{
  throw new Exception('ColoCrossing API Client needs the JSON PHP extension.');
}

//Include Client Class
require_once(dirname(__FILE__) . '/ColoCrossing/Client.php');

//Include Http Package
require_once(dirname(__FILE__) . '/ColoCrossing/Http/Request.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Http/Executor.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Http/Response.php');

//Include Collection Class
require_once(dirname(__FILE__) . '/ColoCrossing/Collection.php');

//Include Resources Package
require_once(dirname(__FILE__) . '/ColoCrossing/Resource.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Resource/Abstract.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Resource/Devices.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Resource/Subnets.php');

//Include Objects Package
require_once(dirname(__FILE__) . '/ColoCrossing/Object.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Object/Factory.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Object/Device.php');

//Include Errors Package
require_once(dirname(__FILE__) . '/ColoCrossing/Error.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Error/Api.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Error/Authorization.php');
require_once(dirname(__FILE__) . '/ColoCrossing/Error/NotFound.php');

//Include Utility Class
require_once(dirname(__FILE__) . '/ColoCrossing/Utility.php');
