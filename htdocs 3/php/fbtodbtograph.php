<?php  session_start();

require_once('../APIS/fb_lib/facebook.php');
require_once('../APIS/jsonpath_lib/JSON.php');
require_once('../APIS/jsonpath_lib/jsonpath.php');
require_once('utility.php');

if (isset($_SESSION['clofus_id'])) {
	$clofus_id = $_SESSION['clofus_id'];	
}

get_Facebook(42);

function get_Facebook($clofus_id){


$app_id = "300487910000736";
$app_secret = "6d7628d36ff1d0e90b94dd02e6999aa8"; 

$con = mysql_connect("localhost","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("NEWSMODEL", $con);


$clofusidsql="SELECT oauth_token from new_fbauth where clofus_id='".$clofus_id."' LIMIT 1";
//echo $clofusidsql;

  	$data3 = mysql_query($clofusidsql)
  	or die(mysql_error()); 
   
   	while($info3 = mysql_fetch_array( $data3 )) 
 	{ 
 //		$clofus_id=$info3['clofus_id']; 
 		$access_token=$info3['oauth_token']; 
 		
	}


$fql = "SELECT message, attachment.description FROM stream WHERE source_id = me() AND created_time > 1298995597 LIMIT 10";   
         
         
$url = 'https://api.facebook.com/method/fql.query?query=' . rawurlencode($fql)."&access_token=".$access_token."&format=json";

echo $url;

$user_data = file_get_contents($url);
echo $user_data;
$parser = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
$o = $parser->decode($user_data);

$len=count($o,0);

for($i=0;$i<$len;$i++) {

     $message=jsonPath($o,"$[$i].message");
	 $attachment=jsonPath($o,"$[$i].attachment.description[0]");
	// print_r($attachment[0]);

$href = mysql_real_escape_string(rawurlencode($attachment[0]));
$msg = mysql_real_escape_string($message[0]);

convert_sent_graph($attachment,$$clofus_id);

/*
	$dupsql = "SELECT * FROM titles_sentence WHERE sentence='".$msg."' and fbdata.clofus_id='".$clofus_id."'";

	$dupraw = mysql_query($dupsql);

//print_r("UUU".mysql_num_rows($dupraw));

	
	if (mysql_num_rows($dupraw) == 0) {
	
$sql="INSERT INTO titles_sentence (clofus_id,sentence) VALUES ('".$clofus_id."','".$msg. "')";

		//echo $sql;
		if (!mysql_query($sql, $con)) {
			die('Error: ' . mysql_error());
		}
	
	}//if
	*/
}//for

}
?>
