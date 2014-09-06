<?php

/**
 * An extension to the generic ColoCrossing_Object that adds support for
 * linking the Object to the resource it originated from.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Resource
 */
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

	protected function getResourceChildCollection($child_type, array $options = null)
	{
		$parent_id = $this->getId();
		$child_resource = $this->resource->$child_type;

		return $child_resource->findAll($parent_id, $options);
	}

	protected function getResourceChildObject($child_type, $child_id)
	{
		if (empty($child_id) || !is_numeric($child_id))
		{
			return null;
		}

		$parent_id = $this->getId();
		$child_resource = $this->resource->$child_type;

		return $child_resource->find($parent_id, $child_id);
	}

}
