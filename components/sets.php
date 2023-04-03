<main class="content">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="container-fluid p-0">
		<div class="d-flex justify-content-between">
			<h1 class="h3 mb-3"><strong>Sets</strong></h1>
			<button class="btn btn-primary mb-3"><a data-bs-toggle="modal" data-bs-target="#createBundle"><i class="align-middle me-2" data-feather="plus"></i><label for="addSet">Add Set</label></a></button>
		</div>

		<div class="row">
			<div class="col-12 d-flex">
				
				<div class="card flex-fill w-100">
					<div class="card-header d-flex justify-content-between">
						<!--
						<h5 class="card-title mb-0">Sets</h5>
						<?php
						if($_SESSION["user_type"] ==1){
							echo '<a data-bs-toggle="modal" data-bs-target="#createBundle"><label for="addSet">Add Set: </label><i class="align-middle me-2" data-feather="plus"></i></a>';
						} ?>-->
					</div>
					<div id="setTable">
					<table id="setsTable" style="width: 100%" class="table table-hover my-0">
						<thead>
							<tr><th style="display:none" class="col-2">id</th>
								<th class="col-2">Set</th>
								<!-- <th>Status</th> -->
								<th>Assignee</th>
								<!-- Total Price Header -->
								<th>Total Cost</th>
								<th style="display: none;">unit</th>
								<th style="display: none;">serial number</th>
								<th style="display: none;">receipt id</th>
								<th style="display: none;">purchase date</th>
								<th style="display: none;">view</th>
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
											//echo '<td style="display: none">' . $employeeId  . '</td>';
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
									$peripherals = "SELECT * from peripherals WHERE set_id = '$bundleId' ";
									$getPeripherals = mysqli_query($db, $peripherals);
									$receipt ='';
									$unit ='';
									$serial ='';
									$item ='';
									$purchase_date ='';
									$actions = '';
									$view = '';
									$i = 0;
									if(mysqli_num_rows($getPeripherals)){
										while ($peripheral = mysqli_fetch_assoc($getPeripherals)) {
											$i++;
											$receipt = $receipt . $peripheral['receipt_id']. "<br><br>";
											$unit = $unit . $peripheral['unit']. "<br><br>";
											$serial = $serial . $peripheral['serial_number']. "<br><br>";
											$purchase_date = $purchase_date . $peripheral['purchase_date']. "<br><br>";
											$actions = $actions . '<a href="peripherals.php?item=row_'. $peripheral['component_id'] .'"><i class="align-middle" data-feather="eye"></i></a><br><br>';
											$item = $item . "<tr><td>" . $peripheral['unit'] . "</td><td>" . $peripheral['serial_number'] . "</td><td>" . $peripheral['receipt_id'] . "</td><td>" . $peripheral['purchase_date'] . "</td></tr>";
										}
										echo '<td style="display: none">' . $unit . '</td>';
										echo '<td style="display: none">' . $serial . '</td>';
										echo '<td style="display: none">' . $receipt . '</td>';
										echo '<td style="display: none">' . $purchase_date . '</td>';
										echo '<td style="display: none">' . $actions . '</td>';
										//echo '<td style="display: none" value="'.$item.'"></td>';
									} 
									else {
										echo '<td style="display: none">None</td>';
										echo '<td style="display: none"></td>';
										echo '<td style="display: none"></td>';
										echo '<td style="display: none"></td>';
										echo '<td style="display: none"></td>';
									}
									#Total Price End Here
									
									if($_SESSION["user_type"] ==1){
									echo '
									<td >
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

