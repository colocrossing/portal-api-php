<?php

class ColoCrossing_Http_Executor
{

	private $curl;

	private $client;

	public function __construct(ColoCrossing_Client $client)
	{
		$this->client = $client;
	}

	public function executeRequest(ColoCrossing_Http_Request $request)
	{
		$this->createCurl();
		$this->setCurlRequestOptions($request);
		$response = $this->executeCurl();
		$this->destroyCurl();

		return $response;
	}

	private function createCurl()
	{
		if(isset($this->curl))
		{
			$this->destroyCurl();
		}

		$this->curl = curl_init();

		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, $this->client->getOption('ssl_verify') ? 2 : 0);
    	curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $this->client->getOption('ssl_verify'));
    	curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($this->curl, CURLOPT_HEADER, false);

		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $this->client->getOption('follow_redirects'));
    	curl_setopt($this->curl, CURLOPT_USERAGENT, $this->client->getOption('application_name') . '/' . $this->client->getVersion());
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
		curl_setopt($curl, CURLOPT_URL, $this->client->getBaseUrl() . $request->getUrl());
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());

        $request_data = $request->getData();
        if(count($request_data))
        {
        	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($request_data));
        }
	}

	private function setCurlHeaders(array $headers = array())
	{
		$headers['X-API-Token'] = $this->client->getAPIToken();

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

		$body = curl_exec($curl);
		if(is_bool($body) && !$body)
		{
			throw new ColoCrossing_Error('Unable to make connection to ColoCrossing API.');
		}

		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

		return new ColoCrossing_Http_Response($body, $code, $content_type);
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
