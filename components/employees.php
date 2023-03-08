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
						<!--<form action="employee.php" method="post" autocomplete="off">-->
							<input type="text" id="searchInput" onkeyup="searchTable()" class="employee-form" placeholder="Search Employee" value="<?php echo $employee; ?>" name="employee">
						<!--	<button type="submit" class="btn btn-primary" name="submit">Search</button>
						</form> -->
						</div>
						<a data-bs-toggle="modal" data-bs-target="#createEmployee"><i class="align-middle me-2" data-feather="plus"></i></a>
					</div>
					<table id="myTable" class="table table-hover my-0">
						<thead>
							<tr>
								<th>First Name</th>
                                <th>Last Name</th>
								<th>Set</th>
								<th>Edit</th>
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
										echo '<td style="display: none">' . $employeeId . '</td>';
										echo '<td>' . $employee['firstname'] . '</td>';
										echo '<td>' . $employee['lastname'] . '</td>';
										
										$checkAssignments = "SELECT * FROM set_bundle WHERE set_id = '$employee[set_id]'"; 
										$checkingAssignments = mysqli_query($db, $checkAssignments);
										$bundle = mysqli_fetch_assoc($checkingAssignments);

										if (mysqli_num_rows($checkingAssignments)) {
											echo '<td style="display: none">' . $bundle['set_id'] . '</td>';
											echo '<td>'. $bundle['set_name'] .'</td>';
										} else {
											echo '<td>None</td>';
										}
										
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
								?>
						</tbody>
					</table>
				</div>
			</div>			
		</div>
	</div>
</main>
<style>
	.employee-form {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-clip: padding-box;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: .2rem;
    color: #495057;
    font-size: .875rem;
    font-weight: 400;
    line-height: 1.5;
    padding: .3rem .85rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
</style>
<script>
	function searchTable() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1]; // Change the index to the column you want to search
	  td2 = tr[i].getElementsByTagName("td")[2];
      if (td) {
        txtValue = (td.textContent + td2.textContent) || (td.innerText + td2.innerText);
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
</script>