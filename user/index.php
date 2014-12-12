
<?php include_once '../konfiguracija.php'; 
//print_r($_SESSION);
if(!isset($_SESSION[$app . "autoriziran"])){
	header("location: ../index.php?error=0");
}

$greske=array();
$upozorenje="";
//print_r($_POST);
//print_r($_GET);


if($_POST){
	if(strlen(trim($_POST["poruka"]))==0){$upozorenje="Poruka ne može biti poslana bez sadržaja!";}else{
	$izraz=$veza->prepare("insert into poruka(posiljatelj,primatelj,vrijeme,sadrzaj,procitano) values(:posiljatelj, :primatelj, :date, :poruka, :procitano)");
	$izraz->execute($_POST);
	$upozorenje="Poruka uspješno poslana!";
	}
}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
   <?php include_once '../head.php'; ?>
    <title><?php echo $naslovapp; ?></title>
  </head>
  <body class="pozadina">
   
    <?php include_once '../gore.php' ;    ?>
    <?php include_once '../mali.php' ;    ?>
    
   
    
    
  
   <div class="large-2 medium-3 columns hide-for-small">
 <?php include_once '../sastrane.php' ;    
 $izraz=$veza->prepare("select * from user where id=:id");
 if($_GET){
 	$izraz->bindParam(":id", $_GET["id"]);
 }else{
 	$izraz->bindParam(":id", $_SESSION[$app."autoriziran"]->id);
 }
 $izraz->execute();
 $user=$izraz->fetch(PDO::FETCH_OBJ);
 
 
 

 ?>
 

