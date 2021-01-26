<?php
require_once ("includes/DB.php");
require_once ("includes/Functions.php");
require_once ("includes/Sessions.php");

if(isset($_GET["id"])) {
	$SearchQueryParameters = $_GET["id"];
	global $ConnectingDB;
	$Admin = $_SESSION["AdminName"];
	$sql = "UPDATE comments SET status='OFF' , approvedby='$Admin' WHERE id='$SearchQueryParameters' ";
	$Execute = $ConnectingDB->query($sql);
	if($Execute) {
		$_SESSION["SuccessMsg"]="Comment Dis-Approved Successfully !";
		Redirect_to("Comments.php");

	}else{
	$_SESSION["ErrorMsg"]="Something Went Wrong. Try Again !";
		Redirect_to("Comments.php");
	}
}


















	
