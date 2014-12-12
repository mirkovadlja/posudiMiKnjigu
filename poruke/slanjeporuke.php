<?php 
include_once '../konfiguracija.php'; 
//print_r($_POST);

if(!isset($_SESSION[$app . "autoriziran"])){
	header("location: ../index.php?error=0");
	
}

$date = date('Y-m-d H:i:s',strtotime("+6hours"));
$izraz=$veza -> prepare("insert into poruka(posiljatelj,primatelj,vrijeme,sadrzaj,procitano)
values(:posiljatelj,(select id from user where username=:primatelj),'$date' ,:sadrzaj,0)");
$izraz->execute($_POST);
//print_r ($_POST);
header("location: index.php");