</div>
   <div class="large-9 medium-8 columns">
    <div class="row">
    	<div class="large-12 columns centrirano knjige font">
    		<h3><?php echo $user->username;?></h3>
    	</div>    	
    </div>
    <div class="row">
    	<div class="large-12 columns">
    		
    		<div class="large-2 columns font hide-for-small hide-for-medium prored">
    		Ime:</br>
    		Prezime: </br>
    		Grad:</br>
    		Knjige:<hr />
    		</div>
    		<div class="large-6 columns font prored">
    			<?php echo $user->ime;?></br>
    			<?php echo $user->prezime;?></br>
    			<?php echo $user->grad;?></br>
    			
    			</div>
    			<div class="large-4 columns desno">
    				<?php if($_SESSION[$app."autoriziran"]->id==$user->id){
    					echo "<a href=\"".$putanjaApp . "user/settings.php\" ><img src=\" ".$putanjaApp. "img/ikone/settings.png\"> </a>";
						//echo "<a href=\"".$putanjaApp . "deleteuser.php?id=".$_SESSION[$app."autoriziran"]->id."\" ><img src=\" ".$putanjaApp. "img/ikone/delete.png\"> </a>";
						echo "<a href=\"#\"data-reveal-id=\"modal_brisanje\"><img src=\"".$putanjaApp. "img/ikone/delete.png\"> </a></br>";
    				}else{
    					echo "<a href=\"#\" data-reveal-id=\"modal_poruka\"><img src=\"".$putanjaApp. "img/ikone/sendmes.png\">Pošalji poruku </a></br>";
						echo $upozorenje;
    				}?>
    				
    				
    				</div>
    		<div class="row knjige">
    			<div class="large-12 columns">
    		<?php 
    		$izraz=$veza->prepare("select a.id as broj,a.naziv as naslov,a.status as status,b.id as id,b.username as korisnik,
   	c.naziv as izdavac,d.ime as name,a.izdanje as izdanje,a.godina as godina 
   	from knjiga a inner join user b on a.vlasnik=b.id 
   	inner join izdavac c on a.izdavac=c.id 
   	inner join autor d on a.autor=d.id 
   	
   	where b.id=:id
   	order by broj");
 			if($_GET){
 			$izraz->bindParam(":id", $_GET["id"]);
			 }else{
 			$izraz->bindParam(":id", $_SESSION[$app."autoriziran"]->id);
				 }
		 $izraz->execute();
 			$knjiga=$izraz->fetchAll(PDO::FETCH_OBJ);
 			foreach ($knjiga as $k):
    		?>
    		<div class="large-4 columns">
				<div class="panel minimum">
				<a href="#" data-reveal-id="modal_<?php echo $k ->broj?>"><h4><?php echo $k-> naslov?></h4></a>
				<p class="font">AUTOR: <?php echo $k-> name;?></br>
				Izdavač: <?php echo $k-> izdavac ?></br>
				
				<?php if($k->status==0){
					echo " <img src=\"".$putanjaApp. "img/ikone/freebook.png\" alt=\"\" title=\"Knjiga je slobodna\"/>";}
					else{
					 echo " <img src=\"".$putanjaApp. "img/ikone/notfree.png\" alt=\"\" title=\"Knjiga je zauzeta\"/>";}?>
  		</p>
				</div>
			</div>
		
   <div id="modal_<?php echo $k->broj ;?>" class="reveal-modal font prored" data-reveal>
 
  <fieldset>
  		<h4><?php echo $k -> naslov;?></h4>
  		Autor knjige: <?php echo $k -> name;?></br>
  		Izdavač: <?php echo $k-> izdavac ?></br>
  			Izdanje: <?php echo $k-> izdanje ?></br>
  			Godina izdanja: <?php echo $k-> godina ?></br>
  		Vlasnik knjige: <a href="<?php echo $putanjaApp; ?>user/index.php?id=<?php echo $k-> id ?>"><?php echo $k-> korisnik ?></a></br>
  		
  		<?php if($k->status==0){
					echo " <img src=\"".$putanjaApp. "img/ikone/freebook.png\" alt=\"\" title=\"Knjiga je slobodna\"/>";}
					else{
					 echo " <img src=\"".$putanjaApp. "img/ikone/notfree.png\" alt=\"\" title=\"Knjiga je zauzeta\"/>";}?>
  		
  		
  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
  
</div>

<?php endforeach;?>
		</div>
    		</div>
    		
    	</div>
    </div>
   </div>
   
   
   <div id="modal_poruka" class="reveal-modal font prored" data-reveal>
 
  <fieldset>
  	<form action="<?php echo $_SERVER['PHP_SELF']."?id=". $user->id;?>" method="post"> 
  	Primatelj: <?php echo $user->username;?>
  		<label>Sadržaj poruke:
        <textarea value="asdasd" name="poruka"></textarea>
      </label>
      <input type="hidden" name="primatelj" value="<?php echo $user->id;?>">
      <input type="hidden" name="procitano" value="0">
      <input type="hidden" name="posiljatelj" value="<?php echo $_SESSION[$app."autoriziran"]->id;?>">
      <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s',strtotime('+5hours'));?>">
      <input type="submit" class="button siroki" value="Pošalji" />
  	</form>
  		
  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
  
</div>


<div id="modal_brisanje" class="reveal-modal centrirano font prored" data-reveal>
 
  <fieldset>  		
  		Ova radnja se nemože poništiti.Jeste li sigurni da želite obrisati profil?</br>
  		<form action="<?php echo $putanjaApp;?>deleteuser.php" method="get">
  			<input type="hidden" name="id" value="<?php echo $_SESSION[$app."autoriziran"]->id;?>" />
  			<input type="submit" class="button siroki" value="Da obriši profil" />
  			
  		</form>
  		<a href="<?php echo $putanjaApp ?>user"> <button class="button odustani font" >Odustani</button></a>
  </fieldset>
  	  <a class="close-reveal-modal">&#215;</a>
</div>

        <?php include_once '../footer.php' ;    ?>
    <script src="<?php echo $putanjaApp;?>js/vendor/jquery.js"></script>
    <script src="<?php echo $putanjaApp;?>js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
