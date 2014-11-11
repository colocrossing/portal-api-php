<?php

/**
 * The base implementation for accessing a specific  Sub-Resource of
 * the API. Handles Creating the URL of the sub-resource by using the
 * parent resource.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Resource
 * @subpackage ColoCrossing_Resource_Child
 * @abstract
 */
abstract class ColoCrossing_Resource_Child_Abstract extends ColoCrossing_Resource_Abstract
{

	/**
	 * The Parent Resource
	 * @var ColoCrossing_Resource
	 */
	private $parent_resource;

	/**
	 * @param ColoCrossing_Resource $parent_resource	The Parent Resource
	 * @param ColoCrossing_Client 	$client 			The API Client
	 * @param string|array<string>  $name   			The Resource Name. If string, it is assumed the
	 *                                      	  			singular form is provided and the plural form
	 *                                      	     		is created by appending an 's'.
	 * @param string              	$url    			The Url of the Resource Relative to the root of parent.
	 */
	public function __construct(ColoCrossing_Resource $parent_resource, ColoCrossing_Client $client, $name, $url)
	{
		parent::__construct($client, $name, $url);

		$this->parent_resource = $parent_resource;
	}

	/**
	 * @return ColoCrossing_Resource The Parent Resource
	 */
	public function getParentResource()
	{
		return $this->parent_resource;
	}

	/**
	 * Retrieves a List of ColoCrossing_Object from this Resource
	 * @param  int 				$parent_id 	The Parent Id
	 * @param  array 			$options 	An Array of Options to Adjust the Result. Includes filters,
	 *											sort, page_number, and page_size.
	 * @return ColoCrossing_Collection<ColoCrossing_Object>	A List of ColoCrossing_Object
	 */
	public function findAll($parent_id, array $options = null)
	{
		$options = $this->createCollectionOptions($options);
		$url = $this->createCollectionUrl($parent_id);

		return new ColoCrossing_Collection($this, $url, $options['page_number'], $options['page_size'], $options['sort'], $options['filters']);
	}

	/**
	 * Retrieves a ColoCrossing_Object from this Resource
	 * @param  int 			$parent_id 	The Parent Id
	 * @param  int 			$id     	The Id
	 * @return ColoCrossing_Object		The ColoCrossing_Object
	 */
	public function find($parent_id, $id)
	{
		$url = $this->createObjectUrl($id, $parent_id);

		return $this->fetch($url);
	}

	/**
	 * Creates the Url that refers to the Collection/Index of this Child Resource
	 * @param  int 	$parent_id 	The Parent Id
	 * @return string 			The Url
	 */
	protected function createCollectionUrl($parent_id)
	{
		return $this->parent_resource->createObjectUrl($parent_id) . $this->getUrl();
	}

	/**
	 * Creates the Url that refers to a Object in this Resource.
	 * @param  int $id 			The Object Id
	 * @param  int $parent_id 	The Parent Id
	 * @return string   		The Url
	 */
	protected function createObjectUrl($id, $parent_id)
	{
		return  $this->parent_resource->createObjectUrl($parent_id) . $this->getUrl() . '/' . urlencode($id);
	}

}
