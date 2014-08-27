<?php

class ColoCrossing_Error_NotFound extends ColoCrossing_Error_Api
{

	public function __construct(array $content = array())
	{
		parent::__construct(404, $content, 'ColoCrossing API Resource Not Found Error');
	}

}
