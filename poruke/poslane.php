
<?php include_once '../konfiguracija.php'; 
//print_r($_SESSION);
if(!isset($_SESSION[$app . "autoriziran"])){
	header("location: ../index.php?error=0");
	
}
$n=0;
if(isset($_GET["stranica"])){
	$stranica=$_GET["stranica"];
	unset($_GET["stranica"]);
	if($stranica==0){
		$stranica=1;
	}
}else{
	$stranica=1;
}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
   <?php include_once '../head.php'; ?>
      <link type="text/css" media="screen" rel="stylesheet" href="<?php echo $putanjaApp;?>css/responsive-tables.css" />
    <title><?php echo $naslovapp; ?></title>
  </head>
  <body class="pozadina">
   
    <?php include_once '../gore.php' ;    ?>
    <?php include_once '../mali.php' ;    ?>
   <div class="large-2 medium-3 columns hide-for-small">
 <?php include_once '../sastrane.php' ;    ?>

</div>
   <div class="large-10 medium-8 columns">
	
			<div class="row centrirano tabla">
			<div class="large-12 columns  knjige font centrirano">
				
				<div class="large-6 columns"><a href="<?php echo $putanjaApp?>/poruke/index.php" class="button siroki <?php echo (strpos($_SERVER["PHP_SELF"],"poruke/index.php")>0 ) ? "aktivan" : "" ?>">Primljene poruke</a></div>
	<div class="large-6 columns"><a href="<?php echo $putanjaApp?>/poruke/poslane.php" class="button siroki <?php echo (strpos($_SERVER["PHP_SELF"],"poruke/poslane.php")>0 ) ? "aktivan" : "" ?>">Poslane poruke</a></div>
	
				
	<table align="center">
  <thead>
    <tr>
      <th>Primatelj</th>
      <th>Datum</th>
        <th>Poruka</th>
         <th>Status</th>
    </tr>
  </thead>
  <tbody>
  	
				<?php
				if($stranica==1){
			$s=0;
		}else{
			$s=($stranica-1)*9;
		}
				$_GET["id"]=$_SESSION[$app . "autoriziran"]->id;
				$izraz=$veza -> prepare("select po.id as id,po.vrijeme as vrijeme,po.procitano as status,
				usa.username as posiljatelj,usb.username as primatelj from poruka po 
				inner join user usa on po.posiljatelj=usa.id 
				inner join user usb on po.primatelj=usb.id 
				where po.posiljatelj=:id order by po.vrijeme desc
				limit $s, 9");
				$izraz->execute($_GET);
				$poruka=$izraz->fetchAll(PDO::FETCH_OBJ);
				foreach($poruka as $mess):
				?>
				<tr>
				 <td><?php echo $mess->primatelj;?> </td>
				 <td><?php echo $mess->vrijeme;?> </td>
				  <td><a href="poruka.php<?php echo "?id=".$mess->id."&pos=".$mess->primatelj;?>">Pročitaj </a></td>
				    <td><?php if($mess->status==0){echo " <img src=\"".$putanjaApp. "img/ikone/neprocitana.png\" alt=\"\" /><img src=\"".$putanjaApp. "img/ikone/new.png\" alt=\"\" />";}else{echo " <img src=\"".$putanjaApp. "img/ikone/procitana.png\" alt=\"\" />";}?> </td>
				</tr>
				<?php 
				$n=$n+1;
				endforeach;
 				$veza=null;?>
 				</tbody>
				</table>
				<div class="pagination-centered">
  <ul class="pagination">
    <li class="arrow"><a href="<?php echo $_SERVER["PHP_SELF"] . "?stranica=" . ($stranica-1) ?>">&laquo;</a></li>
    <li class="current"><a href=""><?php echo  $stranica; ?></a></li>
    <?php if($n==9){echo 
    "<li class=\"arrow\"><a href=".$_SERVER["PHP_SELF"] . "?stranica=" . ($stranica+1).">&raquo;</a></li>";
 }?>
  </ul>
</div>
				</div>
			</div>
   </div>
        <?php include_once '../footer.php' ;    ?>
    <script type="text/javascript" src="<?php echo $putanjaApp;?>js/responsive-tables.js"></script>
    <script src="<?php echo $putanjaApp;?>js/vendor/jquery.js"></script>
    <script src="<?php echo $putanjaApp;?>js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
