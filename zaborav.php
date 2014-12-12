<?php
include_once 'konfiguracija.php';
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
$password1=randomPassword();
//echo $password1;
$password=md5($password1);
$izraz=$veza->prepare("update user set pass=:pass where email=:email");
$izraz->bindParam(":pass", $password);
$izraz->bindParam(":email", $_POST["email"]);
$izraz->execute();


$izraz=$veza->prepare("select * from user where email=:email");
$izraz->bindParam(":email", $_POST["email"]);
$izraz->execute();
$provjera=$izraz->fetch(PDO::FETCH_OBJ);
if($provjera!=null){
	mail($_POST["email"],"Privremena lozinka","Vaša privremena lozinka: ".$password1, 'From: <posudimiknjigu@pmk.com>');	
	
header("location:".$putanjaApp."index.php?nova=1");
	
}else{
	header("location:".$putanjaApp."index.php?nova=0");
}



