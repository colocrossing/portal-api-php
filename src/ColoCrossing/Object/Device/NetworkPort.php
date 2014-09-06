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

	public function getDevice()
	{
		$client = $this->getClient();

		return $this->getObject('device', $client->devices);
	}

	public function isBandwidthGraphAvailable()
	{
		$device = $this->getDevice();

		return !!$this->getHasGraph() && isset($device);
	}

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

	public function isControllable()
	{
		$device = $this->getDevice();

		return $this->isControl() && isset($device);
	}

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

	public function turnOn()
	{
		return $this->setStatus('on');
	}

	public function turnOff()
	{
		return $this->setStatus('off');
	}

}
