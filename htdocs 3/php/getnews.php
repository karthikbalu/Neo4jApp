<?php
//session_start();
//header('Content-Type: text/xml');
//set_time_limit(100);
require_once ('../APIS/restapi.php');
require_once ('../APIS/jsonpath_lib/JSON.php');
require_once ('../APIS/jsonpath_lib/jsonpath.php');
require_once ('../APIS/stat.php');
require_once ('simple_html_dom.php');
require_once ('scrapeimg2.php');
//error_reporting(E_ALL);

//$inp[0]='shanker next movie';

//echo $_GET['interest_slist'];

if (isset($_GET['interest_slist'])) {
    $interest_slist=json_decode($_GET['interest_slist']);
        
	//$interest_slist[0] = $_GET['interest_slist'];
}
else
    $interest_slist[0]='tamil shanker movie';

//print_r( $interest_slist);


class ScrapedInfo
    {
        public $url;
        public $title;
        public $description;
        public $imageUrls;
    }

function scrapeUrl($url)
{
        $info = new ScrapedInfo();
        $info->url = $url;


   @$html = @file_get_html($info->url);

//print_r("'".$html."'");

if ($html!=NULL){

        //Grab the page title
        $info->title = trim($html->find('title', 0)->plaintext);

        //Grab the page description
        foreach($html->find('meta') as $meta)
                if ($meta->name == "description")
                        $info->description = trim($meta->content);

        //Grab the image URLs
        $imgArr = array();
        foreach($html->find('img') as $element)
        {
                $rawUrl = $element->src;
                $height= $element->height;

              if ($height>100){
                //Turn any relative Urls into absolutes
                if (substr($rawUrl,0,4)!="http")
                        $imgArr[] = $url.$rawUrl;
                else
                        $imgArr[] = $rawUrl;
              }
        }
        $info->imageUrls = $imgArr;

        return $info;
}


else
return $info;

}//function

function isnore($question){
    return (!isset($question) || trim($question)==='');
}

function recursive_array_search($needle,$haystack,$subloop = false,$type) {
    //if($subloop === false) $resarr = array();
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if(is_string($needle)) $needle = trim(strtolower($needle));
        if(is_string($value)) $value = trim(strtolower($value));

if ($type=='source')
{        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value,true,'source') === true)) {
	    //$resarr[] = $current_key;
            if($subloop === true) return true;
        }
}else
{
        $pos = stripos($value, $needle);
        if($pos===true OR (is_array($value) && recursive_array_search($needle,$value,true,'url') === true)) {
            //$resarr[] = $current_key;
            if($subloop === true) return true;
        }
}


    }
    return $current_key;
}

function arrangedocint($tot,$int)
{
$r=0;
$n=$int;
$a=array();
$a = array_fill(0, $n, 0);
//print_r($a);

while($r<$tot){

        for ($i=0;$i<$n;$i++)
        {
           if ($r<$tot){
            $a[$i]=$a[$i]+1;
            $r=$r+1;
           }
           else
           {
                break;
           }
        }
        $i=0;
        $n=$n-1;

if($r<$tot && $n==0)
  $n=$int;

//print_r($a);
//echo $r. "\n";
}

return $a;
}

function curl_get($url)
{
    // Initiate the curl session
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    // Removes the headers from the output
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Return the output instead of displaying it directly
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    // Execute the curl session
    $output = curl_exec($ch);

    // Close the curl session
    curl_close($ch);

    return $output;
}


















$int=count($interest_slist);
$aa=arrangedocint(20,$int);
//print_r($aa);

for ($j=0;$j<$int;$j++){

//$curinttxt=$_SESSION['cur_interest_txt'];
//$curinttxt="Steve Jobs";

$curinttxt=$interest_slist[$j];
//echo $curinttxt;

$op = str_ireplace(" ", "+", $curinttxt);

//echo $op;
//$op="ajith";

 $base = "http://clofus.com:8080/dcs/rest?dcs.source=etools&query=".$op."&results=".$aa[$j]."&dcs.algorithm=lingo&dcs.output.format=JSON";
//echo $base;

$response=curl_get($base);

//echo $response;


$ytjson=$response;
//$ytjson=json_encode($response);
//      VERY IMPORTANT ytjson contains json output for 20 videos
        ////echo $ytjson;

                //$json=json_encode($ytjson);
                $parser = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
                $o = $parser->decode($ytjson);

        
   for($i=0;$i<$aa[$j];$i++) {

     $title=jsonPath($o,"$.documents[$i].title");
     $snippet=jsonPath($o,"$.documents[$i].snippet");
     $url=jsonPath($o,"$.documents[$i].url");

     $source=jsonPath($o,"$.documents[$i].sources");

//if ((recursive_array_search('Wikipedia',$source,true,'source')==0)&&(recursive_array_search('youtube',$url,true,'url')==0)) {

if(1){
//print_r($source);


//	$a=scrapeUrl($url[0]);
//	$img=$a->imageUrls;


//$img="abcd.jpg";

//echo $img[0];

//echo $title[0]."\n";
//echo $snippet[0]."\n";
//echo $url[0]."\n";

//$img=$a->imageUrls;
//$tit=$a->title;
//$desc=$a->description;
$cntdoc=0;
if (strlen($snippet[0])>$aa[$j] && strlen($title[0]) && strlen($url[0]))	
{
   if ($cntdoc<20){
	$a=getimage($url[0]);
	//echo $a;

    if(!stristr($url[0], 'youtube') && !stristr($url[0], 'wikipedia') && !empty($a)){
	
	echo "<a href='".$url[0]."'>";
	echo "<div class='docdocument' id='doc_".$i,"'>\n";
	
	echo "<div class='docsnippet'>";

	if (isset($a)){
		echo "<img src='".$a."' alt='' style='width:100%;height:auto'></img>";
	}
	
	$urll=parse_url($a,PHP_URL_HOST);
	
	$hostt=str_ireplace("www."," ",$urll);
	$hostt=str_ireplace(".com"," ",$hostt);
	//$hostt=str_ireplace("."," ",$urll);

	//echo "<span class='docemptyspan'>emptyemptyempty</span>";
	//echo "<span class='docspan'>".$hostt."</span>";	
	echo "</div>\n";

	echo "<span class='docspan'>".$hostt."</span>";
	echo "<div class='doctitle'>".$title[0]."</div>\n";
	
	//echo "<div class='docurl'><a href='".$url[0]."'>Read more..</a></div>\n";
	echo "</div>\n";
	echo "</a>";
        $cntdoc++;
    }
  }
	
} 
}//mac
}//for
//echo $j;

}//for for each interest


?>

