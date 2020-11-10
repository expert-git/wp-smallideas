<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/

	exit;


	//read current user list	
	$file = fopen("wp_users.csv","r");
	$currentUsers = array();
	while(! feof($file)){
		$ln = fgetcsv($file);
		$currentUsers[$ln[0]][] = "";
	}
	fclose($file);	
	//print_r($currentUsers);
	
	//read all orders list	
	$fileo = fopen("allorders.csv","r");
	$ordersArr = array();
	while(! feof($fileo)){
		$lno = fgetcsv($fileo);
		//print_r($lno);
		if(!isset($currentUsers[$lno[3]]))
		$ordersArr[] = $lno;
		//$ordersArr[$ln[0]][] = "";
	}
	fclose($fileo);	
	
	echo count($ordersArr);
	
	
	
	//write to file
	$filev = fopen("output.csv","w");
	foreach ($ordersArr as $line)
	  {
//		  print_r($line);
	  	fputcsv($filev,$line);
	  }
	fclose($filev); 
	
	
?>