<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LADD Will Call System</title>
<link rel="stylesheet" HREF="CSS/style.css" TYPE="text/css" />
</head>
<body>
<div id="container">
<?php
/*  Program name: 
 *  Description:  
 *                
 */
ini_set("include_path","C:/Users/MikeB/Documents/Repositories/LADDDoor/");
include("door_variables.inc");
/* First we check the URL to see if we passed a letter to display to the script */

	$passedletter = strtoupper($_GET['alph']);
?>
<div id="header">
    <div id="TicketProcess">
    <?php switch ($_GET['claim']){
        	case ('confirm'):
				include('confirmclaim.php');
				break;
			case ('processsplit'):
				include('processsplit.php');
				break;
    	}?>
    </div>
    <div id='lettersort'>
    <?php 	foreach (range('A','Z') as $i){
       			echo "<A HREF='index.php?alph=$i'>$i</A> ";
    		}?>
    </div>
    <?php if ($passedletter != ""){
    		echo "<div id='fullist'>";
    		echo "<A HREF='index.php'>FULL LIST</A>";
    		echo "</div>";
	}?>
</div>    
<?php
/* If We didn't, then we load the whole shebang, unclaimed first */
	If ($passedletter == "")
		{
		$queryUnclaimedTicketholders = "SELECT * FROM Door_Tickets 
		 		 WHERE tick_EVENTDATE = '$today' AND tick_CLAIMED = '0'
		 		 ORDER BY tick_ATTENDLAST, tick_ATTENDFIRST, tick_CARDNUM, tick_LEVEL";
		$resultUnclaimedTicketholders = mysqli_query($cxn,$queryUnclaimedTicketholders)
		    	or die ("Couldn't execute queryUnclaimedTicketholders");
		$nrows = mysqli_num_rows($resultUnclaimedTicketholders);

		if ($nrows > 0)
			{	
			$ref_ids=array();
			echo "<CENTER><TABLE CELLPADDING=20 BORDER=0><TR><TD VALIGN='TOP'>";
			echo "<B><FONT SIZE=5>Unclaimed Tickets: $nrows</FONT></B><BR><BR>";
			echo "<Table id='uclist' CELLPADDING=4 BORDER=1><TR>";
					
			while ($ticketrow = mysqli_fetch_assoc($resultUnclaimedTicketholders))
				{
				extract ($ticketrow);
				$check_tick_ID = $tick_ID;
				$check_tick_ATTENDLAST = $tick_ATTENDLAST;
				$check_tick_ATTENDFIRST = $tick_ATTENDFIRST;
				$check_tick_CARDNUM = $tick_CARDNUM;
				$check_tick_LEVEL = $tick_LEVEL;
				$check_tick_SPLITHOSTLAST = $tick_SPLITHOSTLAST;
				$check_tick_SPLITHOSTFIRST = $tick_SPLITHOSTFIRST;
				$check_currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
				$tickcounter = 1;
				$ref_ids[$tickcounter] = $check_tick_ID;
				
				while ($ticketrow = mysqli_fetch_assoc($resultUnclaimedTicketholders))
					{
					extract ($ticketrow);
					$currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
					$ref_ids[$tickcounter] = $check_tick_ID;
					if ($currentholder == $check_currentholder)
						{
						$check_tick_ID = $tick_ID;
						$tickcounter++;	
						}
					else
						{
						echo "<TD><FONT SIZE=4>$check_tick_ATTENDLAST</TD>";
						echo "<TD><FONT SIZE=4>$check_tick_ATTENDFIRST</TD>";
						echo "<TD><FONT SIZE=4>$tickcounter $check_tick_LEVEL</TD>";
						echo "<TD><FONT SIZE=4><A HREF='claim?numtix=$tickcounter&";
						FOR ($i = 1; $i <= (sizeof($ref_ids)); $i++)
							{
 						 	echo "id$i=$ref_ids[$i]&";
							} 
						echo "'>CLAIM</A></FONT></TD>";
						
						if ($tickcounter > 1)
						{
							echo "<TD><FONT SIZE=4><A HREF='split?numtix=$tickcounter&";
							FOR ($i = 1; $i <= (sizeof($ref_ids)); $i++)
								{
 								echo "id$i=$ref_ids[$i]&";
								} 
							echo "'>SPLIT</A></FONT></TD></TR>";
						}
						else
						{
							echo "<TD></TD></TR>";
						}
						
						if (($check_tick_SPLITHOSTLAST != '') and ($check_tick_SPLITHOSTFIRST != ''))
						{
							echo "<TR><TD COLSPAN=5><FONT SIZE=2>Above ticket was split, originally purchased by:
								 $check_tick_SPLITHOSTFIRST $check_tick_SPLITHOSTLAST</TD></TR>";
						}



						$check_tick_ID = $tick_ID;
						$check_tick_ATTENDLAST = $tick_ATTENDLAST;
						$check_tick_ATTENDFIRST = $tick_ATTENDFIRST;
						$check_tick_CARDNUM = $tick_CARDNUM;
						$check_tick_LEVEL = $tick_LEVEL;
						$check_tick_SPLITHOSTLAST = $tick_SPLITHOSTLAST;
						$check_tick_SPLITHOSTFIRST = $tick_SPLITHOSTFIRST;
						$check_currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
						$tickcounter = 1;
						$ref_ids=array();
						}
					}
				$ref_ids[$tickcounter] = $check_tick_ID;
						echo "<TD><FONT SIZE=4>$check_tick_ATTENDLAST</TD>";
						echo "<TD><FONT SIZE=4>$check_tick_ATTENDFIRST</TD>";
						echo "<TD><FONT SIZE=4>$tickcounter $check_tick_LEVEL</TD>";
						echo "<TD><FONT SIZE=4><A HREF='claim?numtix=$tickcounter&";
						FOR ($i = 1; $i <= (sizeof($ref_ids)); $i++)
							{
 						 	echo "id$i=$ref_ids[$i]&";
							} 
						echo "'>CLAIM</A></FONT></TD>";
						
						if ($tickcounter > 1)
						{
							echo "<TD><FONT SIZE=4><A HREF='split?numtix=$tickcounter&";
							FOR ($i = 1; $i <= (sizeof($ref_ids)); $i++)
								{
 								echo "id$i=$ref_ids[$i]&";
								} 
							echo "'>SPLIT</A></FONT></TD></TR>";
						}
						else
						{
							echo "<TD></TD></TR>";
						}

						if (($check_tick_SPLITHOSTLAST != '') and ($check_tick_SPLITHOSTFIRST != ''))
						{
							echo "<TR><TD COLSPAN=5><FONT SIZE=2>Above ticket was split, originally purchased by:
								 $check_tick_SPLITHOSTFIRST $check_tick_SPLITHOSTLAST</TD></TR>";
						}
				echo "</TABLE>";
				}
			}

		$queryClaimedTicketholders = "SELECT * FROM Door_Tickets 
		 		 WHERE tick_EVENTDATE = '$today' AND tick_CLAIMED = '1'
		 		 ORDER BY tick_ATTENDLAST, tick_ATTENDFIRST, tick_CARDNUM, tick_LEVEL";
		$resultClaimedTicketholders = mysqli_query($cxn,$queryClaimedTicketholders)
		    	or die ("Couldn't execute queryClaimedTicketholders");
		$nrows = mysqli_num_rows($resultClaimedTicketholders);

		if ($nrows > 0)
			{	
			echo "<TD VALIGN='TOP'>";
			echo "<B><FONT SIZE=5>Claimed Tickets: $nrows</FONT></B><BR><BR>";
			echo "<Table id='clist' CELLPADDING=4 BORDER=1><TR>";
					
			while ($ticketrow = mysqli_fetch_assoc($resultClaimedTicketholders))
				{
				extract ($ticketrow);
				$check_tick_ID = $tick_ID;
				$check_tick_ATTENDLAST = $tick_ATTENDLAST;
				$check_tick_ATTENDFIRST = $tick_ATTENDFIRST;
				$check_tick_CARDNUM = $tick_CARDNUM;
				$check_tick_LEVEL = $tick_LEVEL;
				$check_tick_CLAIMDATE = $tick_CLAIMDATE;
				$check_currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
				$tickcounter = 1;

				while ($ticketrow = mysqli_fetch_assoc($resultClaimedTicketholders))
					{
					extract ($ticketrow);
					$currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
					if ($currentholder == $check_currentholder)
						{
						$tickcounter++;					
						}
					else
						{
						echo "<TD><FONT SIZE=4>$check_tick_ATTENDLAST</TD>";
						echo "<TD><FONT SIZE=4>$check_tick_ATTENDFIRST</TD>";
						echo "<TD><FONT SIZE=4>$tickcounter $check_tick_LEVEL</TD>";
						//echo "<TD><FONT SIZE=4>$check_tick_CLAIMDATE</TD>";
						echo "</TR>";

						$check_tick_ID = $tick_ID;
						$check_tick_ATTENDLAST = $tick_ATTENDLAST;
						$check_tick_ATTENDFIRST = $tick_ATTENDFIRST;
						$check_tick_CARDNUM = $tick_CARDNUM;
						$check_tick_LEVEL = $tick_LEVEL;
						$check_tick_CLAIMDATE = $tick_CLAIMDATE;
						$check_currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
						$tickcounter = 1;
						}
					}
				}
				echo "<TD><FONT SIZE=4>$tick_ATTENDLAST</TD>";
				echo "<TD><FONT SIZE=4>$tick_ATTENDFIRST</TD>";
				echo "<TD><FONT SIZE=4>$tickcounter $tick_LEVEL</TD>";
				//echo "<TD><FONT SIZE=4>$check_tick_CLAIMDATE</TD>";
				echo "</TR>";
				echo "</TR></TABLE></TABLE>";
			}
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
/* If We did, then we load just the letter */
	else
		{
		
		$queryTicketholders = "SELECT * FROM Door_Tickets 
		 		 WHERE tick_EVENTDATE = '$today' AND tick_ATTENDLAST LIKE '$passedletter%'
		 		 ORDER BY tick_Claimed, tick_ATTENDLAST, tick_ATTENDFIRST";
		$resultTicketholders = mysqli_query($cxn,$queryTicketholders)
		    	or die ("Couldn't execute query Ticketholders");
		$nrows = mysqli_num_rows($resultTicketholders);;

		if ($nrows > 0)
			{	
			echo "<CENTER><TABLE CELLPADDING=20 BORDER=0><TR><TD VALIGN='TOP'>";
			echo "<B><FONT SIZE=5>Unclaimed Tickets ";
			echo $passedletter;
			echo "</FONT></B><BR><BR>";
			echo "<Table id='uclist' CELLPADDING=4 BORDER=1><TR>";
			$counter = 1;

			while ($ticketrow = mysqli_fetch_assoc($resultTicketholders))
				{
				extract ($ticketrow);
				$check_tick_ID = $tick_ID;
				$check_tick_ATTENDLAST = $tick_ATTENDLAST;
				$check_tick_ATTENDFIRST = $tick_ATTENDFIRST;
				$check_tick_CARDNUM = $tick_CARDNUM;
				$check_tick_LEVEL = $tick_LEVEL;
				$check_tick_SPLITHOSTLAST = $tick_SPLITHOSTLAST;
				$check_tick_SPLITHOSTFIRST = $tick_SPLITHOSTFIRST;
				$check_currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
				$tickcounter = 1;
				$ref_ids[$tickcounter] = $check_tick_ID;
				
				while ($ticketrow = mysqli_fetch_assoc($resultTicketholders))
					{
					extract ($ticketrow);
					$currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
					$ref_ids[$tickcounter] = $check_tick_ID;
					if ($currentholder == $check_currentholder)
						{
						$check_tick_ID = $tick_ID;
						$tickcounter++;	
						}
					else
						{
						echo "<TD><FONT SIZE=4>$check_tick_ATTENDLAST</TD>";
						echo "<TD><FONT SIZE=4>$check_tick_ATTENDFIRST</TD>";
						echo "<TD><FONT SIZE=4>$tickcounter $check_tick_LEVEL</TD>";
						echo "<TD><FONT SIZE=4><A HREF='claim?numtix=$tickcounter&";
						FOR ($i = 1; $i <= (sizeof($ref_ids)); $i++)
							{
 						 	echo "id$i=$ref_ids[$i]&";
							} 
						echo "'>CLAIM</A></FONT></TD>";
						
						if ($tickcounter > 1)
						{
							echo "<TD><FONT SIZE=4><A HREF='split?numtix=$tickcounter&";
							FOR ($i = 1; $i <= (sizeof($ref_ids)); $i++)
								{
 								echo "id$i=$ref_ids[$i]&";
								} 
							echo "'>SPLIT</A></FONT></TD></TR>";
						}
						else
						{
							echo "<TD></TD></TR>";
						}

						if (($check_tick_SPLITHOSTLAST != '') and ($check_tick_SPLITHOSTFIRST != ''))
						{
							echo "<TR><TD COLSPAN=5><FONT SIZE=2>Above ticket was split, originally purchased by:
								 $check_tick_SPLITHOSTFIRST $check_tick_SPLITHOSTLAST</TD></TR>";
						}

						$check_tick_ID = $tick_ID;
						$check_tick_ATTENDLAST = $tick_ATTENDLAST;
						$check_tick_ATTENDFIRST = $tick_ATTENDFIRST;
						$check_tick_CARDNUM = $tick_CARDNUM;
						$check_tick_LEVEL = $tick_LEVEL;
						$check_tick_SPLITHOSTLAST = $tick_SPLITHOSTLAST;
						$check_tick_SPLITHOSTFIRST = $tick_SPLITHOSTFIRST;
						$check_currentholder = $tick_ATTENDLAST.$tick_ATTENDFIRST.$tick_CARDNUM.$tick_LEVEL;
						$tickcounter = 1;
						$ref_ids=array();
						}
					}
				$ref_ids[$tickcounter] = $check_tick_ID;
				echo "<TD><FONT SIZE=4>$tick_ATTENDLAST</TD>";
				echo "<TD><FONT SIZE=4>$tick_ATTENDFIRST</TD>";
				echo "<TD><FONT SIZE=4>$tickcounter $check_tick_LEVEL</TD>";
				echo "<TD><FONT SIZE=4><A HREF='claim?numtix=$tickcounter&";
						FOR ($i = 1; $i <= (sizeof($ref_ids)); $i++)
						{
 						 echo "id$i=$ref_ids[$i]&";
						} 
				echo "'>CLAIM</A></TD>";

				if ($tickcounter > 1)
						{
							echo "<TD><FONT SIZE=4><A HREF='split?numtix=$tickcounter&";
							FOR ($i = 1; $i <= (sizeof($ref_ids)); $i++)
								{
 								echo "id$i=$ref_ids[$i]&";
								} 
							echo "'>SPLIT</A></FONT></TD></TR>";
						}
						else
						{
							echo "<TD></TD></TR>";
						}

				if (($check_tick_SPLITHOSTLAST != '') and ($check_tick_SPLITHOSTFIRST != ''))
						{
							echo "<TR><TD COLSPAN=5><FONT SIZE=2>Above ticket was split, originally purchased by:
								 $check_tick_SPLITHOSTFIRST $check_tick_SPLITHOSTLAST</TD></TR>";
						}
						echo "</TABLE>";
				}
			}
		}
			
?>
</body>
</html>