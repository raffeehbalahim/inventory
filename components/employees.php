<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3"><strong>Employees</strong></h1>

		<div class="row">
			<div class="col-12 d-flex">
				<div class="card flex-fill">
					<div class="card-header d-flex justify-content-between">
						<div style="display: inline;">
						<?php
							$employee = "";
							if(isset($_POST['employee'])){
								$employee = $_POST['employee'];
							}
						?>
						</div>
						<?php
						if($_SESSION["user_type"] ==1){ //Checks if User is Admin
							echo '<a data-bs-toggle="modal" data-bs-target="#createEmployee"><label for="addEmployee">Add Employee: </label><i class="align-middle me-2" data-feather="plus"></i></a>';
						} ?>
					</div>
					<div id="employeeTable">
					<table id="employeeTables" class="table table-hover my-0">
						<thead>
							<tr>
								<th>First Name</th>
                                <th>Last Name</th>
								<th>Set</th>
								<?php
								if($_SESSION["user_type"] ==1){ //Checks if User is Admin
									echo '<th>Action</th>';
								} ?>
							</tr>
						</thead>
						<tbody>
							<?php
								if($employee == ""){
									$employees = "SELECT * FROM employees";
								}
								else {
									$employees = "SELECT * FROM employees WHERE firstname LIKE '%$employee%' OR lastname LIKE '%$employee%' OR CONCAT_WS(' ',firstname,lastname) LIKE '%$employee%'";
								}
								$getEmployees = mysqli_query($db, $employees);

								while ($employee = mysqli_fetch_assoc($getEmployees)) {
									$employeeId = $employee['id'];
                                    // $setID = $employees['set_id'];
									echo '<tr>';
										//echo '<td style="display: none">' . $employeeId . '</td>';
										echo '<td>' . $employee['firstname'] . '</td>';
										echo '<td>' . $employee['lastname'] . '</td>';
										
										$checkAssignments = "SELECT * FROM set_bundle WHERE set_id = '$employee[set_id]'"; 
										$checkingAssignments = mysqli_query($db, $checkAssignments);
										$bundle = mysqli_fetch_assoc($checkingAssignments);

										if (mysqli_num_rows($checkingAssignments)) {
											//echo '<td style="display: none">' . $bundle['set_id'] . '</td>';
											echo '<td>'. $bundle['set_name'] .'</td>';
										} else {
											echo '<td>None</td>';
										}
										if($_SESSION["user_type"] ==1){ //Checks if User is Admin
										echo '
											<td>
												<a data-bs-toggle="modal" data-bs-target="#editEmployee" class="employee">
													<i class="align-middle" data-feather="edit-2"></i>
												</a>
												<a href="" data-bs-toggle="modal" data-bs-target="#deleteEmployee" class="employee">
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