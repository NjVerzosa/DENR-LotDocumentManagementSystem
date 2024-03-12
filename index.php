<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];

    // Search Logic
    $sql = "SELECT * FROM land_titles WHERE location = '$search'";
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
                        <a class="nav-link" href="index.php" data-toggle="modal" data-target="#gearModal">Add Lot</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="search_update">
        <div class="container mt-5 pt-1">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <select name="search" class="dropdown">
                    <option value="">Select Location</option>
                    <?php
                    $sql = "SELECT location FROM land_titles";
                    $result_dropdown = mysqli_query($conn, $sql);

                    if ($result_dropdown && mysqli_num_rows($result_dropdown) > 0) {
                        while ($row = mysqli_fetch_assoc($result_dropdown)) {
                            $selected = ($_POST['search'] == $row["location"]) ? 'selected' : '';
                            echo "<option value='" . $row["location"] . "' $selected>" . $row["location"] . "</option>";
                        }
                    }
                    ?>
                </select>



                <button type="submit" class="btn btn-primary nav-link-btn">Search</button>
            </form>
        </div>
    </div>
    <div class="update_table">
        <table class='table'>
            <thead>
                <tr class="bg-primary" style="color: white;">
                    <th>Lot Number</th>
                    <th>Application Number</th>
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
                                        class="btn btn-primary" >EDIT</button></a>
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