<?php
session_start();
include 'config.php';

if (isset($_POST['submit'])) {
    $lot_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['lot_number'])));
    $application_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['application_number'])));
    $date_filed = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['date_filed'])));
    $applicant_name = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['applicant_name'])));
    $area = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['area'])));
    $location = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['location'])));
    $approved_date = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['approved_date'])));
    $remarks = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['remarks'])));
    $status = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['status'])));

    $stmt_insert = mysqli_prepare($conn, "INSERT INTO land_titles (lot_number, application_number, date_filed, applicant_name, area, location, approved_date, remarks, status) VALUES (?,?,?,?,?,?,?,?,?)");
    
    if (!$stmt_insert) {
        die('Error in preparing the statement: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_insert, "sssssssss", $lot_number, $application_number, $date_filed, $applicant_name, $area, $location, $approved_date, $remarks, $status);

    if (mysqli_stmt_execute($stmt_insert)) {
        mysqli_stmt_close($stmt_insert);
        header('location: index.php');
        exit();
    } else {
        $error_message = mysqli_error($conn);
        mysqli_stmt_close($stmt_insert);
        header('location: add-lot.php?error=' . urlencode($error_message));
        exit();
    }
}
