<?php

class ColoCrossing_Error_Authorization extends ColoCrossing_Error_Api
{

	public function __construct($status = 403, array $content = array())
	{
		parent::__construct($status, $content, 'ColoCrossing API Authorization Error');
	}

}
