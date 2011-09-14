<?php
class TicketNotification
{
	
	private $message;
	public function __construct($message)
	{
		$this->message = $message;
	}
	
	public function __toString()
	{
		$source  = LADDDoor::application_root().'/application/controls/TicketNotification.html';
		$data    = array('message' => $this->message);
		
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $data);
	}
}
?>