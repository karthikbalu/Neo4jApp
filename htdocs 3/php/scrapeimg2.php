<?php
require("url_to_absolute.php");

//$ourl='http://9to5mac.com/category/ios-devices/';
//echo getimage($ourl);

function getimage($ourl){

$curl_handle=curl_init();
//$ourl='http://9to5mac.com/category/ios-devices/';
//$ourl="http://en.wikipedia.org/wiki/Steve_Jobs";

curl_setopt($curl_handle,CURLOPT_URL,$ourl);
//curl_setopt($curl_handle,CURLOPT_URL,'http://9to5mac.com/category/ios-devices/');
curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);

curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'http://clofus.com');

if(!function_exists('startsWith')){
function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
}


/*
$userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)";
curl_setopt($curl_handle, CURLOPT_USERAGENT, $userAgent);

//Some other options I use:
curl_setopt($curl_handle, CURLOPT_FAILONERROR, true);
curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl_handle, CURLOPT_AUTOREFERER, true);
curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10);
*/

$html = curl_exec($curl_handle);
$html = @mb_convert_encoding($html, 'HTML-ENTITIES', 'utf-8');

curl_close($curl_handle);


if (empty($html))
{
	return 0;
   // print "Not today";
}
else
{
   //print_r($html);

preg_match_all('/<img[^>]+>/i',$html, $result); 
$str=$html;
//print_r($str);


$dom = new DOMDocument();
@$dom->loadHTML($str);
$elements = $dom->getElementsByTagName('img');

//$img = $dom->getElementsByTagName('img')->childNodes;

//print_r($img);

if (!is_null($elements)) {
  foreach ($elements as $element) {
    //echo "<br/>". $element->nodeName. ": ";

    $nodes = $element->attributes;

    foreach ($nodes as $node) {
     // echo $node->nodeValue. "\n";
	$name = $node->nodeName;
        $value = $node->nodeValue;
	 //echo "Attribute '$name' : '$value'<br />";

	if ($name=="src") $src=$node->nodeValue;
	if ($name=="height") $height=$node->nodeValue;
	if ($name=="width") $width=$node->nodeValue;
    }
	if (isset($height))
	 if ((!stristr($src, 'gif'))&& $height>100){
	    if (startsWith($src,"//"))
		{$src="http:".$src; return $src;}
	    else
                $src=url_to_absolute($ourl, $src);
            return $src;
	    //print_r("URL:". $src."<br />");
	}
	$height="";$width="";$src="";
  }
}
else
//print_r("null html");
return 0;


}//if
}//function



/*
for($i=0;$i<10;$i++){
$p = $dom->getElementsByTagName('img')->item($i);
//echo $p."\n";

if ($p->hasAttributes()) {
  foreach ($p->attributes as $attr) {
    $name = $attr->nodeName;
    $value = $attr->nodeValue;
    echo "Attribute '$name' :: '$value'<br />";
  }
}
}

//Function to get the absolute URL for image
function InternetCombineUrl($absolute, $relative) {
$p = parse_url($relative);
if($p["scheme"])return $relative;

extract(parse_url($absolute));

$path = dirname($path);

if($relative{0} == "/") {
$cparts = array_filter(explode("/", $relative));
}
else {
$aparts = array_filter(explode("/", $path));
$rparts = array_filter(explode("/", $relative));
$cparts = array_merge($aparts, $rparts);
foreach($cparts as $i => $part) {
if($part == ".") {
$cparts[$i] = null;
}
if($part == "..") {
$cparts[$i - 1] = null;
$cparts[$i] = null;
}
}
$cparts = array_filter($cparts);
}
$path = implode("/", $cparts);
$url = "";
if($scheme) {
$url = "$scheme://";
}
if($user) {
$url .= "$user";
if($pass) {
$url .= ":$pass";
}
$url .= "@";
}
if($host) {
$url .= "$host/";
}
$url .= $path;
return $url;
}


function is_notnull($v) {
  return !is_null($v);
}
 
$img = array();
$i=0;
foreach( $result as $img_tag)
{
$aa=is_notnull($img_tag);


//print_r($aa);
echo $aa;
$i++;
    preg_match_all('/(alt|title|src)=("[^"]*")/i',$aa, $img[$aa]);
}

//print_r($img);




$doc = new DOMDocument;
$doc->preserveWhiteSpace = FALSE;
@$doc->loadHTML($html);


//print_r($doc);

$anchor_tags = $doc->getElementsByTagName("*");

//print_r( $anchor_tags);

foreach ($anchor_tags as $tag) {
iecho"\ndsdc";
$keywords[] = strtolower($tag->nodeValue);
echo $tag->nodeValue;
}

*/

?>
