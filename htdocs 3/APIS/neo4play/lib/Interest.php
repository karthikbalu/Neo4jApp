<?php
use Everyman\Neo4j\Node,
	Everyman\Neo4j\Relationship,
    Everyman\Neo4j\Index;

class Interest
{

    protected $node = null;

    public static function getInterestByName($name)
    {
        $InterestIndex = new Index(Neo4Play::client(), Index::TypeNode, 'Interests');
        $node = $InterestIndex->findOne('name', $name);
        if (!$node) {
            return null;
        }

        $Interest = new Interest();
        $Interest->id = $node->getId();
        $Interest->name = $node->getProperty('name');
        $Interest->node = $node;
        return $Interest;
    }
    
     public static function save(Interest $Interest)
    {
        if (!$Interest->node) {
            $Interest->node = new Node(Neo4Play::client());
        }

        $Interest->node->setProperty('name', $Interest->name);
        $Interest->node->save();
        $Interest->id = $Interest->node->getId();

        $InterestIndex = new Index(Neo4Play::client(), Index::TypeNode, 'Interests');
        $InterestIndex->add($Interest->node, 'name', $Interest->name);
        return $Interest->id;
    }
    
    public static function create_link($node_a,$node_b,$value){
	    
	    $InterestIndex = new Index(Neo4Play::client(), Index::TypeNode, 'Interests');
	    
	    $relation = $InterestIndex->makeRelationship();
	    $relation->setStartNode($node_a)
	    ->setEndNode($node_b)
	    ->setType('has')
	    ->setProperty('usrid', $value)
	    ->save();
    }  

}


?>

