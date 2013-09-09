<?php
  session_start();
require_once('../APIS/jsonpath_lib/JSON.php');
require_once('../APIS/jsonpath_lib/jsonpath.php');


if (isset($_POST['sname'])) {
	$susrid = $_POST['sname'];
	$_SESSION['usrid']=$susrid;
}
if (isset($_POST['spwd'])) {
	$spwd = $_POST['spwd'];
	$_SESSION['password']=$spwd;
}
if (isset($_POST['semail'])) {
	$semail = $_POST['semail'];
	$_SESSION['email']=$semail;
}

  $app_id = "300487910000736";
  $app_secret = "6d7628d36ff1d0e90b94dd02e6999aa8"; 
  $my_url = "http://localhost/php/starter.php";
  $after_redirect = "http://localhost/php/new_signup.php";

if (isset($_REQUEST["code"])) {
   $code = $_REQUEST["code"];
}

   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'];

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
   }

   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);
     //print_r($response);


/*
$fql= 'SELECT uid1, uid, name, pic_small 
         FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())';
         */
    $fql='SELECT uid, username, name, pic, hometown_location,locale, email 
            FROM user WHERE uid=me()';     
         
$url = 'https://api.facebook.com/method/fql.query?query=' . rawurlencode($fql)."&access_token=".$params['access_token']."&format=json";
//echo $url;
$user = file_get_contents($url);
//echo $user;
$parser = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
$o = $parser->decode($user);

	 $uid=jsonPath($o,"$[0].uid");
     $username=jsonPath($o,"$[0].username");
	 $name=jsonPath($o,"$[0].name");
     $pic_small=jsonPath($o,"$[0].pic");
     $hometown_location=jsonPath($o,"$[0].hometown_location.city");
     $locale=jsonPath($o,"$[0].locale");
     //$email=jsonPath($o,"$[0].email");


     $_SESSION['oauth_token']=$params['access_token'];
     $_SESSION['expires']=$params['expires'];

     $_SESSION['uid']=$uid[0];
     $_SESSION['username']=$username[0];
	 $_SESSION['name']=str_replace("'"," ",$name[0]);
     $_SESSION['pic_small']=$pic_small[0];
     $_SESSION['hometown_location']=$hometown_location[0];
     $_SESSION['locale']=$locale[0];
     
     echo("<script> top.location.href='" . $after_redirect . "'</script>");
   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }


?>