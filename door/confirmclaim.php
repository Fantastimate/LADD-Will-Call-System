<?php
/*  Program name: 
 *  Description:  
 *                
 */
//ini_set("include_path",".:/home/door/DOOR/");
//include("door_variables.inc");
?>

<?php
$numtix = ($_GET['numtix']);
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$level = $_GET['level'];
$tick_CLAIMDATE=date('Y-m-d H:i:s');

	FOR ($i = 1; $i <= $numtix; $i++)
		{
			$tick_id = ($_GET['id'.$i]);
			$queryCheckTicket = "SELECT  `tick_CLAIMED` 
								FROM  `Door_Tickets` 
								WHERE  `tick_ID` =  '$tick_id'";
			$resultClaimTicket = mysqli_query($cxn,$queryCheckTicket)
				or die ("Sorry I was unable to verify that the ticket is unclaimed.  Please contact the System Administrator.");
			$tick_CLAIMED = mysqli_fetch_row($resultClaimTicket);
			if ($tick_CLAIMED[0] != 1){
				$queryUpdateTicket = "UPDATE Door_Tickets SET tick_CLAIMED='1', tick_CLAIMDATE='$tick_CLAIMDATE'
					 WHERE tick_ID ='$tick_id'";
				$resultClaimTicket = mysqli_query($cxn,$queryUpdateTicket)
					or die ("Couldn't execute queryUpdateTicket");
				echo "<div class='confirmed'>$level Ticket #$tick_id for $fname $lname marked claimed.</div>";
			} else {
				echo "<div class='alreadyclaimed'>The #$i ticket for $fname $lname is already claimed.</div>";
			}
		} 
//echo "update complete.<BR><BR><BR>";
//echo "<A HREF='index.php'>Return To Ticket Counter</A><BR>";
?>
