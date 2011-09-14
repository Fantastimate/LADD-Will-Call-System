<?php
require LADDDoor::application_root().'/application/controls/TicketList.php';
require LADDDoor::application_root().'/application/controls/Ticket.php';
require LADDDoor::application_root().'/application/queries/LADDDoorQueryTicketDetails.php';

class Split extends LADDViewController
{
	public $ticketCount;
	
	protected function initialize() 
	{ 
		$this->ticketCount = (int) $_GET['numtix'];
	}
	
	public function showTickets()
	{
		$ticket_ids = isset($_GET['id']) ? $_GET['id'] : null;

		$ticket_ids = array_map("intval", $ticket_ids);
		$params     = array('ticket_ids' => implode(',', $ticket_ids), 'limit' => count($ticket_ids));
		$results    = new LADDDoorQueryTicketDetails(LADDDoor::database(), $params);
		
		if(count($results) > 0)
		{
			$this->tickets   = new TicketList();
			
			foreach($results as $ticketrow)
			{
				$ticket = $ticketrow['tick_CLAIMED'] == 1 ? new Ticket(Ticket::TEMPLATE_SPLIT_CLAIMED) : new Ticket(Ticket::TEMPLATE_SPLIT_UNCLAIMED);
				
				$ticket->firstname      = $ticketrow['tick_ATTENDFIRST'];
				$ticket->lastname       = $ticketrow['tick_ATTENDLAST'];
				$ticket->level          = $ticketrow['tick_LEVEL'];
				$ticket->claimed        = $ticketrow['tick_CLAIMED'];
				$ticket->id             = $ticketrow['tick_ID'];
				$ticket->total          = $ticketrow['tick_NUM'];
				
				$this->tickets->append($ticket);
			}
			
			$this->tickets->setTitle('Split <span>or</span> Claim the following '.$this->ticketCount.' tickets');
		}
		
		echo $this->tickets;
	}
}
?>