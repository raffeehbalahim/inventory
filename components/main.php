<main class="content">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3"><strong>Dashboard</strong></h1>

		<div class="row">
			<div class="col-12 col-lg-8 col-xxl-9 d-flex">
				<div class="card flex-fill">
					<div class="card-header d-flex justify-content-between">
						<h5 class="card-title mb-0">Peripherals</h5>
						<a data-bs-toggle="modal" data-bs-target="#createItem"><i class="align-middle me-2" data-feather="plus"></i></a>
					</div>
					<div class="filter">
					<button class="btn btn-primary" id="showFilter" onclick="showFilters()">Show More</button>
					<div class="filter-option" id="filter">
					<form action="index.php" method="post" autocomplete="off">
							<div class="d-flex justify-content-between">
								<h6 class="card-title">Filter:</h6>
								<a onclick="closeFilters()"><i class="align-middle me-2" data-feather="minus"></i></a>
							</div>
							<div class="option-bundle">
								<div class="row mb-3">
                        			<div class="col">
										<input type="text" class="form-control" placeholder="Item" value="" name="brand">
									</div>
									<div class="col">
										<input type="text" class="form-control" placeholder="Unit" value="" name="unit">
									</div>
								</div>	
								<div class="row mb-3">
                        			<div class="col">
										<input type="number" class="form-control" placeholder="Serial Number" value="" name="serial_number">
									</div>
									<div class="col">
										<input type="text" class="form-control" placeholder="Manufacturer" value="" name="manufacturer">
									</div>
								</div>	
								<div class="row mb-3">
                        			<div class="col">
										<input type="date" class="form-control" name="purchaseDate">
									</div>
									<div class="col">
									<select class="form-select mb-3" name="bundle">
										<?php
										#Displays options for Sorting Sets
										echo '<option value="all" selected>All Set</option>';
										echo '<option value="0">No Set</option>';

										#Gets Set Bundle Options
                                    	$bundles = "SELECT * FROM set_bundle"; 
                                    	$getBundles = mysqli_query($db, $bundles);
            
                                   		 while ($bundle = mysqli_fetch_assoc($getBundles)) {
											echo '<option value="' . $bundle['set_id'] . '">' . $bundle['set_name'] . '</option>'; 
                                    	}
                                		?>
                            			</select>
									</div>
								</div>		
							</div>
						<button type="submit" class="btn btn-primary" style="float:right" name="submit">Filter</button>
					</form>
					</div>
					
					<!--<form action="index.php" method="post" autocomplete="off">
						<a class="card-title" style=" margin-right:10px;">Set: </a>
							<div class="option-bundle">
                            <select class="form-select mb-3" name="bundle">
								<?php
									#Checks if Set is Selected for Sorting
									#Displays options for Sorting Sets
									//if(isset($_POST['bundle'])){
									//	$option = $_POST['bundle'];
									//} else{
									//	$option = 'all';
									//}
									//if($option == 'all'){
									//	echo '<option value="all" selected>All</option>';
									//} else {
									//	echo '<option value="all">All</option>';
									//}
									//if($option == '0'){
									//	echo '<option value="0" selected>No Set</option>';
									//} else {
									//	echo '<option value="0">No Set</option>';
									//}
								?>
                                <?php
									#Gets Set Bundle Options
                                    //$bundles = "SELECT * FROM set_bundle"; 
                                    //$getBundles = mysqli_query($db, $bundles);
            
                                    //while ($bundle = mysqli_fetch_assoc($getBundles)) {
                                    //    if($option == $bundle['set_id']) {
									//		echo '<option value="' . $bundle['set_id'] . '" selected>' . $bundle['set_name'] . '</option>'; 
									//	} else {
									//		echo '<option value="' . $bundle['set_id'] . '">' . $bundle['set_name'] . '</option>'; 
									//	}
                                    //}
                                ?>
                            </select>
							</div>
						<button type="submit" class="btn btn-primary" name="submit">Filter</button>
					</form>-->
					</div>
					<table class="table table-hover my-0">
						<thead>
							<tr>
								<?php
									#Sorting Table Header
									if(isset($_GET['sort'])){
										if($_GET['sort'] == 'brand'){
											if($_GET['order'] == 'asc'){
											echo '<th><a class="sort-head" href="index.php?sort=brand&order=desc">Item <i class="fa fa-sort-down"></i></a></th>';
											} else {
											echo '<th><a class="sort-head" href="index.php?sort=brand&order=asc">Item <i class="fa fa-sort-up"></i></a></th>';
											}
										} else {
											echo '<th><a class="sort-head" href="index.php?sort=brand&order=asc">Item</a></th>';
										}
										if($_GET['sort'] == 'unit'){
											if($_GET['order'] == 'asc'){
											echo '<th><a class="sort-head" href="index.php?sort=unit&order=desc">Unit <i class="fa fa-sort-down"></i></a></th>';
											} else {
											echo '<th><a class="sort-head" href="index.php?sort=unit&order=asc">Unit <i class="fa fa-sort-up"></i></a></th>';
											}
										} else {
											echo '<th><a class="sort-head" href="index.php?sort=unit&order=asc">Unit</a></th>';
										}
										if($_GET['sort'] == 'serial_number'){
											if($_GET['order'] == 'asc'){
											echo '<th><a class="sort-head" href="index.php?sort=serial_number&order=desc">Serial Number <i class="fa fa-sort-down"></i></a></th>';
											} else {
											echo '<th><a class="sort-head" href="index.php?sort=serial_number&order=asc">Serial Number <i class="fa fa-sort-up"></i></a></th>';
											}
										} else {
											echo '<th><a class="sort-head" href="index.php?sort=serial_number&order=asc">Serial Number</a></th>';
										}
										if($_GET['sort'] == 'purchase_date'){
											if($_GET['order'] == 'asc'){
											echo '<th><a class="sort-head" href="index.php?sort=purchase_date&order=desc">Purchase Date <i class="fa fa-sort-down"></i></a></th>';
											} else {
											echo '<th><a class="sort-head" href="index.php?sort=purchase_date&order=asc">Purchase Date <i class="fa fa-sort-up"></i></a></th>';
											}
										} else {
											echo '<th><a class="sort-head" href="index.php?sort=purchase_date&order=asc">Purchase Date</a></th>';
										}
										if($_GET['sort'] == 'manufacturer'){
											if($_GET['order'] == 'asc'){
											echo '<th><a class="sort-head" href="index.php?sort=manufacturer&order=desc">Manufacturer <i class="fa fa-sort-down"></i></a></th>';
											} else {
											echo '<th><a class="sort-head" href="index.php?sort=manufacturer&order=asc">Manufacturer <i class="fa fa-sort-up"></i></a></th>';
											}
										} else {
											echo '<th><a class="sort-head" href="index.php?sort=manufacturer&order=asc">Manufacturer</a></th>';
										}
										if($_GET['sort'] == 'set_id'){
											if($_GET['order'] == 'asc'){
											echo '<th><a class="sort-head" href="index.php?sort=set_id&order=desc">Set <i class="fa fa-sort-down"></i></a></th>';
											} else {
											echo '<th><a class="sort-head" href="index.php?sort=set_id&order=asc">Set <i class="fa fa-sort-up"></i></a></th>';
											}
										} else {
											echo '<th><a class="sort-head" href="index.php?sort=set_id&order=asc">Set</a></th>';
										}

									}
									else {
										echo '<th><a class="sort-head" href="index.php?sort=brand&order=asc">Item</a></th>';
										echo '<th><a class="sort-head" href="index.php?sort=unit&order=asc">Unit</a></th>';
										echo '<th><a class="sort-head" href="index.php?sort=serial_number&order=asc">Serial Number</a></th>';
										echo '<th><a class="sort-head" href="index.php?sort=purchase_date&order=asc">Purchase Date</a></th>';
										echo '<th><a class="sort-head" href="index.php?sort=manufacturer&order=asc">Manufacturer</a></th>';
										echo '<th><a class="sort-head" href="index.php?sort=set_id&order=asc">Set</a></th>';
										//<!-- <th>Status</th> -->
										
									}
									echo '<th>Edit</th>';
								?>
							</tr>
						</thead>
						<tbody>
							<?php
								#Checks if Item has Filter
								if(isset($_POST['brand'])){
									$brand = $_POST['brand'];
								} else {
									$brand = "";
								}
								#Checks if Item has Filter
								if(isset($_POST['unit'])){
									$unit = $_POST['unit'];
								} else {
									$unit = "";
								}
								#Checks if Item has Filter
								if(isset($_POST['serial_number'])){
									$serial_number = $_POST['serial_number'];
								} else {
									$serial_number = "";
								} 
								#Checks if Item has Filter
								if(isset($_POST['manufacturer'])){
									$manufacturer = $_POST['manufacturer'];
								} else {
									$manufacturer = "";
								}
								if(isset($_POST['purchaseDate'])){
									$purchaseDate = $_POST['purchaseDate'];
								} else {
									$purchaseDate = "";
								}
								#checks if Sort Option is Selected
								if(isset($_GET['sort'])){
									$sort = $_GET['sort'];
								}
								#checks if Filter Option is Selected
								if(isset($_POST['bundle'])){
									$check = $_POST['bundle'];
									if($check != 'all'){
										if(isset($_GET['sort'])){
											$order = $_GET['order'];
											if($serial_number == ""){ //Checks if there is a Serial Number has a Filter
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' ORDER BY $sort $order";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND purchase_date = '$purchaseDate' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' ORDER BY $sort $order";
												}
											} else {
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND serial_number = '$serial_number' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' ORDER BY $sort $order";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND purchase_date = '$purchaseDate' AND serial_number = '$serial_number' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' ORDER BY $sort $order";
												}
											}
										} else {
											if($serial_number == ""){ //Checks if there is a Serial Number has a Filter
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%'";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND purchase_date = '$purchaseDate' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%'";
												}
											} else {
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND serial_number = '$serial_number' AND  brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%'";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND purchase_date = '$purchaseDate' AND serial_number = '$serial_number' AND  brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%'";
												}
											}
										}
										$result = mysqli_query($db, $get_peripherals);
									} else {
										if(isset($_GET['sort'])){
											$order = $_GET['order'];
											if($serial_number == ""){ //Checks if there is a Serial Number has a Filter
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' ORDER BY $sort $order";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE brand LIKE '%$brand%' AND purchase_date = '$purchaseDate' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' ORDER BY $sort $order";
												}
											} else {
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE serial_number = '$serial_number' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' ORDER BY $sort $order";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE serial_number = '$serial_number' AND purchase_date = '$purchaseDate' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' ORDER BY $sort $order";
												}
											}
										} else {
											if($serial_number == ""){ //Checks if there is a Serial Number has a Filter
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%'";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE brand LIKE '%$brand%' AND purchase_date = '$purchaseDate' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%'";
												}
											} else {
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE serial_number = '$serial_number' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%'";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE serial_number = '$serial_number'  AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%'";
												}
											}
										}
										$result = mysqli_query($db, $get_peripherals);
									}
								} else {
									if(isset($_GET['sort'])){
										$order = $_GET['order'];
										$get_peripherals = "SELECT * FROM peripherals ORDER BY $sort $order";
									} else {
										$get_peripherals = "SELECT * FROM peripherals";
									}
									$result = mysqli_query($db, $get_peripherals);
								}

								while ($peripherals = mysqli_fetch_assoc($result)) {
									echo '<tr>';
										echo '<td style="display: none">' . $peripherals['component_id'] . '</td>';
										echo '<td style="display: none">' . $peripherals['set_id'] . '</td>';
										echo '<td>' . $peripherals['brand'] . '</td>';
										echo '<td>' . $peripherals['unit'] . '</td>';
										echo '<td>' . $peripherals['serial_number'] . '</td>';
										echo '<td>' . $peripherals['purchase_date'] . '</td>';
										echo '<td>' . $peripherals['manufacturer'] . '</td>';
									
										$set = $peripherals['set_id'];

										if($set == 0) {
											echo '<td>None</td>';
										} else {
											$get_setID = "SELECT *
											FROM set_bundle 
											WHERE set_id = '$set'";
												
											$result_set = mysqli_query($db, $get_setID);

											if (mysqli_num_rows($result_set) > 0) {
												while ($set = mysqli_fetch_assoc($result_set)) {
													$set = $set['set_name'];
													echo '<td>' . $set . '</td>';
												}
											} else {
												echo '<td>None</td>';
											}                    
										}

										echo '
											<td>
												<a href="" data-bs-toggle="modal" data-bs-target="#deleteItem" class="item">
													<i class="align-middle me-2" data-feather="trash-2"></i>
												</a>
												<a data-bs-toggle="modal" data-bs-target="#editItem" class="item" id="' . $peripherals['component_id'] . '">
													<i class="align-middle" data-feather="settings"></i>
												</a>
											</td>';
									echo '</tr>';
								}
								?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-12 col-lg-4 col-xxl-3 d-flex">
				
				<div class="card flex-fill w-100">
					<div class="card-header d-flex justify-content-between">
						<h5 class="card-title mb-0">Sets</h5>
						<a data-bs-toggle="modal" data-bs-target="#createBundle"><i class="align-middle me-2" data-feather="plus"></i></a>
					</div>
					<table class="table table-hover my-0">
						<thead>
							<tr>
								<th class="col-2">Set</th>
								<!-- <th>Status</th> -->
								<th>Assignee</th>
								<th class>Edit</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$bundles = "SELECT * FROM set_bundle"; 
							$getBundles = mysqli_query($db, $bundles);

							while ($bundle = mysqli_fetch_assoc($getBundles)) {
								$bundleId = $bundle['set_id']; 
								echo '<tr>';
									echo '<td style="display: none">' . $bundleId . '</td>';
									echo '<td>' . $bundle['set_name'] . '</td>'; 

									$bundleAssignments = "SELECT * from employees WHERE set_id = '$bundleId' "; 
									$getBundleAssignments = mysqli_query($db, $bundleAssignments);
									
									if(mysqli_num_rows($getBundleAssignments)){
										while ($employee = mysqli_fetch_assoc($getBundleAssignments)) {
											$employeeId = $employee['id'];
											echo '<td>' . $employee['firstname'] . ' ' . $employee['lastname'] .'</td>';
											echo '<td style="display: none">' . $employeeId  . '</td>';
										}
									} else {
										echo '<td>None</td>';
									}
									
									echo '
									<td>
										<a href="" data-bs-toggle="modal" data-bs-target="#deleteBundle" class="set">
											<i class="align-middle me-2" data-feather="trash-2"></i>
										</a>
										
										<a data-bs-toggle="modal" data-bs-target="#editSet" class="set">
											<i class="align-middle" data-feather="settings"></i>
										</a>
									</td>';
								echo '</tr>';
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>

<style>
	.filter {
		padding: 0 1.25rem;
	}
	.filter-option {
		display: none;
	}
	/*.option-bundle {
		width: 100%;
		display: inline!important;
	}
	.option-bundle .form-select {
		width: fit-content!important;
		display: inline!important;
	}*/
	.sort-head {
		color: #495057;
	}
	.fa.fa-sort-down{
		vertical-align: middle;
		margin-top: -5px;
	}
	.fa.fa-sort-up {
		vertical-align: middle;
		margin-top: 5px;
	}
</style>
<script type="text/javascript">
	function showFilters(){
		document.getElementById("showFilter").style.display = 'none';
		document.getElementById("filter").style.display = 'block';
	}
	function closeFilters(){
		document.getElementById("showFilter").style.display = 'block';
		document.getElementById("filter").style.display = 'none';
	}
</script>