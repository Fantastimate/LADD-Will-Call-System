<?php
class LADDDoorQueryRedeemTicket extends AMQuery
{
	protected function initialize()
	{
		$timestamp = date(LADDDoor::DATE_FORMAT_ROW);
		extract($this->options);
		
		$this->sql = <<<SQL
			UPDATE Door_Tickets SET tick_CLAIMED='1', tick_CLAIMDATE='$timestamp'
			WHERE tick_ID ='$id'
			AND tick_CLAIMED != 1
SQL;
	}
}
?>