<?php
class LADDDoorQueryTickets extends AMQuery
{
	const TICKETS_UNCLAIMED = 0;
	const TICKETS_CLAIMED   = 1;
	
	protected function initialize()
	{
		$today = LADDDoor::today();
		extract($this->options);
		
		if($filter)
		{
			 $filter = "AND tick_ATTENDLAST LIKE '$filter%'";
		}
		
		$this->sql = <<<SQL
			SELECT *, 
			COUNT(tick_NUM) tick_TOTAL,
			MD5(CONCAT(tick_ATTENDLAST,tick_ATTENDFIRST,tick_CARDNUM,tick_LEVEL, tick_SPLITHOSTLAST, tick_SPLITHOSTFIRST)) tick_HASH,
			GROUP_CONCAT(DISTINCT tick_ID) tick_TICKETIDS
			FROM Door_Tickets 
			WHERE tick_EVENTDATE = DATE(NOW()) AND tick_CLAIMED = '$status'
			$filter
			GROUP BY tick_HASH
			ORDER BY tick_ATTENDLAST, tick_ATTENDFIRST, tick_CARDNUM, tick_LEVEL
SQL;
	}
}
?>