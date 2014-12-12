<?php 
include_once 'konfiguracija.php';
$izraz=$veza->prepare("update user set potvrda=1 where id=:id");
$izraz->execute($_GET);
header("location:".$putanjaApp."index.php?uspjesno=2");
