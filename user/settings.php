
<?php
	include_once '../konfiguracija.php';
	//print_r($_SESSION);
	if (!isset($_SESSION[$app . "autoriziran"])) {
		header("location: ../index.php?error=0");
	}
	$greske = array();
	if($_POST){
	include_once 'provjera.php';
	//include_once 'kontrolaLozinkiUnos.php';
	if(empty($greske)){
		if(strlen($_POST["password1"])>0){
		unset($_POST["password2"]);		
		$_POST["password1"] = md5($_POST["password1"]);	
		$id=$_SESSION[$app."autoriziran"]->id;	
		$izraz = $veza -> prepare("update  user set ime=:ime,prezime=:prezime,username=:username,email=:email,grad=:grad,pass=:password1 where id=$id;");
		$izraz -> execute($_POST);
		
$izraz= $veza -> prepare("select * from user where email=:email and pass=:password1");
$izraz->bindParam("email", $_POST["email"]);
$izraz->bindParam("password1", $_POST["password1"]);
$izraz-> execute();
$entitet= $izraz -> fetch(PDO::FETCH_OBJ);
session_destroy();
session_start();
$_SESSION[$app . "autoriziran"]=$entitet;

		header("location:".$putanjaApp."user/index.php");
		//print_r($_POST);
		}
		else{
		unset($_POST["password2"]);		
		unset($_POST["password1"]);		
		$id=$_SESSION[$app."autoriziran"]->id;	
		$izraz = $veza -> prepare("update  user set ime=:ime,prezime=:prezime,username=:username,email=:email,grad=:grad where id=$id;");
		$izraz -> execute($_POST);
		$izraz= $veza -> prepare("select * from user where email=:email");
$izraz->bindParam("email", $_POST["email"]);
$izraz-> execute();
$entitet= $izraz -> fetch(PDO::FETCH_OBJ);
session_destroy();
session_start();
$_SESSION[$app . "autoriziran"]=$entitet;
		header("location:".$putanjaApp."user/index.php");
		//print_r($_POST);
		}
		 	}
		 	}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
   <?php
	include_once '../head.php';
 ?>
    <title><?php echo $naslovapp; ?></title>
  </head>
  <body class="pozadina">
   
    <?php
	include_once '../gore.php';
    ?>
    <?php
		include_once '../mali.php';
    ?>
    
   
    
    
  
   <div class="large-2 medium-3 columns hide-for-small">
 <?php
	include_once '../sastrane.php';
?>
</div>
   <div class="large-9 medium-8 columns font">
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
		} ?>id="ime" value="<?php if(isset($_POST["ime"])){echo $_POST["ime"];}else{echo $_SESSION[$app."autoriziran"]->ime;}?>" />
	
		
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
		} ?>id="prezime" value="<?php if(isset($_POST["prezime"])){echo $_POST["prezime"];}else{echo $_SESSION[$app."autoriziran"]->prezime;}?>" />
		
		
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
		} ?>id="email" value="<?php if(isset($_POST["email"])){echo $_POST["email"];}else{echo $_SESSION[$app."autoriziran"]->email;}?>" />
	
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
		} ?>id="username" value="<?php if(isset($_POST["username"])){echo $_POST["username"];}else{echo $_SESSION[$app."autoriziran"]->username;}?>" />
		
		
  		
  		<input type="hidden" name="grad" id="grad" value="Osijek" />
  		
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
<div class="pod font">(Ukoliko želite da Vaša lozinka ostane nepromjenjena polja za lozinku i njen ponovni unos ostavite praznim)</div>
  		<input type="submit" class="button siroki" value="Sačuvaj izmjene"/>
  		<a href="<?php echo $putanjaApp?>user/index.php"><button class="button odustani">Odustani</button></a>
  		</form>
  </fieldset>
  
   </div>
 
   

        <?php
	include_once '../footer.php';
    ?>
    <script src="<?php echo $putanjaApp; ?>js/vendor/jquery.js"></script>
    <script src="<?php echo $putanjaApp; ?>js/foundation.min.js"></script>
    <script>
		$(document).foundation();
    </script>
  </body>
</html>
