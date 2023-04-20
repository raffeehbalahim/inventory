<?php
    include '../db/config.php';
    session_start();

    if(isset($_POST['editItem'])){
        $item = $_POST['item'];
        $brand = $_POST['brand'];
        $unit = $_POST['unit'];
        $serial = $_POST['serial'];
        $purchaseDate = $_POST['purchaseDate'];
        $specs = $_POST['specs'];
        $price = $_POST['price'];
        $manufacturer = $_POST['manufacturer'];
        $receiptId = $_POST['receiptId'];
        $set = $_POST['set']; 
        
        # Update item information
        $update_query = "UPDATE peripherals 
            SET brand = '$brand',
                unit = '$unit',
                serial_number = '$serial',
                purchase_date = '$purchaseDate',
                specs = '$specs',
                price = '$price',
                manufacturer = '$manufacturer',
                receipt_id = '$receiptId',
                set_id = '$set'
            WHERE component_id = '$item'";
        mysqli_query($db, $update_query);

        $get_item = "SELECT * FROM peripherals WHERE component_id = '$unit'";
        $result_set = mysqli_query($db, $get_item);

        $user = $_SESSION["username"];
        $description = "Edit the peripheral information of " . $unit . " with a serial number of " . $serial . ".";
        $affected_user = "None";
        $date = date("Y-m-d h:i:sa");
        $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
        mysqli_query($db, $logs);

        header('location: ../index.php');
    } else if(isset($_POST['editSet'])){
        # Edit Set
        $bundleId = $_POST['setID'];
        $currentEmployee = $_POST['currentEmployee'];
        $assignee = $_POST['assignee'];
        $timecreated = time();

        if ($assignee == 0 && $currentEmployee !=0) {
            # If users selects none
            $unsetAssignee = "UPDATE employees SET set_id = 0 WHERE id = '$currentEmployee'"; 
            mysqli_query($db, $unsetAssignee);
            $get_employees = "SELECT * FROM employees WHERE id = '$currentEmployee'";
            $result_set = mysqli_query($db, $get_employees);

            if (mysqli_num_rows($result_set) > 0) {
                while ($employee = mysqli_fetch_assoc($result_set)) {
                    $name = $employee['firstname']." ".$employee['lastname'];
                    $affected_user = $name;
                }
            } else {
                $name = 'NONE';
                $affected_user = $name;
            }
            $user = $_SESSION["username"];
            $description = "Edit Set Assignee to NONE.";
            $date = date("Y-m-d h:i:sa");
            $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
            mysqli_query($db, $logs);
        } else if ($currentEmployee != $assignee){
            if ($currentEmployee != 0) {
                # If users selects new employee
                # Remove the set of the previous employee
                $unsetAssignee = "UPDATE employees SET set_id = 0 WHERE id = '$currentEmployee'"; 
                mysqli_query($db, $unsetAssignee);

                $get_employees = "SELECT * FROM employees WHERE id = '$currentEmployee'";
                $result_set = mysqli_query($db, $get_employees);

                if (mysqli_num_rows($result_set) > 0) {
                    while ($employee = mysqli_fetch_assoc($result_set)) {
                        $name = $employee['firstname']." ".$employee['lastname'];
                        $affected_user = $name;
                    }
                } else {
                    $name = 'NONE';
                    $affected_user = $name;
                }
                $user = $_SESSION["username"];
                $description = "Edit Set Assignee to NONE.";
                $date = date("Y-m-d h:i:sa");
                $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
                mysqli_query($db, $logs);
            }
            # Assign the set into the new employee
            $setAssignee = "UPDATE employees SET set_id = '$bundleId' WHERE id = '$assignee'";
            mysqli_query($db, $setAssignee);
            $get_employees = "SELECT * FROM employees WHERE id = '$assignee'";
            $result_set = mysqli_query($db, $get_employees);

            if (mysqli_num_rows($result_set) > 0) {
                while ($employee = mysqli_fetch_assoc($result_set)) {
                    $name = $employee['firstname']." ".$employee['lastname'];
                    $affected_user = $name;
                }
            } else {
                $name = 'NONE';
                $affected_user = $name;
            }
            $user = $_SESSION["username"];
            $description = "Edit Set Assignee.";
            $date = date("Y-m-d h:i:sa");
            $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
            mysqli_query($db, $logs);
        }
        header('location: ../sets.php');
    } else if (isset($_POST['editEmployee'])) {
        # Edit Employee
        $employee = $_POST['employee'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $currentBundle = $_POST['currentBundle'];
        $newBundle = $_POST['set'];
        $timecreated = time();

        //if ($newBundle == 0 && $currentBundle != 0) {
        //    # If users selects none
        //    $unsetBundle = "DELETE FROM bundle_assignments WHERE bundle_id = '$currentBundle'";
        //    mysqli_query($db, $unsetBundle);
        //} else if($newBundle != $currentBundle){
        //    if ($currentBundle != 0) {
        //        # If users selects new bundle
        //        $unsetBundle = "DELETE FROM bundle_assignments WHERE bundle_id = '$currentBundle'";
        //        mysqli_query($db, $unsetBundle);
        //    }
        //    $setBundle = "INSERT INTO bundle_assignments (bundle_id, employee_id, timecreated)
        //        VALUES ('$newBundle', '$employee', '$timecreated')";
        //    mysqli_query($db, $setBundle);
        //}
        
        # Update the employees information
        $updateEmployee = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', set_id = '$newBundle' WHERE id = '$employee'";
        mysqli_query($db, $updateEmployee);
        $user = $_SESSION["username"];
        $affected_user = $firstname." ".$lastname;
        $description = "Edit employee information.";
        $date = date("Y-m-d h:i:sa");
        $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
        mysqli_query($db, $logs);

        header('location: ../employee.php');
    } else if(isset($_POST['submitAssignItem'])){
        $item = $_POST['item'];
        $set = $_POST['set']; 
        
        # Update item information
        $update_setItem = "UPDATE peripherals 
            SET set_id = '$set'
            WHERE component_id = '$item'";
        mysqli_query($db, $update_setItem);

        $get_item = "SELECT * FROM peripherals WHERE component_id = '$item'";
        $result_set = mysqli_query($db, $get_item);

        if (mysqli_num_rows($result_set) > 0) {
            while ($peripheral = mysqli_fetch_assoc($result_set)) {
                $item_name = $peripheral['unit'];
                $item_serial = $peripheral['serial_number'];
            }
        } else {
            $item_name = 'NONE';
            $item_serial = 'NONE';
        }
        $user = $_SESSION["username"];
        $description = "Assign/Edit the set of peripheral " . $item_name . " with a serial number of " . $item_serial . ".";
        $affected_user = "None";
        $date = date("Y-m-d h:i:sa");
        $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
        mysqli_query($db, $logs);
        header('location: ../index.php');
    } else if(isset($_POST['submitProfile'])){
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName']; 
        $username = $_SESSION["username"];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        # Update item information
        $update_employeeInfo= "UPDATE employees 
            SET firstname = '$fname', lastname = '$lname'
            WHERE username = '$username'";
        mysqli_query($db, $update_employeeInfo);
        $update_employeeCreds= "UPDATE users 
            SET `password` = '$pass'
            WHERE username = '$username'";
        mysqli_query($db, $update_employeeCreds);

        $user = $fname." ".$lname;
        $description = "Edit Profile Information.";
        $affected_user = $user;
        $date = date("Y-m-d h:i:sa");
        $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
        mysqli_query($db, $logs);
        header('location: ../profile.php');
    }

?>