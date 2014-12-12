<?php include_once 'konfiguracija.php'; ?>
<?php include_once 'analyticstracking.php'; ?>

<div class="gore">
	<div class="large-4 medium-6 small-12 columns grampi" style="text-align: left;color: #D6D6D6">


<div class="show-for-small"><img src="<?php echo $putanjaApp ?>img/logo.png" alt="" />Posudi</div>
<div class="hide-for-small"><img src="<?php echo $putanjaApp ?>img/logo.png" alt="" />Posudi mi knjigu</div>

	</div>
	<div class="large-8 medium-6 small-12 columns  hide-for-small font">
		<?php echo $_SESSION[$app . "autoriziran"]->ime. " ". $_SESSION[$app . "autoriziran"]->prezime. '&nbsp;&nbsp;&nbsp;&nbsp;' ; ?>
		<a href="../odjava.php"><img src="<?php echo $putanjaApp ?>img/ikone/logout32.png" alt="" /></a>
	</div>
</div>
