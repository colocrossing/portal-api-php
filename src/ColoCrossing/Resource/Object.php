<?php

class ColoCrossing_Resource_Object extends ColoCrossing_Object
{

	private $resource;

	public function __construct(ColoCrossing_Client $client, ColoCrossing_Resource $resource, array $values = array())
	{
		parent::__construct($client, $values);

		$this->resource = $resource;
	}

	public function getResource()
	{
		return $this->resource;
	}

}
