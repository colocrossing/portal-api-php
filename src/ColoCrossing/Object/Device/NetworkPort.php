<?php

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
