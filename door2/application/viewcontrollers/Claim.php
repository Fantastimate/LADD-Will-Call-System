<?php 
require LADDDoor::application_root().'/application/controls/TicketList.php';
require LADDDoor::application_root().'/application/controls/Ticket.php';
require LADDDoor::application_root().'/application/queries/LADDDoorQueryTicketDetails.php';

class Claim extends LADDViewController
{
	public $ticketCount;
	private $tickets;
	
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
		
		$total_tickets = count($results);
		if($total_tickets > 0)
		{
			$this->tickets   = new TicketList();
			
			foreach($results as $ticketrow)
			{
				
				$ticket = new Ticket(Ticket::TEMPLATE_REDEEM);
				
				
				$ticket->firstname      = $ticketrow['tick_ATTENDFIRST'];
				$ticket->lastname       = $ticketrow['tick_ATTENDLAST'];
				$ticket->level          = $ticketrow['tick_LEVEL'];
				$ticket->claimed        = $ticketrow['tick_CLAIMED'];
				$ticket->id             = $ticketrow['tick_ID'];
				
				$this->tickets->append($ticket);
			}
			
			$this->tickets->setTitle('Are you <span>sure</span> you want to mark the following '.$total_tickets.' as redeemed?');
		}
		
		echo $this->tickets;
	}
	
	public function confirmQueryString()
	{
		/*
			Given the group by logic in from the query to generate the index.php page, firstname, lastname, and level should
			be uniform among all the Ticket objects in the Ticket list, hence just pulling item 0
		*/
		$qs = array();
		$qs['numtix'] = $this->ticketCount;
		$qs['fname']  = $this->tickets[0]->firstname;
		$qs['lname']  = $this->tickets[0]->lastname;
		$qs['level']  = $this->tickets[0]->level;
		$qs['id']     = array();
		
		foreach($this->tickets as $ticket)
		{
			if(!$tickets->claimed)
			{
				$qs['id'][] = $ticket->id;
			}
		}
		
		return http_build_query($qs);
	}
}
?>