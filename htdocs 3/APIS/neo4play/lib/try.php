<?php
require_once('neo4jphp.phar');

	use Everyman\Neo4j\Client,
    Everyman\Neo4j\Transport,
    Everyman\Neo4j\Node,
    Everyman\Neo4j\Index,
    Everyman\Neo4j\Relationship,
    Everyman\Neo4j\PathFinder;

$client = new Client(new Transport('198.101.208.177', 8080));
	/*
$keanu = new Node($client);
$keanu->setProperty('name', 'Keanu Reeves');
$a=$keanu->save()->getId();

		$index = new Index($client, Index::TypeNode, 'Interests');
        $index->add($keanu, 'name', 'Keanu Reeves');

$index=new Index($client, Index::TypeNode, 'Interests');

		$sr=$index->find('name','Keanu Reeves');
//print_r($sr);

$laurence = new Node($client);
$laurence->setProperty('name', 'Laurence Fishburne')->save();

$keanu->relateTo($laurence, 'IN')->save();	

	$index=new Index($client, Index::TypeNode, 'Interests');
				$sr=$index->find('name','Keanu Reeves');


$queryString = "START n=node(1) ".
    "MATCH (n)<-[:KNOWS]-(x)-[:HAS]->()".
    "RETURN x";
*/    

$index=new Index($client, Index::TypeNode, 'Interests');
		$sr=$index->findOne('interest','tamil');
$nodeid=$sr->getId();
$nodeeclient=$sr->getClient();
$nodee=$nodeeclient->getNode($nodeid);

/*
    $queryString="START john=node(".$nodee.")".
    "MATCH john-[:USRID]->()-[:USRID]->fof".
"RETURN john,fof";

$query = new Everyman\Neo4j\Cypher\Query($client, $queryString);
$result = $query->getResultSet();

print_r($result);*/

$relationships = $nodeeclient->getNodeRelationships($nodee,'USRID');
//print_r($relationships[0]->getStartNode());

echo $i=0;
echo "<script> var node=[];";
foreach ($relationships as $relationship) {
    $interest = $relationship->getEndNode();
    $interest2= $relationship->getStartNode();
    $i1text=$interest->getProperty('interest');
    $i2text=$interest->getProperty('interest');
   // echo $i1text;
   // echo $i2text;
    //echo "\t" . $interest->getProperty('interest') . "\n";
    //echo "\t" . $interest2->getProperty('interest') . "\n";
    echo "node[".$i."]='".$interest->getProperty('interest')."';";
    
    echo "node2[".$i."]='".$interest2->getProperty('interest')."';";
$i++;
}
echo "</script>";
	
?>