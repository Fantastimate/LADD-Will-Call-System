<?php
class FullList
{
	
	public function __construct()
	{
	
	}
	
	public function __toString()
	{
		$data    = array();
		$source  = LADDDoor::application_root().'/application/controls/FullList.html';
		
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $data);
	}
}
?>