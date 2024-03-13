<?php
include "config.php";

if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // Search Logic
    $sql = "SELECT * FROM land_titles WHERE lot_number = '$search' ";
    $result = mysqli_query($conn, $sql);

} else {
    // Select all records
    $sql = "SELECT * FROM land_titles";
    $result = mysqli_query($conn, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DENR | MAIN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark"
        style="background: linear-gradient(to right, #0056b3, #007bff, #28a745); box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
        <!-- Navbar content goes here -->
        <div class="container" style="margin-left: 0px;">
            <img src="assets/logo.png" alt="Logo" class="header-logo">
            <a class="navbar-brand" href="index.php"> DENR CENRO Lot Management System</a>
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
                onmouseout="this.style.color='#333'">MAIN</span>
        </a>

        <a class="nav-link" href="" data-toggle="modal" data-target="#gearModal"
            style="font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-decoration: none; color: #333; transition: color 0.3s ease;">

            <!-- Use inline CSS for hover state -->
            <span style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'"
                onmouseout="this.style.color='#333'">ADD DATA</span>
        </a>

    </div>
    <!-- Second slide bar -->
    <div class="slide-bar slide-bar-right-middle">
        <img src="assets/arrow.png" alt="Logo" class="slide_bar_icon">
        <span style="transition: color 0.3s ease;" onmouseover="this.style.color='#007bff'"
            onmouseout="this.style.color='#333'" onclick="nav()">Track File</span>
    </div>
    <script>
        function nav() {
            window.location.href = 'Tracker/index.php';
        }
    </script>
    <div class="search_update">
        <div class="container mt-5 pt-1">
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Enter Lot Number">
                <button type="submit" class="btn btn-primary nav-link-btn">Search</button>
            </form>
        </div>
    </div>

    <div class="update_table">
        <table class='table'>
            <thead>
                <tr class="bg-primary" style="color: white;">
                    <th>Lot #</th>
                    <th>Application #</th>
                    <th>Date Filed</th>
                    <th>Applicant Name</th>
                    <th>Area</th>
                    <th>Location</th>
                    <th>Approved Date</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row["lot_number"] ?>
                            </td>
                            <th>
                                <?php echo $row["application_number"] ?>
                            </th>
                            <th>
                                <?php echo $row["date_filed"] ?>
                            </th>
                            <th>
                                <?php echo $row["applicant_name"] ?>
                            </th>
                            <th>
                                <?php echo $row["area"] ?>
                            </th>
                            <th>
                                <?php echo $row["location"] ?>
                            </th>
                            <th>
                                <?php echo $row["approved_date"] ?>
                            </th>
                            <th>
                                <!-- 0 is to proceed -->
                                <!-- 1 is to proceed means, got subdivider -->
                                <?php if ($row['remarks'] == "Titled") { ?>
                                    <button class="btn btn-primary" onclick='return confirm("No subdivider yet")'>TITLED</button>
                                <?php } elseif ($row['remarks'] == "Untitled") { ?>
                                    <a href="records.php?id=<?php echo $row["id"] ?>"><button
                                            class="btn btn-success">PROCEED</button></a>
                                <?php } ?>
                            </th>
                            <th>
                                <!-- Default actions to edit data incase of incorrect inputs by user -->
                                <a href="edit.php?applicant_name=<?php echo $row["applicant_name"] ?>"><button
                                        class="btn btn-primary">EDIT</button></a>
                            <?php } ?>

                        </th>
                    </tr>
                    <?php

                } else {
                    echo "<tr><td colspan='8'>No results found.</td></tr>";
                }

                ?>
            </tbody>
        </table>
    </div>
    <!-- Adding a Book, Lot or New Data -->
    <div class="modal fade" id="gearModal" tabindex="-1" role="dialog" aria-labelledby="gearModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gearModalLabel">Add LOT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_lot.php" method="POST">
                        <div class="form-group">
                            <label for="">Lot Number *</label>
                            <input type="number" class="form-control" name="lot_number" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Application Number *</label>
                            <input type="number" class="form-control" name="application_number" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Date Filed *</label>
                            <input type="date" class="form-control" name="date_filed" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Applicant Name *</label>
                            <input type="text" class="form-control" name="applicant_name" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Area *</label>
                            <input type="text" class="form-control" name="area" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Location *</label>
                            <input type="text" class="form-control" name="location" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Approved Date *</label>
                            <input type="date" class="form-control" name="approved_date" id="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Remarks *</label>
                            <select class="form-control" name="remarks" id="">
                                <option value="Untitled">Untitled</option>
                                <option value="Titled">Titled</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status *</label>
                            <select class="form-control" name="status" id="">
                                <option value="0">0 for Titled</option>
                                <option value="1">1 for Subdivided</option>
                                <option value="3">3 for Untitled and No Subdivider</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit">ADD DATA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- For Subdivision -->
    <!-- <div class="modal fade" id="subModal" tabindex="-1" role="dialog" aria-labelledby="subModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gearModalLabel">Subdivide</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Lot Number *</label>
                            <input type="number" class="form-control" name="lot_number" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Date Filed *</label>
                            <input type="date" class="form-control" name="date_filed" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Applicant Name *</label>
                            <input type="text" class="form-control" name="applicant_name" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Location *</label>
                            <input type="text" class="form-control" name="location" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Remarks *</label>
                            <input type="text" class="form-control" name="remarks" id="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="ADD">ADD DATA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>