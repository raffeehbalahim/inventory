<main class="content">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="container-fluid p-0">
		<h1 class="h3 mb-3"><strong>Dashboard</strong></h1>

		<div class="row">
			<div class="col-12 d-flex">
				<div class="card flex-fill">
					<div class="card-header d-flex justify-content-between">
						<h5 class="card-title mb-0">Peripherals</h5>
						<?php
						if($_SESSION["user_type"] ==2){ //Checks if User is Admin
							echo '<a data-bs-toggle="modal" data-bs-target="#requestItem"><label for="addItem">Request Item: </label><i class="align-middle me-2" data-feather="plus"></i></a>';
						}?>
					</div>
					<div style="display: none!important;" class="card-header d-flex">
						<input id="searchInput" class="employee-form" placeholder="Search" onkeyup="searchItemTable()">
					</div>
					<div class="filter">
					<div class="d-flex justify-content-end">
					<div id="showFilter">
						<label for="inputFirstname">Filter: </label>
						<a onclick="showFilters()"></a>
					</div>
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
										<input type="date" class="form-control" name="purchaseDate">
									</div>
									<div class="col">
										<input type="text" class="form-control" placeholder="Receipt ID" value="" name="receiptId">
									</div>
								</div>		
								<div class="row mb-3">
									<div class="col">
										<input type="text" class="form-control" placeholder="Additional Info" value="" name="Specs">
									</div>
									<?php if($_SESSION["user_type"] == 1){ ?>
									<div class="col">
									<?php }  else {?>
									<div class="col" style="visibility: hidden">
									<?php } ?>
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
					<table id="myTable" style="width: 100%" class="table table-hover my-0">
						<thead>
							<tr>
								<th style="display:none">Component Id</th>
								<th style="display:none">Set Id</th>
								<?php
										echo '<th style="display:none"><a class="sort-head">Item</a></th>';
										echo '<th><a class="sort-head"">Unit</a></th>';
										echo '<th style="display:none"><a class="sort-head">Serial Number</a></th>';
										echo '<th style="display:none"><a class="sort-head">Purchase Date</a></th>';
										echo '<th><a class="sort-head">Item Cost</a></th>';
										echo '<th style="display:none"><a class="sort-head">Manufacturer</a></th>';
										echo '<th style="display:none"><a class="sort-head">Receipt ID</a></th>';
										echo '<th style="display:none"><a class="sort-head">Additional Information</a></th>';
										echo '<th><a class="sort-head">Assignee</a></th>';
										echo '<th><a class="sort-head">Set</a></th>';
										//<!-- <th>Status</th> -->
									if($_SESSION["user_type"] == 1){
										echo '<th id="action" style="text-align: right">Actions</th>';
									} else {
										echo '<th id="action" style="display:none">Actions</th>';
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

								if($_SESSION["user_type"] ==1){
									echo '<tr>';
										//echo '<td style="display: none">' . $peripherals['component_id'] . '</td>';
										echo '<td style="display: none" id="component_id_' . $peripherals['component_id'] . '">' . $peripherals['component_id'] . '</td>';
										echo '<td style="display: none" id="set_id_' . $peripherals['component_id'] . '">' . $peripherals['set_id'] . '</td>';
										echo '<td style="display:none" id="brand_' . $peripherals['component_id'] . '">' . $peripherals['brand'] . '</td>';
										echo '<td id="unit_' . $peripherals['component_id'] . '">' . $peripherals['unit'] . '</td>';
										echo '<td style="display:none" id="serial_number_' . $peripherals['component_id'] . '">' . $peripherals['serial_number'] . '</td>';
										echo '<td style="display:none" id="purchase_date_' . $peripherals['component_id'] . '">' . $peripherals['purchase_date'] . '</td>';
										echo '<td id="price_' . $peripherals['component_id'] . '">' . $peripherals['price'] . '</td>';
										echo '<td style="display:none" id="manufacturer_' . $peripherals['component_id'] . '">' . $peripherals['manufacturer'] . '</td>';
										echo '<td style="display:none" id="receipt_id_' . $peripherals['component_id'] . '">' . $peripherals['receipt_id'] . '</td>';
										echo '<td style="display:none" id="specs_' . $peripherals['component_id'] . '">' . $peripherals['specs'] . '</td>';
										
									
										$set = $peripherals['set_id'];

										$bundleAssignments = "SELECT * from employees WHERE set_id = '$set' "; 
										$getBundleAssignments = mysqli_query($db, $bundleAssignments);
										if($set!= 0){
									
										if(mysqli_num_rows($getBundleAssignments)){
											while ($employee = mysqli_fetch_assoc($getBundleAssignments)) {
												$employeeId = $employee['id'];
												echo '<td>' . $employee['firstname'] . ' ' . $employee['lastname'] .'</td>';
												//echo '<td style="display: none">' . $employeeId  . '</td>';
											}
										} else {
											echo '<td>None</td>';
										}
										} else {
											echo '<td>None</td>';
										}


										if($set == 0) {
											echo '<td><span id="set_text_' . $peripherals['component_id'] . '" class="badge bg-warning my-2">None</span></td>';
										} else {
											$get_setID = "SELECT *
											FROM set_bundle 
											WHERE set_id = '$set'";
												
											$result_set = mysqli_query($db, $get_setID);

											if (mysqli_num_rows($result_set) > 0) {
												while ($set = mysqli_fetch_assoc($result_set)) {
													$set = $set['set_name'];
													if($set == "Archived"){
														echo '<td><span class="badge bg-danger my-2" id="set_text_' . $peripherals['component_id'] . '">' . $set . '</span></td>';
													} else {
														echo '<td><span class="badge bg-success my-2" id="set_text_' . $peripherals['component_id'] . '">' . $set . '</span></td>';
													}
												}
											} else {
												echo '<td><span class="badge bg-warning my-2" id="set_text_' . $peripherals['component_id'] . '">None</span></td>';
											}                    
										}
										if($_SESSION["user_type"] ==1){ // Checks if User is Admin
										echo '
											<td style="text-align: right">
												<a title="View" style="margin-right: 10px" href="peripherals.php?item=row_'. $peripherals['component_id'] .'" id="' . $peripherals['component_id'] . '">
													<i class="align-middle" data-feather="eye" ></i>
												</a>
												<a title="Assign" style="margin-right: 10px" data-bs-toggle="modal" data-bs-target="#assignItem" class="item" onclick="editItems(' . $peripherals['component_id'] . ')">
													<i class="align-middle" data-feather="user-plus"></i>
												</a>
												<a title="Delete" href="" data-bs-toggle="modal" data-bs-target="#deleteItem" class="item delete" onclick="editItems(' . $peripherals['component_id'] . ')">
													<i class="align-middle me-2" data-feather="trash-2"></i>
												</a>
											</td>';
										} else {
											echo '<td style="display:none"></td>';
										}
										echo '</tr>';
								} else {
									$user = $_SESSION['username'];
									$get_empSetID = "SELECT *
											FROM employees 
											WHERE username = '$user'";
												
									$result_set = mysqli_query($db, $get_empSetID);
									if (mysqli_num_rows($result_set) > 0) {
										while ($emp = mysqli_fetch_assoc($result_set)) {
											$employee_set = $emp['set_id'];
										}
									}

									if($peripherals['set_id'] == $employee_set && $peripherals['set_id']!=0){
									echo '<tr>';
										//echo '<td style="display: none">' . $peripherals['component_id'] . '</td>';
										echo '<td style="display: none" id="component_id_' . $peripherals['component_id'] . '">' . $peripherals['component_id'] . '</td>';
										echo '<td style="display: none" id="set_id_' . $peripherals['component_id'] . '">' . $peripherals['set_id'] . '</td>';
										echo '<td style="display:none" id="brand_' . $peripherals['component_id'] . '">' . $peripherals['brand'] . '</td>';
										echo '<td id="unit_' . $peripherals['component_id'] . '">' . $peripherals['unit'] . '</td>';
										echo '<td style="display:none" id="serial_number_' . $peripherals['component_id'] . '">' . $peripherals['serial_number'] . '</td>';
										echo '<td style="display:none" id="purchase_date_' . $peripherals['component_id'] . '">' . $peripherals['purchase_date'] . '</td>';
										echo '<td id="price_' . $peripherals['component_id'] . '">' . $peripherals['price'] . '</td>';
										echo '<td style="display:none" id="manufacturer_' . $peripherals['component_id'] . '">' . $peripherals['manufacturer'] . '</td>';
										echo '<td style="display:none" id="receipt_id_' . $peripherals['component_id'] . '">' . $peripherals['receipt_id'] . '</td>';
										echo '<td style="display:none" id="specs_' . $peripherals['component_id'] . '">' . $peripherals['specs'] . '</td>';
										
									
										$set = $peripherals['set_id'];

										$bundleAssignments = "SELECT * from employees WHERE set_id = '$set' "; 
										$getBundleAssignments = mysqli_query($db, $bundleAssignments);
										if($set!= 0){
									
										if(mysqli_num_rows($getBundleAssignments)){
											while ($employee = mysqli_fetch_assoc($getBundleAssignments)) {
												$employeeId = $employee['id'];
												echo '<td>' . $employee['firstname'] . ' ' . $employee['lastname'] .'</td>';
												//echo '<td style="display: none">' . $employeeId  . '</td>';
											}
										} else {
											echo '<td>None</td>';
										}
										} else {
											echo '<td>None</td>';
										}


										if($set == 0) {
											echo '<td><span id="set_text_' . $peripherals['component_id'] . '" class="badge bg-warning my-2">None</span></td>';
										} else {
											$get_setID = "SELECT *
											FROM set_bundle 
											WHERE set_id = '$set'";
												
											$result_set = mysqli_query($db, $get_setID);

											if (mysqli_num_rows($result_set) > 0) {
												while ($set = mysqli_fetch_assoc($result_set)) {
													$set = $set['set_name'];
													if($set == "Archived"){
														echo '<td><span class="badge bg-danger my-2" id="set_text_' . $peripherals['component_id'] . '">' . $set . '</span></td>';
													} else {
														echo '<td><span class="badge bg-success my-2" id="set_text_' . $peripherals['component_id'] . '">' . $set . '</span></td>';
													}
												}
											} else {
												echo '<td><span class="badge bg-warning my-2" id="set_text_' . $peripherals['component_id'] . '">None</span></td>';
											}                    
										}
										if($_SESSION["user_type"] ==1){ // Checks if User is Admin
										echo '
											<td style="text-align: right">
												<a title="View" style="margin-right: 10px" href="peripherals.php?item=row_'. $peripherals['component_id'] .'" id="' . $peripherals['component_id'] . '">
													<i class="align-middle" data-feather="eye" ></i>
												</a>
												<a title="Assign" style="margin-right: 10px" data-bs-toggle="modal" data-bs-target="#assignItem" class="item" onclick="editItems(' . $peripherals['component_id'] . ')">
													<i class="align-middle" data-feather="user-plus"></i>
												</a>
												<a title="Delete" href="" data-bs-toggle="modal" data-bs-target="#deleteItem" class="item delete" onclick="editItems(' . $peripherals['component_id'] . ')">
													<i class="align-middle me-2" data-feather="trash-2"></i>
												</a>
											</td>';
										} else {
											echo '<td style="display:none"></td>';
										}
										echo '</tr>';
								}
								}
								}
								?>
						</tbody>
					</table>
					<div id="footer" class="dataTables_wrapper">
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<style>
	.search-wrap {
    position: sticky;
    right: 0px;
    background: white;
}
</style>