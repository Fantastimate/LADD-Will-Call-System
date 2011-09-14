<?php
$page = null;

abstract class LADDPage
{
	public $isPostBack                = false;
	
	public static function CodeBehind($class)
	{
		global $page;
		require LADDDoor::application_root().'/application/viewcontrollers/'.$class;
		
		$class = substr($class, 0, strrpos($class, '.'));
		$page = new $class();
	}
	
	public function __construct()
	{
		if(count($_POST))
		{
			$this->isPostBack = true;
		}
		
		$this->page_load();
	}
	
	protected abstract function page_load();
}
?>