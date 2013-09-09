<?php session_start();
ini_set('register_globals', 'on');
ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);

if (isset($_POST['uname'])) {
	$susrid = $_POST['uname'];
}
if (isset($_POST['upwd'])) {
	$spwd = $_POST['upwd'];
}


$con = mysql_connect("localhost","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("NEWSMODEL", $con);

$clofus_id=0;
$ss="SELECT * FROM new_fbauth where usrid='".$susrid."' and password='".$spwd."' LIMIT 1";

	$sqlinterest = mysql_query($ss) or die(mysql_error());
    
while ($info231 = mysql_fetch_array($sqlinterest)) {
	
	 $name=$info231['name'];
     $small_pic=$info231['pic_small'];
     $email=$info231['email'];
     $hometown_location=$info231['hometown_location'];
     $clofus_id=$info231['clofus_id'];
     $oauth_token=$info231['oauth_token'];
}

	if ($clofus_id !=0){

	 $_SESSION['loggedin']=1;
	 $_SESSION['name']=$name;
     $_SESSION['pic_small']=$small_pic;
     $_SESSION['email']=$email;
     $_SESSION['hometown_location']=$hometown_location;
     $_SESSION['clofus_id']=$clofus_id;    
     $_SESSION['oauth_token']=$oauth_token;
     
        echo("<script> top.location.href='../news.php'</script>");
     
	}
	else {
		$_SESSION['loggedin']=0;
		echo("<script> top.location.href='../index.php'</script>");
	}

   
   ?>
    