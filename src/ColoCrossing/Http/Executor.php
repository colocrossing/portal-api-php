<?php

class ColoCrossing_Http_Executor
{
	private $curl;

	public function __construct(ColoCrossing_Client $client)
	{
		$this->client = $client;
	}

	public function executeRequest(ColoCrossing_Http_Request $request)
	{
		$this->createCurl();
		$this->setCurlRequestOptions($request);
		$this->executeCurl();
		$this->destroyCurl();
	}

	private function createCurl()
	{
		if(isset($this->curl))
		{
			$this->destroyCurl();
		}

		$this->curl = curl_init();

    	curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, true);
    	curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($this->curl, CURLOPT_HEADER, true);

		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $this->client->getOption('follow_redirects'));
    	curl_setopt($curl, CURLOPT_USERAGENT, $this->client->getOption('application_name') . '/' . $client->getVersion());
    	curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->client->getOption('request_timeout'));
    	curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->client->getOption('request_timeout'));

    	return $this->curl;
	}

	private function getCurl()
	{
		if(empty($this->curl))
		{
			return $this->createCurl();
		}

		return $this->curl;
	}

	private function setCurlRequestOptions(ColoCrossing_Http_Request $request)
	{
		$this->setCurlHeaders($request->getHeaders());

		$curl = $this->getCurl();
		curl_setopt($curl, CURLOPT_URL, $request->getUrl());
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
	}

	private function setCurlHeaders(array $headers = array())
	{
		$curl = $this->getCurl();
	    $curl_headers = array();

	    foreach ($headers as $key => $value) {
	        $curl_headers[] = "$key: $value";
	    }

	    curl_setopt($curl, CURLOPT_HTTPHEADER, $curl_headers);
	}

	private function executeCurl()
	{
		$curl = $this->getCurl();
		$response = curl_exec($curl);
	}

	private function destroyCurl()
	{
		if(isset($this->curl))
		{
			return false;
		}

		curl_close($this->curl);
		$this->curl = null;
	}
}