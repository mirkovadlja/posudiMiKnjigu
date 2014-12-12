
<script>



function dohvati(){
	
	//alert("nesto");
  	$.ajax({
				type: "POST",
				url: "../provjeraporuka.php",
				success: function(vratioServer){
					
					//alert(vratioServer);
					
					setTimeout("dohvati()", 5000);
				}
			});
}
	  setTimeout("dohvati()", 5000);
	
</script>