<?php

abstract class ColoCrossing_Resource_Abstract
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
		$url = $this->getURL();
		$response = $this->sendRequest($url);
		$content = $response->getContent();
		$name = $this->getName(true);

		if(empty($content) || empty($content[$name]))
		{
			return null;
		}

		return ColoCrossing_Object_Factory::createObjectCollection($name, $content[$name]);
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
