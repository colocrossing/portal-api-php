<?php

interface ColoCrossing_Resource
{

	public function findAll($options);

	public function find($id);

	public function getClient();

	public function getName($plural);

	public function getURL();

}