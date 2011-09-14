<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LADD Will Call Claim All tickets</title>
</head>
<body>
<?php
/*  Program name: 
 *  Description:  
 *                
 */
ini_set("include_path",".:/home/door/DOOR/");
include("door_variables.inc");
?>

<?php

$numtix = ($_GET['numtix']);

echo "<CENTER><TABLE CELLPADDING=10 BORDER=0><TR><TD VALIGN='TOP'>";
echo '<FONT SIZE=5><B>Are you <I>sure</I> you want to mark the following '.$numtix.' as redeemed?</B></FONT><BR><BR>';
echo "<Table CELLPADDING=4 BORDER=0>";

$claimurl = "index.php?claim=confirm&numtix=$numtix&";
	FOR ($i = 1; $i <= $numtix; $i++)
		{
			$tick_id = ($_GET['id'.$i]);
			$queryClaimTicket = "SELECT * FROM Door_Tickets 
		 		 WHERE tick_ID ='$tick_id'
		 		 ORDER BY tick_ATTENDLAST, tick_ATTENDFIRST";
			$resultClaimTicket = mysqli_query($cxn,$queryClaimTicket)
		    	or die ("Couldn't execute queryClaimTicket");
			$nrows = mysqli_num_rows($resultClaimTicket);
			$claimurl .='id';
			$claimurl .= $i;
			$claimurl .='=';
			$claimurl .= $tick_id;
			$claimurl .='&';

		if ($nrows > 0)
			{				
			while ($ticketrow = mysqli_fetch_assoc($resultClaimTicket))
				{
				extract ($ticketrow);
				echo '<tr><TD><FONT SIZE=5>';
				echo $tick_LEVEL;
				echo '</TD><TD><FONT SIZE=5>';
				echo $tick_ATTENDFIRST;
				echo '</TD><TD><FONT SIZE=5>';
				echo $tick_ATTENDLAST;
				echo '</TD>';
				if ($tick_CLAIMED == '1'){
					echo "<td>This ticket is already claimed</td>";
				}
				echo "</tr>";
				}
			}
		} 
$claimurl .= 'fname=';
$claimurl .= $tick_ATTENDFIRST;
$claimurl .= '&lname=';
$claimurl .= $tick_ATTENDLAST;
$claimurl .= '&level=';
$claimurl .= $tick_LEVEL;
echo '</TABLE></TABLE>';
echo '<BR><BR>';
echo '<FONT SIZE=5><A HREF="';
echo $claimurl;
echo '">Hells <B>YES</B></A>';
echo '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ';
echo '<A HREF="index.php">Fuck <B>NO</B></A></FONT>';
?>
</body>
</html>