<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3"><strong>Dashboard</strong></h1>

		<div class="row">
			<div class="col-12 col-lg-8 col-xxl-9 d-flex">
				<div class="card flex-fill">
					<div class="card-header d-flex justify-content-between">
						<h5 class="card-title mb-0">Peripherals</h5>
						<a data-bs-toggle="modal" data-bs-target="#createItem"><i class="align-middle me-2" data-feather="plus"></i></a>
					</div>
					<table class="table table-hover my-0">
						<thead>
							<tr>
								<th>Item</th>
								<th>Unit</th>
								<th>Serial Number</th>
								<th>Purchase Date</th>
								<th>Manufacturer</th>
								<th>Set</th>
								<!-- <th>Status</th> -->
								<th>Edit</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$get_peripherals = "SELECT * FROM peripherals";
								$result = mysqli_query($db, $get_peripherals);

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