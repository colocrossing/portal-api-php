<?php

class ColoCrossing_Resource_Object extends ColoCrossing_Object
{

	private $resource;

	public function __construct(ColoCrossing_Resource $resource = null, array $values = array())
	{
		parent::__construct($values);
		$this->resource = $resource;
	}

	public function getResource()
	{
		return $this->resource;
	}

}
