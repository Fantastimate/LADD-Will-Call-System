<?php require realpath('./').'/application/system/LADDEnvironment.php' ?>
<?php LADDPage::CodeBehind('DoorMain.php'); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LADD Will Call System</title>
<link rel="stylesheet" href="resources/css/global.css" type="text/css" />
<link rel="stylesheet" href="resources/css/letterNavigation.css" type="text/css" />
<link rel="stylesheet" href="resources/css/tickets.css" type="text/css" />
<link rel="stylesheet" href="resources/css/notifications.css" type="text/css" />
<link rel="stylesheet" href="resources/css/infoBox.css" type="text/css" />
<link rel="stylesheet" href="resources/css/live-search.css" type="text/css" />
<script src="resources/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/jquery.corner.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/jquery-ui-1.8.1.custom.min.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/notifications.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/index.init.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/live-search.init.js" type="text/javascript" charset="utf-8"></script>
<script src="resources/js/mustache.js" type="text/javascript" charset="utf-8"></script>
<script type="text/html" id="template-live-search-result-unclaimed">
	<ul class="live-search-result unclaimed">
		<li class="actions" data-context="live-search-element">
			<div class="split {{split_status}}"><a href="split.php?{{querystring}}">SPLIT</a></div>
			<div class="claim"><a href="claim.php?{{querystring}}">CLAIM</a></div>
		</li>
		<li class="name" data-context="live-search-element">{{lastname}}, {{firstname}}</li> 
		<li class="level" data-context="live-search-element">{{total}} {{level}}</li>
	</ul>
</script>
<script type="text/html" id="template-live-search-result-claimed">
	<ul class="live-search-result claimed">
		<li class="name" data-context="live-search-element">{{lastname}}, {{firstname}}</li> 
		<li class="level" data-context="live-search-element">{{total}} {{level}}</li>
	</ul>
</script>

</head>
<body>
	
<div class="container">
	<div id="live-search">
		<div class="live-search-form">
			<input type="text" name="search" value="" id="search" data-context="live-search-element" placeholder="Search By Last Name">
		</div>
		<div class="live-search-results">
			
		</div>
	</div>
	<div class="ui">
		<div id="header">
			<div id="notifications-container">
				<?php $page->showNotifications() ?> 
			</div>
			<?php $page->letterSort() ?>
		</div>
		<div class="clearfix">
			<?php $page->showTickets() ?>
		</div>
	</div>
</div>
<div class="infoBox">
	<h3>Notification Title</h3>
	<p>Notification Message</p>
	<img src="./resources/images/graphics/popup-arrow.png" width="18" height="9">
</div>
</body>
</html>