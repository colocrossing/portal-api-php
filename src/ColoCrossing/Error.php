<?php

class ColoCrossing_Error extends Exception
{

	private $type;

	public function __construct($message, $type = 'server_error')
	{
		parent::__construct($message);

		$this->type = $type;
	}

	public function getType()
	{
		return $this->type;
	}

}
