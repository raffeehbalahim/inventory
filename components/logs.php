<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3"><strong>Logs</strong></h1>

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
								<th>User</th>
								<th>Description</th>
								<th>Affected User</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$logs = "SELECT * FROM logs";
								$getLogs = mysqli_query($db, $logs);
								while ($log = mysqli_fetch_assoc($getLogs)) {
									$name = $log['user'];
									echo '<tr>';
									echo '<td>' . $name . '</td>';
									echo '<td>' . $log['description'] . '</td>';
									echo '<td>' . $log['affected_user'] . '</td>';
									echo '<td>' . $log['date'] . '</td>';
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