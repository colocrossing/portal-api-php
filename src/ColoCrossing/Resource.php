<?php

interface ColoCrossing_Resource
{

	public function fetchAll($url, array $options = null);

	public function fetch($url);

	public function getClient();

	public function getName($plural);

	public function getURL();

}