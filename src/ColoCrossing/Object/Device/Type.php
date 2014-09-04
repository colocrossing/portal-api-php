<?php

class ColoCrossing_Object_Device_Type extends ColoCrossing_Object
{

	public function isRack()
	{
		return !!$this->getValue('is_rack');
	}

	public function isRacked()
	{
		return !$this->isRack();
	}

	public function isVirtual()
	{
		return !!$this->getValue('is_virtual');
	}

	public function isPowered()
	{
		return $this->isPowerEndpoint() || $this->isPowerDistribution();
	}

	public function isPowerEndpoint()
	{
		return $this->getValue('power') == 'endpoint';
	}

	public function isPowerDistribution()
	{
		return $this->getValue('power') == 'distribution';
	}

	public function isNetworked()
	{
		return $this->isNetworkEndpoint() || $this->isNetworkDistribution();
	}

	public function isNetworkEndpoint()
	{
		return $this->getValue('network') == 'endpoint';
	}

	public function isNetworkDistribution()
	{
		return $this->getValue('network') == 'distribution';
	}

}
