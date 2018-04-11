<?php

function sanitizeFormPassword($inputText){
	//strip_tags uklanja html elemente iz forme
	$inputText=strip_tags($inputText );
	return $inputText;
}
function sanitizeFormUsername($inputText){
	//strip_tags uklanja html elemente iz forme
	$inputText=strip_tags($inputText );
	//uklanja sva prazna mjesta 
	$inputText =str_replace(" ","",$inputText );
	return $inputText;
}
function sanitizeFormString($inputText){
	//strip_tags uklanja html elemente iz forme
	$inputText=strip_tags($inputText );
	//uklanja sva prazna mjesta 
	$inputText =str_replace(" ","",$inputText );
	//prvo slovo veliko
	$inputText=ucfirst(strtolower($inputText));
	return $inputText;
}
	


if(isset($_POST['registerButton'])){
	//register form
	$username=sanitizeFormUsername($_POST['username']);
	$firstName=sanitizeFormString($_POST['firstName']);
	$lastName=sanitizeFormString($_POST['lastName']);
	$email=sanitizeFormString($_POST['email']);
	$email=sanitizeFormString($_POST['email']);
	$email2=sanitizeFormString($_POST['email2']);
	$password=sanitizeFormPassword($_POST['password']);
	$password2=sanitizeFormPassword($_POST['password2']);

	$wasSuccessful=$account->register($username,$firstName,$lastName,$email,$email2,$password,$password2);
	if($wasSuccessful==true){
		$_SESSION['userLoggedIn']=$username;
		header("Location: index.php");
	}

}	 


?>