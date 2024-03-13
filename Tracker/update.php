<?php
include "config.php";

// Initialize variables with empty values
$category = "";
$cadastral = "";
$case = "";
$location = "";
$range = "";
$no_records = "";

// Check if ID parameter is present in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the record from the database
    $sql = "SELECT * FROM boxes WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $category = $row['category'];
                $cadastral = $row['cadastral'];
                $case = $row['case_number'];
                $location = $row['location'];
                $location = explode(", ", $row['location']);

                $range = $row['range_val'];
                $no_records = $row['no_records'];
            } else {
                echo "No record found with ID: " . $id;
                exit();
            }
        } else {
            echo "Error retrieving record: " . mysqli_error($conn);
            exit();
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "ID parameter is missing.";
    exit();
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $category = $_POST["category"];
    $cadastral = $_POST["cadastral"];
    $case = $_POST["case"];
    $location = $_POST["rack"] . ", " . $_POST["layer"] . ", " . $_POST["box"];
    $range = $_POST["range"];
    $no_records = $_POST["no_record"];

    // Update query
    $sql = "UPDATE boxes SET category=?, cadastral=?, case_number=?, location=?, range_val=?, no_records=? WHERE id=?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssssi", $category, $cadastral, $case, $location, $range, $no_records, $id);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            header("location: edit_box.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark"
        style="background: linear-gradient(to right, #0056b3, #007bff, #28a745); box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
        <!-- Navbar content goes here -->
        <div class="container" style="margin-left: 0px;">
            <img src="assets/logo.png" alt="Logo" class="header-logo">
            <a class="navbar-brand" href=""> DENR CENRO Document Tracker System</a>
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">

                </ul>

            </div>
        </div>
    </nav>


    <div class="slide-bar">
        <img src="assets/Hamburger-Button.png" alt="Logo" class="slide_bar_icon">
        <a class="nav-link" href="index.php"
            style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; color: #333; transition: color 0.3s ease;">

            <!-- Use inline CSS for hover state -->
            <span style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'"
                onmouseout="this.style.color='#333'">TRACK</span>
        </a>

        <a class="nav-link" href="insert_box.php"
            style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; color: #333; transition: color 0.3s ease;">

            <!-- Use inline CSS for hover state -->
            <span style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'"
                onmouseout="this.style.color='#333'">INSERT</span>
        </a>

    </div>
    <!-- Second slide bar -->
    <div class="slide-bar slide-bar-right-middle">
        <img src="assets/arrow.png" alt="Logo" class="slide_bar_icon">
        <span style="transition: color 0.3s ease;" onmouseover="this.style.color=''"
            onmouseout="this.style.color='#333'" onclick="nav()">Lot Management</span>
    </div>
    <script>
        function nav() {
            window.location.href = '/DENR-LotDocumentManagementSystem/index.php';
        }
    </script>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Edit Record</h4>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Category:</label>
                                <input type="text" name="category" class="form-control"
                                    value="<?php echo $category; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Cadastral:</label>
                                <input type="text" name="cadastral" class="form-control"
                                    value="<?php echo $cadastral; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Case Number:</label>
                                <input type="text" name="case" class="form-control" value="<?php echo $case; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Rack:</label>
                                <input type="text" name="rack" class="form-control" value="<?php echo $location[0]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Layer:</label>
                                <input type="text" name="layer" class="form-control"
                                    value="<?php echo $location[1]; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Box:</label>
                                <input type="text" name="box" class="form-control" value="<?php echo $location[2]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Range:</label>
                                <input type="text" name="range" class="form-control" value="<?php echo $range; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">No. of Records:</label>
                                <input type="text" name="no_record" class="form-control"
                                    value="<?php echo $no_records; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>