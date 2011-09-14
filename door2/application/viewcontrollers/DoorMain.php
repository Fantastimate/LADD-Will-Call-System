<?php
require LADDDoor::application_root().'/application/controls/TicketList.php';
require LADDDoor::application_root().'/application/controls/Ticket.php';
require LADDDoor::application_root().'/application/queries/LADDDoorQueryTickets.php';

class DoorMain extends LADDViewController
{
	private $hasLetterFilter;
	private $notifications;
	protected function initialize() 
	{ 
		$this->hasLetterFilter = isset($_GET['alph']);
		$this->notifications   = array();
		
		if(isset($_GET['claim']))
		{
			$this->processActions();
		}
	}
	
	public function letterSort()
	{
		echo new LetterSort();
	}
	
	public function showNotifications()
	{
		foreach($this->notifications as $notification)
		{
			echo $notification;
		}
	}
	
	public function showTickets()
	{
		if($this->hasLetterFilter)
		{
			// we only want the first character
			$this->showUnclaimedTickets((string)$_GET['alph'][0]);
		}
		else
		{
			$this->showAllTickets();
		}
	}
	
	private function processActions()
	{
		switch($_GET['claim'])
		{
			case 'confirm':
				$this->processRedeemedTickets();
				break;
			
			case 'processsplit':
				$this->processSplitTickets();
				break;
		}
	}
	private function processRedeemedTickets()
	{
		require LADDDoor::application_root().'/application/actions/RedeemTickets.php';
		$action = new RedeemTickets();
		$this->notifications = $action->execute();
	}
	
	private function processSplitTickets()
	{
		require LADDDoor::application_root().'/application/actions/SplitTickets.php';
		$action = new SplitTickets();
		$this->notifications = $action->execute();
	}
	
	private function showAllTickets()
	{
		$this->showUnclaimedTickets();
		$this->showClaimedTickets();
	}
	
	private function showUnclaimedTickets($filter=null)
	{
		$unclaimed = new LADDDoorQueryTickets(LADDDoor::database(), array('status'=>LADDDoorQueryTickets::TICKETS_UNCLAIMED, 'filter'=>$filter));
		$tickets_unclaimed = null;
		
		if(count($unclaimed > 0))
		{
			$tickets_unclaimed   = new TicketList('Unclaimed Tickets: '.count($results));
			
			foreach($unclaimed as $ticketrow)
			{
				$ticket = new Ticket(Ticket::TEMPLATE_UNCLAIMED);
				
				$ticket->firstname      = $ticketrow['tick_ATTENDFIRST'];
				$ticket->lastname       = $ticketrow['tick_ATTENDLAST'];
				$ticket->total          = $ticketrow['tick_TOTAL'];
				$ticket->level          = $ticketrow['tick_LEVEL'];
				$ticket->splitfirstname = $ticketrow['tick_SPLITHOSTFIRST'];
				$ticket->splitlastname  = $ticketrow['tick_SPLITHOSTLAST'];
				$ticket->group          = explode(',', $ticketrow['tick_TICKETIDS']);
				
				$tickets_unclaimed->append($ticket);
			}
			
			$message_extra = null;
			if($filter)
			{
				$message_extra = " [".strtoupper($filter[0])."]";
			}
			
			$tickets_unclaimed->setTitle('Unclaimed Tickets'.$message_extra.': '.count($tickets_unclaimed));
			
			echo $tickets_unclaimed;
		}
	}
	
	private function showClaimedTickets($filter=null)
	{
		$claimed   = new LADDDoorQueryTickets(LADDDoor::database(), array('status'=>LADDDoorQueryTickets::TICKETS_CLAIMED, 'filter'=>$filter));
		$tickets_claimed  = null;
		if(count($claimed) > 0)
		{
			$tickets_claimed   = new TicketList('Claimed Tickets: '.count($results));
			
			foreach($claimed as $ticketrow)
			{
				$ticket = new Ticket(Ticket::TEMPLATE_CLAIMED);
				
				$ticket->firstname      = $ticketrow['tick_ATTENDFIRST'];
				$ticket->lastname       = $ticketrow['tick_ATTENDLAST'];
				$ticket->total          = $ticketrow['tick_TOTAL'];
				$ticket->level          = $ticketrow['tick_LEVEL'];
				$ticket->splitfirstname = $ticketrow['tick_SPLITHOSTLAST'];
				$ticket->splitlastname  = $ticketrow['tick_SPLITHOSTFIRST'];
				$ticket->group          = explode(',', $ticketrow['tick_TICKETIDS']);
				
				$tickets_claimed->append($ticket);
			}
			
			$message_extra = null;
			if($filter)
			{
				$message_extra = " [".strtoupper($filter[0])."]";
			}
			
			$tickets_claimed->setTitle('Claimed Tickets'.$message_extra.': '.count($tickets_claimed));
			echo $tickets_claimed;
		}
	}
}
?>