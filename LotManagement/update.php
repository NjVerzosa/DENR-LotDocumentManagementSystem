<?php
session_start();
include 'config.php';

if (isset($_POST['submit'])) {
    // Get form data
    $id = $_POST['id'];
    $lot_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['lot_number'])));
    $application_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['application_number'])));
    $date_filed = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['date_filed'])));
    $applicant_name = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['applicant_name'])));
    $area = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['area'])));
    $location = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['location'])));
    $remarks = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['remarks'])));
    $status = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['status'])));

    // Dump all the data being updated
    echo "Data being updated:<br>";
    echo "ID: $id<br>";
    echo "Lot Number: $lot_number<br>";
    echo "Application Number: $application_number<br>";
    echo "Date Filed: $date_filed<br>";
    echo "Applicant Name: $applicant_name<br>";
    echo "Area: $area<br>";
    echo "Location: $location<br>";
    echo "Remarks: $remarks<br>";
    echo "Status: $status<br>";

    // Prepare and execute update query
    $stmt_update = mysqli_prepare($conn, "UPDATE land_titles SET lot_number=?, application_number=?, date_filed=?, applicant_name=?, area=?, location=?, remarks=?, status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt_update, "isssssssi", $lot_number, $application_number, $date_filed, $applicant_name, $area, $location, $remarks, $status, $id);

    if (mysqli_stmt_execute($stmt_update)) {
        // Redirect to index page on successful update
        header('location: index.php');
        exit();
    } else {
        // Display error message if update fails
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Display error message if form submission failed
    echo "Form submission failed.";
}
?>
