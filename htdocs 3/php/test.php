<?php

require_once('fbtodb.php');



$a="Black pepper (Piper nigrum) is a flowering vine in the family Piperaceae, cultivated for its fruit, which is usually dried and used as a spice and seasoning. The fruit, known as a peppercorn when dried, is approximately 5 millimetres (0.20 in) in diameter, dark red when fully mature, and, like all d...";

echo "III ".$a;


$sentence=convert2sentence($a);
$exp=array_filter(explode(' ', $sentence), 'strlen');
$sliced=array_slice($exp, 0, 7);
$short_sentence=implode(' ', $sliced);


	print_r($sliced);



	echo "SSS ".$short_sentence;
	

?>