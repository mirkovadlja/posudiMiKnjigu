<?php

include_once '../konfiguracija.php';
if (!preg_match("/^[a-z ,.'-àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/i", $_POST["naziv"])) {
	$g=new stdClass();
	$g->element="naziv";
	$g->poruka="Naziv sadrži nedozvoljene znakove";
	array_push($greske,$g);
}
if(strlen(trim($_POST["naziv"]))==0){
	$g=new stdClass();
	$g->element="naziv";
	$g->poruka="Naziv mora sadržavati barem jedan znak";
	array_push($greske,$g);
	
}
if(strlen(trim($_POST["autor"]))==0){
	$g=new stdClass();
	$g->element="autor";
	$g->poruka="Ime i prezime autora mora sadržavati barem jedan znak";
	array_push($greske,$g);
	
}
if (!preg_match("/^[a-z ,.'-àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/i", $_POST["autor"])) {
	$g=new stdClass();
	$g->element="autor";
	$g->poruka="Ime ili prezime autora sadrži nedozvoljene znakove";
	array_push($greske,$g);
}

if (!preg_match("/^[a-z ,.'-àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/i", $_POST["izdavac"])) {
	$g=new stdClass();
	$g->element="izdavac";
	$g->poruka="Naziv izdavača sadrži nedozvoljene znakove";
	array_push($greske,$g);
}
if(strlen(trim($_POST["izdavac"]))==0){
	$g=new stdClass();
	$g->element="izdavac";
	$g->poruka="Ime izdavača mora sadržavati barem jedan znak";
	array_push($greske,$g);
	
}
if(!is_numeric($_POST["godina"])){
	$g=new stdClass();
	$g->element="godina";
	$g->poruka="Godina mora biti broj";
	array_push($greske,$g);
}
if(!is_numeric($_POST["izdanje"])){
	$g=new stdClass();
	$g->element="izdanje";
	$g->poruka="Izdanje mora biti broj";
	array_push($greske,$g);
}

if($_POST["godina"]>2015)
{
	$g=new stdClass();
	$g->element="godina";
	$g->poruka="Nemoguće :)";
	array_push($greske,$g);
}
