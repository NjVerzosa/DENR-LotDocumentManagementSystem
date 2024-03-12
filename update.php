<?php
session_start();
include 'config.php';

if (isset($_POST['update_main'])) {
    $id = $_POST['id'];
    $lot_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['lot_number'])));
    $application_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['application_number'])));
    $date_filed = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['date_filed'])));
    $applicant_name = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['applicant_name'])));
    $area = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['area'])));
    $location = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['location'])));
    $remarks = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['remarks'])));
    $status = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['status'])));
    $approved_date = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['approved_date'])));

    $update_query = "UPDATE land_titles SET lot_number='$lot_number', application_number='$application_number', date_filed='$date_filed', ";
    $update_query .= "applicant_name='$applicant_name', area='$area', location='$location', remarks='$remarks', ";
    $update_query .= "status='$status', approved_date='$approved_date' WHERE id='$id'";

    $stmt_update = mysqli_query($conn, $update_query);

    if ($stmt_update) {
        header('location: index.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

/*
For Subdivider
 */ 

 if (isset($_POST['update_sub'])) {
    $id = $_POST['id'];
    $lot_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['lot_number'])));
    $application_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['application_number'])));
    $date_filed = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['date_filed'])));
    $applicant_name = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['applicant_name'])));
    $area = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['area'])));
    $location = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['location'])));
    $remarks = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['remarks'])));
    $status = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['status'])));

    $stmt_update = mysqli_prepare($conn, "UPDATE land_titles SET lot_number=?, application_number=?, date_filed=?, applicant_name=?, area=?, location=?, remarks=?, status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt_update, "isssssssi", $lot_number, $application_number, $date_filed, $applicant_name, $area, $location, $remarks, $status, $id);

    if (mysqli_stmt_execute($stmt_update)) {
        header('location: index.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Form submission failed.";
}
