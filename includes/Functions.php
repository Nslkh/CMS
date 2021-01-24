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
function Login_Attemt($UserName,$Password) {
	global $ConnectingDB;
		$sql = "SELECT * FROM admins WHERE username=:userName AND password=:password LIMIT 1";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':userName',$UserName);
		$stmt->bindValue(':password',$Password);
		$stmt->execute();
		$Result = $stmt->rowcount();
		if ($Result==1) {
			return $Found_Account = $stmt->fetch();
		}else{
			return null;
		}
}
function Confirm_Login(){
	if (isset($_SESSION["UserId"])) {
		return true;
	}else {
		$_SESSION["ErrorMsg"] = "Login Required ! ";
		Redirect_to("Login.php");
	}
}
?>