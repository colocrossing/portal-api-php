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

	public function getResourceChildCollection($child_type, array $options = null)
	{
		$parent_id = $this->getId();
		$child_resource = $this->resource->$child_type;

		return $child_resource->findAll($parent_id, $options);
	}

	public function getResourceChildObject($child_type, $child_id)
	{
		if(empty($child_id) || !is_numeric($child_id))
		{
			return null;
		}

		$parent_id = $this->getId();
		$child_resource = $this->resource->$child_type;

		return $child_resource->find($parent_id, $child_id);
	}

}
