<?php
include_once 'konfiguracija.php';

$_GET["username"]="unknown".$_SESSION[$app."autoriziran"]->id;
$izraz=$veza->prepare("update user set ime='unknown', prezime='unknown', username=:username,email='unknown',grad='unknown',foto='unknown',potvrda='0' where id=:id");
$izraz->execute($_GET);
header("location:".$putanjaApp."index.php");
//print_r($_GET);