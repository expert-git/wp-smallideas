<?php

	/* core inclusions */
	include_once("../../app.smallideas.com.au/ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/userHistory.class.php");	
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");	

	//read current user list (to get phone number)
	$file = fopen("wp_users.csv","r");
	$currentUsers = array();
	while(! feof($file)){
		$ln = fgetcsv($file);
		$theemail = strtolower($ln[0]);
		$currentUsers[$theemail][] = $ln[1];
	}
	fclose($file);
	//print_r($currentUsers); exit;

	//get all active users from DB
	$userObjArr = DAL_User::GetAllActive();
	echo count($userObjArr);
	
	
	//get userhistory for each active user	
	foreach($userObjArr as $userObj){
		$historyObjArr = DAL_UserHistory::GetAbsolutelyAllForUser($userObj->id);
		$userObj->redeems = count($historyObjArr);
		$em = strtolower($userObj->email);
	//	echo "\n".$em."\n";
		if(isset($currentUsers[$em])){
			$userObj->phone = str_replace('"','',$currentUsers[$em][0]);
		}
		
	}
	
//	print_r($userObjArr); exit;


	//write to file
	$filev = fopen("usersNotUsingApp.csv","w");
	fputcsv($filev,array('email','phone','last renewal','redeems'));
	foreach ($userObjArr as $u)
	  {
	  	fputcsv($filev,array($u->email," ".$u->phone,$u->lastRenewed,$u->redeems));
	  }
	fclose($filev); 
	

	
	
//	print_r($userObjArr);

?>