<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LADD Will Call Split Tickets</title>
</head>
<body>
<?php
/*  Program name: 
 *  Description:  
 *                
 */
ini_set("include_path",".:/home/door/door/");
include("door_variables.inc");
?>

<?php

$numtix = ($_GET['numtix']);
$alreadyclaimed = 0;
echo "<Form name='splitform' action='index.php?claim=processsplit' method='POST'>";
echo "<TABLE CELLSPACING=10>";

FOR ($i = 1; $i <= $numtix; $i++){
			$tick_id = ($_GET['id'.$i]);
			$querySplitTicket = "SELECT * FROM Door_Tickets 
		 		 WHERE tick_ID ='$tick_id'
		 		 ORDER BY tick_ATTENDLAST, tick_ATTENDFIRST";
			$resultSplitTicket = mysqli_query($cxn,$querySplitTicket)
		    	or die ("Couldn't execute querySplitTicket");
			$nrows = mysqli_num_rows($resultSplitTicket);

		if ($nrows > 0){				
			while ($ticketrow = mysqli_fetch_assoc($resultSplitTicket)){
				extract ($ticketrow);
				
				echo '<TD><FONT SIZE=4>';
				echo "$i)";
				echo '<TD><FONT SIZE=4>';
				echo $tick_LEVEL;
				echo '</TD><TD><FONT SIZE=4>';
				if ($tick_CLAIMED != '1') {
					echo $tick_ATTENDFIRST." ";
					echo $tick_ATTENDLAST;
					echo '</TD><TD><FONT SIZE=4>';
					echo "<input type= 'radio' name='ticket$i' value='claim'
						onclick=\"javascript:document.splitform.splitfirstname$i.disabled=true;
						javascript:document.splitform.splitlastname$i.disabled=true\">Claim";
					echo '</TD><TD><FONT SIZE=4>';
					echo "<input type= 'radio' name='ticket$i' value='split'
						onclick=\"javascript:document.splitform.splitfirstname$i.disabled=false;
						javascript:document.splitform.splitlastname$i.disabled=false\">Split";
				} else {
					echo "Ticket for $tick_ATTENDFIRST $tick_ATTENDLAST Already Claimed</td><td>";
					echo "<input type='radio' name='ticket$i' value='claim' disabled='disabled' checked='checked'>Claimed";
					echo '</TD><TD><FONT SIZE=4>';
					echo "<input type= 'radio' name='ticket$i' value='split' disabled='disabled'>Split";
					$alreadyclaimed += 1;
				}
				echo "</TD><TD><FONT SIZE=3>";
					echo "<input type= 'text' name='splitfirstname$i' value ='Firstname' 
						onclick=\"this.value='';\" disabled=true>";
					echo "<input type= 'text' name='splitlastname$i' value ='Lastname' 
						onclick=\"this.value='';\" disabled=true>";
					echo "<input type='hidden' name='hostfirstname$i' value='$tick_ATTENDFIRST'>";
					echo "<input type='hidden' name='hostlastname$i' value='$tick_ATTENDLAST'>";
					echo "<input type='hidden' name='ticketid$i' value='$tick_id'>";
					echo "<input type='hidden' name='ticketlevel$i' value='$tick_LEVEL'>";
				echo '</TD></TR><TR></TR>';
			}
		}
	} 

echo "</table>";
echo "<input type='hidden' name='numtix' value='$numtix'>";
if ($alreadyclaimed < $numtix){
	echo "<INPUT TYPE='button' value='Nevermind' onClick=\"parent.location='index.php'\"> ";
	echo "<input type='submit' value='Submit' />";
} else {
	echo "<input type='button' value='Return' onClick=\"parent.location='index.php'\"/>";
}
echo "</form>";
?>
</body>
</html>