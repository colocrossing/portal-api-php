<?php

/**
 * Represents an instance of a Support Ticket resource from the API.
 * Holds data for a Support Ticket and provides methods to retrive
 * objects related to the Support Ticket such as its Department, Responses, and Devices.
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 */
class ColoCrossing_Object_SupportTicket extends ColoCrossing_Resource_Object
{

	/**
	 * Retrieves the Creation Date of the Support Ticket as
	 * a Unix Timestamp.
	 * @return int The Date The Support Ticket was Created.
	 */
	public function getDateCreated()
	{
		$created_at = $this->getValue('created_at');

		return $created_at && isset($created_at) ? strtotime($created_at) : null;
	}

	/**
	 * Retrieves the Last Updated Date of the Support Ticket as
	 * a Unix Timestamp.
	 * @return int The Date The Support Ticket was Updated.
	 */
	public function getDateUpdated()
	{
		$updated_at = $this->getValue('updated_at');

		return $updated_at && isset($updated_at) ? strtotime($updated_at) : null;
	}

}
