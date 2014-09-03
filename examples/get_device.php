<?php

require_once('../src/ColoCrossing.php');

$colocrossing_client = new ColoCrossing_Client();
$colocrossing_client->setAPIToken('eb3ac813fd85acd1a386c46cd84e39c6bf263c35');
$colocrossing_client->setOption('ssl_verify', false);

?>

<h1>Device</h1>

<?php

$device_id = 18; //Enter your device id here
$device = $colocrossing_client->devices->find($device_id);

if(isset($device))
{

	echo '<p>Id: ' . $device->getId() . '</p>';
	echo '<p>Name: ' . $device->getName() . '</p>';
	echo '<p>Hostname: ' . $device->getHostname() . '</p>';
	echo '<p>Subzone: ' . $device->getSubzone() . '</p>';

	echo '<h2>Type</h2>';

	$type = $device->getType();

	echo '<p>Id: ' . $type->getId() . '</p>';
	echo '<p>Name: ' . $type->getName() . '</p>';

	echo '<h2>Assets</h2>';

	$assets = $device->getAssets();

	foreach ($assets as $i => $asset)
	{
		echo '<p>Asset #' . $asset->getId() . ' - ' . $asset->getName() . '</p>';

		$groups = $asset->getGroups();

		foreach ($groups as $j => $group)
		{
			echo '<p>Belongs to Group #' . $group->getId() . ' - ' . $group->getName() . '</p>';
		}
	}

	echo '<h2>Notes</h2>';

	$notes = $device->getNotes();

	foreach ($notes as $i => $note)
	{
		echo '<p>Note #' . $note->getId() . ' - ' . $note->getNote() . '</p>';
	}
}

?>