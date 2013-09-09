<?php
class Neo4Play
{
    protected static $client = null;

    public static function client()
    {
        return self::$client;
    }

    public static function setClient(Everyman\Neo4j\Client $client)
    {
        self::$client = $client;
    }
}
?>
