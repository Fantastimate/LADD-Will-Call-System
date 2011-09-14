<?php
class LADDDoorQueryLiveSearch extends AMQuery
{
	protected function initialize()
	{
		$timestamp = date(LADDDoor::DATE_FORMAT_ROW);
		extract($this->options);
		
		$this->sql = <<<SQL
			SELECT *, 
			COUNT(tick_NUM) tick_TOTAL,
			MD5(CONCAT(tick_ATTENDLAST,tick_ATTENDFIRST,tick_CARDNUM,tick_LEVEL, tick_SPLITHOSTLAST, tick_SPLITHOSTFIRST)) tick_HASH,
			GROUP_CONCAT(DISTINCT tick_ID) tick_TICKETIDS
			FROM Door_Tickets 
			WHERE tick_EVENTDATE = DATE(NOW()) AND tick_ATTENDLAST LIKE '$query%'
			GROUP BY tick_HASH
			ORDER BY tick_ATTENDLAST, tick_ATTENDFIRST, tick_CARDNUM, tick_LEVEL
SQL;
	}
}

?>