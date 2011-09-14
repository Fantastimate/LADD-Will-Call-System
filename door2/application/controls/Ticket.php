<?php
require "TicketNotification.php";
require "NotificationFlag.php";

class Ticket
{
	const TEMPLATE_REDEEM          = 1;
	const TEMPLATE_UNCLAIMED       = 2;
	const TEMPLATE_CLAIMED         = 3;
	const TEMPLATE_SPLIT_UNCLAIMED = 4;
	const TEMPLATE_SPLIT_CLAIMED   = 5;
	
	public $firstname;
	public $lastname;
	public $level;
	public $group;
	public $splitfirstname;
	public $splitlastname;
	public $claimed;
	public $id;
	public $total = 1;
	
	private $format;
	
	public function __construct($format)
	{
		$this->format = $format;
	}
	
	public function __toString()
	{
		$source  = $this->templateSource();
		
		$data    = array('firstname'     => $this->firstname,
		                 'lastname'      => $this->lastname,
		                 'total'         => $this->total,
		                 'level'         => $this->level,
		                 'id'            => $this->id,
		                 'querystring'   => $this->querystring());
		
		switch($this->format)
		{
			case Ticket::TEMPLATE_UNCLAIMED:
				$this->prepareSplitNotifications($data);
				$this->prepareUnclaimed($data);
				break;
			
			case Ticket::TEMPLATE_REDEEM:
				$this->prepareRedeem($data);
				break;
			
			case Ticket::TEMPLATE_CLAIMED:
				$this->prepareSplitNotifications($data);
				$this->prepareClaimed($data);
				break;
		}
		
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $data);
	}
	
	private function templateSource()
	{
		switch($this->format)
		{
			case Ticket::TEMPLATE_UNCLAIMED:
				return LADDDoor::application_root().'/application/controls/TicketUnclaimed.html';
				break;
			
			case Ticket::TEMPLATE_REDEEM:
				return LADDDoor::application_root().'/application/controls/TicketRedeem.html';
				break;
			
			case Ticket::TEMPLATE_CLAIMED:
				return LADDDoor::application_root().'/application/controls/TicketClaimed.html';
				break;
			
			case Ticket::TEMPLATE_SPLIT_UNCLAIMED:
				return LADDDoor::application_root().'/application/controls/TicketSplitUnclaimed.html';
				break;
			
			case Ticket::TEMPLATE_SPLIT_CLAIMED:
				return LADDDoor::application_root().'/application/controls/TicketSplitClaimed.html';
				break;
		}
	}
	
	private function prepareSplitNotifications(&$data)
	{
		$data['split_status'] = $this->total > 1 ? 'enabled' : 'disabled';
		$data['split_action'] = $data['split_status'] == 'enabled' ? 'split.php?'.$data['querystring'] : '#unavilable';
		
		
		if($this->splitfirstname && $this->splitlastname)
		{
			//$text = "Above ticket was split, originally purchased by: ";
			$text = "Originally purchased by: ";
			$text.= $this->splitfirstname.' '.$this->splitlastname;
			$notification = new TicketNotification($text);
			
			if(!isset($data['notifications'])) $data['notifications'] = array();
			
			$data['notifications'][] = $notification;
			$data['notification_flag'] = new NotificationFlag("Split Ticket");
		}
	}
	
	private function prepareUnclaimed(&$data)
	{
	}
	
	private function prepareRedeem(&$data)
	{
		if($this->claimed)
		{
			if(!isset($data['notifications'])) $data['notifications'] = array();
			
			$data['notifications'][] = new TicketNotification('This ticket is already claimed');
		}
	}
	
	private function prepareClaimed(&$data)
	{
		$data['id'] = implode(', ', $this->group);
	}
	
	private function querystring()
	{
		$qs = array();
		
		$qs['numtix'] = $this->total;
		$qs['id']     = array();
		
		$count = count($this->group);
		
		for($i = 0; $i < $count; $i++)
		{
			$qs['id'][] = $this->group[$i];
		}
		
		return http_build_query($qs);
	}
}
?>