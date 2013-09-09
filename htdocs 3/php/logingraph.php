<?php
session_start();
header('Content-Type: text/plain');
require_once('../APIS/neo4jphp.phar');

error_reporting(-1);
ini_set('display_errors', TRUE); 

	use Everyman\Neo4j\Client,
    Everyman\Neo4j\Transport,
    Everyman\Neo4j\Node,
    Everyman\Neo4j\Index,
    Everyman\Neo4j,
    Everyman\Neo4j\Cypher,
    Everyman\Neo4j\Relationship,
    Everyman\Neo4j\PathFinder;

//$usrid = $_SESSION['clofus_id'];
$usrid='42';
$con = mysql_connect("localhost", "root", "root");
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("NEWSMODEL", $con);
//ORDER BY yt_tmm
$sqlinterest = "select * from titles_sentence where clofus_id='".$usrid."' ORDER BY weight LIMIT 1 ";
$j=1;
	$data231 = mysql_query($sqlinterest) or die(mysql_error());
//$i=1;
	$interest_slist = array();
	$startn='START n=node:Interests("';
	while ($info231 = mysql_fetch_array($data231)) {
		$cur_interest = $info231['sentence'];
		//$usrid = $info231['usrid'];
		//$yt_tmm=$info231['yt_tmm'];
		
		$anodes=explode(' ',$cur_interest);
		$keywords[]=$anodes[0];
		for ($i=1;$i<count($anodes);$i++)
		{
		   if (!empty($anodes[$i]))		
		    { $startn=$startn.'interest:'.$anodes[$i];
				if ($j!=4 || $i != count($anodes)-2)
			      $startn=$startn.' OR ';
			}
		}	//$rep=' interest:';
			//echo $anodes[1];
		//$ans=str_ireplace(" ",$rep, $cur_interest);
		//print_r( $anodes);
		$j++;
	}
	$startn=$startn.'") ';
	//print_r($keywords);
//	$start='START n=node:Interests("interest:'.$keywords[0].' OR interest:'.$keywords[1].
//		' OR interest:'.$keywords[2].' OR interest:'.$keywords[3].'") ';
//echo $startn;	

$client = new Client(new Transport('localhost', 7474));
$index=new Index($client, Index::TypeNode, 'Interests');
//$sr=$index->findOne('interest','tamil');
/*
START n=node:Interests("interest:oru OR interest:kal OR interest:jayaraj OR interest:harris OR interest:song")
   MATCH p=(n)-[:USR5]->(m)
   RETURN n.interest,m.interest
   LIMIT 7
*/
$queryString = $startn.
	"MATCH p=(n)-[:USR".$usrid."]->(m) ".
    "RETURN n.interest,m.interest LIMIT 20";
    
    echo $queryString;
    
    
    /*
$query = new Everyman\Neo4j\Cypher\Query($client, $queryString);
$result = $query->getResultSet();


//echo"AAA";
//print_r($sr2);
//echo "BBB";

foreach ($result as $row) {
	//$rw1=$row['p']->getStartNode();
	//$rw2=$row['p']->getEndNode();
	
	//$rw1->getId();
	//$nodes=$rw1->getProperty('interest')
	$res[]=$row['n.interest'];
	$res[]=$row['m.interest'];
	
    //print_r('start: '. $row['n'].' <br>');
    //print_r('   end: '. $row['p'].' <br>');
}

//print_r($res);

/*
$index2=new Index($client, Index::TypeRelationship, 'USRID');
$sr2=$index2->findOne('usrid','5');
*/


/*
$nodeid=$sr->getId();
//print_r("AA".$sr);

$nodeeclient=$sr->getClient();
$nodee=$nodeeclient->getNode($nodeid);

$relationships = $nodeeclient->getNodeRelationships($nodee,'USRID');
//print_r($relationships[0]->getStartNode());

//echo
$i=0;
//echo "<script> var node1=[],node2=[];";
foreach ($relationships as $relationship) {
    $interest = $relationship->getEndNode();
    $interest2= $relationship->getStartNode();
    $i1text=(string)$interest->getProperty('interest');
    $i2text=(string)$interest2->getProperty('interest');
   // echo $i1text;
   // echo $i2text;
   
   $nodes[]=$i1text;
   $nodes[]=$i2text;
    //echo "\t" . $interest->getProperty('interest') . "\n";
    //echo "\t" . $interest2->getProperty('interest') . "\n";
   //echo "node1[".$i."]='".$interest->getProperty('interest')."';";
   //echo "node2[".$i."]='".$interest2->getProperty('interest')."';";
$i++;
}
//echo "</script>";*/

if (!empty($res))
{
$aa= array_values(array_filter($res));
$jsonytlist = json_encode($aa);
echo $jsonytlist;
}
?>