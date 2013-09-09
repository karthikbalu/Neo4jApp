<?php
require_once('lib/neo4jphp.phar');

	use Everyman\Neo4j\Client,
    Everyman\Neo4j\Transport,
    Everyman\Neo4j\Node,
    Everyman\Neo4j\Index,
    Everyman\Neo4j\Relationship;

$client = new Client(new Transport('198.101.208.177', 8080));


$con = mysql_connect("localhost", "root", "clofusclofusclofus123r");
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("BEMODEL", $con);

//$interest = new Interest();


	$sqlinterest = "select * from yt_usr_interest order by yt_tmm DESC";

	$data231 = mysql_query($sqlinterest) or die(mysql_error());

	$interest_slist = array();
	
	while ($info231 = mysql_fetch_array($data231)) {
		$cur_interest = $info231['yt_interest'];
		$usrid = $info231['usrid'];
		
		echo $cur_interest."<br>";
		
		$a=explode(' ',$cur_interest);
		
		$temp='';
		for ($i=0;$i<count($a);$i++){
			
			$keanu = new Node($client);
			$keanu->setProperty('interest', $a[$i]);
			$x=$keanu->save();
			$index = new Index($client, Index::TypeNode, 'Interests');
			$index->add($keanu, 'interest', $a[$i]);
			
			
			if ($temp!==''){
				$rell=$temp->relateTo($x, 'IN');	
				$rell->setProperty('usrid', $usrid);
				$rell->save();
			}
			$temp=$x;
			
			$index=new Index($client, Index::TypeNode, 'Interests');
			$sr=$index->find('interest',$a[$i]);
				//print_r($sr[1]->getId());
			
			for($k=0;$k<count($sr);$k++){
				$rela=$keanu->relateTo($sr[$k], 'IN');	
				$rela->setProperty('usrid', $usrid);
				$rela->save();
			}//for 
	    }//for	
	    $x='';
			
	}//while
		
		
		
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