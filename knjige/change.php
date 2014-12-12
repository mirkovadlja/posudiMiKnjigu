
<?php
	include_once '../konfiguracija.php';
	//print_r($_SESSION);
	if (!isset($_SESSION[$app . "autoriziran"])) {
		header("location: ../index.php?error=0");
	}
	//print_r($_POST);
	$greske=array();
	if($_POST){
	include_once 'provjera.php';
		if(empty($greske)){
			
			if($_POST["sifraautora"]==0){			
					$izraz=$veza->prepare("insert into autor(ime) values (:autor)");
					$izraz->bindParam(":autor", $_POST["autor"]);
					$izraz->execute();
					$autorid= $veza->lastInsertId();
					//echo $autorid;
				}else{
					$autorid=$_POST["sifraautora"];
					//echo $autorid;
				}
				
				if($_POST["sifraizdavaca"]==0){
					$izraz=$veza->prepare("insert into izdavac(naziv) values (:izdavac)");
					$izraz->bindParam(":izdavac", $_POST["izdavac"]);
					$izraz->execute();
					$izdavacid= $veza->lastInsertId();
					//echo $izdavacid;
				}else{
					$izdavacid=$_POST["sifraizdavaca"];
					//echo $izdavacid;
				}			
			$izraz=$veza->prepare("insert into knjiga(naziv,autor,godina,izdanje,izdavac,vlasnik,status) values (:naziv,:autor,:godina,:izdanje,:izdavac,:vlasnik,'0')");
			$izraz->bindParam(":naziv", $_POST["naziv"]);
			$izraz->bindParam(":autor", $autorid);
			$izraz->bindParam(":godina", $_POST["godina"]);
			$izraz->bindParam(":izdanje", $_POST["izdanje"]);
			$izraz->bindParam(":izdavac", $izdavacid);
			$izraz->bindParam(":vlasnik", $_POST["vlasnik"]);
			$izraz->execute();
			$kat= $veza->lastInsertId();
			
			$izraz=$veza->prepare("insert into posjed(knjiga,user) values(:book,:korisnik)");
			$izraz->bindParam(":book", $kat);
			$izraz->bindParam(":korisnik", $_SESSION[$app."autoriziran"]->id);
			$izraz->execute();
			
	      header("location: ../knjige");
		//echo "uspjeh";
		}
	}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
  	  
 
   <?php
	include_once '../headk.php';
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
   <div class="large-10 medium-8 columns ">
   	<div class="row knjige ">
   		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
   			
   			
   			
   			
   			  	
   			<label for="naziv" >Naslov: <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="naziv"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="text" name="naziv" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="naziv" value="<?php if(isset($_POST["naziv"])){echo $_POST["naziv"];}?>"  />
   			
   					
        <div class="row font">
        <div class="four columns">  
        	<?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="autor"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		?>    
            <label for="autor">Autor: <?php if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} ?></label>
            <input type="text" name="autor" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?> id="autor" placeholder="Ime i prezime autora" value="" />
		<input type="hidden" name="sifraautora" id="sifraautora" value="0">
        </div>  
        </div> 	
        
        
        <div class="row font">
        <div class="four columns">   
        	<?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="izdavac"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		?>    
           <label for="izdavac">Izdavač: <?php if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} ?></label>
            <input type="text" name="izdavac" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?> id="izdavac" placeholder="Naziv izdavača" value="" />
		<input type="hidden" name="sifraizdavaca" id="sifraizdavaca" value="0">
        </div>  
        </div> 		
        
        <label for="godina" >Godina: <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="godina"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="text" name="godina" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="godina" value="<?php if(isset($_POST["godina"])){echo $_POST["godina"];}?>" />
   			
        <label for="izdanje" >Izdanje: <?php 
  		$poruka="";
  		foreach ($greske as $g) {
			  if($g->element=="izdanje"){
			  	$poruka=$g->poruka;
				  break;
			  }
		  }		
		if(strlen($poruka)>0){
		echo "(".$poruka.")";
		} 
  		?> </label>
  		<input type="text" name="izdanje" <?php if(strlen($poruka)>0){
		echo "style=\"border-color:red\"";
		} ?>id="izdanje" value="<?php if(isset($_POST["izdanje"])){echo $_POST["izdanje"];}?>"  />
   			
		
   			<input type="hidden" name="vlasnik" value="<?php echo $_SESSION[$app. "autoriziran"]->id;?>">		
   			<input type="hidden" name="status" value="0">		
   			<input type="submit" class="button siroki" value="Dodaj knjigu" />
  			
   			</form>
   			<a href="<?php echo $putanjaApp ?>knjige/index.php"> <button class="button odustani font" >Odustani</button></a>
   </div>
   </div>
   
   
   
        <?php
	include_once '../footer.php';
    ?>
    <script src="<?php echo $putanjaApp; ?>js/vendor/jquery.js"></script>
    <script src="<?php echo $putanjaApp; ?>js/foundation.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>

<script>
    
  
 $(function() {
 	$("#autor").autocomplete({
    source: "traziAutora.php",
    minLength: 1,
     search: function( event, ui ) {
     	$("#sifraautora").val(0);
     	
     },
    focus: function( event, ui ) {
    	event.preventDefault();
    	},
    select: function(event, ui) {
        //$(this).val('').blur();
        $(this).val(ui.item.ime);
        $("#sifraautora").val(ui.item.id);
        event.preventDefault();
        //spremiUBazu(ui.item);
		
    }
	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.ime + "</a>" )
        .appendTo( ul );
    };
	
	
	

 	$("#izdavac").autocomplete({
    source: "traziIzdavaca.php",
    minLength: 1,
      search: function( event, ui ) {
     	$("#sifraizdavaca").val(0);
     	
     },
    focus: function( event, ui ) {
    	event.preventDefault();
    	},
    select: function(event, ui) {
        //$(this).val('').blur();
        $(this).val(ui.item.naziv);
        $("#sifraizdavaca").val(ui.item.id);
        event.preventDefault();
        //spremiUBazu(ui.item);
		
    }
	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.naziv + "</a>" )
        .appendTo( ul );
    };
    });
    </script>
 
    <script>
		$(document).foundation();

    </script>
  
    <?php
	include_once '../osvjezi.php';
?>
  </body>
</html>
