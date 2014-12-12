
<?php include_once '../konfiguracija.php'; 
//print_r($_SESSION);
if(!isset($_SESSION[$app . "autoriziran"])){
	header("location: ../index.php?error=0");
}

if(isset($_GET["stranica"])){
	$stranica=$_GET["stranica"];
	if($stranica==0){
		$stranica=1;
	}
}else{
	$stranica=1;
}
if(isset($_GET["trazi"])){
	$trazi=$_GET["trazi"];
} else if(isset($_POST["trazi"])){
	$trazi=$_POST["trazi"];
}else{
	$trazi="";
}
//print_r($_POST)
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
 <?php include_once '../sastrane.php' ;    ?>

</div>
   <div class="large-10 medium-8 columns ">
   	<div class="row knjige ">
   		<div class="row font">
   			<div class="large-12 columns">
   			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
   		<input type="text"  name="trazi" value="<?php if(isset($_POST["trazi"])){echo $_POST["trazi"];}?>"/>
   		Traži po:&nbsp;&nbsp; 
   		
      <input type="radio" name="kriterij" value="1" id="kriterij1" <?php if(!isset($_POST["kriterij"]) || $_POST["kriterij"]==1){echo "checked=\"true\"";}?>><label for="kriterij1">Naslov</label>
      <input type="radio" name="kriterij" value="2" id="kriterij2" <?php if(isset($_POST["kriterij"]) && $_POST["kriterij"]==2){echo "checked=\"true\"";}?>><label for="kriterij2">Ime autora</label>
      
      <input type="submit" value="Traži" class="button trazi"/>
      </form>
      </div>
      </div>
      
      <a href="<?php echo $putanjaApp;?>knjige/dodaj.php"><button class="button sastrane font " >Dodaj novu knjigu</button></a><hr />
   	<?php
   	$i=0;
    if($_POST){
			switch ($_POST["kriterij"]) {
    case 1:
        $kriterij="a.naziv";
        break;
    case 2:
       $kriterij="d.ime";
        break;
   default:
   $kriterij="d.naziv";
        break;
 }
 
			$trazi=$_POST["trazi"];				
			}else{ $kriterij="a.naziv";
 	$trazi="";
			}
			$vlasnik=$_SESSION[$app. "autoriziran"]->id;
			if($stranica==1){
			$s=0;
		}else{
			$s=($stranica-1)*9;
		}
   	$izraz = $veza -> prepare("select a.id as broj,a.naziv as naslov,a.status as status,b.id as id,b.username as korisnik,
   	c.naziv as izdavac,d.ime as name,a.godina as godina,a.izdanje as izdanje,f.username as gdje,f.id as idgdje
   	from knjiga a 
   	inner join user b on a.vlasnik=b.id 
   	inner join izdavac c on a.izdavac=c.id 
   	inner join autor d on a.autor=d.id 
   	inner join posjed e on e.knjiga=a.id
   	inner join user f on e.user=f.id
   	where $kriterij like :trazi and vlasnik=$vlasnik
   	order by broj
   	limit $s, 9");
	
	$trazi = "%". $trazi."%";
	$izraz->bindParam(":trazi", $trazi);
	$izraz->execute();
	$info=$izraz->fetchAll(PDO::FETCH_OBJ);
	foreach($info as $knjiga): ?>
	
		<div class="large-4 columns">
			<div class="panel minimum">
				<a href="#" data-reveal-id="modal_<?php echo $knjiga ->broj?>"><h4><?php echo $knjiga-> naslov?></h4></a>
				<p class="font">AUTOR: <?php echo $knjiga-> name;?> </br>
				Izdavač: <?php echo $knjiga-> izdavac ?></br>
				<?php if($knjiga->status==0){
					echo " <img src=\"".$putanjaApp. "img/ikone/freebook.png\" alt=\"\" title=\"Knjiga je slobodna\"/>";}
					else{
					 echo " <img src=\"".$putanjaApp. "img/ikone/notfree.png\" alt=\"\" title=\"Knjiga je zauzeta\"/>";}?>
				</p>
			<div class="dolje">
				<a href="<?php echo $putanjaApp;?>knjige/settings.php?id=<?php echo $knjiga->broj;?>" ><img src="<?php echo $putanjaApp;?>img/ikone/settings.png"> </a>
				<a href="#" data-reveal-id="modal_delete_<?php echo $knjiga ->broj?>" ><img src="<?php echo $putanjaApp;?>img/ikone/delete.png"> </a>
				<?php
				
				if($knjiga->status==0){
					
					echo "<a href=\"".$putanjaApp."knjige/zauzeta.php?id=".$knjiga ->broj."\">";
					echo "<img src=\"".$putanjaApp. "img/ikone/freebook.png\" alt=\"\"/>";
					echo "<img src=\"".$putanjaApp. "img/ikone/arrow.png\" alt=\"\"/>";
					echo "<img src=\"".$putanjaApp. "img/ikone/notfree.png\" alt=\"\"/>";
					echo "</a>";
									
				}else{
					echo "<a href=\"".$putanjaApp."knjige/slobodna.php?id=".$knjiga ->broj."\">";
					echo "<img src=\"".$putanjaApp. "img/ikone/notfree.png\" alt=\"\"/>";
					echo "<img src=\"".$putanjaApp. "img/ikone/arrow.png\" alt=\"\"/>";
					echo "<img src=\"".$putanjaApp. "img/ikone/freebook.png\" alt=\"\"/>";
					echo "</a>";
					
				
				}	
				?>	
			</div>
			</div>
		</div>
  
 <div id="modal_<?php echo $knjiga->broj ;?>" class="reveal-modal font prored" data-reveal>
 
  <fieldset>
  		<h4><?php echo $knjiga -> naslov;?></h4>
  		Autor knjige: <?php echo $knjiga -> name;?></br>
  		Izdavač: <?php echo $knjiga-> izdavac ?></br>
  			Izdanje: <?php echo $knjiga-> izdanje ?></br>
  			Godina izdanja: <?php echo $knjiga-> godina ?></br>
  			Knjiga je trenutno u posjedu korisnika <a href="<?php echo $putanjaApp."user/index.php?id=".$knjiga->idgdje ?>"><?php echo $knjiga->gdje?></a></br>
  		
  		<?php if($knjiga->status==0){
					echo " <img src=\"".$putanjaApp. "img/ikone/freebook.png\" alt=\"\" title=\"Knjiga je slobodna\"/>";}
					else{
						
					 echo " <img src=\"".$putanjaApp. "img/ikone/notfree.png\" alt=\"\" title=\"Knjiga je zauzeta\"/>";}?>
				
							
  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
</div>
<div id="modal_delete_<?php echo $knjiga->broj ;?>" class="reveal-modal" data-reveal>
 
  <fieldset>
  		<h4><?php echo $knjiga -> naslov;?></h4>
  		Autor knjige: <?php echo $knjiga -> name;?></br>
  		
  		<?php if($knjiga->status==0){
					echo " <img src=\"".$putanjaApp. "img/ikone/freebook.png\" alt=\"\" title=\"Knjiga je slobodna\"/>";}
					else{
					 echo " <img src=\"".$putanjaApp. "img/ikone/notfree.png\" alt=\"\" title=\"Knjiga je zauzeta\"/>";}?>
				<div class="centrirano font">Jeste li sigurni da želite obrisati knjigu?</br>
  			<a href="<?php echo $putanjaApp;?>knjige/delete.php?id=<?php echo $knjiga->broj;?>"><button class="button sastrane font " >Da, obriši</button></a><hr />
  			<a href="<?php echo $putanjaApp ?>knjige"> <button class="button odustani font" >Odustani</button></a>
  		</div>
  </fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
</div>


  <?php  
  $i=$i+1;
 
  endforeach;
  if($i==0){echo "<p class=\"centrirano\">Pretraga po zadanim kriterijima nema rezultata</p>";}
   ?>
   </div>
   <div class="pagination-centered">
  <ul class="pagination">
    <li class="arrow"><a href="<?php echo $_SERVER["PHP_SELF"] . "?stranica=" . ($stranica-1) ?>&trazi=<?php echo $trazi ?>&kriterij=<?php echo $kriterij ?>">&laquo;</a></li>
    <li class="current"><a href=""><?php echo  $stranica; ?></a></li>
    <?php if($i==9){echo 
    "<li class=\"arrow\"><a href=".$_SERVER["PHP_SELF"] . "?stranica=" . ($stranica+1)."&trazi=".$trazi."&kriterij=".$kriterij. "\">&raquo;</a></li>";
 }?>
  </ul>
</div>
   
   </div>
   <div id="greska" class="reveal-modal zoomIn centrirano" data-reveal>
  
  <fieldset>
	Ne možete obrisati knjigu koja je trenutno zauzeta i nije u Vašem posjedu!
  	</fieldset>
  
  <a class="close-reveal-modal">&#215;</a>
</div>

   
   
        <?php include_once '../footer.php' ;    ?>
    <script src="<?php echo $putanjaApp;?>js/vendor/jquery.js"></script>
    <script src="<?php echo $putanjaApp;?>js/foundation.min.js"></script>
    <script>
      $(document).foundation();
   <?php
		if(isset($_GET["greska"])){
	    echo	   "$(document).ready(function(){\$('#greska').foundation('reveal', 'open')});";
		}
		?>
    </script>
		
		
	   
	 
    <?php include_once '../osvjezi.php';?>
  </body>
</html>
