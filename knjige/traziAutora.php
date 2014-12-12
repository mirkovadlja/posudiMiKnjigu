<?php
include_once '../konfiguracija.php';
$izraz = $veza->prepare("select * from autor where ime like :uvjet");


if(isset($_GET["term"])){
	$uv="%" . $_GET["term"] . "%";
$izraz->bindParam(':uvjet', $uv);	
}
else {
	$uv="%";
	$izraz->bindParam(':uvjet', $uv);
}
$izraz->execute();
echo json_encode($izraz->fetchAll(PDO::FETCH_OBJ));