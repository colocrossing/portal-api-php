<?php

class ColoCrossing_Client
{
	const VERSION = '1.0.0';

	private static $DEFAULT_OPTIONS = array(
		'application_name' => 'ColoCrossing PHP API Client',
		'api_url' => 'https://portal.matt/api/',
		'api_version' => 1,
		'request_timeout' => 60,
		'follow_redirects' => false,
		'ssl_verify' => true,
		'page_size' => 30
	);

	private $api_token;

	private $options = array();

	private $http_executor;

	public function __construct($api_token = null, $options = array())
	{
		$this->setAPIToken($api_token);

		if(empty($this->api_token))
		{
			$this->setAPIToken(getenv('COLOCROSSING_API_TOKEN'));
		}

		$this->setOptions($options);

		$this->devices = new ColoCrossing_Resource_Devices($this);
		$this->subnets = new ColoCrossing_Resource_Subnets($this);
	}

	public function setAPIToken($api_token)
	{
		$this->api_token = $api_token;
	}

	public function getAPIToken()
	{
		return $this->api_token;
	}

	public function setOptions(array $options)
	{
		$this->options = array_merge(self::$DEFAULT_OPTIONS, $options);
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
		return self::VERSION;
	}

	public function getBaseUrl()
	{
		return $this->getOption('api_url') . 'v' . $this->getOption('api_version');
	}
}
