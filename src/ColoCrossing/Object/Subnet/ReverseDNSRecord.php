<?php

/**
 * Represents an instance of a Subnet's Reverse DNS Record resource
 * from the API. Holds data for a Subnet's Reverse DNS Record and
 * provides methods to retrive objects related to the rDNS record
 * such as its Subnet.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 * @subpackage ColoCrossing_Object_Subnet
 */
class ColoCrossing_Object_Subnet_ReverseDNSRecord extends ColoCrossing_Resource_Object
{

	public function update($value)
	{
		$subnet = $this->getSubnet();

		if (empty($subnet))
		{
			return false;
		}

		$resource = $this->getResource();
		$result = $resource->update($subnet->getId(), $this->getId(), $value);

		if ($result)
		{
			$this->setValue('record', $value);
		}

		return $result;
	}

	public function getSubnet()
	{
		$client = $this->getClient();

		return $this->getObject('subnet', $client->subnets);
	}

}
