<?php

class ColoCrossing_Error_Api extends ColoCrossing_Error
{

	private $status;

	private $type;

	public function __construct($status = 500, array $content = array(), $message = null)
	{
		parent::__construct((isset($message) ? $message : 'ColoCrossing API Error') . ' - ' . $content['message']);

		$this->status = $status;
		$this->type = $content['type'];
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getType()
	{
		return $this->content;
	}

}
