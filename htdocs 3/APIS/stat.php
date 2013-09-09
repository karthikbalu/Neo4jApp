<?php 
function mmmr($array, $output = 'mean'){ 
    if(!is_array($array)){ 
        return FALSE; 
    }else{ 
        switch($output){ 
            case 'mean': 
                $count = count($array); 
                $sum = array_sum($array); 
                $total = $sum / $count; 
            break; 
            case 'median': 
                rsort($array); 
                $middle = round(count($array) / 2); 
                $total = $array[$middle-1]; 
            break; 
            case 'mode': 
                $v = array_count_values($array); 
                arsort($v); 
                foreach($v as $k => $v){$total = $k; break;} 
            break; 
            case 'range': 
                sort($array); 
                $sml = $array[0]; 
                rsort($array); 
                $lrg = $array[0]; 
                $total = $lrg - $sml; 
            break; 
        } 
        return $total; 
    } 
}

function variance($aValues, $bSample = false)
{
    $fMax = max($aValues);// / count($aValues);
    $fVariance = array();
    foreach ($aValues as $i)
    {
        $fVariance[] = pow($fMax-$i, 2);
    
    }
    
    //$fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
 //   return $fVariance;
}

function standard_deviation($aValues, $bSample = false)
{
    $fMean = array_sum($aValues) / count($aValues);
    $fVariance = 0.0;
    foreach ($aValues as $i)
    {
        $fVariance += pow($i - $fMean, 2);
    }
    $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
    return (float) sqrt($fVariance);
}
function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}



function filterkwrd($data)
{
$ans=array_filter($data,function ($item) use (&$data) {
   // echo "Filtering key ", key($data), '<br>', PHP_EOL;
   //echo IsNullOrEmptyString(key($data));
   
   $pos=stripos(key($data), 'http://');
   $pos2=strcmp(key($data), '-');
   
   $os = array("the", "in", "of","that","this","a","at","was","and","there","where","your","he","she","his","him","her","then","when","why");
   
   if ( $pos !== false ) 
   	 {   next($data);
    	 return false;
     }elseif (IsNullOrEmptyString(key($data))) {
  	  //  echo '$var is either 0, empty, or not set at all';
     	next($data);
  	    return false;  	  
     }elseif(strcmp(key($data),'-') == 0){
     next ($data);
     return false;
     }elseif (in_array(key($data), $os)){
      next ($data);
      return false;
     }
     else{
     	next($data);
  	    return true;  	  
     }
     
    }
 );
 return array_combine(array_keys($ans),array_values($ans));
 }
 
 
 function mutation($keywords, $results)
{

	$num_of_keywords = count($keywords);
	
	for($i=0; $i<$num_of_keywords; $i++)
	{
		for($j=0; $j<$num_of_keywords; $j++)
		{
			if($i != $j)
			{
				array_push($results,$keywords[$i],$keywords[$j] );
			}
		}
	
	}
	return ($results);

}

function pc_array_power_set($array,$pair_count) {
    // initialize by adding the empty set
    $results = array(array( ));

    foreach ($array as $element)
        foreach ($results as $combination)
            array_push($results, array_merge(array($element), $combination));



$results2=array();
foreach ($results as $combination) {
    if (count($combination) ==$pair_count) {
       // print_r ($combination) ;
    $results2[]=$combination;
    }
}

    //print_r( $results2);
return $results2;
}


function mutate_check_rvs($json,$mut_element_array,$n)
{
//$n=$n-1;
$json_a=json_decode($json,true);
//$json_o=json_decode($json,false);
//print_r($json_a['title']);


//print_r($json_o->title);

//print_r($json_o->entry);



//print_r($json_o->entry[2]->title);
//print_r($json_o->entry[2]->category[0]['@attributes']);

$rv_title="";
$rv_keyword="";

$rv_title_count=0;
$current_rv_keyword_count=0;
$present_current_rv=0;
$rv_match_found=0;

//$mut_element_array=new array();


//echo $mut_element_array[0];
//echo $mut_element_array[1];

/*
print_r($json_a['title']);

print_r($json_a['entry'][2]['title']);

print_r($json_a['entry'][2]["category"][2]['@attributes']['term']);
*/
$i=0;
foreach($json_a['entry'] as $rv)
{
	$current_rv_keyword_count1=0;// Resets the current rv counter
	$current_rv_keyword_count2=0;
	
	
	$current_rv_keyword_count=NULL;
	$current_rv_keyword_count=array();
	
	$rv_title=explode(" ",$json_a['entry'][$i]['title']);
	
	if (in_array($mut_element_array[0],$rv_title)==true && in_array($mut_element_array[1],$rv_title)==true)
	$rv_match_found=$rv_match_found+4;
	
	//$rv_title=array_merge($rv_title,$rv_title);   // CURRENT VIDEO TITTLE ARRAY LIST
	
	$j=0;
	//echo $json_a['entry'][2]["category"][2]['@attributes']['term'];
	//echo $i.'<br>';
	if ($i<20){
//PER RECENT VOIDEO
	  foreach($json_a['entry'][$i]["category"] as $rv)
		{
		    //echo"<br>".$j;
		    $current_rv_keyword=$json_a['entry'][$i]["category"][$j]['@attributes']['term'];
			//$rv_keyword[]=$current_rv_keyword;//for future use//$json_a['entry'][$i]["category"][$j]['@attributes']['term'];
		//echo $current_rv_keyword   ." <BR>nnn";
		
		//print_r($mut_element_array);
		
			for($k=0;$k<$n;$k++){ 
		        if (strcasecmp($current_rv_keyword,$mut_element_array[$k])==0)
				$current_rv_keyword_count[$k]=1;
			}
			/*
			if (strcasecmp($current_rv_keyword,$mut_element_array[1])==0)
			//if (strpos($current_rv_keyword,$mut_element_array[1])==false)
				$current_rv_keyword_count2=1;			
				*/
			$j++;
		//echo $current_rv_keyword ."===".$mut_element_array[0]."===".$mut_element_array[1];
		//echo $current_rv_keyword_count1."====".$current_rv_keyword_count2."<br>";
	
	    }//for
	}// if $per_rv_video_title_keyword=array_merge($rv_keyword[],$rv_title);
	
	if (array_sum($current_rv_keyword_count)>=$n){
	//if (($current_rv_keyword_count1+$current_rv_keyword_count2)>=2){
				$rv_match_found++;		
				//echo "COUNTED".$rv_match_found;
		}
		
 //echo "NEXT VIDEO : FOUND".$rv_match_found."<BR><BR>";
 $i++;
}//new rv video

//print_r($rv_keyword);
//echo "MATCH :".$rv_match_found;
return $rv_match_found;
}
?>
