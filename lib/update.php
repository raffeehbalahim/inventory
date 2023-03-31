<?php
    include '../db/config.php';

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
        } else if ($currentEmployee != $assignee){
            if ($currentEmployee != 0) {
                # If users selects new employee
                # Remove the set of the previous employee
                $unsetAssignee = "UPDATE employees SET set_id = 0 WHERE id = '$currentEmployee'"; 
                mysqli_query($db, $unsetAssignee);
            }
            # Assign the set into the new employee
            $setAssignee = "UPDATE employees SET set_id = '$bundleId' WHERE id = '$assignee'";
            mysqli_query($db, $setAssignee);
        }
        header('location: ../index.php');
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

        header('location: ../employee.php');
    } else if(isset($_POST['submitAssignItem'])){
        $item = $_POST['item'];
        $set = $_POST['set']; 
        
        # Update item information
        $update_setItem = "UPDATE peripherals 
            SET set_id = '$set'
            WHERE component_id = '$item'";
        mysqli_query($db, $update_setItem);
        header('location: ../index.php');
    }
    
?>