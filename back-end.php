<?php
session_start();
include 'config.php';

if (isset($_POST['ADD'])) {
    $lot_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['lot_number'])));
    $date_filed = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['date_filed'])));
    $applicant_name = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['applicant_name'])));
    $location = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['location'])));
    $remarks = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['remarks'])));

    $position = '';
    $status = 0;

    $stmt_insert = mysqli_prepare($conn, "INSERT INTO land_titles (lot_number, date_filed, applicant_name, location, remarks, position, status) VALUES (?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt_insert, "sssssss", $lot_number, $date_filed, $applicant_name, $location, $remarks, $position, $status);
    if (mysqli_stmt_execute($stmt_insert)) {
        echo '<script>alert("Lot Added");</script>';
    } else {
        echo '<script>alert("Please try again");</script>';
    }



}


if (isset($_POST['ADD'])) {
    $date_filed = $_POST["date_filed"];
    $applicant_name = $_POST["applicant_name"];
    $remarks = $_POST["remarks"];

    // Check if there is a record in subdivided_titles with the same land_title_id
    $check_sql = "SELECT position FROM subdivided_titles WHERE land_title_id = $id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // If a record exists, use the position from the subdivided_titles table
        $check_row = mysqli_fetch_assoc($check_result);
        $new_position = $check_row["position"] + 1;
    } else {
        // If no record exists, use the position from the land_titles table
        $get_position_sql = "SELECT position FROM land_titles WHERE id = $id";
        $get_position_result = mysqli_query($conn, $get_position_sql);
        $get_position_row = mysqli_fetch_assoc($get_position_result);
        $new_position = intval($get_position_row["position"]) + 1;
    }

    // Insert the new subdivided record into subdivided_titles table
    $insert_sql = "INSERT INTO subdivided_titles (lot_number, date_filed, applicant_name, location, remarks, position, land_title_id)
            SELECT lot_number, '$date_filed', '$applicant_name', location, '$remarks', $new_position, $id
            FROM land_titles
            WHERE id = $id";



    if (mysqli_query($conn, $insert_sql)) {
        // Update the isSubdivide column in the land_titles table to 1
        $update_sql = "UPDATE land_titles SET status = 1 WHERE id = $id";
        if (mysqli_query($conn, $update_sql)) {
            echo "Record subdivided successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
        // Redirect to index.php after successful insertion and update
        header("Location: history.php?id=$id");
        exit;
    } else {
        echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
    exit;
}

// If the form is not submitted, show the form
$id = $_GET["id"];

// Get the current record details
$sql = "SELECT * FROM land_titles WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>