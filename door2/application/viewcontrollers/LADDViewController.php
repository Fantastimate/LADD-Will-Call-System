<?php
class LADDViewController extends LADDPage
{
	public $session;
	protected $requiresAuthorization  = false;
	
	protected function page_load()
	{
		/*$this->hasAuthorizedUser = NakedTruth::hasAuthorizedUser();
		
		if($this->requiresAuthorization && !$this->hasAuthorizedUser)
		{
			header('Location: /management/login');
		}
		
		$this->session = NakedTruth::session();
		*/
		$this->initialize();
	}
	
	/*public function navigation_management()
	{
		echo new NTManagementNavigation();
	}*/
	
	protected function initialize() { }
	
}
?>
