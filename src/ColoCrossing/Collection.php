<?php

class ColoCrossing_Collection implements Iterator, Countable
{

	private $resource;

	private $size = null;

	private $overall_position;

	private $page_position;

	private $page_number;

	private $page_size;

	private $objects;

	public function __construct(ColoCrossing_Resource $resource, $page_number = 1, $page_size = 30)
	{
		$this->resource = $resource;

		$this->setPageNumber($page_number);
		$this->setPageSize($page_size);

		$this->overall_position = ($this->page_number - 1) * $this->page_size;
		$this->page_position = 0;

		$this->loadCurrentPage();
	}

	public function rewind()
	{
		$this->setPageNumber(1);

        $this->overall_position = 0;
		$this->page_position = 0;
    }

    public function current()
    {
        return $this->objects[$this->page_position];
    }

	public function key()
	{
        return $this->overall_position;
    }

    public function next()
    {
        $this->overall_position++;
        $this->page_position++;

        if($this->page_position == $this->page_size)
        {
        	$this->setPageNumber($this->page_number + 1);
        	$this->page_position = 0;
        	$this->loadCurrentPage();
        }
    }

    public function valid()
    {
        return isset($this->objects[$this->page_position]);
    }

    public function count()
    {
    	return $this->size();
    }

    public function size()
    {
    	if($this->size === null)
    	{
	    	$this->size = 0;
	    	$page_number = 1;

	    	do{
		    	$options = array(
					'format' => 'array',
					'page_number' => $page_number,
					'page_size' => 100
				);
				$objects = $this->resource->findAll($options);

				$num_objects = count($objects);
				$this->size += $num_objects;
			}while($num_objects > 0 && $page_number++);
	    }

	    return $this->size;
    }

	private function setPageNumber($page_number)
	{
		$this->page_number = max($page_number, 1);
	}

	private function setPageSize($page_size)
	{
		$this->page_size = max(min($page_size, 100), 1);
	}

	private function loadCurrentPage()
	{
		$options = array(
			'format' => 'array',
			'page_number' => $this->page_number,
			'page_size' => $this->page_size
		);
		$this->objects = $this->resource->findAll($options);
	}

}
