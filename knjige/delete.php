<?php
include_once '../konfiguracija.php';
$izraz=$veza->prepare("select * from knjiga where id=:id");
$izraz->execute($_GET);
$info=$izraz->fetch(PDO::FETCH_OBJ);
//print_r($info);
if($info->status==0)
{

$izraz=$veza->prepare("delete from knjiga where id=:id");
$izraz->execute($_GET);
header("location: ../knjige");
//print_r($_GET);
}else{
	header("location: ../knjige/index.php?greska=1");
}

