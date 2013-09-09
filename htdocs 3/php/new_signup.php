<?php  session_start();
require_once('../APIS/jsonpath_lib/JSON.php');
require_once('../APIS/jsonpath_lib/jsonpath.php');
require_once('utility.php');

  $loginpage = "http://localhost/index.php";
  
$con = mysql_connect("localhost", "root", "root");
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("NEWSMODEL", $con);


if (isset($_SESSION['oauth_token'])) {
	$oauth_token = $_SESSION['oauth_token'];	
}
if (isset($_SESSION['expires'])) {
	$expires = time()+$_SESSION['expires'];	
}



if (isset($_SESSION['uid'])) {
	$uid = $_SESSION['uid'];	
}
if (isset($_SESSION['name'])) {
	$name = $_SESSION['name'];	
}
if (isset($_SESSION['pic_small'])) {
	$pic_small = $_SESSION['pic_small'];	
}

if (isset($_SESSION['hometown_location'])) {
	$hometown_location = $_SESSION['hometown_location'];	
}
if (isset($_SESSION['locale'])) {
	$locale = $_SESSION['locale'];	
}
if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];	
}

if (isset($_SESSION['usrid'])) {
	$usrid = $_SESSION['usrid'];	
}

if (isset($_SESSION['password'])) {
	$password = $_SESSION['password'];	
}




	
$sql="INSERT INTO new_fbauth (usrid,password,uid, name,pic_small, hometown_location, locale, email, oauth_token,expires) VALUES ('".$usrid."','".$password."','".$uid."','". $name."','". $pic_small ."','".$hometown_location ."','". $locale ."','". $email ."','". $oauth_token."','".$expires."')";
//echo $sql;

		if (!mysql_query($sql, $con)) {
			die('Error: ' . mysql_error());
		}
	
		
$clofusidsql="SELECT clofus_id from new_fbauth where usrid='".$usrid."' and uid='".$uid."' LIMIT 1";
//echo $clofusidsql;

  	$data3 = mysql_query($clofusidsql)
  	or die(mysql_error()); 
   
   	while($info3 = mysql_fetch_array( $data3 )) 
 	{ 
 		$clofus_id=$info3['clofus_id']; 
	}
		$_SESSION['clofus_id']=$clofus_id;
//echo "WWW".$clofus_id."WEW";
		
		
//===================CLOFUS INITIAL SETUP=====================

 $fql_frndlist= 'SELECT uid, name, pic_small 
         FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())';

$url = 'https://api.facebook.com/method/fql.query?query=' . rawurlencode($fql_frndlist)."&access_token=".$oauth_token."&format=json";

$friends = file_get_contents($url);

$parser = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
$o = $parser->decode($friends);
$len=count($o,0);

for($i=0;$i<$len;$i++) {

     $fuid=jsonPath($o,"$[$i].uid");
	 $fname=jsonPath($o,"$[$i].name");
     $fsmall_pic=jsonPath($o,"$[$i].pic_small");
     
     
     $fname=str_replace("'","",$fname);
     
     //echo "\n".$fname[0]."   ".$fsmall_pic[0];

$dupsql = "SELECT * FROM fb_frnd WHERE fb_frnd.fb_usrid='".$fuid[0]."'";
	//echo "yyy:".$dupsql;

	$dupraw = mysql_query($dupsql);
	
	if (mysql_num_rows($dupraw) == 0) {
	
	$sql = "INSERT INTO fb_frnd (fb_usrid,clofus_id,fb_name,fb_photo,in_clofus) VALUES ('".$fuid[0]."','" . $clofus_id . "','" . $fname[0] . "','" . $fsmall_pic[0] ."',0)";

		//echo $sql;
		if (!mysql_query($sql, $con)) {
			die('Error: ' . mysql_error());
		}
	
	}
}//for

get_Facebook($clofus_id);

    if ($name !=""){
     $_SESSION['signedup']=1;
	 $_SESSION['loggedin']=1;
	 $_SESSION['name']=$name;
     $_SESSION['pic_small']=$pic_small;
     $_SESSION['email']=$email;
     $_SESSION['hometown_location']=$hometown_location;
     $_SESSION['clofus_id']=$clofus_id;    
     $_SESSION['oauth_token']=$oauth_token;
     
        echo("<script> top.location.href='../news.php'</script>");    
	}
	else {
	    $_SESSION['loggedin']=2;
		echo("<script> top.location.href='../index.php'</script>");
	}

?>


