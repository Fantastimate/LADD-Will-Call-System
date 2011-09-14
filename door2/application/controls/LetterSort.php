<?php
require 'FullList.php';
class LetterSort
{
	
	public function __construct()
	{
	
	}
	
	public function __toString()
	{
		$data = array('letters'=>array());
		
		foreach (range('A','Z') as $letter)
		{
			$data['letters'][] = new Letter($letter);
		}
		
		if(isset($_GET['alph']))
		{
			$data['fulllist'] = new FullList();
		}
		
		$source  = LADDDoor::application_root().'/application/controls/LetterSort.html';
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $data);
	}
}
?>