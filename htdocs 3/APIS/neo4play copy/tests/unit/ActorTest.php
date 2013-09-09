<?php
class ActorTest extends PHPUnit_Framework_TestCase
{
    public function testCreateActorAndRetrieveByName()
    {
        $actor = new Actor();
        $actor->name = 'Test Guy '.rand();
        Actor::save($actor);

        $actorId = $actor->id;
        self::assertNotNull($actorId);

        $retrievedActor = Actor::getActorByName($actor->name);
        self::assertInstanceOf('Actor', $retrievedActor);
        self::assertEquals($actor->id, $retrievedActor->id);
        self::assertEquals($actor->name, $retrievedActor->name);
    }

    public function testActorDoesNotExist()
    {
        $retrievedActor = Actor::getActorByName('Test Guy '.rand());
        self::assertNull($retrievedActor);
    }
}
?>
