<?php
require LADDDoor::application_root().'/application/queries/LADDDoorQueryRedeemTicket.php';
require LADDDoor::application_root().'/application/queries/LADDDoorQueryTicketDetails.php';
require LADDDoor::application_root().'/application/controls/Notification.php';

class RedeemTickets
{
	public function __construct()
	{
		
	}
	
	public function execute()
	{
		$notifications = array();
		
		$ticket_ids = isset($_GET['id']) ? $_GET['id'] : null;
		$ticket_ids = array_map("intval", $ticket_ids);
		$params     = array('ticket_ids' => implode(',', $ticket_ids), 'limit' => count($ticket_ids));
		
		$tickets = new LADDDoorQueryTicketDetails(LADDDoor::database(), $params);
		
		if(count($tickets) > 0)
		{
			foreach($tickets as $ticket)
			{
				if($ticket['tick_CLAIMED'] != 1)
				{
					$redeem = new LADDDoorQueryRedeemTicket(LADDDoor::database(), array('id'=>$ticket['tick_ID']));
					if($redeem->execute())
					{
						$message = $ticket['tick_LEVEL'].' Ticket #'.$ticket['tick_ID'].' for '.$ticket['tick_ATTENDFIRST'].' '. $ticket['tick_ATTENDLAST'].' marked claimed.';
						$notifications[] = new Notification($message, Notification::SUCCESS_NOTIFICATION);
					}
					else
					{
						$message = 'The #'.$ticket['tick_ID'].' ticket for '.$ticket['tick_ATTENDFIRST'].' '. $ticket['tick_ATTENDLAST'].' is already claimed.';
						$notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
					}
				}
				else
				{
					$message = 'The #'.$ticket['tick_ID'].' ticket for '.$ticket['tick_ATTENDFIRST'].' '. $ticket['tick_ATTENDLAST'].' is already claimed.';
					$notifications[] = new Notification($message, Notification::ERROR_NOTIFICATION);
				}
			}
		}
		
		return $notifications;
	}
}

?>