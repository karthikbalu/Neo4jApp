<?php
error_reporting(0);
require_once('utility.php');

if (isset($_GET['clofus_id'])) {
	$clofus_id = $_GET['clofus_id'];
}
else
    $clofus_id='62';


if (isset($_GET['cursent'])) {
	$cursent = $_GET['cursent'];
}
else
    $cursent='';


if (isset($_GET['same_flg'])) {
	$same_flg = $_GET['same_flg'];
}
else
    $same_flg=0;
    
    
if (isset($_GET['Jtitles'])) {
	$Jtitles = $_GET['Jtitles'];
}
else
    $Jtitles='';
    
    


$sent=clofus_engine($clofus_id,$cursent,$same_flg,$Jtitles);
//$sent=clofus_engine($clofus_id,'',0,'');
//$r=json_decode($sent);
//print_r($r);

echo $sent;

function clofus_engine($clofus_id,$cursent,$same_flg,$Jtitles){

$con = mysql_connect("localhost","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("NEWSMODEL", $con);




if ($same_flg==0){      //START ALLWAYS - DIFFERENT

	$sql = "SELECT * FROM titles_sentence WHERE clofus_id='".$clofus_id."' and sent_flg=0  ORDER BY weight DESC LIMIT 5";		
	//echo $sql;
	$raw = mysql_query($sql) or die(mysql_error());
	
	while ($info231 = mysql_fetch_array($raw)) {
		$cur_sent = $info231['sentence'];
		$sword=explode(' ',$cur_sent);
		
		//echo $sword[0]."<br>\n";
		
	    $cur_senta=traversegraph($sword[0],2,1);
	    
	 if(isset($cur_senta[0])){
		$cur_sent=$cur_senta[0];
		//echo $cur_sent; 
		$totsent[]=$cur_sent;
		
		$sql2 = "UPDATE titles_sentence set sent_flg=1 WHERE sentence='".$cur_sent."' and clofus_id='".$clofus_id."'";		
		$raw2 = mysql_query($sql2);
	  }
		
    }
    
	$Jtotsent=json_encode($totsent);
 
}else{				//SAME
	$inc_weight = "UPDATE titles_sentence set weight=weight + ".$weight." WHERE sentence='".$cursent."' and clofus_id='".$clofus_id."'";		
	$raw = mysql_query($inc_weight);
	
	$sentences=traversegraph($cursent,2,5);
	
	$Jtotsent=json_encode($sentences);
}

$titles=json_decode($Jtitles);

for ($i=0;$i<count($titles);$i++){
	if (!IsNullOrEmptyString($titles[$i]))
	{
		convert_sent_graph($titles[$i],$clofus_id);
	}
}

//print_r($Jtotsent);


 return $Jtotsent;

}

?>