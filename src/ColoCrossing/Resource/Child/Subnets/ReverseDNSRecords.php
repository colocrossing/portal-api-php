<?php

class ColoCrossing_Resource_Child_Subnets_ReverseDNSRecords extends ColoCrossing_Resource_Child_Abstract
{

	public function __construct(ColoCrossing_Client $client)
	{
		parent::__construct($client->subnets, $client, 'rdns_record', '/rdns-records');
	}

	public function update($subnet_id, $id, $value)
	{
		$records = array();
		$records[] = array(
			'id' => $id,
			'value' => $value
		);

		return $this->updateAll($subnet_id, $records);
	}

	public function updateAll($subnet_id, array $records)
	{
		$client = $this->getClient();
		$subnet = $client->subnets->find($subnet_id);

		if (empty($subnet) || $subnet->isPendingServiceRequest())
		{
			return false;
		}

		$data = array('record' => array());
		foreach ($records as $key => $record) {
			$data['record'][$record['id']] = $record['value'];
		}

		$url = $this->createCollectionUrl($subnet_id);

		$response = $this->sendRequest($url, 'PUT', $data);

		if (empty($response))
		{
			return false;
		}

		$content = $response->getContent();

		if (empty($content) || empty($content['status']) || $content['status'] == 'error')
		{
			return false;
		}

		if (isset($content['ticket']) && isset($content['ticket']['id']) && is_numeric($content['ticket']['id']) && $content['ticket']['id'] > 0)
		{
			return intval($content['ticket']['id']);
		}

		return true;
	}

}
