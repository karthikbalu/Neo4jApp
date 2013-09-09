<?php
require_once('lib/neo4jphp.phar');

	use Everyman\Neo4j\Client,
    Everyman\Neo4j\Transport,
    Everyman\Neo4j\Node,
    Everyman\Neo4j\Index,
    Everyman\Neo4j\Relationship;

$client = new Client(new Transport('198.101.208.177', 8080));

$nodes_count=0;
$links_count=0;

$con = mysql_connect("localhost", "root", "clofusclofusclofus123r");
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("BEMODEL", $con);

//$interest = new Interest();


	$sqlinterest = "select * from yt_usr_interest order by yt_tmm DESC LIMIT 10 ";

	$data231 = mysql_query($sqlinterest) or die(mysql_error());

	$interest_slist = array();
	
	while ($info231 = mysql_fetch_array($data231)) {
		$cur_interest = $info231['yt_interest'];
		$usrid = $info231['usrid'];
		$a=explode(' ',$cur_interest);
		echo $usrid;
		//print_r($a);
		$prev='';

		for ($i=1;$i<count($a);$i++){
		$index2=new Index($client, Index::TypeNode, 'Interests');

		$d=(string)$a[$i];
		//echo "KKK".$d;
		if (!empty($d)){
		
		//	echo "AAA2:".$d."BBB";	
		$sr=$index2->find('interest',$d);
		//echo "AAA:";
		}

		//print_r($sr);
		if (empty($sr)){

			//CREATE LINK
			echo $usrid;
			$keanu = new Node($client);
			$keanu->setProperty('interest', $a[$i]); 
			//$keanu->setProperty($usrid,'usrid');
			$y=$keanu->save();
			$nodes_count++;
			
			//print_r($y);
			$index = new Index($client, Index::TypeNode, 'Interests');
			echo $usrid;
			$index->add($keanu, 'interest', $a[$i]);
			//$index->add($keanu, $usrid,'usrid');
			
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
					$rela=$y->relateTo($prev, 'USRID');	
					$rela->setProperty('usrid', $usrid);
					$rela->save();	
					$links_count++;
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
			  		echo "LINK CREATED".$y->getId();
					$rela=$y->relateTo($sr[0], 'USRID');	
					$rela->setProperty('usrid', $usrid);
					$rela->save();	
					$links_count++;
			  }
			}
		  }
		}//else
		}//key_words for
		
	//	echo "looped\n";
				
	}//while
		echo "Total Nodes created: ".$nodes_count;
		echo "Total Links created: ".$links_count;
		
		/*
		$interest->name = $cur_interest;
		//echo Interest::save($interest);
		
		$interest= Interest::getInterestByName($cur_interest);
		//echo $interest->id;
		//echo "<br>".$interest->name;
		//echo Actor::getActorByName($cur_interest);
		
		Interest::create_link(15,16,"abc");
		*/
		
?>