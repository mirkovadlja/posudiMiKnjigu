<?php
include_once 'konfiguracija.php';
if (!preg_match("/^[a-z ,.'-àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/i", $_POST["ime"])) {
	$g=new stdClass();
	$g->element="ime";
	$g->poruka="Ime sadrži nedozvoljene znakove";
	array_push($greske,$g);
}

if (!preg_match("/^[a-z ,.'-àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/i", $_POST["prezime"])) {
	$g=new stdClass();
	$g->element="prezime";
	$g->poruka="Prezime sadrži nedozvoljene znakove";
	array_push($greske,$g);
}

if (trim(strlen($_POST["email"]))==0) {
	$g=new stdClass();
	$g->element="email";
	$g->poruka="Email obavezan";
	array_push($greske,$g);
}else if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $_POST["email"])) {
	$g=new stdClass();
	$g->element="email";
	$g->poruka="Format email-a neispravan";
	array_push($greske,$g);
}else {
	$izraz = $veza -> prepare("select * from user where email=:email");
$izraz->bindParam(":email", $_POST["email"]);
$izraz -> execute();
$t = $izraz -> fetch(PDO::FETCH_COLUMN);
if($t>0){
	$g=new stdClass();
	$g->element="email";
	$g->poruka="Email postoji, odaberite drugi";
	array_push($greske,$g);
}
	
}

if (!preg_match("/^[a-z ,.'-àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/i", $_POST["username"])) {
	$g=new stdClass();
	$g->element="username";
	$g->poruka="Korisničko ime sadrži nedozvoljene znakove";
	array_push($greske,$g);
}else {
	$izraz = $veza -> prepare("select * from user where username=:username");
$izraz->bindParam(":username", $_POST["username"]);
$izraz -> execute();
$t = $izraz -> fetch(PDO::FETCH_COLUMN);
if($t>0){
	$g=new stdClass();
	$g->element="username";
	$g->poruka="Korisničko ime postoji, odaberite drugo";
	array_push($greske,$g);
}
	
}

if(strlen($_POST["password1"])==0){
	$g=new stdClass();
	$g->element="password1";
	$g->poruka="Unesite lozinku";
	array_push($greske,$g);	
}
if(strlen($_POST["password2"])==0){
	$g=new stdClass();
	$g->element="password2";
	$g->poruka="Unesite lozinku ponovno";
	array_push($greske,$g);	
}else if($_POST["password1"]!=$_POST["password2"]){
	$g=new stdClass();
	$g->element="password2";
	$g->poruka="Lozinke se ne podudaraju";
	array_push($greske,$g);	
	
}
