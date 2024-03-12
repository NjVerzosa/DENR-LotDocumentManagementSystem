<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission
    $id = $_POST["id"];
    $date_filed = $_POST["date_filed"];
    $applicant_name = $_POST["applicant_name"];
    $remarks = $_POST["remarks"];

    // Insert the new subdivided record into subdivided_titles table
    $insert_sql = "INSERT INTO subdivided_titles (lot_number, date_filed, applicant_name, location, remarks, subdivided_to)
            SELECT lot_number, '$date_filed', '$applicant_name', location, '$remarks', $id
            FROM subdivided_titles
            WHERE id = $id";

    if (mysqli_query($conn, $insert_sql)) {
        // Update the isSubdivide column in the subtitles table to 1
        $update_sql = "UPDATE land_titled SET status = 1 WHERE id = $id";
        if (mysqli_query($conn, $update_sql)) {
            echo 'Very Good';
        } else {
            echo 'Bad';
        }
    }
}