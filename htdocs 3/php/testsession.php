<?php
session_start();
	//$susrid =  $_SESSION['name'];
	//echo ;

	
	echo $_SESSION['loggedin'];
	
	if (isset($_SESSION['loggedin'])){
   echo '<script type="text/javascript">var cloggedin=1</script>';
   	echo "   LOGGEDIN: ".$_SESSION['loggedin'];

   }else{
   echo '<script type="text/javascript">var cloggedin=0</script>';
	}
	
	

		if (isset($_SESSION['name'])){
  echo '<script type="text/javascript">var cname="'.$_SESSION['name'].'"</script>';
  echo "   NAME: ".$_SESSION['name'];	
	
 
}else{
   echo '<script type="text/javascript">var cname=0</script>';
	}
	
		if (isset($_SESSION['pic_small'])){
  echo '<script type="text/javascript">var cpic_small="'.$_SESSION['pic_small'].'"</script>';
 
}else{
   echo '<script type="text/javascript">var cpic_small=0</script>';
	}
	
		if (isset($_SESSION['in_clofus'])){
  echo '<script type="text/javascript">var cin_clofus="'.$_SESSION['in_clofus'].'"</script>';
}else{
   echo '<script type="text/javascript">var cin_clofus=0</script>';
	}
	
		if (isset($_SESSION['email'])){
  echo '<script type="text/javascript">var cemail="'.$_SESSION['email'].'"</script>';
}else{
   echo '<script type="text/javascript">var cemail=0</script>';
	}
		if (isset($_SESSION['hometown_location'])){
   echo '<script type="text/javascript">var chometown_location="'.$_SESSION['hometown_location'].'"</script>';
   	}else{
   echo '<script type="text/javascript">var chometown_location=0</script>';
	}
		if (isset($_SESSION['clofus_id'])){
  echo '<script type="text/javascript">var clofus_id="'.$_SESSION['clofus_id'].'"</script>';
  echo "   clofus_id: ".$_SESSION['clofus_id'];	
	
}else{
   echo '<script type="text/javascript">var clofus_id=0</script>';
	}
	
     

	




?>