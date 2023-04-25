<main class="content">
	<div class="container-fluid p-0">
		<div class="d-flex justify-content-between">
			<h1 class="h3 mb-3"><strong>Request Logs</strong></h1>
			<?php if($_SESSION["user_type"] ==2){ //Checks if User is Admin ?>
				<button class="btn btn-primary mb-3"><a data-bs-toggle="modal" data-bs-target="#requestItem"><i class="align-middle me-2" data-feather="plus"></i><label for="addItem">Request Item</label></a></button>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-12 d-flex">
				<div class="card flex-fill">
					<div class="card-header d-flex justify-content-end">
					</div>
					<table id="requestTable" style="width: 100%" class="table table-hover my-0">
						<thead>
							<tr>
								<th>Item Request</th>
								<th>Requestor</th>
                                <th>Date</th>
                                <th>Status</th>
								<?php if($_SESSION["user_type"] ==1){ //Checks if User is Admin ?>
								<th id="action" style="text-align: right">Actions</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php
								if($_SESSION["user_type"] ==1){
									$requests = "SELECT * FROM requests";
								} else {
									$user_id = $_SESSION["id"];
									$requests = "SELECT * FROM requests WHERE userid = '$user_id'";
								}
								$getRequests = mysqli_query($db, $requests);
								while ($request = mysqli_fetch_assoc($getRequests)) {
									echo '<tr>';
									$itemid = $request['itemid'];
                                    $userid = $request['userid'];
                                    $items = "SELECT * FROM peripherals WHERE component_id = '$itemid'";
                                    $getItem = mysqli_query($db, $items);
								    while ($item = mysqli_fetch_assoc($getItem)) {
                                        $item_name = $item['brand']." - ".$item['unit'];
                                    }
                                    echo '<td>' . $item_name . '</td>';
                                    $users = "SELECT * FROM users WHERE id = '$userid'";
                                    $getUser = mysqli_query($db, $users);
                                    while ($user = mysqli_fetch_assoc($getUser)) {
                                        $username = $user['username'];
                                    }
                                    $employees = "SELECT * FROM employees WHERE username = '$username'";
                                    $getEmployee = mysqli_query($db, $employees);
                                    while ($employee = mysqli_fetch_assoc($getEmployee)) {
                                        $emp_name = $employee['firstname']." ".$employee['lastname'];
                                    }
									echo '<td>' . $emp_name . '</td>';
                                    echo '<td>' . $request['date'] . '</td>';
                                    if($request['status'] == 0){
                                        echo '<td>Pending</td>';
                                    } else if($request['status'] == 1) {
                                        echo '<td>Approved</td>';
                                    } else if($request['status'] == 2) {
                                        echo '<td>Declined</td>';
                                    }
									if($_SESSION["user_type"] ==1){ //Checks if User is Admin
									echo '
											<td style="text-align: right">
                                                <a title="Approve" href="lib/update.php?approve=' . $itemid . '">
                                                    <i class="align-middle me-2" data-feather="check"></i>
                                                </a>
												<a title="Decline" href="lib/update.php?decline=' . $itemid . '">
													<i class="align-middle me-2" data-feather="x"></i>
												</a>
											</td>';
									} 
									echo '</tr>';
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