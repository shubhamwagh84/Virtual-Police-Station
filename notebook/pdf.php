
<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <meta charset="utf-8"/>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



</head>
<body>

	<style type="text/css">
		html, body{
			overflow:hidden;
		}
	</style>

	
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8">
			<iframe src="tesr.pdf" style="width: 100%; height: 570px;"></iframe>
		</div>

		<div class="col-sm-4 mt-5">
			<?php include 'sign.html'; ?>
			<img src="" id="im">
		</div>
	</div>
</div>
<script>

	$(document).ready(function(){
		
			$('#btnPrint').hide();
			$('#language').hide();
			$('#cfm').hide();
			$('#sign').show();

			$('#sign').click(function(){
				//alert("");
			var img = new Image();
			img.src = 'sample.jpg';

			var doc = new jsPDF();  // optional parameters
			 doc = "tesr.pdf";

			doc.addImage(img, 'JPEG', 1, 2);
			doc.save("new.pdf");
		});
		});

	
</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>



</body>
</html>