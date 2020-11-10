<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);
	
	/* core inclusions */
	include_once("../wp-config.php");
	include_once(EP_PATH."/initialise.php");
	include_once(EPABSPATH."/include/classes/user.class.php");
	include_once(EPABSPATH."/include/classes/service.class.php");

	//print_r($_POST); 
	
	if(isset($_POST) && count($_POST)>5){
		
		if(isset($_POST['joomtst']) && $_POST['joomtst']!=''){
			//spam check
			exit;
		}
		
		$result = X_User::CreateGroupUser($_POST);

		if($result > 0){
			//all good!
			echo json_encode(array('success'=>1));			
		} else if($result == PASSWORD){
			//couldn't update
			echo json_encode(array('success'=>0,'reason'=>'password'));
		} else if($result == EMAIL){
			//couldn't update
			echo json_encode(array('success'=>0,'reason'=>'email'));
		} else {
			//couldn't update
			echo json_encode(array('success'=>0,'reason'=>'unknown'));		
		}

	} 
	
	exit;

	
?>