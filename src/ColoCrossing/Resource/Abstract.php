<?php

abstract class ColoCrossing_Resource_Abstract implements ColoCrossing_Resource
{

	private $client;

	private $name;

	private $url;

	private $child_resources;

	public function __construct(ColoCrossing_Client $client, $name, $url)
	{
		$this->client = $client;
		$this->url = $url;

		$this->child_resources = array();

		$this->setName($name);
	}

	public function getClient()
	{
		return $this->client;
	}

	public function getName($plural = false)
	{
		return $this->name[$plural ? 'plural' : 'singular'];
	}

	public function getURL()
	{
		return $this->url;
	}

	public function __get($child_name)
	{
		$parent_name = $this->getName(true);
		$available_child_resources = ColoCrossing_Resource_Child_Factory::getAvailableChildResources($parent_name);

		if (isset($available_child_resources) && isset($available_child_resources[$child_name]))
		{
			if (empty($this->child_resources[$child_name]))
			{
				$this->child_resources[$child_name] = ColoCrossing_Resource_Child_Factory::createChildResource($parent_name, $child_name, $this->client);
			}

			return $this->child_resources[$child_name];
		}
	}

	public function findAll(array $options = null)
	{
		$options = $this->createCollectionOptions($options);
		$url = $this->createCollectionUrl();

		return new ColoCrossing_Collection($this, $url, $options['page_number'], $options['page_size'], $options['sort'], $options['filters']);
	}

	public function find($id)
	{
		$url = $this->createObjectUrl($id);

		return $this->fetch($url);
	}

	public function fetchAll($url, array $options = null)
	{
		$options = $this->createCollectionOptions($options);

		$request = $this->createRequest($url);

		$query_params = array(
			'page' => $options['page_number'],
			'limit' => $options['page_size'],
			'sort' => implode($options['sort'], ',')
		);
		foreach ($options['filters'] as $filter => $value)
		{
			$query_params[$filter] = $value;
		}
		$request->setQueryParams($query_params);

		$response = $this->executeRequest($request);
		$content = $this->getResponseContent($response, true);

		if (empty($content))
		{
			return array();
		}

		return ColoCrossing_Object_Factory::createObjectArray($this->client, $this, $content);
	}

	public function fetch($url)
	{
		$response = $this->sendRequest($url);
		$content = $this->getResponseContent($response, false);

		if (empty($content))
		{
			return null;
		}

		return ColoCrossing_Object_Factory::createObject($this->client, $this, $content);
	}

	protected function createCollectionOptions(array $options = null)
	{
		$options = isset($options) && is_array($options) ? $options : array();

		$options['format'] = isset($options['format']) ? $options['format'] : 'collection';
		$options['filters'] = isset($options['filters']) && is_array($options['filters']) ? $options['filters'] : array();
		$options['sort'] = isset($options['sort']) ? (is_array($options['sort']) ? $options['sort'] : array($options['sort']) ) : array();
		$options['page_number'] = isset($options['page_number']) ? max($options['page_number'], 1) : 1;
		$options['page_size'] = isset($options['page_size']) ? $options['page_size'] : $this->client->getOption('page_size');
		$options['page_size'] = max(min($options['page_size'], 100), 1);

		return $options;
	}

	protected function createCollectionUrl()
	{
		return $this->url;
	}

	protected function createObjectUrl($id)
	{
		return $this->url . '/' . urlencode($id);
	}

	protected function sendRequest($url, $method = 'GET', $data = array())
	{
		$request = $this->createRequest($url, $method, $data);
		return $this->executeRequest($request);
	}

	protected function createRequest($url, $method = 'GET', $data = array())
	{
		return new ColoCrossing_Http_Request($url, $method, $data);
	}

	protected function executeRequest(ColoCrossing_Http_Request $request)
	{
		try
		{
			$executor = $this->client->getHttpExecutor();
			return $executor->executeRequest($request);
		}
		catch(ColoCrossing_Error_NotFound $e)
		{
			return null;
		}
	}

	protected function getResponseContent(ColoCrossing_Http_Response $response = null, $is_collection = false)
	{
		if (empty($response))
		{
			return null;
		}

		$content = $response->getContent();
		$name = $this->getName($is_collection);

		return isset($content) && isset($content[$name]) && is_array($content[$name]) ? $content[$name] : null;
	}

	private function setName($name)
	{
		if (is_array($name))
		{
			$this->name = $name;
		}
		else
		{
			$this->name = array(
				'singular' => $name,
				'plural' => $name . 's'
			);
		}
	}

}
