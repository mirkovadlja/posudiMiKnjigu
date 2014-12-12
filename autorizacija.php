<?php 
if(!$_POST)
{
	header("location: index.php");
}
include_once 'konfig.php';
$_POST["password"]=md5($_POST["password"]);
$izraz= $veza -> prepare("select * from user where email=:email and pass=:password and potvrda=1");
$izraz-> execute($_POST);
$objekt= $izraz -> fetch(PDO::FETCH_OBJ);


if($objekt!=null){
		session_start();
		$_SESSION[$app . "autoriziran"]=$objekt;
		header("location: " . $putanjaApp . "naslovna");
		
	}else{
		header("location: " . $putanjaApp . "index.php?error=0");
	}
	

//	print_r($_POST);
