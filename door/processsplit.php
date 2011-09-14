<?php
/*  Program name: 
 *  Description:  
 *                
 */
//ini_set("include_path",".:/home/door/DOOR/");
//include("door_variables.inc");
?>

<?php



$numtix = ($_POST['numtix']);
$tick_CLAIMDATE=date('Y-m-d H:i:s');

FOR ($i = 1; $i <= $numtix; $i++){
		$tixaction = ($_POST["ticket$i"]);
		$tick_id = ($_POST["ticketid$i"]);
		$hostFirstName = ($_POST["hostfirstname$i"]);
		$hostLastName = ($_POST["hostlastname$i"]);
		$level = ($_POST["ticketlevel$i"]);
		if ($tixaction == 'claim'){
			$queryCheckTicket = "SELECT  `tick_CLAIMED` 
								FROM  `Door_Tickets` 
								WHERE  `tick_ID` =  '$tick_id'";
			$resultClaimTicket = mysqli_query($cxn,$queryCheckTicket)
				or die ("Sorry I was unable to verify that the ticket is unclaimed.  Please contact the System Administrator.");
			$tick_CLAIMED = mysqli_fetch_row($resultClaimTicket);
			if ($tick_CLAIMED[0] != '1'){
				$queryUpdateTicket = "UPDATE Door_Tickets SET tick_CLAIMED='1', tick_CLAIMDATE='$tick_CLAIMDATE'
					 				WHERE tick_ID ='$tick_id'";
				$resultClaimTicket = mysqli_query($cxn,$queryUpdateTicket)
					or die ("Couldn't execute queryUpdateTicket");
				echo "<div class='confirmed'>$i)$level Ticket #$tick_id for $hostFirstName $hostLastName marked claimed.</div>";
			} else {
				echo "<div class='alreadyclaimed'>The #$i ticket for $hostFirstName $hostLastName is already claimed.</div>";
			}
		} 
		elseif ($tixaction == 'split'){
			$splitFirstName = ($_POST["splitfirstname$i"]);
			$splitLastName = ($_POST["splitlastname$i"]);
			$hostFirstName = ($_POST["hostfirstname$i"]);
			$hostLastName = ($_POST["hostlastname$i"]);
			$queryCheckTicket = "SELECT  `tick_CLAIMED` 
								FROM  `Door_Tickets` 
								WHERE  `tick_ID` =  '$tick_id'";
			$resultClaimTicket = mysqli_query($cxn,$queryCheckTicket)
				or die ("Sorry I was unable to verify that the ticket is unclaimed.  Please contact the System Administrator.");
			$tick_CLAIMED = mysqli_fetch_row($resultClaimTicket);
			if (($splitFirstName == 'Firstname') or ($splitLastName == 'Lastname')){
				if ($tick_CLAIMED[0] != '1'){
					echo "The #$i $level item submitted still contains the default First and/or Last Name. No update was made for this ticket. <br />'";
				} else {
					echo "The #$i ticket for $hostFirstName $hostLastName is already claimed.<br />";
				}
			}
			elseif (($splitFirstName == '') or ($splitLastName == '')){
				if ($tick_CLAIMED[0] != '1'){
					echo "The #$i $level item submitted contains a blank First and/or Last Name. No update was made for this ticket. <br />'";
				} else {
					echo "The #$i ticket for $hostFirstName $hostLastName is already claimed.<br />";
				}
			}
			else{
				if ($tick_CLAIMED[0] != '1'){
					$queryUpdateTicket =   "UPDATE Door_Tickets 
											SET tick_SPLITHOSTLAST='$hostLastName', tick_SPLITHOSTFIRST='$hostFirstName', tick_ATTENDLAST='$splitLastName', tick_ATTENDFIRST='$splitFirstName' 
											WHERE tick_ID ='$tick_id'";
					$resultClaimTicket = mysqli_query($cxn,$queryUpdateTicket)
						or die ("Couldn't execute queryUpdateTicket");
					echo "$i) $level Ticket #$tick_id has been split and marked for pickup by $splitFirstName $splitLastName.<br />";
				} else {
					echo "The #$i ticket for $hostFirstName $hostLastName is already claimed.<br />";
				}
			}

		}
		elseif ($tixaction == '')
		{
				
				echo "The #$i $level item submitted without selecting to claim or split the ticket.  
					No change was made to this ticket and it will remain in the system under the name $hostFirstName $hostLastName.<br />";
			}
	}
//echo "Return to the <a href='index.php'>ticketlist</A>.";


?>
