<?php  
session_start();
function ErrorMsg(){
	if(isset($_SESSION['ErrorMsg'])) {
		$Output = "<div class=\"alert alert-danger\">";
		$Output .= htmlentities($_SESSION['ErrorMsg']) ;
		$Output .= "</div>";
		$_SESSION['ErrorMsg'] = null;
		return $Output;

	}
}


function SuccessMsg(){
	if(isset($_SESSION['SuccessMsg'])) {
		$Output = "<div class=\"alert alert-success\">";
		$Output .= htmlentities($_SESSION['SuccessMsg']) ;
		$Output .= "</div>";
		$_SESSION['SuccessMsg'] = null;
		return $Output;

	}
}
?>
