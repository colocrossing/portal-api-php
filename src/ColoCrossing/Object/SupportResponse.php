<?php

/**
 * Represents an instance of a Support Response resource from the API.
 * Holds data for a Support Response and provides methods to retrive
 * objects related to the Support Response such as its Ticket and Creator
 *
 * @category   ColoCrossing
 * @package    ColoCrossing_Object
 */
class ColoCrossing_Object_SupportResponse extends ColoCrossing_Resource_Object
{

	/**
	 * Retrieves the Creation Date of the Support Response as
	 * a Unix Timestamp.
	 * @return int The Date the Support Response was Created.
	 */
	public function getDateCreated()
	{
		$created_at = $this->getValue('created_at');

		return $created_at && isset($created_at) ? strtotime($created_at) : null;
	}

}
