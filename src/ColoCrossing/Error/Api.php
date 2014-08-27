<?php

class ColoCrossing_Error_Api extends ColoCrossing_Error
{

	private $status;

	public function __construct($status = 500, array $content = array(), $message = null)
	{
		parent::__construct((isset($message) ? $message : 'ColoCrossing API Error') . ' - ' . $content['message'], $content['type']);

		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}

}
