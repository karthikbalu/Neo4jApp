<?php
require_once(__DIR__.'/lib/neo4jphp.phar');
require_once(__DIR__.'/lib/neo4jphp.phar');
require_once(__DIR__.'/lib/Neo4Play.php');
require_once(__DIR__.'/lib/Actor.php');

// ** set up error reporting, environment and connection... **//

//Neo4Play::setClient($client);

error_reporting(-1);
ini_set('display_errors', 1);

if (!defined('APPLICATION_ENV')) {
    define('APPLICATION_ENV', 'development');
}

$host = '198.101.208.177';
$port = (APPLICATION_ENV == 'development') ? 8080 : 8080;
$transport = new Everyman\Neo4j\Transport($host, $port);
$client = new Everyman\Neo4j\Client($transport);

Neo4Play::setClient($client);
?>
