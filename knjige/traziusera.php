<?php
include_once '../konfiguracija.php';
$izraz = $veza->prepare("select * from user where username like :uvjet and username!=:user");


if(isset($_GET["term"])){
	$uv="%" . $_GET["term"] . "%";
$izraz->bindParam(':uvjet', $uv);	
}
else {
	$uv="%";
	$izraz->bindParam(':uvjet', $uv);
}
$izraz->bindParam(':user', $_SESSION[$app."autoriziran"]->username);
$izraz->execute();
echo json_encode($izraz->fetchAll(PDO::FETCH_OBJ));