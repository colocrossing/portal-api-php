<?php

require_once('../src/ColoCrossing.php');

$cc_client = new ColoCrossing_Client();
$cc_client->setAPIToken('eb3ac813fd85acd1a386c46cd84e39c6bf263c35');
$cc_client->setOption('ssl_verify', false);
$cc_client->setOption('page_size', 10);
try
{

/*	$device = $cc_client->devices->find(18);

	$pdus = $device->getPowerDistributionUnits();
	foreach ($pdus as $i => $pdu)
	{
		echo $pdu . '<br>';

		$ports = $pdu->getPorts();

		foreach ($ports as $j => $port)
		{
			echo $port->turnOn() ? 'T' : 'F';
			echo '<br>';
		}
	}*/

/*	$device = $cc_client->devices->find(18);

	$switches = $device->getSwitches();
	foreach ($switches as $i => $switch)
	{
		echo $switch . '<br>';

		$ports = $switch->getPorts();

		foreach ($ports as $j => $port)
		{
			echo $port->turnOn() ? 'T' : 'F';
		}
	}*/

/*	$device = $cc_client->devices->find(18);

	$switches = $device->getSwitches();
	foreach ($switches as $i => $switch) {
		echo $switch . '<br>';

		$port = $switch->getPort(4);
		if(isset($port) && $port->isBandwidthGraphAvailable())
		{
			$graph = $port->getBandwidthGraph(strtotime('-5 days'), time());

			if(isset($graph))
			{
				ob_clean();
		    	ob_start();

	        	header("Content-Type: image/png");
		    	imagepng($graph);
		    	imagedestroy($graph);

		    	ob_end_flush();
		    }
		}
	}*/


/*	$subnet = $cc_client->subnets->find(715);
	echo $subnet . '<br>';

	foreach ($subnet->getIpAddresses() as $key => $ip_address){
		echo $ip_address . '<br>';
		echo($subnet->addNullRoute($ip_address, "Test #$key", strtotime('+1 hours')));
		echo '<br>';
	}*/

/*	$null_routes = $subnet->getNullRoutes();
	foreach ($null_routes as $key => $null_route) {
		echo $null_route . '<br>';
		echo $null_route->remove() ? 'T' : 'F';
		echo '<br>';
	}*/

/*
	$subnet = $cc_client->subnets->find(306);
	echo $subnet . '<br>';
	$ips = $subnet->getIpAddresses();
	echo implode('<br>', $ips);
*/

/*
	$device = $cc_client->devices->find(11);

	$pdus = $device->getPowerDistributionUnits();
	foreach ($pdus as $i => $pdu) {
		echo $pdu . '<br>';

		$owner = $pdu->getOwner();
		echo $owner . '<br>';

		$detailed_device = $pdu->getDetailedDevice();
		echo $detailed_device . '<br>';

		$ports = $pdu->getPorts();

		foreach ($ports as $j => $port) {
			echo $port . '<br>';

			$device = $port->getDevice();

			if(isset($device)) {
				echo $device->getName() . '<br>';
			}
		}
	}
*/

/*
	$devices = $cc_client->devices->findAll();

	foreach ($devices as $key => $device) {
		echo $device->getName() . '<br>';
	}
*/

/*

	$device = $cc_client->devices->find(35); //33 || 35
	echo $device->getName() . '<br>';

	foreach($device->getNotes() as $i => $note){
		echo '---' . $note->getNote() . '<br>';
	}
*/


/*	$subnets = $cc_client->null_routes->findAllByIpAddress('1.1.2.13');

	foreach ($subnets as $key => $subnet) {
		echo $subnet->getIpAddress() . '<br>';

		//$network = $subnet->getNetwork();
		//echo 'Network: ' . (isset($network) ? $network->getIpAddress() : 'N/A') . '<br>';
	}*/


/*
	$subnets = $cc_client->subnets->findAll();

	foreach ($subnets as $i => $subnet) {
		echo $subnet->getIpAddress() . '<br>';

		$rdns_records = $subnet->getReverseDNSRecords();
		if(isset($rdns_records)) {
			foreach ($rdns_records as $j => $rdns_record) {
				echo '--' . $rdns_record->getIpAddress() . '<br>';
			}
		}
	}
*/

/*
 	$networks = $cc_client->networks->findAll();

	foreach ($networks as $key => $network) {
		echo $network->getIpAddress() . '<br>';

		$null_routes = $network->getNullRoutes();

		foreach ($null_routes as $key => $null_route) {
			echo '--' . $null_route->getIpAddress() . '<br>';
		}
	}
*/

/*
	$networks = $cc_client->networks->findAll();

	foreach ($networks as $i => $network) {
		echo $network->getId() . ' - ' . $network->getIpAddress() . '<br>';
		$subnets = $network->getSubnets();
		foreach ($subnets as $j => $subnet) {
			echo '--' . $subnet->getId() . ' - ' . $subnet->getIpAddress(). '<br>';
		}
	}
*/

/*
	$null_routes = $cc_client->null_routes->findAll();

	foreach ($null_routes as $key => $null_route) {
		echo $null_route->getIpAddress() . ' - ' . $null_route->getDateAdded() . ' - ' . $null_route->getDateExpire() . '<br>';

		$subnet = $null_route->getSubnet();
		echo 'Subnet: ' . (isset($subnet) ? $subnet->getIpAddress() : 'N/A') . '<br>';
	}
*/

/*
	$subnet = $cc_client->subnets->find(715);
	$rdns_records = $subnet->getReverseDNSRecords();

	foreach ($rdns_records as $j => $rdns_record) {
		echo $rdns_record->getIpAddress() . '<br>';
		echo $rdns_record->getRecord() . '<br>';

		echo $rdns_record->update("host$j.google.com") ? 'T' : 'F';
		echo '<br>';

		echo $rdns_record->getRecord() . '<br>';
	}*/


}
catch (ColoCrossing_Error $e)
{
    echo $e->getMessage();
}
