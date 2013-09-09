<?php
use Everyman\Neo4j\Node,
    Everyman\Neo4j\Index;
/*
class Actor
{
    public $id = null;
    public $name = '';

    public static function save(Actor $actor)
    {
    }

    public static function getActorByName($name)
    {
    }
}*/

class Actor
{
    //

    protected $node = null;

    //

    public static function getActorByName($name)
    {
        $actorIndex = new Index(Neo4Play::client(), Index::TypeNode, 'actors');
        $node = $actorIndex->findOne('name', $name);
        if (!$node) {
            return null;
        }

        $actor = new Actor();
        $actor->id = $node->getId();
        $actor->name = $node->getProperty('name');
        $actor->node = $node;
        return $actor;
    }
    
     public static function save(Actor $actor)
    {
        if (!$actor->node) {
            $actor->node = new Node(Neo4Play::client());
        }

        $actor->node->setProperty('name', $actor->name);
        $actor->node->save();
        $actor->id = $actor->node->getId();

        $actorIndex = new Index(Neo4Play::client(), Index::TypeNode, 'actors');
        $actorIndex->add($actor->node, 'name', $actor->name);
    }

}


?>

