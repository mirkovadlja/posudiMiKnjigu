
<?php include_once '../konfiguracija.php'; 
//print_r($_POST);

if(!isset($_SESSION[$app . "autoriziran"])){
	header("location: ../index.php?error=0");
	
}


if(isset($_GET["a"])){
	$izraz=$veza->prepare("update poruka set procitano=1 where posiljatelj=(select id from user where username=:pos) and primatelj=:pri ");
	$izraz->bindParam(":pos", $_GET["pos"]);
	$izraz->bindParam(":pri", $_SESSION[$app. "autoriziran"]->id);
	
	$izraz->execute();
};
$izraz=$veza->prepare("select id from user where username=:username");
$izraz->bindParam(":username", $_GET["pos"]);
$izraz->execute();
$treba=$izraz->fetch(PDO::FETCH_OBJ);
$profil=$treba->id;

?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
   <?php include_once '../head.php'; ?>
      <link type="text/css" media="screen" rel="stylesheet" href="responsive-tables.css" />
    <title><?php echo $naslovapp; ?></title>
  </head>
  <body class="pozadina">
   
    <?php include_once '../gore.php' ;    ?>
    <?php include_once '../mali.php' ;    ?>
   <div class="large-2 medium-3 columns hide-for-small">
 <?php include_once '../sastrane.php' ;    ?>

</div>
   <div class="large-10 medium-8 columns font knjige">
   	<div class="row"><div class="large-10 columns">
   	<h5>Poruke korisnika: </br>
			<?php echo $_GET["pos"]. "  (<a href=". $putanjaApp. "user/index.php?id=".$profil.">Pogledaj profil)</a></h5>";
					?>
			
			<form action="slanjeporuke.php" method="post">
				<label for="sadrzaj">Nova poruka:
				
        <textarea value="" name="sadrzaj"></textarea>
      </label>
				<input type="hidden" name="posiljatelj" id="posiljatelj" value="<?php echo $_SESSION[$app. "autoriziran"]->id;?>"/>
				<input type="hidden" name="primatelj" id="primatelj" value="<?php echo $_GET["pos"]?>"/>
				<input type="submit" class="button siroki" value="Pošalji poruku"/>
				
			</form>
			<?php
			unset($_GET["id"]);
			$_GET["dad"] =$_SESSION[$app . "autoriziran"]->username;
			$izraz=$veza-> prepare("select 
por.sadrzaj as sadrzaj,por.vrijeme as vrijeme,a.username as posiljatelj, b.id as id,b.username
from poruka por
inner join user a on por.posiljatelj=a.id
inner join user b on por.primatelj=b.id
where (a.username=:pos and b.username=:dad) or (a.username=:dad and b.username=:pos) order by por.vrijeme desc ");
$izraz->execute($_GET);
$poruka=$izraz->fetchAll(PDO::FETCH_OBJ);


//print_r($poruka);

				foreach($poruka as $mess):
			?>
			
			<hr />
			<?php 
			
			echo "<div class=\"centrirano prored\">";
			if($mess->posiljatelj==$_SESSION[$app . "autoriziran"]->username){echo "<img src=\"".$putanjaApp. "img/ikone/red.png\" alt=\"\" />";}else{echo "<img src=\"".$putanjaApp. "img/ikone/green.png\" alt=\"\" />";}
			echo $mess->vrijeme;?> </div>
			<?php echo $mess->sadrzaj;?> 
			<?php 
				endforeach;
 				$veza=null;?>
   </div>
 
   </div></div>
        <?php include_once '../footer.php' ;    ?>
    <script type="text/javascript" src="<?php echo $putanjaApp;?>responsive-tables.js"></script>
    <script src="<?php echo $putanjaApp;?>js/vendor/jquery.js"></script>
    <script src="<?php echo $putanjaApp;?>js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
