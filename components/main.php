<main class="content">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>Dashboard</strong></h1>

		<div class="row">
			<div class="col-12 col-lg-8 col-xxl-9 d-flex">
				<div class="card flex-fill">
					<div class="card-header d-flex justify-content-between">
						<h5 class="card-title mb-0">Peripherals</h5>
						<?php
						if($_SESSION["user_type"] ==1){ //Checks if User is Admin
							echo '<a data-bs-toggle="modal" data-bs-target="#createItem"><label for="addItem">Add Item: </label><i class="align-middle me-2" data-feather="plus"></i></a>';
						}?>
					</div>
					<div style="display: none!important;" class="card-header d-flex">
						<input id="searchInput" class="employee-form" placeholder="Search" onkeyup="searchItemTable()">
					</div>
					<div class="filter">
					<div id="showFilter">
						<label for="inputFirstname">Filter: </label>
						<button class="btn btn-primary" onclick="showFilters()">Show More</button>
					</div>
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
										<input type="number" class="form-control" placeholder="Specs" value="" name="Specs">
									</div>
									<div class="col">
										<input type="text" class="form-control" placeholder="Receipt ID" value="" name="receiptId">
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
						<button type="submit" class="btn btn-primary" style="float:right" name="submit">Add Filter</button>
					</form>
					</div>
					</div>
					<table id="myTable" class="table table-hover my-0">
						<thead>
							<tr>
								<th style="display:none">Component Id</th>
								<th style="display:none">Set Id</th>
								<?php
										echo '<th><a class="sort-head">Item</a></th>';
										echo '<th><a class="sort-head"">Unit</a></th>';
										echo '<th><a class="sort-head">Serial Number</a></th>';
										echo '<th><a class="sort-head">Purchase Date</a></th>';
										echo '<th><a class="sort-head">Item Cost</a></th>';
										echo '<th><a class="sort-head">Manufacturer</a></th>';
										echo '<th><a class="sort-head">Receipt ID</a></th>';
										echo '<th><a class="sort-head">Additional Information</a></th>';
										echo '<th><a class="sort-head">Set</a></th>';
										//<!-- <th>Status</th> -->
									if($_SESSION["user_type"] == 1){
										echo '<th>Actions</th>';
									}
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
								if(isset($_POST['specs'])){
									$specs = $_POST['specs'];
								} else {
									$specs = "";
								}
								if(isset($_POST['receiptId'])){
									$receiptId = $_POST['receiptId'];
								} else {
									$receiptId = "";
								}
								#checks if Sort Option is Selected
								if(isset($_GET['sort'])){
									$sort = $_GET['sort'];
								}
								#checks if Filter Option is Selected
								if(isset($_POST['bundle'])){
									$check = $_POST['bundle'];
									if($check != 'all'){
											if($serial_number == ""){ //Checks if there is a Serial Number has a Filter
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' AND receipt_id LIKE '%$receiptId%'";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND purchase_date = '$purchaseDate' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' AND receipt_id LIKE '%$receiptId%'";
												}
											} else {
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND serial_number = '$serial_number' AND  brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' AND receipt_id LIKE '%$receiptId%'";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE set_id = '$check' AND purchase_date = '$purchaseDate' AND serial_number = '$serial_number' AND  brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' AND receipt_id LIKE '%$receiptId%'";
												}
											}
										$result = mysqli_query($db, $get_peripherals);
									} else {
											if($serial_number == ""){ //Checks if there is a Serial Number has a Filter
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' AND receipt_id LIKE '%$receiptId%'";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE brand LIKE '%$brand%' AND purchase_date = '$purchaseDate' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' AND receipt_id LIKE '%$receiptId%'";
												}
											} else {
												if($purchaseDate == ""){
													$get_peripherals = "SELECT * FROM peripherals WHERE serial_number = '$serial_number' AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' AND receipt_id LIKE '%$receiptId%'";
												} else {
													$get_peripherals = "SELECT * FROM peripherals WHERE serial_number = '$serial_number'  AND brand LIKE '%$brand%' AND unit LIKE '%$unit%' AND manufacturer LIKE '%$manufacturer%' AND receipt_id LIKE '%$receiptId%'";
												}
											}
										$result = mysqli_query($db, $get_peripherals);
									}
								} else {
									$get_peripherals = "SELECT * FROM peripherals";
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
										echo '<td>' . $peripherals['price'] . '</td>';
										echo '<td>' . $peripherals['manufacturer'] . '</td>';
										echo '<td>' . $peripherals['receipt_id'] . '</td>';
										echo '<td>' . $peripherals['specs'] . '</td>';
									
										$set = $peripherals['set_id'];

										if($set == 0) {
											echo '<td><span class="unassigned">None</span></td>';
										} else {
											$get_setID = "SELECT *
											FROM set_bundle 
											WHERE set_id = '$set'";
												
											$result_set = mysqli_query($db, $get_setID);

											if (mysqli_num_rows($result_set) > 0) {
												while ($set = mysqli_fetch_assoc($result_set)) {
													$set = $set['set_name'];
													if($set == "Archived"){
														echo '<td><span class="archived">' . $set . '</span></td>';
													} else {
														echo '<td><span class="assigned">' . $set . '</span></td>';
													}
												}
											} else {
												echo '<td><span class="unassigned">None</span></td>';
											}                    
										}
										if($_SESSION["user_type"] ==1){ // Checks if User is Admin
										echo '
											<td>
												<a data-bs-toggle="modal" data-bs-target="#editItem" class="item" id="' . $peripherals['component_id'] . '">
													<i class="align-middle" data-feather="edit-2"></i>
												</a>
												<a href="" data-bs-toggle="modal" data-bs-target="#deleteItem" class="item">
													<i class="align-middle me-2" data-feather="trash-2"></i>
												</a>
											</td>';
									echo '</tr>';
										}
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
						<?php
						if($_SESSION["user_type"] ==1){
							echo '<a data-bs-toggle="modal" data-bs-target="#createBundle"><label for="addSet">Add Set: </label><i class="align-middle me-2" data-feather="plus"></i></a>';
						} ?>
					</div>
					<div id="setTable">
					<table class="table table-hover my-0">
						<thead>
							<tr>
								<th class="col-2">Set</th>
								<!-- <th>Status</th> -->
								<th>Assignee</th>
								<!-- Total Price Header -->
								<th>Total Cost</th>
								<!-- ------------------ -->
								<?php
								if($_SESSION["user_type"] ==1){
									echo '<th class>Actions</th>';
								} ?>
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
									#Total Price
									$total = "SELECT SUM(price) as price from peripherals WHERE set_id = '$bundleId' "; 
									$getTotal = mysqli_query($db, $total);
									$totals =mysqli_fetch_assoc($getTotal);
									if($totals['price'] == ""){
										$totals['price'] = 0;
									}
									echo '<td>' . $totals['price']  . '</td>';
									#Total Price End Here
									
									if($_SESSION["user_type"] ==1){
									echo '
									<td>
										<a data-bs-toggle="modal" data-bs-target="#editSet" class="set">
											<i class="align-middle" data-feather="edit-2"></i>
										</a>
										<a href="" data-bs-toggle="modal" data-bs-target="#deleteBundle" class="set">
											<i class="align-middle me-2" data-feather="trash-2"></i>
										</a>
									</td>';
								echo '</tr>';
									}
							}
						?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>