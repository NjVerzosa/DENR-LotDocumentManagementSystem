<?php
session_start();
include 'config.php';

if (isset($_GET['applicant_name'])) {
    $applicant_name = $_GET['applicant_name'];
    $query = "SELECT * FROM subdivided_titles WHERE applicant_name = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $applicant_name);
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

            <nav class="navbar navbar-expand-lg navbar-dark"
                style="background: linear-gradient(to right, #0056b3, #007bff, #28a745); box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                <!-- Navbar content goes here -->
                <div class="container" style="margin-left: 0px;">
                    <img src="assets/logo.png" alt="Logo" class="header-logo">
                    <a class="navbar-brand" href="index.php"> DENR CENRO Record Tracer</a>
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
                        onmouseout="this.style.color='#333'">Track File</span>
                </a>

                <a class="nav-link" href="edit_box.php"
                    style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; color: #333; transition: color 0.3s ease;">

                    <!-- Use inline CSS for hover state -->
                    <span style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'"
                        onmouseout="this.style.color='#333'">Update Data</span>
                </a>

                <a class="nav-link" href="insert_box.php"
                    style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; color: #333; transition: color 0.3s ease;">

                    <!-- Use inline CSS for hover state -->
                    <span style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'"
                        onmouseout="this.style.color='#333'">Add Box</span>
                </a>

            </div>
            <!-- Second slide bar -->
            <div class="slide-bar slide-bar-right-middle">
                <img src="assets/arrow.png" alt="Logo" class="slide_bar_icon">
                <span style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'"
                    onmouseout="this.style.color='#333'">system 2</span>
                </a>
            </div>XF
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


                            <button type="submit" name="update_sub" class="btn btn-primary">Update</button>
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