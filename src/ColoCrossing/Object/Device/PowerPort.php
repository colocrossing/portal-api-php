<?php

/**
 * Represents an instance of a PDU's Power Port resource from
 * the API. Holds data for a PDU's Power Port and provides
 * methods to retrieve objects related to the power port such as
 * its assigned Device or PDU. It also provides methods to restart,
 * turn on or turn off the port.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 * @subpackage ColoCrossing_Object_Device
 */
class ColoCrossing_Object_Device_PowerPort extends ColoCrossing_Object
{

	/**
	 * Retreives the Deivce object that the Power Port belongs to.
	 * @return ColoCrossing_Object_Device 	The Power Port's Device
	 */
	public function getDevice()
	{
		$client = $this->getClient();

		return $this->getObject('device', $client->devices);
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

		$pdu = $this->getPowerDistributionUnit();
		$device = $this->getDevice();

		$client = $this->getClient();

		return $client->devices->pdus->setPortStatus($pdu->getId(), $this->getId(), $device->getId(), $status);
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

	/**
	 * Restarts the port.
	 * @return boolean 	True if the status is set successfully, false otherwise.
	 */
	public function restart()
	{
		return $this->setStatus('restart');
	}

}
