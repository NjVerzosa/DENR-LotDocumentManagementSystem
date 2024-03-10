<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission
    $id = $_POST["id"];
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
        header("Location: records.php?id=$id");
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DENR Lots Doc</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <img src="assets/logo.png" alt="Logo" class="header-logo">
            <a class="navbar-brand" href="#"> DENR CENRO Lot Document Management System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Main</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Card with Form -->
    <div class="container mt-4" style="width:50%;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add Lot</h5>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="form-group">
                        <label for="lotNumber">Date Filed:</label>
                        <input type="date" class="form-control" id="lotNumber" name="date_filed" required>
                    </div>
                    <div class="form-group">
                        <label for="lotNumber">Applicant Name:</label>
                        <input type="" class="form-control" id="lotNumber" name="applicant_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and other scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>