<?php 
include_once 'konfiguracija.php';
if(!isset($_SESSION[$app . "autoriziran"])){
	header("location: ../index.php?error=0");
}
$broj=0;
$izraz=$veza->prepare("select procitano from poruka where primatelj=:ja");
$izraz->bindParam(":ja", $_SESSION[$app. "autoriziran"]->id);
$izraz->execute();
$rez=$izraz->fetchAll(PDO::FETCH_OBJ);
foreach($rez as $new):
	if($new->procitano==1){
		$broj=$broj+1;
	}
endforeach;
$veza=null;
echo $broj;
?>