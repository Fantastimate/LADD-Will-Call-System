<?php
class TicketList implements Countable, ArrayAccess, Iterator
{
	private $data;
	private $tickets = 0;
	private $currentIndex;
	
	public function __construct()
	{
		
	}
	
	public function append(Ticket $ticket)
	{
		if(!isset($this->data)) $this->data = array('tickets'=>array());
		$this->tickets           = $this->tickets + $ticket->total;
		$this->data['tickets'][] = $ticket;
	}
	
	public function setTitle($value)
	{
		$this->data['title'] = $value;
	}
	
	public function count()
	{
		return $this->tickets;
	}
	
	/* ArrayAccess */
	public function offsetExists ($offset)
	{
		return isset($this->data['tickets'][$offset]);
	}
	
	public function offsetGet ($offset)
	{
		return isset($this->data['tickets'][$offset]) ? $this->data['tickets'][$offset] : null;
	}
	
	public function offsetSet ($offset, $value)
	{
		$this->data['tickets'][$offset] = $value;
	}
	
	public function offsetUnset ($offset )
	{
		unset($this->data['tickets'][$offset]);
	}
	
	/* Iterator */
	function rewind() 
	{
		$this->currentIndex = 0;
	}

	function current() 
	{
		return $this->data['tickets'][$this->currentIndex];
	}

	function key() 
	{
		return $this->currentIndex;
	}

	function next() 
	{
		++$this->currentIndex;
	}

	function valid() 
	{
		return isset($this->data['tickets'][$this->currentIndex]);
	}
	
	public function __toString()
	{
		$source              = LADDDoor::application_root().'/application/controls/TicketList.html';
		$this->data['total'] = count($this);
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $this->data);
	}
}
?>