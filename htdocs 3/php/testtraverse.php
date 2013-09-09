<?php
header('Content-Type: text/plain');
require_once('utility.php');
require_once('getnews.php');

error_reporting(E_ALL);

$sentences='tamil next shanker';
$sentences=traversegraph("movie next shanker",2,1);
print_r( $sentences[0]);
//getnews($sentences);
//getnews('comedy vadivelu');
?>