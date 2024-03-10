<?php
session_start();
include 'config.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['submit'])) {
    $lot_number = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['lot_number'])));
    $date_filed = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['date_filed'])));
    $applicant_name = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['applicant_name'])));
    $location = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['location'])));
    $remarks = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['remarks'])));
    $position = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['position'])));
    $status = htmlspecialchars(mysqli_real_escape_string($conn, trim($_POST['status'])));


    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: index.php?error=CSRF token validation failed");
        exit();
    }

    $stmt_update = mysqli_prepare($conn, "UPDATE land_titles SET date_filed=?, applicant_name=?, location=?, remarks=?, position=?, status=? WHERE lot_number=?");
    mysqli_stmt_bind_param($stmt_update, "ssssssi", $date_filed, $applicant_name, $location, $remarks, $position, $status, $lot_number);

    if (mysqli_stmt_execute($stmt_update)) {
        header('location: index.php');
        exit();
    } else {
        header('location: edit-lot.php?lot_number=' . $lot_number);
        exit();
    }



}
if (isset($_GET['applicant_name'])) {
    $applicant_name = $_GET['applicant_name'];
    $query = "SELECT * FROM land_titles WHERE applicant_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $applicant_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
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
                        <h5 class="card-title">Edit
                            <?php echo $row['applicant_name']; ?>
                        </h5>
                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="form-group row">
                                <label for="lotNumber" class="col-sm-3 col-form-label">Lot Number:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['lot_number']; ?>"
                                        name="lot_number" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dateFiled" class="col-sm-3 col-form-label">Date Filed:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['date_filed']; ?>"
                                        name="date_filed" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="applicantName" class="col-sm-3 col-form-label">Applicant Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['applicant_name']; ?>"
                                        name="applicant_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="location" class="col-sm-3 col-form-label">Location:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['location']; ?>"
                                        name="location" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="location" class="col-sm-3 col-form-label">Status:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['status']; ?>"
                                        name="status">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="location" class="col-sm-3 col-form-label">Remakrs:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>"
                                        name="remarks">
                                </div>
                            </div>


                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        </body>

        </html>

        <?php
    } else {
        echo "No records found.";
    }
}
?>