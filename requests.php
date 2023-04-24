<?php include 'db/config.php'; session_start();
if($_SESSION["loggedin"] != true){
	header("location: login.php");
}
?>
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
	<link href="DataTables/datatables.min.css" rel="stylesheet"/>
	
	<script src="DataTables/datatables.min.js"></script>

	<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
	<link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.dataTables.min.css" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<?php 
			include './components/sidebar.php';
    	?>
		<div class="main">
			<?php 
				include './components/navbar.php';
				include './components/requests.php';
				include './components/footer.php';
				include './components/modal.php';

			?>
		</div>
	</div>
	
	<script src="styles/js/app.js"></script>
	<script src="styles/js/main.js"></script>
	
</body>
</html>