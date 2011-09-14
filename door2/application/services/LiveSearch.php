<?php
require realpath('../../').'/application/system/LADDEnvironment.php';
require LADDDoor::application_root().'/application/queries/LADDDoorQueryLiveSearch.php';

$tickets = new LADDDoorQueryLiveSearch(LADDDoor::database(), array('query'=>$_GET['q']));

$response = array();
foreach($tickets as $ticket)
{
	$row = new stdClass();
	
	$row->lastname  = $ticket['tick_ATTENDLAST'];
	$row->firstname = $ticket['tick_ATTENDFIRST'];
	$row->claimed   = $ticket['tick_CLAIMED'] ? true : false;
	$row->level     = $ticket['tick_LEVEL'];
	$row->total     = $ticket['tick_TOTAL'];
	$row->ids       = array_map("intval", explode(',', $ticket['tick_TICKETIDS']));
	
	$response[] = $row;
}

header('Content-Type: application/json');
echo json_encode($response);

?>