<?php

require_once('ColoCrossing/Http/Executor.php');

class ColoCrossing_Client
{
	public const $VERSION = '1.0.0';

	private static $DEFAULT_OPTIONS = array(
		'application_name' => 'ColoCrossing PHP API Client'
		'resource_url' => 'https://portal.matt/api/',
		'version' => 1,
		'request_timeout' => 60,
		'follow_redirects' => false
	);

	private $api_token;

	private $options = array();

	private $http_executor;

	public function __construct($api_token = null, $options = array())
	{
		$this->setAPIToken($api_token);

		if(empty($this->api_token))
		{
			$this->setAPIToken(getenv('COLOCROSSING_API_TOKEN'))
		}

		$this->setOptions($options);
	}

	public function setAPIToken(array $api_token)
	{
		$this->api_token = $api_token;
	}

	public function getAPIToken()
	{
		return $this->api_token;
	}

	public function setOptions(array $options)
	{
		$this->options = array_merge($this->DEFAULT_OPTIONS, $options);
	}

	public function getOptions()
	{
		return $this->options;
	}

	public function setOption($key, $value)
	{
		$this->options[$key] = $value;
	}

	public function getOption($key)
	{
		return isset($this->options[$key]) ? $this->options[$key] : false;
	}

	public function getHttpExecutor()
	{
		if(empty($this->http_executor))
		{
			$this->http_executor = new ColoCrossing_Http_Executor($this);
		}
		return $this->http_executor;
	}

	public function getVersion()
	{
		return self::$VERSION;
	}
}