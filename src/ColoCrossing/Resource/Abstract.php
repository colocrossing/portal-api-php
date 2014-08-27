<?php

class ColoCrossing_Resource_Abstract
{

	private $client;

	public function __construct(ColoCrossing_Client $client)
	{
		$this->client = $client;
	}

	public function test()
	{
		$response = $this->sendRequest('/devices/100');

		var_dump($response->getContent());
	}

	public function getClient()
	{
		return $this->client;
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

}
