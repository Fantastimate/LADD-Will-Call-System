<?php
class Letter
{
	private $letter;
	
	public function __construct($letter)
	{
		$this->letter = $letter;
	}
	
	public function __toString()
	{
		$source  = LADDDoor::application_root().'/application/controls/Letter.html';
		$data    = array('letter'=>$this->letter);
		
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $data);
	}
}
?>