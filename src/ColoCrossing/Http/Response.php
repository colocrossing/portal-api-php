<?php

class ColoCrossing_Http_Response
{
	private $body;

	private $content;

	private $content_type;

	private $code;

	public function __construct($body, $code = 200, $content_type = null)
	{
		$this->setBody($body);
		$this->setCode($code);
		$this->setContentType($content_type);

		$this->setContent();
	}

	public function getBody()
	{
		return $this->body;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getContentType()
	{
		return $this->content_type;
	}

	private function setBody($body)
	{
		$this->body = $body;
	}

	private function setCode($code)
	{
		$this->code = $code;
	}

	private function setContentType($content_type)
	{
		$this->content_type = $content_type;
	}

	private function setContent()
	{
		switch ($this->getContentType()) {
			case 'image/jpeg':
			case 'image/png':
			case 'image/gif':
				$this->content = imagecreatefromstring($this->body);

				if(is_bool($this->content) && !$this->content)
				{
					throw new ColoCrossing_Error('ColoCrossing API Error - Image is corrupt or in an unsupported format.');
				}
				break;
			case 'application/json':
				$this->content = json_decode($this->body, true);

				if(isset($this->content) && isset($this->content['status']) && $this->content['status'] == 'error')
				{
					$this->throwAPIError();
				}
				break;
			default:
				$this->content = null;
				break;
		}
	}

	private function throwAPIError()
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
