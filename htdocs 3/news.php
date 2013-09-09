<?php session_start(); ?>
<html>
<head>
<link href="css/news.css" rel="stylesheet" type="text/css"/>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200' rel='stylesheet' type='text/css'>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	    <script type="text/javascript" src="scripts/news.js"></script>
	    
		<?php
		if (isset($_SESSION['loggedin'])){
			echo '<script type="text/javascript">var loggedin=' . $_SESSION['loggedin'] . '</script>';
		}else
			echo '<script type="text/javascript">var loggedin="notset"</script>';

		if (isset($_SESSION['clofus_id']))
			echo '<script type="text/javascript">var clofus_id=' . $_SESSION['clofus_id'] . '</script>';
		else
			echo '<script type="text/javascript">var clofus_id="notset"</script>';
		
		if (isset($_SESSION['signedup']))
			echo '<script type="text/javascript">var signedup=' . $_SESSION['signedup'] . '</script>';
		else
			echo '<script type="text/javascript">var signedup="notset"</script>';

		if (isset($_SESSION['name']))
			echo '<script type="text/javascript">var name="' . $_SESSION['name'] . '"</script>';
		else
			echo '<script type="text/javascript">var name="notset"</script>';	
			
		if (isset($_SESSION['pic_small'])){
			echo '<script type="text/javascript">var cpic_small="'.$_SESSION['pic_small'].'"</script>'; 
		}else
			echo '<script type="text/javascript">var cpic_small="notset"</script>';	
	
	
		if (isset($_SESSION['email'])){
			echo '<script type="text/javascript">var cemail="'.$_SESSION['email'].'"</script>';
		}else
			echo '<script type="text/javascript">var cemail="notset"</script>';	
	
		
		if (isset($_SESSION['hometown_location'])){
			echo '<script type="text/javascript">var chometown_location="'.$_SESSION['hometown_location'].'"</script>';
		}else
			echo '<script type="text/javascript">var chometown_location="notset"</script>';	
	
	
?>
</head>
<body>
</body>

<div class='wrapper'>

<div class='newswrapper'>
	<div class='newsbody'>
		<div class='newsheader'>
			<div class='newslogo'>Clofus</div>
			<div class='newsmenu'>Home&nbsp;&nbsp;&nbsp;How it works!&nbsp;&nbsp;&nbsp;Invite friend</div>
		</div>
		<div class='profile'>
			<div class='profileimg'></div>
		</div>
		<div class='loading'>
			<div class='loadingimg'>
			</div>
		</div>
		<div class='newsfeed'>
			EMPTY
		</div>
		<div class="footer">
			<div class="footer1">Copyright 2012 Clofus. All rights reserved.</div>
			<div class="footer2">Terms & Conditions&nbsp;|&nbsp;Privacy Policy</div>
		</div>
	
	</div>
</div>


</div>
</html>