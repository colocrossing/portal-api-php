<?php

abstract class ColoCrossing_Resource_Child_Abstract extends ColoCrossing_Resource_Abstract
{

	private $parent_resource;

	public function __construct(ColoCrossing_Resource $parent_resource, ColoCrossing_Client $client, $name, $url)
	{
		parent::__construct($client, $name, $url);

		$this->parent_resource = $parent_resource;
	}

	public function getParentResource()
	{
		return $this->parent_resource;
	}

	public function findAll($parent_id, array $options = null)
	{
		$options = $this->createCollectionOptions($options);
		$url = $this->createCollectionUrl($parent_id);

		return new ColoCrossing_Collection($this, $url, $options['page_number'], $options['page_size'], $options['sort'], $options['filters']);
	}

	public function find($parent_id, $id)
	{
		$url = $this->createObjectUrl($id, $parent_id);

		return $this->fetch($url);
	}

	protected function createCollectionUrl($parent_id)
	{
		return $this->parent_resource->createObjectUrl($parent_id) . $this->getUrl();
	}

	protected function createObjectUrl($id, $parent_id)
	{
		return  $this->parent_resource->createObjectUrl($parent_id) . $this->getUrl() . '/' . urlencode($id);
	}

}
