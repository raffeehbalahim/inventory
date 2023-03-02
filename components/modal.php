<!-- Create Bundle -->
<div class="modal fade" id="createBundle" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <form action="lib/create.php" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create set</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input required type="text" class="form-control" placeholder="Set" name="newBundle">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="createBundle">
                </div>
            </form>
		</div>
	</div>
</div>
<!-- Create Item -->
<div class="modal fade" id="createItem" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <form action="lib/create.php" method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Brand" name="brand">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Unit Name" name="unit">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Serial Number" name="serialNumber">
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" name="purchaseDate">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Manufacturer" name="manufacturer">
                        </div>
                        <div class="col">
                            <select class="form-select" name="bundle">
                                <option disabled selected>Set</option>
                                <?php
                                    $bundles = "SELECT * FROM set_bundle"; 
                                    $getBundle = mysqli_query($db, $bundles);
            
                                    while ($bundle = mysqli_fetch_assoc($getBundle)) {
                                        echo '<option value="' . $bundle['set_id'] . '">' . $bundle['set_name'] . '</option>';
                                    }  
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <label for="formFile" class="form-label">Bulk add item</label>
                            <input class="form-control" type="file" id="formFile" name="itemFile">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="createItem">
                </div>
            </form>
		</div>
	</div>
</div>
<!-- Create Employee -->
<div class="modal fade" id="createEmployee" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <form action="lib/create.php" method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="First Name" name="firstname">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Last Name" name="lastname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <select class="form-select mb-3" name="bundle">
                                <option disabled selected>Set</option>
                                <?php
                                    $bundles = "SELECT * FROM set_bundle"; 
                                    $getBundles = mysqli_query($db, $bundles);
            
                                    while ($bundle = mysqli_fetch_assoc($getBundles)) {
                                        $bundleId = $bundle['set_id']; 

                                        $check_set_assigned = "SELECT * FROM employees WHERE set_id = '$bundleId'";
                                        $check_set_assigned_result = mysqli_query($db, $check_set_assigned); 

                                        if (mysqli_num_rows($check_set_assigned_result)){
                                            echo '<option disabled value="' . $bundle['set_id'] . '">' . $bundle['set_name'] . '</option>'; 
                                        } else {
                                            echo '<option value="' . $bundle['set_id'] . '">' . $bundle['set_name'] . '</option>'; 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <label for="formFile" class="form-label">Bulk add employee</label>
                                <input class="form-control" type="file" id="formFile" name="empFile">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="createEmployee">
                </div>
            </form>
		</div>
	</div>
</div>
<!-- Edit Item -->
<div class="modal fade" id="editItem" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <form action="lib/update.php" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="item" id="item">
                    <div class="row mb-3">
                        <div class="col">
                            <input required type="text" class="form-control" placeholder="Brand" name="brand" id="brand">
                        </div>
                        <div class="col">
                            <input required type="text" class="form-control" placeholder="Unit Name" name="unit" id="unit">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input required type="text" class="form-control" placeholder="Serial Number" name="serial" id="serial">
                        </div>
                        <div class="col">
                            <input required type="date" class="form-control" name="purchaseDate" id="purchaseDate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <select required class="form-select" name="set">
                                <!--<option selected id="set"></option> -->
                                <?php

                                    $get_sets = "SELECT * FROM set_bundle";
                                    $result = mysqli_query($db, $get_sets);
            
                                    while ($set = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $set['set_id'] . '">' . $set['set_name'] . '</option>';
                                    }  
                                ?>
                                <option value="0">None</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="editItem" value="Save">
                </div>
            </form>
		</div>
	</div>
</div>
<!-- Edit Set -->
<div class="modal fade" id="editSet" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <form action="lib/update.php" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Set</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="setID" id="setID">
                            <input readonly type="text" class="form-control" name="set" id="set">
                        </div>
                        <div class="col">
                            <input type="hidden" name="currentEmployee" id="empID">
                            <select required class="form-select" name="assignee">
                                <option selected id="currentAssignee" style="display:none;"></option>
                                <?php 
                                
                                $employee = "SELECT * FROM employees ";
                                $getEmployee = mysqli_query($db, $employee);
        
                                while ($employee = mysqli_fetch_assoc($getEmployee)) {
                                    $employeeId = $employee['id'];
                                    
                                    if ($employee['set_id'] != 0) {
                                        echo '<option disabled value="' . $employee['id'] . '">' . $employee['firstname'] . ' ' . $employee['lastname'] . '</option>';
                                    } else {
                                        echo '<option value="' . $employee['id'] . '">' . $employee['firstname'] . ' ' . $employee['lastname'] . '</option>';
                                    }
                                }  
                                ?>
                                <option id="none" style="display:none;" value="0">None</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="editSet" value="Save">
                </div>
            </form>
		</div>
	</div>
</div>
<!-- Edit Employee -->
<div class="modal fade" id="editEmployee" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <form action="lib/update.php" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="employee" id="employee">
                    <div class="row mb-3">
                        <div class="col">
                            <input required type="text" class="form-control" placeholder="Brand" name="firstname" id="firstname">
                        </div>
                        <div class="col">
                            <input required type="text" class="form-control" placeholder="Unit Name" name="lastname" id="lastname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <input type="hidden" name="currentBundle" id="currentBundle">
                            <select required class="form-select" name="set">
                                <option selected id="currentBundle" style="display:none;"></option>
                                <?php
                                    $bundles = "SELECT * FROM set_bundle "; 
                                    $getBundle = mysqli_query($db, $bundles);
            
                                    while ($bundle = mysqli_fetch_assoc($getBundle)) {
                                        $bundleId = $bundle['set_id']; 
    
                                        $bundleAssignments = "SELECT * FROM employees WHERE set_id = '$bundleId'"; 
                                        $getBundleAssignments = mysqli_query($db, $bundleAssignments); 
                                        if(mysqli_num_rows($getBundleAssignments)){
                                            echo '<option disabled value="' . $bundleId . '">' . $bundle['set_name'] . '</option>'; 
                                        } else {
                                            echo '<option value="' . $bundleId . '">' . $bundle['set_name'] . '</option>'; 
                                        }
                                    }
                                ?>
                                <option id="none" style="display:none;" value="0">None</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="editEmployee" value="Save">
                </div>
            </form>
		</div>
	</div>
</div>

<div class="modal fade" id="deleteBundle" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this set?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="set"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="" class="btn btn-danger" id="delete">Delete</a>
            </div>
		</div>
	</div>
</div>

<div class="modal fade" id="deleteItem" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this item?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="item" id="item">
                    <div class="row mb-3">
                        <div class="col">
                            <input disabled type="text" class="form-control" placeholder="Brand" name="brand" id="brand">
                        </div>
                        <div class="col">
                            <input disabled type="text" class="form-control" placeholder="Unit Name" name="unit" id="unit">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input disabled type="text" class="form-control" placeholder="Serial Number" name="serial" id="serial">
                        </div>
                        <div class="col">
                            <input disabled type="date" class="form-control" name="purchaseDate" id="purchaseDate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <input disabled type="text" class="form-control"  name="set" id="set">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="" class="btn btn-danger" id="delete">Delete</a>
                </div>
		</div>
	</div>
</div>

<div class="modal fade" id="deleteEmployee" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this employee?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="employee" id="employee">
                    <div class="row mb-3">
                        <div class="col">
                            <input disabled type="text" class="form-control" placeholder="First Name" name="firstname" id="firstname">
                        </div>
                        <div class="col">
                            <input disabled type="text" class="form-control" placeholder="Last Name" name="lastname" id="lastname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <input disabled type="text" class="form-control"  name="set" id="set">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="" class="btn btn-danger" id="delete">Delete</a>
                </div>
		</div>
	</div>
</div>