<?php
require LADDDoor::application_root().'/application/queries/LADDDoorQueryRedeemTicket.php';
require LADDDoor::application_root().'/application/queries/LADDDoorQuerySplitTicket.php';
require LADDDoor::application_root().'/application/queries/LADDDoorQueryTicketDetails.php';
require LADDDoor::application_root().'/application/controls/Notification.php';

class SplitTickets
{
	private $notifications;
	private $tickets;
	
	public function __construct()
	{
		
	}
	
	public function execute()
	{
		$this->notifications = array();
		
		if(count($_POST['tickets']))
		{
			if($this->initializeTickets())
			{
				$_POST = array_map(array($this, 'processInput'), $_POST);
				
				foreach($this->tickets as $key=>$value)
				{
					switch($_POST['ticketaction'][$key])
					{
						case 'claim':
							$this->claimTicket($key);
							break;
				
						case 'split':
							$this->splitTicket($key);
							break;
					}
				}
			}
			else
			{
				$message = "No tickets were submitted for processing";
				$this->notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
			}
		}
		else
		{
			$message = "No tickets were submitted for processing";
			$this->notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
		}
		
		return $this->notifications;
	}
	
	private function processInput($value)
	{
		if(is_array($value))
		{
			return array_map(array($this, 'processInput'), $value);
		}
		else
		{
			return trim($value);
		}
	}
	
	private function initializeTickets()
	{
		$ticket_ids = isset($_POST['tickets']) ? $_POST['tickets'] : null;
		
		if($ticket_ids)
		{
			$ticket_ids = array_map("intval", $ticket_ids);
			$params     = array('ticket_ids' => implode(',', $ticket_ids), 'limit' => count($ticket_ids));
		
			$results = new LADDDoorQueryTicketDetails(LADDDoor::database(), $params);
		
			if(count($results))
			{
				$this->tickets = array();
			
				foreach($results as $ticketrow)
				{
					$this->tickets[$ticketrow['tick_ID']] = $ticketrow['tick_CLAIMED'];
				}
			
				return true;
			}
		}
		
		return false;
	}
	
	private function claimTicket($id)
	{
		if($this->tickets[$id] == 1)
		{
			$message = 'The #'.$id.' ticket for '.$_POST['hostfirstname'][$id].' '.$_POST['lastfirstname'][$id].' is already claimed.';
			$this->notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
		}
		else
		{
			$action = new LADDDoorQueryRedeemTicket(LADDDoor::database(), array('id'=>$id));
		
			if($action->execute())
			{
				$message = $_POST['ticketlevel'][$id].' Ticket #'.$id.' for '.$_POST['hostfirstname'][$id].' '.$_POST['hostlastname'][$id].' marked claimed.';
				$this->notifications[] = new Notification($message, Notification::SUCCESS_NOTIFICATION);
			}
			else
			{
				$message = 'The #'.$id.' ticket for '.$_POST['hostfirstname'][$id].' '.$_POST['lastfirstname'][$id].' is already claimed.';
				$this->notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
			}
		}
	}
	
	private function splitTicket($id)
	{
		if($this->tickets[$id] == 1)
		{
			$message = 'The #'.$id.' ticket for '.$_POST['hostfirstname'][$id].' '.$_POST['lastfirstname'][$id].' is already claimed.';
			$this->notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
		}
		else
		{
			if($_POST['splitfirstname'][$id] == 'First Name' || $_POST['splitfirstname'][$id] == 'Last Name')
			{
				$message = "The #$id ".$_POST['ticketlevel'][$id]." item submitted still contains the default First and/or Last Name. No update was made for this ticket.";
				$this->notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
			}
			else if(empty($_POST['splitfirstname'][$id]) || empty($_POST['splitfirstname'][$id]))
			{
				$message = "The #$id ".$_POST['ticketlevel'][$id]." item submitted contains a blank First and/or Last Name. No update was made for this ticket.";
				$this->notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
			}
			else
			{
				$params = array('id' => $id,
				                'hostLastName'   => $_POST['hostlastname'][$id],
				                'hostFirstName'  => $_POST['hostfirstname'][$id],
				                'splitLastName'  => $_POST['splitlastname'][$id],
				                'splitFirstName' => $_POST['splitfirstname'][$id]);
				
				$action = new LADDDoorQuerySplitTicket(LADDDoor::database(), $params);
				
				if($action->execute())
				{
					$message = $_POST['ticketlevel'][$id].' Ticket #'.$id.' has been split and marked for pickup by '.$_POST['splitfirstname'][$id].' '.$_POST['splitlastname'][$id];
					$this->notifications[] = new Notification($message, Notification::SUCCESS_NOTIFICATION);
				}
				else
				{
					$message = 'The #'.$id.' ticket for '.$_POST['hostfirstname'][$id].' '.$_POST['lastfirstname'][$id].' is already claimed.';
					$this->notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
				}
			}
		}
	}
}

?>