<?php

abstract class ColoCrossing_Resource_Abstract implements ColoCrossing_Resource
{

	private $client;

	private $name;

	private $url;

	public function __construct(ColoCrossing_Client $client, $name, $url)
	{
		$this->client = $client;
		$this->url = $url;

		$this->setName($name);
	}

	public function findAll($options = null)
	{
		$options = isset($options) && is_array($options) ? $options : array();

		$format = isset($options['format']) ? $options['format'] : 'collection';
		$sort = isset($options['sort']) ? (is_array($options['sort']) ? $options['sort'] : array($options['sort']) ) : array();
		$page_number = isset($options['page_number']) ? max($options['page_number'], 1) : 1;
		$page_size = isset($options['page_size']) ? $options['page_size'] : $this->client->getOption('page_size');
		$page_size = max(min($page_size, 100), 1);

		if($format == 'collection')
		{
			return new ColoCrossing_Collection($this, $page_number, $page_size, $sort);
		}

		$request = $this->createRequest($this->getURL());
		$request->setQueryParams(array('page' => $page_number, 'limit' => $page_size, 'sort' => implode($sort, ',')));
		$response = $this->executeRequest($request);

		$content = $response->getContent();
		$name = $this->getName(true);

		if(empty($content) || empty($content[$name]))
		{
			return array();
		}

		return ColoCrossing_Object_Factory::createObjectArray($this->getName(), $content[$name]);
	}

	public function find($id)
	{
		$url = $this->getURL() . '/' . urlencode($id);
		$response = $this->sendRequest($url);
		$content = $response->getContent();
		$name = $this->getName();

		if(empty($content) || empty($content[$name]))
		{
			return null;
		}

		return ColoCrossing_Object_Factory::createObject($name, $content[$name]);
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
		$executor = $this->client->getHttpExecutor();
		return $executor->executeRequest($request);
	}

	private function setName($name)
	{
		if(is_array($name))
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
