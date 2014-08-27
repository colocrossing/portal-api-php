<?php

class ColoCrossing_Http_Response
{
	private $headers;

	private $body;

	private $content;

	private $code;

	public function __construct($response, $code = 200)
	{
		$this->setCode($code);

		$header_size = strpos($response, "\r\n\r\n");
		$this->setHeaders($response, $header_size);
		$this->setBody($response, $header_size);

		$this->setContent();
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function getHeader($key)
	{
		return isset($this->headers[$key]) ? $this->headers[$key] : false;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getCode()
	{
		return $this->code;
	}

	private function setHeaders($response, $header_size)
	{
		$header = substr($response, 0, $header_size);

		$this->headers = array();
		foreach (explode("\r\n", $header) as $i => $line)
		{
			if($i > 0)
			{
				list($key, $value) = explode(': ', $line);
				$this->headers[$key] = $value;
			}
		}
	}

	private function setBody($response, $header_size)
	{
		$this->body = substr($response, $header_size);
	}

	private function setContent()
	{
		$content_type = isset($this->headers['Content-Type']) ? $this->headers['Content-Type'] : '';
		switch ($content_type) {
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
				$this->content = imagecreatefromstring($this->body);
				break;
			case 'application/json':
				$this->content = json_decode($this->body, true);
				if(isset($this->content) && isset($this->content['status']) && $this->content['status'] == 'error')
				{
					$this->throwError();
				}
				break;
			default:
				$this->content = null;
				break;
		}
	}

	private function setCode($code)
	{
		$this->code = $code;
	}

	private function throwError()
	{
		switch ($this->content['type']) {
			case 'api_token_missing':
			case 'unauthorized':
			case 'inactive':
				throw new ColoCrossing_Error_Authorization($this->code, $this->content);
				break;
			case 'missing_resource':
				throw new ColoCrossing_Error_NotFound($this->content);
				break;
			default:
				throw new ColoCrossing_Error_Api($this->code, $this->content);
				break;
		}
	}

}
