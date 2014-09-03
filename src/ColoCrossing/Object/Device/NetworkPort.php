<?php

class ColoCrossing_Object_Device_NetworkPort extends ColoCrossing_Object
{

	public function getDevice()
	{
		$client = $this->getClient();

		return $this->getObject('device', $client->devices);
	}

	public function hasBandwidthGraph()
	{
		$device = $this->getDevice();

		return !!$this->getHasGraph() && isset($device);
	}

	public function getBandwidthGraph($start = null, $end = null)
	{
		if(!$this->hasBandwidthGraph())
		{
			return null;
		}

		$switch = $this->getSwitch();
		$device = $this->getDevice();

		$client = $this->getClient();

		return $client->devices->switches->getBandwidthGraph($switch->getId(), $this->getId(), $device->getId(), $start, $end);
	}

}
