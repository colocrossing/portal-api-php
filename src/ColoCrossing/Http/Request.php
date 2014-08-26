<?php

class ColoCrossing_Http_Request
{
	private $url;

	private $method = 'GET';

	private $headers = array();

	private $queryParams = array();

	private $data = array();

	public function __construct($url, $method = 'GET', array $headers = array(), array $queryParams = array(), array $data = array())
	{
		$this->setUrl($url);

		$this->setMethod($method);
		$this->setHeaders($headers);

		$this->setQueryParams($getQueryParams);
		$this->setData($data);
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function getUrl()
	{
		return $this->url . $this->getQueryString();
	}

	public function setMethod($method)
	{
		$this->method = strtoupper($method);
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function setHeaders(array $headers)
	{
		$this->headers = $headers;
	}

	public function setHeader($key, $value)
	{
	    $this->headers[$key] = $value;
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function setQueryParams(array $queryParams)
	{
		$this->queryParams = $queryParams;
	}

	public function setQueryParam($key, $value)
	{
	    $this->queryParams[$key] = $value;
	}

	public function getQueryParams()
	{
		return $this->queryParams;
	}

	public function getQueryString()
	{
		return count($this->queryParams) ? '?' . $this->buildQuery($this->queryParams) : '';
	}

	public function setData(array $data)
	{
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}

	private function buildQuery($parts)
  	{
    	$pairs = array();
    	foreach ($parts as $key => $value)
    	{
      		if (is_array($value))
      		{
        		foreach ($value as $v)
        		{
          			$pairs[] = urlencode($key) . '=' . urlencode($v);
        		}
      		}
      		else
      		{
        		$pairs[] = urlencode($key) . '=' . urlencode($value);
      		}
    	}
    	return implode('&', $pairs);
  	}
}