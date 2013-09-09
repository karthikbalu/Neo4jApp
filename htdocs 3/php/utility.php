<?php  //session_start();
error_reporting(0);
require_once('../APIS/fb_lib/facebook.php');
require_once('../APIS/jsonpath_lib/JSON.php');
require_once('../APIS/jsonpath_lib/jsonpath.php');
//require_once('../APIS/stat.php');

require_once('../APIS/neo4jphp.phar');
error_reporting(E_ALL);

	use Everyman\Neo4j\Client,
    Everyman\Neo4j\Transport,
    Everyman\Neo4j\Node,
    Everyman\Neo4j\Index,
    Everyman\Neo4j\Relationship;




//if (isset($_SESSION['clofus_id'])) {
//	$clofus_id = $_SESSION['clofus_id'];	
//}

function addtograph($cur_interest,$usrid)
{
$client = new Client(new Transport('clofus.com', 7474));
$a=array_filter(explode(' ',$cur_interest));
	//print_r( $a);
	//	echo ")))";
		//print_r($a);
		
		if (count($a)<=5)
			$sent_length=count($a);
		else
			$sent_length=5;
		
		$prev='';
//echo "KKK1".$d;
		for ($i=0;$i<$sent_length;$i++){
echo $a[$i];
		if (!IsNullOrEmptyString($a[$i])){
//		echo "KKK2".$d;
		$index2=new Index($client, Index::TypeNode, 'Interests');

		$d=$a[$i];
//		echo "KKK".$d;
		if (!empty($d)){
		
			//echo "AAA2:".$d."BBB";	
		$sr=$index2->find('interest',$d);
		//echo "AAA:";
		}

		//print_r($sr);
		if (empty($sr)){

			//CREATE LINK
			echo 'create link: '.$a[$i];
			$keanu = new Node($client);
			$keanu->setProperty('interest', $a[$i]); 
			//$keanu->setProperty('yt_tmm',$yt_tmm);
			$y=$keanu->save();
			//$nodes_count++;
			
			//print_r($y);
			$index = new Index($client, Index::TypeNode, 'Interests');
			//echo $usrid;
			$index->add($keanu, 'interest', $a[$i]);
			//$index->add($keanu, 'yt_tmm', $yt_tmm);
			
			
			
			if(($i==2)||($i==3)||($i==4)){
			//echo "UUU";
			//print_r($prev);
			//echo "===";			
			if (!empty($prev)){
			  $paths = $y->findPathsTo($prev)->getPaths();
			 //echo "HHH";
			 // print_r( $path->getProperty('usrid'));
			  
			  if (empty($paths)){
			  		//CREATE LINK
			  		echo "LINK CREATED".$y->getId();
					//$rela=$y->relateTo($prev, 'USRID');
					$rela=$y->relateTo($prev, 'USR'.$usrid);	
					//$rela->setProperty('usrid', $usrid);
					$rela->save();	
					//$links_count++;
			  }
			 }
			}
			$prev=$y;
		}else{
		  if (!empty($y)){
			if($i!==0){			
			  $paths = $y->findPathsTo($sr[0])->getPaths();
			  if (empty($paths)){
			  		//create link
			  		//echo "LINK CREATED".$y->getId();
					//$rela=$y->relateTo($sr[0], 'USRID');
					$rela=$y->relateTo($sr[0], 'USR'.$usrid);		
					//$rela->setProperty('usrid', $usrid);
					$rela->save();	
					//$links_count++;
			  }
			}
		  }
		}//else
		}
		}//key_words for

}


function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}

function convert_sent_graph($input,$clofus_id){
	//echo "III ".$input;
	$sentence=convert2sentence($input);
	
	$short_sentence=implode(' ', array_slice(explode(' ', $sentence), 0, 7));
	//echo "SSS ".$short_sentence;
	$res=add2db($short_sentence,$clofus_id);
	if ($res)
		return true;
	
return false;		
}


