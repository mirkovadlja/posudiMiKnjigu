<?php

if (!preg_match("/^[a-z ,.'-àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+$/i", $_POST["ime"])) {
	$g=new stdClass();
	$g->element="ime";
	$g->poruka="Ime sadrži nedozvoljene znakove";
	array_push($greske,$g);
}