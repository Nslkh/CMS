<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");

if(isset($_GET["id"])) {
	$SearchQueryParameters = $_GET["id"];
	global $ConnectingDB;
	$sql = "DELETE FROM  category  WHERE id='$SearchQueryParameters' ";
	$Execute = $ConnectingDB->query($sql);
	if($Execute) {
		$_SESSION["SuccessMsg"]="Category Deleted Successfully !";
		Redirect_to("Categories.php");

	}else{
	$_SESSION["ErrorMsg"]="Something Went Wrong. Try Again !";
		Redirect_to("Categories.php");
	}
}


















	