function traversegraph($cur_sent,$degree,$limit){

$client = new Client(new Transport('clofus.com', 7474));
	$traverse_words=explode(' ', $cur_sent);
	$traverse_word=$traverse_words[0];
  /*
$queryString="START n=node:Interests(interest='".$traverse_word."') ".
"MATCH p=n-[*".$degree."]-m ".
"RETURN extract(n in nodes(p) : n.interest) as words";   
*/
$queryString="START n=node:Interests(interest='".$traverse_word."') ".
"MATCH p=n-[*".$degree."]-m ".
"RETURN nodes(p) as words LIMIT ".$limit;    
  //echo $queryString;
$query = new Everyman\Neo4j\Cypher\Query($client, $queryString);

$result = $query->getResultSet();
//print_r($result);
$ro=$result;
$sentenes='';
$n=0;
foreach ($result as $row) {
	for ($i=0;$i<=$degree;$i++){
    	$out[$n][]=$row['words'][$i]->getProperty('interest');
    }
    $sentenes[$n]=implode(' ',$out[$n]);
    $n++;
}

//print_r($sentenes[0]);

return $sentenes;
}


function add2db($sentence,$clofus_id){

$con = mysql_connect("localhost","root","root");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("NEWSMODEL", $con);

	$dupsql = "SELECT * FROM titles_sentence WHERE sentence='".$sentence."' and clofus_id='".$clofus_id."'";

	$dupraw = mysql_query($dupsql);

	if (mysql_num_rows($dupraw) == 0 &&  !IsNullOrEmptyString($sentence)) {
	
$sql="INSERT INTO titles_sentence (clofus_id,sentence) VALUES ('".$clofus_id."','".$sentence. "')";

		//echo $sql;
		if (!mysql_query($sql, $con)) {
			die('Error: ' . mysql_error());
			return false;
		}else{
					//echo"\n===".$sentence;
			addtograph($sentence,$clofus_id);
			return true;
		}
	
	}//if

}


function convert2sentence($input){
 
 $input = ereg_replace("[^A-Za-z0-9 *]", " ", strtolower($input) );

	 	// EEEEEEK Stop words
		$commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero','http','www','com','net','org');
 
  $sentence=preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);

$exp=array_filter(explode(' ', $sentence), 'strlen');
$sliced=array_slice($exp, 0, 7);
$short_sentence=implode(' ', $sliced);
//echo $short_sentence;
return $short_sentence;

//return true;
}


//get_Facebook(42);

function get_Facebook($clofus_id){

//echo $clofus_id;

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
 		//$clofus_id=$info3['clofus_id']; 
 		$access_token=$info3['oauth_token']; 
 		
	}


$fql = "SELECT message, attachment.description,attachment.href FROM stream WHERE source_id = me() AND created_time > 1298995597 LIMIT 100";   
         
         
$url = 'https://api.facebook.com/method/fql.query?query=' . rawurlencode($fql)."&access_token=".$access_token."&format=json";

//echo $url;

$user_data = file_get_contents($url);
//echo $user_data;
$parser = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
$o = $parser->decode($user_data);

$len=count($o,0);

for($i=0;$i<$len;$i++) {

     $message=jsonPath($o,"$[$i].message");
	 $description=jsonPath($o,"$[$i].attachment.description[0]");
	 
	 //if (isset(jsonPath($o,"$[$i].attachment.href[0]")))
	 	$href=jsonPath($o,"$[$i].attachment.href[0]");
	 
	// print_r($attachment[0]);

//$href = mysql_real_escape_string(rawurlencode($attachment[0]));
//$desc = mysql_real_escape_string(rawurlencode($description[0]));
//$msg = mysql_real_escape_string($message[0]);



//$new_desc = ereg_replace("[^A-Za-z0-9 ]", " ", strtolower($description[0]) );

if (!IsNullOrEmptyString($description[0]) && !IsNullOrEmptyString($href[0])){
//echo "DDD ".$description[0];
	$sentence=convert_sent_graph($description[0],$clofus_id);
}
//echo $sentence;
//echo "\n<br>";

	}//for
}
?>
