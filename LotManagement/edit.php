<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM land_titles WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
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
                        <h5 class="card-title">Edit
                            <?php echo $row['applicant_name']; ?>
                        </h5>
                        <form method="POST" action="update.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="form-group row">
                                <label for="lotNumber" class="col-sm-3 col-form-label">Lot Number:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['lot_number']; ?>"
                                        name="lot_number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Applicant #:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['application_number']; ?>"
                                        name="application_number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dateFiled" class="col-sm-3 col-form-label">Date Filed:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['date_filed']; ?>"
                                        name="date_filed">
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
                                <label for="location" class="col-sm-3 col-form-label">Area:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['area']; ?>" name="area">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="location" class="col-sm-3 col-form-label">Location:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['location']; ?>"
                                        name="location">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remarks" class="col-sm-3 col-form-label">Remarks:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['remarks']; ?>"
                                        name="remarks">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="remarks" class="col-sm-3 col-form-label">Approved Date:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['approved_date']; ?>"
                                        name="approved_date">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="location" class="col-sm-3 col-form-label">Status:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $row['status']; ?>" name="status">
                                </div>
                            </div>


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
