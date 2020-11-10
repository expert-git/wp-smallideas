<?php
	
	/* core inclusions */
	include_once("../../ep_library/initialise.php");
	include_once(EPABSPATH."/include/classes/template.class.php");

	/* database classes required for page */
	include_once(EPABSPATH."/include/classes/DAL/user.class.php");
	include_once(EPABSPATH."/include/classes/category.class.php");
	

	

	/* check authentication and process login if required */
	include_once(EPABSPATH."/include/classes/auth.class.php");	 
  	
	//is admin?
    $isAdmin = (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']);

	//show login if required, update session time
	X_Auth::Login(); 

	if(!$isAdmin){
		session_destroy();
		header("Location: /manager/");
		exit;
	}
	

	//setup page templates
	$template = new Template(EPABSPATH.'/templates/masterAdmin.tmpl.php');
	$pageTemplate = new Template(EPABSPATH.'/templates/viewUsersAdmin.tmpl.php');
	$pageTemplate->parent($template);  //so that pageTemplate can access the variables set in the parent template
	

/*	//get users
	$option = (isset($_GET['get'])) ? $_GET['get'] : '';
	switch($option){
		case "unapproved":
			$pageTitle = "Guides Awaiting Approval";
			$userObjArr = DAL_User::GetAllUnapproved();
			break;
		case "guides":
			$pageTitle = "All Guides";
			$userObjArr = DAL_User::GetAllGuides();
			break;
		default:
			$pageTitle = "All Users";
			$userObjArr = DAL_User::GetAll();
			break;
	}*/
	$userObjArr = DAL_User::GetAll();

	//set template variables
	$template->title = " App Users | Small Ideas";
	$template->isAdmin = $isAdmin;
	$template->activeTab = 'users';
	$template->bodyClass = '';
	$template->userObjArr = $userObjArr;
	$template->pagelevelCSS = '';
	$template->pagelevelScripts = '<script src="/js/table-datatables-editable-users.js" type="text/javascript"></script>';

	
	
	//display page
	$template->content = $pageTemplate->run();	//generate inner page content
	echo $template;	//echo master

?>