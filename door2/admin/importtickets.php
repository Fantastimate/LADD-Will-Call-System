<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import Tickets</title>
<style type="text/css">
<!--
body {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #666666;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
.oneColElsCtr #container {
	width: 46em;
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 1px solid #000000;
	text-align: left; /* this overrides the text-align: center on the body element. */
}
.oneColElsCtr #mainContent {
	padding: 0 20px; /* remember that padding is the space inside the div box and margin is the space outside the div box */
}
-->
</style></head>

<body class="oneColElsCtr">

<div id="container">
  <div id="mainContent">
    <?php  $comp = $_GET['comp'];
	switch ($comp) {
		case 'bpt':
			echo '- Log onto <A HREF="http://www.brownpapertickets.com/">Brown Paper Tickets</A>.<br />
- Deactivate ticket sales for the current event.<br />
- Go to the SALES link for the current event.<br />
- Select <I>"View individual sales in complete format."</I>.<br />
- Click <B>VIEW SALES</B> button.<br />
- On the top, click <I><B>Tab Delimited File (Excel).</B></I><br /><br />
- This will download a file called tdsales.xls to your computer.  Save this file.<br />
- Edit the name of the tdsales.xls file to reflect the game date (example: <I>tdsales-12-04-2009.xls</I>)<br /><br />

Use the form below to upload the xls file into the system.<br /><br /><br />';
			echo '<form action="upload_file_bpt.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<input type="submit" name="submit" value="Submit" />
</form><BR><BR>

<FONT SIZE=4>
- Please be sure ticket sales are closed before using this interface: there will be no way to reload ticket data!<BR>
- Be sure to only load the BPT tdsales file once!<BR>
</FONT>';
			break;
		case 'gold':
			echo 'GoldStar';
			echo '<form action="upload_file_gold.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<input type="submit" name="submit" value="Submit" />
</form><BR><BR>

<FONT SIZE=4>
- Please be sure ticket sales are closed before using this interface: there will be no way to reload ticket data!<BR>
- Be sure to only load the BPT tdsales file once!<BR>
</FONT>';
			break;
		case 'stub':
			echo 'StubDog';
			echo '<form action="upload_file_stub.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<input type="submit" name="submit" value="Submit" />
</form><BR><BR>

<FONT SIZE=4>
- Please be sure ticket sales are closed before using this interface: there will be no way to reload ticket data!<BR>
- Be sure to only load the BPT tdsales file once!<BR>
</FONT>';
			break;
	} ?>
	<!-- end #mainContent --></div>
<!-- end #container --></div>
</body>
</html>