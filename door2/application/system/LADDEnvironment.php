<?php
require 'LADDDoor.php';
require 'LADDPage.php';
require LADDDoor::application_root().'/application/viewcontrollers/LADDViewController.php';
require LADDDoor::application_root().'/application/lib/axismundi/data/AMQuery.php';
require LADDDoor::application_root().'/application/lib/axismundi/display/AMDisplayObject.php';

require LADDDoor::application_root().'/application/controls/LetterSort.php';
require LADDDoor::application_root().'/application/controls/Letter.php';

date_default_timezone_set('America/Los_Angeles');

//if (session_id() == "") session_start();

?>