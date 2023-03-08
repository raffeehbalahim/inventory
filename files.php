<?php include 'db/config.php'; session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Capytech Inventory</title>

	<link href="styles/css/bootstrap.min.css" rel="stylesheet">
	<link href="styles/css/app.css" rel="stylesheet">
	<link href="styles/css/main.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<script src="styles/js/jquery.js"></script>
</head>

<body>
	<div class="wrapper">
		<?php 
			include './components/sidebar.php';
    	?>
		<div class="main">
			<?php 
				include './components/navbar.php';
				include './components/file.php';
				include './components/footer.php';
				include './components/modal.php';

			?>
		</div>
	</div>
	
	<script src="styles/js/app.js"></script>
	<script src="styles/js/main.js"></script>
	
</body>
</html>