<html lang="en">
<head>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<?php
require_once('neo4jphp.phar');

	use Everyman\Neo4j\Client,
    Everyman\Neo4j\Transport,
    Everyman\Neo4j\Node,
    Everyman\Neo4j\Index,
    Everyman\Neo4j\Relationship,
    Everyman\Neo4j\PathFinder;

$client = new Client(new Transport('198.101.208.177', 8080));
$index=new Index($client, Index::TypeNode, 'Interests');
$sr=$index->findOne('interest','tamil');
$nodeid=$sr->getId();
$nodeeclient=$sr->getClient();
$nodee=$nodeeclient->getNode($nodeid);

$relationships = $nodeeclient->getNodeRelationships($nodee,'USRID');
//print_r($relationships[0]->getStartNode());

//echo
$i=0;
echo "<script> var node1=[],node2=[];";
foreach ($relationships as $relationship) {
    $interest = $relationship->getEndNode();
    $interest2= $relationship->getStartNode();
    $i1text=$interest->getProperty('interest');
    $i2text=$interest->getProperty('interest');
   // echo $i1text;
   // echo $i2text;
    //echo "\t" . $interest->getProperty('interest') . "\n";
    //echo "\t" . $interest2->getProperty('interest') . "\n";
    echo "node1[".$i."]='".$interest->getProperty('interest')."';";
    
    echo "node2[".$i."]='".$interest2->getProperty('interest')."';";
$i++;
}
echo "</script>";


?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>arbor.js project template</title>
	<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <canvas id="viewport" width="720" height="300"></canvas>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>

  <!- run from the original source files: -->
  <!-- <script src="../../src/etc.js"></script>
       <script src="../../src/kernel.js"></script>
       <script src="../../src/graphics/colors.js"></script>
       <script src="../../src/graphics/primitives.js"></script>
       <script src="../../src/graphics/graphics.js"></script>
       <script src="../../src/tween/easing.js"></script>
       <script src="../../src/tween/tween.js"></script>
       <script src="../../src/physics/atoms.js"></script>
       <script src="../../src/physics/physics.js"></script>
       <script src="../../src/physics/system.js"></script>
       <script src="../../src/dev.js"></script> -->

  <!-- run from the minified library file: -->
  <script src="../../lib/arbor.js"></script>  
    <script src="../../lib/arbor-tween.js"></script>  

  <script src="main.js"></script>

</body>
</html>
