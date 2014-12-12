
<?php include_once '../konfiguracija.php'; 
//print_r($_POST);
if(!isset($_SESSION[$app . "autoriziran"])){
	header("location: ../index.php?error=0");
}
if($_POST)
{
	if($_POST["sifrausera"]!=0){
		$izraz=$veza->prepare("update posjed set user=:sifrausera where knjiga=:id");
$izraz->bindParam(":id", $_POST["knjiga"]);
$izraz->bindParam(":sifrausera", $_POST["sifrausera"]);
$izraz->execute();

$izraz=$veza->prepare("update knjiga set status='1' where id=:id");
$izraz->bindParam(":id", $_POST["knjiga"]);

$izraz->execute();
//print_r($izraz);
header("location:".$putanjaApp."knjige");
	}else{
		header("location:".$putanjaApp."knjige");
	}
}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
   <?php include_once '../headk.php'; ?>
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
   			<div class="large-12 columns prored">
   				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
   		Za promjenu statusa knjige u zauzeta odaberite korisničko ime korisnika kod kojeg se knjiga nalazi!
   		 <input type="text" name="userime" id="userime"  value="" />
		<input type="hidden" name="sifrausera" id="sifrausera" value="0">
		<input type="hidden" name="knjiga" id="knjiga" value="<?php echo $_GET["id"]?>">
		<input type="submit" class="button siroki" value="Potvrdi">
		</form>
		<a href="<?php echo $putanjaApp ?>knjige/index.php"> <button class="button odustani font" >Odustani</button></a>
			</div>
			</div>
		</div>

   
        <?php include_once '../footer.php' ;    ?>
    <script src="<?php echo $putanjaApp;?>js/vendor/jquery.js"></script>
    <script src="<?php echo $putanjaApp;?>js/foundation.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    
    
		<script>
	$(function() {
 	$("#userime").autocomplete({
    source: "traziusera.php",
    minLength: 1,
     search: function( event, ui ) {
     	$("#sifrausera").val(0);
     	
     },
    focus: function( event, ui ) {
    	event.preventDefault();
    	},
    select: function(event, ui) {
        //$(this).val('').blur();
        $(this).val(ui.item.username);
        $("#sifrausera").val(ui.item.id);
        event.preventDefault();
        //spremiUBazu(ui.item);
		
    }
	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.username + "</a>" )
        .appendTo( ul );
    };
	
	
	

 	
    });
    </script>
 
    <script>
		$(document).foundation();

    </script>
    
  </body>
</html>
