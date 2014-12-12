<?php
include_once '../konfiguracija.php';
$izraz=$veza->prepare("update posjed set user=:vlasnik where knjiga=:id");
$izraz->bindParam(":id", $_GET["id"]);
$izraz->bindParam(":vlasnik", $_SESSION[$app."autoriziran"]->id);
$izraz->execute();
//print_r($izraz);

$izraz=$veza->prepare("update knjiga set status='0' where id=:id");
$izraz->bindParam(":id", $_GET["id"]);

$izraz->execute();

header("location:".$putanjaApp."knjige");
