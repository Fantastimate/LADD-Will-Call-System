<?php
class LADDDoorQuerySplitTicket extends AMQuery
{
	protected function initialize()
	{
		$timestamp = date(LADDDoor::DATE_FORMAT_ROW);
		extract($this->options);
		
		$this->sql = <<<SQL
			UPDATE Door_Tickets 
			SET tick_SPLITHOSTLAST='$hostLastName', tick_SPLITHOSTFIRST='$hostFirstName', tick_ATTENDLAST='$splitLastName', tick_ATTENDFIRST='$splitFirstName'
			WHERE tick_ID ='$id'
SQL;
	}
}
?>