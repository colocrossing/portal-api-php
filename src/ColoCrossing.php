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

require_once(dirname(__FILE__) . '/ColoCrossing/Client.php');