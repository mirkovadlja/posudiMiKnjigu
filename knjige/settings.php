
<?php
	include_once '../konfiguracija.php';
	//print_r($_SESSION);
	if (!isset($_SESSION[$app . "autoriziran"])) {
		header("location: ../index.php?error=0");
	}
	//print_r($_POST);
	$greske=array();
	if($_GET){
		$izraz=$veza->prepare("select a.id as broj,a.naziv as naslov,a.godina as godina,a.izdanje as izdanje,
		a.status as status,b.id as id,b.username as korisnik,a.color as color
   	c.naziv as izdavac,d.ime as name
   	from knjiga a inner join user b on a.vlasnik=b.id 
   	inner join izdavac c on a.izdavac=c.id 
   	inner join autor d on a.autor=d.id 
   	
   	where a.id=:id");
	$izraz->execute($_GET);
	$knjigaa=$izraz->fetch(PDO::FETCH_OBJ);
		
	}
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
			
			$izraz=$veza->prepare("update knjiga set naziv=:naziv,autor=:autor,godina=:godina,izdanje=:izdanje,izdavac=:izdavac where id=:id");
			$izraz->bindParam(":naziv", $_POST["naziv"]);
			$izraz->bindParam(":autor", $autorid);
			$izraz->bindParam(":godina", $_POST["godina"]);
			$izraz->bindParam(":izdanje", $_POST["izdanje"]);
			$izraz->bindParam(":id", $_POST["id"]);
			$izraz->bindParam(":izdavac", $izdavacid);
			$izraz->execute();
			$kat= $veza->lastInsertId();
			
			
				//header("location: ../knjige");
		echo "uspjeh";
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
		} ?>id="naziv" value="<?php if($_GET){echo $knjigaa->naslov;}else{echo $_POST["naziv"];}?>" />
   			
   					
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
		} ?> id="autor" placeholder="Ime i prezime autora" value=""/>
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
		} ?> id="izdavac" placeholder="Naziv izdavača" value=""/>
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
		} ?>id="godina" value="<?php if($_GET){echo $knjigaa->godina;}else{echo $_POST["godina"];}?>"  />
   			
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
		} ?>id="izdanje" value="<?php if($_GET){echo $knjigaa->izdanje;}else{echo $_POST["izdanje"];}?>"/>
   			
		
   			<input type="hidden" name="vlasnik" value="<?php echo $_SESSION[$app. "autoriziran"]->id;?>">		
   			<input type="hidden" name="status" value="0">	
   			<input type="hidden" name="id" value="<?php if($_GET){echo $_GET["id"];}else{echo $_POST["id"];}?>">		
   			<input type="submit" class="button siroki" value="Spremi izmjene" />
  			
   			</form>
   			<a href="<?php echo $putanjaApp ?>knjige/index.php"> <button class="button sastrane font" >Odustani</button></a>
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
