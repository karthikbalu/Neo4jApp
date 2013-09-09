<?php
define('APPLICATION_ENV', 'testing');
require_once(__DIR__.'/../bootstrap.php');

$transport->delete('/cleandb/secret-key');
?>
