<?php 
include_once 'konfiguracija.php';

$r=0;
$izraz=$veza->prepare("select *from poruka where primatelj=:prim and procitano='0'");
$izraz->bindParam(':prim', $_SESSION[$app."autoriziran"]->id);
$izraz->execute();
$info=$izraz->fetchAll(PDO::FETCH_OBJ);
	foreach($info as $knjiga): 
		$r=$r+1;
	endforeach;
	

?>

<div class="row">
    <div class="small-12 columns show-for-small">
    <nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1 ><?php echo $_SESSION[$app. "autoriziran"]->ime. ' '. $_SESSION[$app. "autoriziran"]->prezime ?>
    <?php if($r>0){echo "<img src=\"".$putanjaApp. "img/ikone/neprocitana.png\" alt=\"\" /> ";} ?></h1>
    </li>
    
    <li class="toggle-topbar menu-icon"><a href="#"><span >Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <ul class="right"  >
      <li ><a href="<?php echo $putanjaApp ?>naslovna"><img src="<?php echo $putanjaApp ?>img/ikone/home32.png"> Naslovna</a></li>
         <li ><a href="<?php echo $putanjaApp ?>user"><img src="<?php echo $putanjaApp ?>img/ikone/user1.png"> Profil</a></li>
       <li ><a href="<?php echo $putanjaApp ?>knjige"><img src="<?php echo $putanjaApp ?>img/ikone/books12.png"> Moje knjige</a></li>
     
         <li ><a  href="<?php echo $putanjaApp ?>poruke"><img src="<?php echo $putanjaApp ?>img/ikone/message1.png">Poruke</a></li>
         <li ><a  href="<?php echo $putanjaApp ?>odjava.php"><img src="<?php echo $putanjaApp ?>img/ikone/odjava.png">Odjavi se</a></li>
        
  </section>
</nav>
     </div>
    </div>
    