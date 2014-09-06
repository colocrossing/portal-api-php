<?php

/**
 * Responsible for managing all Interactions with the ColoCrossing API
 * @category   ColoCrossing
 */
class ColoCrossing_Client
{

	/**
	 * The Version of this Library
	 */
	const VERSION = '1.0.1';

	/**
	 * The Default Options
	 * @var array
	 */
	private static $DEFAULT_OPTIONS = array(
		'application_name' => 'ColoCrossing PHP API Client',
		'api_url' => 'https://portal.matt/api/',
		'api_version' => 1,
		'request_timeout' => 60,
		'follow_redirects' => false,
		'ssl_verify' => true,
		'page_size' => 30
	);

	/**
	 * The resources loaded in this client.
	 * @var array<ColoCrossing_Resource>
	 */
	private $resources;

	/**
	 * The API Token.
	 * @var string
	 */
	private $api_token;

	/**
	 * The Options for this.
	 * @var array
	 */
	private $options = array();

	/**
	 * The executor of HTTP Requests
	 * @var ColoCrossing_Http_Executor
	 */
	private $http_executor;

	/**
	 * @param string $api_token The api token.
	 * @param array  $options   The Options to overide.
	 */
	public function __construct($api_token = null, $options = array())
	{
		$this->setAPIToken($api_token);

		if(empty($this->api_token))
		{
			$this->setAPIToken(getenv('COLOCROSSING_API_TOKEN'));
		}

		$this->setOptions($options);

		$this->resources = array();
	}

	/**
	 * @param string $api_token The API Token for authentication.
	 */
	public function setAPIToken($api_token)
	{
		$this->api_token = $api_token;
	}

	/**
	 * @return string The API Token.
	 */
	public function getAPIToken()
	{
		return $this->api_token;
	}

	/**
	 * @param array $options The Options.
	 */
	public function setOptions(array $options)
	{
		$this->options = array_merge(self::$DEFAULT_OPTIONS, $options);
	}

	/**
	 * @return array The Options.
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * @param string 		$key   The Individual Option to Set.
	 * @param string|int 	$value The value of the Option.
	 */
	public function setOption($key, $value)
	{
		$this->options[$key] = $value;
	}

	/**
	 * @param  string $key The key of the option.
	 * @return string|int  The Value of the option. False if Option not found.
	 */
	public function getOption($key)
	{
		return isset($this->options[$key]) ? $this->options[$key] : false;
	}


	/**
	 * Retrieves the Executor of HTTP Requests. If not exists, then it creates it.
	 * @return ColoCrossing_Http_Executor The Request Executor.
	 */
	public function getHttpExecutor()
	{
		if(empty($this->http_executor))
		{
			$this->http_executor = new ColoCrossing_Http_Executor($this);
		}

		return $this->http_executor;
	}

	/**
	 * @return string The version of the API
	 */
	public function getVersion()
	{
		return self::VERSION;
	}

	/**
	 * @return string The Root Url of the API with the version on it.
	 */
	public function getBaseUrl()
	{
		return $this->getOption('api_url') . 'v' . $this->getOption('api_version');
	}

	/**
	 * Retrieves a Resource if it is available. If the resource is available, but has not 
	 * been created yet, then the resource is created and returned. Otherwise the already 
	 * existing resource is returned.
	 *
	 * Resources that are available are devices, networks, null_routes and subnets.
	 * @param  string 		$name 		The name of the resource requested.		
	 * @return ColoCrossing_Resource 	The resource
	 */
	public function getResource($name)
	{
		$available_resources = ColoCrossing_Resource_Factory::getAvailableResources();
		
		if(empty($available_resources[$name]))
		{
			return null;
		}

		if(empty($this->resources[$name]))
		{
			$this->resources[$name] = ColoCrossing_Resource_Factory::createResource($name, $this);
		}

		return $this->resources[$name];
	}

	/**
	 * Handles Magic Loading of Resources
	 * @param  string $name 			The function called.
	 * @return ColoCrossing_Resource    The resource.
	 */
	public function __get($name)
	{
		$available_resources = ColoCrossing_Resource_Factory::getAvailableResources();
		
		if(isset($available_resources[$name]))
		{
			return $this->getResource($name);
		}
	}
}
