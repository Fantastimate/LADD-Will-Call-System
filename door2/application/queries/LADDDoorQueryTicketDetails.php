<?php
class LADDDoorQueryTicketDetails extends AMQuery
{
	protected function initialize()
	{
		$today = LADDDoor::today();
		
		extract($this->options);
		
		$limit = $limit ? 'LIMIT '.$limit : null;
		
		$this->sql = <<<SQL
			SELECT * FROM Door_Tickets
			WHERE tick_ID IN ($ticket_ids)
			AND tick_EVENTDATE = DATE(NOW())
			ORDER BY tick_ATTENDLAST, tick_ATTENDFIRST $limit
SQL;
	}
}
?>