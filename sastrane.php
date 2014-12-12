<?php include_once 'konfiguracija.php';?>
<?php 
$r=0;
$izraz=$veza->prepare("select *from poruka where primatelj=:prim and procitano='0'");
$izraz->bindParam(':prim', $_SESSION[$app."autoriziran"]->id);
$izraz->execute();
$info=$izraz->fetchAll(PDO::FETCH_OBJ);
	foreach($info as $knjiga): 
		$r=$r+1;
	endforeach;
	?>

<div class="icon-bar vertical five-up ">
	<a href="<?php echo $putanjaApp ?>naslovna"> <button class="button sastrane font <?php echo (strpos($_SERVER["PHP_SELF"],"naslovna/")>0 ) ? "aktivan" : "" ?>" ><img src="<?php echo $putanjaApp ?>img/ikone/home32.png"> Naslovna</button></a>
  	<a href="<?php echo $putanjaApp ?>user"><button class="button sastrane font <?php echo (strpos($_SERVER["PHP_SELF"],"user/")>0 ) ? "aktivan" : "" ?>" ><img src="<?php echo $putanjaApp ?>img/ikone/user1.png">Profil</button></a>
 	<a href="<?php echo $putanjaApp ?>knjige"> <button class="button sastrane font <?php echo (strpos($_SERVER["PHP_SELF"],"knjige/")>0 ) ? "aktivan" : "" ?>" ><img src="<?php echo $putanjaApp ?>img/ikone/books12.png"> Moje knjige</button></a>
  <a href="<?php echo $putanjaApp ?>poruke"><button class="button sastrane font <?php echo (strpos($_SERVER["PHP_SELF"],"poruke/")>0 ) ? "aktivan" : "" ?>" ><?php if($r>0){echo "<img src=\"".$putanjaApp. "img/ikone/new.png\" alt=\"\" /> ";} ?><img src="<?php echo $putanjaApp ?>img/ikone/message1.png"> Poruke</button></a>
 



</div>
