<?php
include_once 'konfiguracija.php';
//print_r($_GET);
$greske=array();
if($_POST){
	include_once 'provjera.php';
	//include_once 'kontrolaLozinkiUnos.php';
	if(empty($greske)){
		unset($_POST["password2"]);		
		$_POST["password1"] = md5($_POST["password1"]);		
		$izraz = $veza -> prepare("insert into user(ime,prezime,username,email,pass,ovlasti,potvrda,grad) values (:ime,:prezime,:username,:email,:password1,:ovlasti,:potvrda,:grad);");
		$izraz -> execute($_POST);
			
		$id= $veza->lastInsertId();
		$link=$putanjaApp."potvrda.php?id=".$id;
		mail($_POST["email"],"Potvrda registracije",$link,'From: <posudimiknjigu@pmk.com>');	
		header("location:".$putanjaApp."index.php?pot=1");
		//print_r($_POST);
		//echo $link;
		
		 	}
}
//print_r($_POST);
//print_r($greske);
?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php
		include_once 'head.php';
		?>
		<title><?php echo $naslovapp ; ?></title>
	</head>
	<body  class="slika">
		<div class="row">
			<div class="large-6 medium-6 small-12 columns ">

				<img class="show-for-small malicentar" src="img/logo.png" />
				<img class="center hide-for-small" src="img/logo.png"  alt=""/>
			</div>
			<div class="large-6 medium-6 small-12 columns reg">
				<form  action="autorizacija.php" method="POST">

					<div class="row">
						<div class="large-6 medium-6 small-12 columns ">
							<label for="email" class="login" <?php if(isset($_GET["error"]) && $_GET["error"]==0){echo "style=\"color: red\"";}?>>Email
								<input type="text" id="email" name="email" />
							</label>

						</div>
						<div class="large-6 medium-6 small-12 columns ">
							<label for="password" class="login" <?php if(isset($_GET["error"]) && $_GET["error"]==0){echo "style=\"color: red\"";}?>>Password
								<input type="password" id="password" name="password"/>
							</label>
						</div>
					</div>

					<div class="row">
						<div class="large-6 medium-6 small-12 columns">
							<input type="submit" class="button siroki" value="Log in" />
						</div>
				</form>
				<div class="large-6 medium-6 small-12 columns login">
					<a href="#" data-reveal-id="modal_zaboravi" class="login"> Zaboravio sam lozinku</a>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns reg">
					<a href="#" data-reveal-id="registracija" class="button siroki">Registriraj se!</a>
				</div>
			</div>

		</div>
		</div>
	
<div id="registracija" class="reveal-modal zoomIn" data-reveal>
  
  <fieldset>
  	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
  	
  		<label for="ime" >Ime <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="ime"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="text" name="ime" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="ime" value="<?php if(isset($_POST["ime"])){echo $_POST["ime"];}?>" />
	
		
  			<label for="prezime" >Prezime <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="prezime"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="text" name="prezime" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="prezime" value="<?php if(isset($_POST["prezime"])){echo $_POST["prezime"];}?>" />
		
		
  			<label for="email" >Email <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="email"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="text" name="email" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="email" value="<?php if(isset($_POST["email"])){echo $_POST["email"];}?>" />
	
  			<label for="username" >Korisničko ime <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="username"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="text" name="username" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="username" value="<?php if(isset($_POST["username"])){echo $_POST["username"];}?>" />
		
		
  			<label for="password1" >Lozinka <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="password1"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="password" name="password1" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="username" value="" />
		
		
  				<label for="password2" >Ponovi lozinku <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="password2"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="password" name="password2" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="username" value="" />
		
  		<input type="hidden" name="ovlasti" id="ovlasti" value="0" />
  		<input type="hidden" name="grad" id="grad" value="Osijek" />
  		<input type="hidden" name="potvrda" id="potvrda" value="0" />

  		<input type="submit" class="button siroki" value="Registriraj me!"/>
  		</form>
  <a href="<?php echo $putanjaApp?>index.php" ><button class="button odustani">Odustani</button></a>
  </fieldset>
  <a class="close-reveal-modal">&#215;</a>
</div>
<div id="modal_zaboravi" class="reveal-modal font prored" data-reveal>
 
  <fieldset>
  	<form action="zaborav.php" method="post"> 
  		<label>Unesite email koji ste koristili pri registraciji 
        <input type="text" value="" name="email" />
        <input type="submit" class="button siroki" value="Potvrdi"/>
        </label>
  	</form>
  		 <a href="<?php echo $putanjaApp?>index.php" ><button class="button odustani">Odustani</button></a>
  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
  
</div>

<div id="bravooo" class="reveal-modal font prored centrirano" data-reveal>
 
  <fieldset>
  	<p><?php if(isset($_GET["nova"]) && $_GET["nova"]==1){
  echo "Privremena lozinka je poslana na uneseni email,nakon prijave promjenite privremenu lozinku željenom lozinkom!";
	} ?>
	<?php if(isset($_GET["nova"]) && $_GET["nova"]==0){
  echo "Korisnički račun s danom email adresom ne postoji!";
	} ?>
  	</p> 
  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
  
</div>

<div id="potvrdaaa" class="reveal-modal font prored centrirano" data-reveal>
   <fieldset>
  <p>
  	Uspješno ste završili registraciju! Nastavite na log in:
</p>
	<a href="<?php echo $putanjaApp?>index.php" ><button class="button siroki">Nastavi</button></a>
  
  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
  
</div>
<div id="potvrdeee" class="reveal-modal font prored centrirano" data-reveal>
   <fieldset>
  <p>
  	Email s linkom za potvrdu registracije je poslan na Vašu adresu!
</p>
	<a href="<?php echo $putanjaApp?>index.php" ><button class="button siroki">Nastavi</button></a>
  
  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
  
</div>

		<script src="<?php echo $putanjaApp;?>js/vendor/jquery.js"></script>
		<script src="<?php echo $putanjaApp;?>js/foundation.min.js"></script>
		<script>
			$(document).foundation();
		<?php
		if(isset($_POST["ime"])){
	    echo	   "$(document).ready(function(){\$('#registracija').foundation('reveal', 'open')});";
		}
		?>
		<?php
		if(isset($_GET["pot"])){
	    echo	   "$(document).ready(function(){\$('#potvrdeee').foundation('reveal', 'open')});";
		}
		?>
		<?php
		if(isset($_GET["nova"])){
	    echo	   "$(document).ready(function(){\$('#bravooo').foundation('reveal', 'open')});";
		}
		?>
		
		<?php
		if(isset($_GET["uspjesno"])){
	    echo	   "$(document).ready(function(){\$('#potvrdaaa').foundation('reveal', 'open')});";
		}
		?>
		</script>
	</body>
</html>
