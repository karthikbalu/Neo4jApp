<?php session_start(); ?>
<html>
<head>
 <link href="css/login.css" rel="stylesheet" type="text/css"/>
 <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200' rel='stylesheet' type='text/css'>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	    <script type="text/javascript" src="scripts/index.js"></script>

<?php
		if (isset($_SESSION['loggedin'])){
		    if ($_SESSION['loggedin']==1){
				echo '<script type="text/javascript">var loggedin=' . $_SESSION['loggedin'] . '</script>';
				echo("<script> top.location.href='news.php'</script>");
			}elseif($_SESSION['loggedin']==2){
				echo '<script type="text/javascript">var loggedin=' . $_SESSION['loggedin'] . '</script>';
				echo("<script> alert('Error with your facebook signup')</script>");
			}elseif($_SESSION['loggedin']==0){
				echo '<script type="text/javascript">var loggedin=' . $_SESSION['loggedin'] . '</script>';
			}
			else{
				echo '<script type="text/javascript">var loggedin=' . $_SESSION['loggedin'] . '</script>';
				echo("<script> console.log('Not loggedin yet')</script>");
			}
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
			echo '<script type="text/javascript">var name=' . $_SESSION['name'] . '</script>';
		else
			echo '<script type="text/javascript">var name="notset"</script>';		
?>


</head>
<body>
</body>
<div class='wrapper'>
<div class='loginwrapper'>


<div class='logo'><a class="logolink" href="index.php">Clofus</a></div>
<div class='sublogotext'>Be Surprised by our selection of updated contents from the web</div>


<div class='loginsection'>
	<div class='loginleft'>
		<div class="heading1">Signup</div>
		<div class="heading11">Get all updated news..It's free always!</div>
		<div class="heading12"></div>
		<div class="innerloginleft">
			<div class="signuptext"> 
				<li> Get Updated News from Web </li> 
				<li> Get Documents of your interest </li> 
				<li> Discover the web like never before </li> 
			</div>
			
			 <div class="signup">
			    <div class="ipbox">
			    <form name="signup" action="php/starter.php" method="post">
					<input type='text' class='ibox1' value="Email" name="semail" id="semail"></input>
					<input type='text' class='ibox1' value='Username' name="sname" id="sname"></input>
					<input type='text' class='ibox1' value="Password" name="spwd" id="spwd"></input>
				</form>
				</div>
				<div class='ifbbtn'>Signup with Facebook</div>
			 </div>
				
		</div>
	</div>
	
	<div class='loginright'>
        <div class='heading3'>Sign in</div>
		<div class='innerloginright'>
		    <form name="signin" action="php/signin_bck.php" method="post">
				<input type='text' class='ibox' value="Username" name="uname" id="uname"></input>
				<input type='text' class='ibox' value='Password' name="upwd" id="upwd"></input>
			</form>
			<div class="iforgot">Forgot Password?</div>
			<div class='ibutton'>Login</div>

		</div>
		
	</div>
</div>

<div class="footer">
	<div class="footer1">
			Copyright 2012 Clofus. All rights reserved.</div>
	<div class="footer2">
	        <a href="terms.php">Terms & Conditions</a>&nbsp;|&nbsp;<a href="terms.php">Privacy Policy</a>	        
	</div>
	<div class="footer3">
	<a class="sm-facebook" title="Facebook" href="http://www.facebook.com/pages/Clofus/408597462511506" target="_blank"><img src="img/footer-facebook.png" alt="Facebook" /></a>  
	        <a class="sm-twitter" title="Twitter" href="http://twitter.com/tryclofus" target="_blank"><img src="img/footer-twitter.png" alt="Twitter" /></a>
	</div>
</div>





</div>

</div>
</html>