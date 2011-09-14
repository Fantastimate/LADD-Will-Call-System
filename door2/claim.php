<?php require realpath('./').'/application/system/LADDEnvironment.php' ?>
<?php LADDPage::CodeBehind('Claim.php'); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LADD Will Call Claim All tickets</title>
<link rel="stylesheet" HREF="resources/css/global.css" TYPE="text/css" />
<link rel="stylesheet" HREF="resources/css/tickets.css" TYPE="text/css" />
<link rel="stylesheet" HREF="resources/css/claim.css" TYPE="text/css" />
<script src="resources/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/jquery.corner.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/claim.init.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	
<div class="container">
	<div class="ui">
		<?php $page->showTickets() ?>
		<div class="action clearfix">
			<ul>
				<li class="confirm"><a href="index.php?claim=confirm&<?php echo $page->confirmQueryString() ?>">Hells <span>YES</span></a></li>
				<li class="cancel"><a href="index.php">Fuck <span>NO</span></a></li>
			</ul>
		</div>
	</div>
</div>
</body>
</html>