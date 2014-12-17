<?php

/**
 * Represents an instance of a Switch's Network Port resource from
 * the API. Holds data for a Switch's Network Port and provides
 * methods to retrieve objects related to the network port such as
 * its Device, Switch or Bandwidth Graph. It also provides methods
 * to turn on or turn off the port.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 * @subpackage ColoCrossing_Object_Device
 */
class ColoCrossing_Object_Device_NetworkPort extends ColoCrossing_Object
{

	/**
	 * Retreives the Deivce object that the Network Port belongs to.
	 * @return ColoCrossing_Object_Device 	The Network Port's Device
	 */
	public function getDevice()
	{
		$client = $this->getClient();

		return $this->getObject('device', $client->devices);
	}

	/**
	 * Determines if a Bandwidth Graph is available for this Port
	 * @return boolean True if graph is available, false otherwise.
	 */
	public function isBandwidthGraphAvailable()
	{
		$device = $this->getDevice();

		return !!$this->getHasGraph() && isset($device);
	}

	/**
	 * Retrieves the Bandwidth Graph for this port.
	 * @param  int $start 		The start time of the graph. Defaults to start of current month if null.
	 * @param  int $end   		The end time of the graph. Defaults to now if null.
	 * @return resource|null   	The image resource of the graph
	 */
	public function getBandwidthGraph($start = null, $end = null)
	{
		if (!$this->isBandwidthGraphAvailable())
		{
			return null;
		}

		$switch = $this->getSwitch();
		$device = $this->getDevice();

		$client = $this->getClient();

		return $client->devices->switches->getBandwidthGraph($switch->getId(), $this->getId(), $device->getId(), $start, $end);
	}

	/**
	 * Determines if a Bandwidth Usage is available for this Port
	 * @return boolean True if graph is available, false otherwise.
	 */
	public function isBandwidthUsageAvailable()
	{
		$device = $this->getDevice();

		return !!$this->getHasBandwidthUsage() && isset($device);
	}

	/**
	 * Retrieves the Bandwidth Usage for this port.
	 * @return ColoCrossing_Object 	The Bandwidth Usage
	 */
	public function getBandwidthUsage()
	{
		if (!$this->isBandwidthUsageAvailable())
		{
			return null;
		}

		$switch = $this->getSwitch();
		$device = $this->getDevice();

		$client = $this->getClient();

		return $client->devices->switches->getBandwidthUsage($switch->getId(), $this->getId(), $device->getId());
	}

	/**
	 * Determines if the port has the ability to be controlled.
	 * @return boolean True if the port status can be set, false otherwise.
	 */
	public function isControllable()
	{
		return $this->isControl();
	}

	/**
	 * Sets the status of the port.
	 * @param 	string $status 	The status of the port. Either 'on' or 'off'.
	 * @return boolean 			True if the status is set successfully, false otherwise.
	 */
	public function setStatus($status)
	{
		if (!$this->isControllable())
		{
			return false;
		}

		$switch = $this->getSwitch();
		$device = $this->getDevice();

		$client = $this->getClient();

		return $client->devices->switches->setPortStatus($switch->getId(), $this->getId(), $device->getId(), $status);
	}

	/**
	 * Turns the port on.
	 * @return boolean 	True if the status is set successfully, false otherwise.
	 */
	public function turnOn()
	{
		return $this->setStatus('on');
	}

	/**
	 * Turns the port off.
	 * @return boolean 	True if the status is set successfully, false otherwise.
	 */
	public function turnOff()
	{
		return $this->setStatus('off');
	}

}
