<?php
require 'includes/DB.php';  
function Redirect_to($New_location){
	header("Location:".$New_location);
	exit;
}
function CheckUserNameExistsOrNot($UserName){
 	global $ConnectingDB;
 	$sql = "SELECT username FROM admins WHERE username=:userName";
 	$stmt = $ConnectingDB->prepare($sql);
 	$stmt->bindValue(':userName', $UserName);
 	$stmt->execute();
 	$Result = $stmt->rowcount();
 	if($Result ==1) {
 		return true;
 	}else {
 		return false;
 	}
}
?>