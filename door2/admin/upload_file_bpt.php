<?php
	$path = realpath('../');
	ini_set("include_path",".:/home/door/door/");
	include($path."/door_variables.inc");


if ($_FILES["file"]["size"] < 500000)
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
    {
	echo "<B>";
	echo $_FILES["file"]["name"] . " already exists. ";
	echo "</B>";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"]. "<br />";
      $path = "upload/";
      $path.= $_FILES["file"]["name"];

	$f = fopen($path,"r");
      	while($array = fgetcsv($f,5000,"\t")) 
		{
			$tick_NUM=trim($array[0]);  
			$tick_ORDERDATE=date('Y-m-d H:i:s', (strtotime($array[1])));
			$tick_EVENTDATE=date('Y-m-d', (strtotime($array[2])));
			$tick_ATTENDLAST=ucfirst(trim($array[4]));
			$tick_ATTENDFIRST=ucfirst(trim($array[5]));
			$tick_SHIPLAST=ucfirst(trim($array[6]));
			$tick_SHIPFIRST=ucfirst(trim($array[7]));
			$tick_SHIPADDR=trim($array[8]);
			$tick_SHIPCITY=trim($array[9]);
			$tick_SHIPSTATE=trim($array[10]);
			$tick_SHIPZIP=trim($array[11]);
			$tick_SHIPPHONE=trim($array[13]);
			$tick_EMAIL=trim($array[14]);
			$tick_CARDNUM=substr($array[15], 12);
			$tick_LEVEL=substr($array[18], 0, 3);

 			if(is_numeric($tick_NUM))
    				{
        			$queryBPTentry = "INSERT INTO Door_Tickets 
				(tick_NUM, tick_ORDERDATE, tick_EVENTDATE, tick_ATTENDLAST, tick_ATTENDFIRST, tick_SHIPLAST, 
				tick_SHIPFIRST, tick_SHIPADDR, tick_SHIPCITY, tick_SHIPSTATE, tick_SHIPZIP, tick_SHIPPHONE,
				tick_EMAIL, tick_CARDNUM, tick_LEVEL)
				VALUES 
				('$tick_NUM', '$tick_ORDERDATE', '$tick_EVENTDATE', '$tick_ATTENDLAST' , '$tick_ATTENDFIRST' , '$tick_SHIPLAST' , 
				'$tick_SHIPFIRST' , '$tick_SHIPADDR' , '$tick_SHIPCITY' , '$tick_SHIPSTATE' , '$tick_SHIPZIP' , '$tick_SHIPPHONE',
				'$tick_EMAIL' , '$tick_CARDNUM' , '$tick_LEVEL')";
	 		 mysqli_query($cxn,$queryBPTentry)
		 		 or die ("Couldn't execute query insert into.");
    				}
   				 else
   				 {

   				 }	 		 
		}
	fclose($f);
	echo "<B>BPT Data Added.</B><BR><BR>";
	echo "<A HREF='../'>user console</A> ";
	echo "<A HREF='../admin/'>admin console</A> ";
      }
    }
  }
else
  {
  echo "Invalid file";
  }
?> 

