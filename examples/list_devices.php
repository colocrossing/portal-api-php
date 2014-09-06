<?php

require_once('../src/ColoCrossing.php');

$colocrossing_client = new ColoCrossing_Client();
$colocrossing_client->setAPIToken('eb3ac813fd85acd1a386c46cd84e39c6bf263c35');
$colocrossing_client->setOption('ssl_verify', false);

?>

<h1>List Devices</h1>

<?php

$options = array(
	'sort' => 'id'
);
$devices = $colocrossing_client->devices->findAll($options);

foreach ($devices as $key => $device)
{
	echo '<p>Device #' . $device->getId() . ' - ' . $device->getName() . '</p>';
}

?>
