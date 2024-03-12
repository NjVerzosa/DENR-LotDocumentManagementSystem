<?php
include "config.php";

// Assuming $specific_id is the specific id you want to match
$specific_id = $_GET["id"]; // Get the id from the URL parameter

// Fetch the land title details for the specific id
$land_title_sql = "SELECT * FROM land_titles WHERE id = $specific_id";
$land_title_result = $conn->query($land_title_sql);
$land_title_row = $land_title_result->fetch_assoc();

// Fetch the subdivided titles for the specific land title id, including the applicant's name, sorted by position
$subdivided_titles_sql = "SELECT *
                          FROM subdivided_titles
                          WHERE land_title_id = $specific_id
                          AND subdivided_to IS NULL
                          ORDER BY remarks";
$subdivided_titles_result = $conn->query($subdivided_titles_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DENR Lot Subdividers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <img src="assets/logo.png" alt="Logo" class="header-logo">

            <a class="navbar-brand" href="#"> DENR CENRO Record Tracer</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Main | New</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="index.php">Search</a>
                    </li> -->

                </ul>
            </div>
        </div>
    </nav>

    <div class="col-12 col-md-3 d-flex" style="width:50%;margin-left:1%;">
        <div class="card flex-fill border-0">
            <div class="card-body py-4">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="text-success">Lot Owner:
                            <?php echo $land_title_row["applicant_name"]; ?>
                        </h6>
                        <p>Lot Number:
                            <?php echo $land_title_row["lot_number"]; ?>
                        </p>
                        <p>Date Filed:
                            <?php echo $land_title_row["date_filed"]; ?>
                        </p>
                        <p>Location:
                            <?php echo $land_title_row["location"]; ?>
                        </p>
                        <p>Remarks:
                            <?php echo $land_title_row["remarks"]; ?>
                        </p>
                        <button class="btn btn-success open-modal" data-toggle="modal" data-target="#gearModal"
                            data-user_id="<?php echo $land_title_row["id"]; ?>"
                            data-date="<?php echo $land_title_row["date_filed"]; ?>"
                            data-applicant-name="<?php echo $land_title_row["applicant_name"]; ?>"
                            data-remarks="<?php echo $land_title_row["remarks"]; ?>"
                            style="margin-left:65%;padding:1px;width:30%;">ADD</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="update_table">
        <table class='table'>
            <thead>
                <tr class="bg-primary" style="color: white;">
                    <th>Applicant Name</th>
                    <th>Lot Number</th>
                    <th>Date Filed</th>
                    <th>Location</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($subdivided_titles_result->num_rows > 0) {
                    while ($row = $subdivided_titles_result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row["applicant_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["lot_number"]; ?>
                            </td>
                            <td>
                                <?php echo $row["date_filed"]; ?>
                            </td>
                            <td>
                                <?php echo $row["location"]; ?>
                            </td>
                            <th>
                                <!-- 0 is to proceed -->
                                <!-- 1 is to proceed means, got subdivider -->
                                <?php if ($row['status'] == 0) { ?>
                                    <button class="btn btn-primary" onclick='return confirm("No subdivider yet")'>Untitled</button>
                                <?php } elseif ($row['status'] == 1) { ?>
                                    <a href="records.php?id=<?php echo $row["id"] ?>"><button
                                            class="btn btn-success">Proceed</button></a>
                                <?php } ?>
                            </th>
                            <th>
                                <!-- Default actions to edit data incase of incorrect inputs by user -->
                                <a href="edit-subdivider.php?applicant_name=<?php echo $row["applicant_name"] ?>"><button
                                        class="btn btn-primary">Edit</button></a>
                            <?php } ?>

                        </th>
                    </tr>
                    <?php

                } else {
                    echo "<tr><td colspan='5'>No subdivided titles found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


</body>
<!-- Adding a subdiveder to subdiveder -->
<!-- back-end -->
<div class="modal fade" id="gearModal" tabindex="-1" role="dialog" aria-labelledby="gearModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gearModalLabel">Add LOT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add_subdivider.php" method="POST">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="userId" name="id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Date Filed:</label>
                        <input type="date" class="form-control" name="date_filed" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="applicantName" name="applicant_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Applicant Name:</label>
                        <input type="text" class="form-control" name="applicant_name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Remarks *</label>
                        <select class="form-control" name="remarks" id="">
                            <option value="Untitled">Untitled</option>
                            <option value="Titled">Titled</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // JavaScript to handle modal opening and data population
    $(document).ready(function () {
        // Event listener for the click on the "ADD" button
        $('.open-modal').click(function () {
            // Get the data attributes from the button
            var userId = $(this).data('user_id');
            var dateFiled = $(this).data('date');
            var applicantName = $(this).data('applicant-name');

            // Populate the modal with the fetched data
            $('#userId').val(userId);
            $('#dateFiled').val(dateFiled);
            $('#applicantName').val(applicantName);
            // Show the modal
            $('#gearModal').modal('show');
        });
    });
</script>

</html>