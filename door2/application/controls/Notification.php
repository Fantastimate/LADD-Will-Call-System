<?php
class Notification
{
	const SUCCESS_NOTIFICATION = 1;
	const ERROR_NOTIFICATION   = 2;
	
	private $message;
	private $style;
	public function __construct($message, $style)
	{
		$this->message = $message;
		$this->style   = $style;
	}
	
	public function __toString()
	{
		
		switch($this->style)
		{
			case Notification::SUCCESS_NOTIFICATION:
				$source  = LADDDoor::application_root().'/application/controls/NotificationSuccess.html';
				break;
			
			case Notification::ERROR_NOTIFICATION:
				$source  = LADDDoor::application_root().'/application/controls/NotificationError.html';
				break;
		}
		
		
		$data    = array('message' => $this->message);
		
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $data);
	}
}
?>