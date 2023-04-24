<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3"><strong>Request Logs</strong></h1>

		<div class="row">
			<div class="col-12 d-flex">
				<div class="card flex-fill">
					<div class="card-header d-flex justify-content-end">
						<?php
						if($_SESSION["user_type"] ==1){ //Checks if User is Admin
							echo '<a data-bs-toggle="modal" data-bs-target="#addFile"><i class="align-middle me-2" data-feather="plus"></i></a>';
						}?>
					</div>
					<table id="fileTable" style="width: 100%" class="table table-hover my-0">
						<thead>
							<tr>
								<th>Item Request</th>
								<th>Requestor</th>
                                <th>Date</th>
                                <th>Status</th>
								<th id="action">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$requests = "SELECT * FROM requests";
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
                                    } else {
                                        echo '<td>Approved</td>';
                                    }
									if($_SESSION["user_type"] ==1){ //Checks if User is Admin
									echo '
											<td>
                                                <a title="Delete" href="">
                                                    <i class="align-middle me-2" data-feather="check"></i>
                                                </a>
												<a title="Delete" href="">
													<i class="align-middle me-2" data-feather="trash-2"></i>
												</a>
											</td>';
									} else {
										echo '
											<td>
												<a title="Download" href="uploads/'.$name.' " download>
													<i class="align-middle" data-feather="download"></i>
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