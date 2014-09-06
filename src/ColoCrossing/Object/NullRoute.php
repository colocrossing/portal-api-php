<?php

/**
 * Represents an instance of a Null Route resource from the API.
 * Holds data for a Null Route and provides methods to retrive
 * objects related to the null route such as its Subnet.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 */
class ColoCrossing_Object_NullRoute extends ColoCrossing_Resource_Object
{

	public function getDateAdded()
	{
		$date_added = $this->getValue('date_added');

		return $date_added && isset($date_added) ? strtotime($date_added) : null;
	}

	public function getDateExpire()
	{
		$date_expire = $this->getValue('date_expire');

		return $date_expire && isset($date_expire) ? strtotime($date_expire) : null;
	}

	public function getSubnet()
	{
		$client = $this->getClient();

		return $this->getObject('subnet', $client->subnets);
	}

	public function remove()
	{
		$client = $this->getClient();

		return $client->null_routes->remove($this->getId());
	}

}
