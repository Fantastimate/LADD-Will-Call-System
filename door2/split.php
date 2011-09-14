<?php require realpath('./').'/application/system/LADDEnvironment.php' ?>
<?php LADDPage::CodeBehind('Split.php'); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LADD Will Call Split Tickets</title>
<link rel="stylesheet" HREF="resources/css/global.css" TYPE="text/css" />
<link rel="stylesheet" HREF="resources/css/split.css" TYPE="text/css" />
<script src="resources/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/jquery.corner.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/split.init.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<div class="container">
		<div class="ui">
			<form name="splitform" action="index.php?claim=processsplit" method="post">
				<div class="ticket-list">
					<?php $page->showTickets() ?>
				</div>
				<div class="actions clearfix">
					<ul>
						<li class="confirm"><a href="submit">Submit</a></li>
						<li class="cancel"><a href="index.php">Nevermind</a></li>
					</ul>
				</div>
			</form>
		</div>
	</div>
</body>
</html>