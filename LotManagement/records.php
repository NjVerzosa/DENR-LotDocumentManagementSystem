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
                        <button class="btn btn-success" style="margin-left:65%;padding:1px;width:30%;">ADD</button>
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
                    <th>History</th>
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
                            <td>
                                <?php echo $row["remarks"]; ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 0) { ?>
                                    <button class="btn btn-primary" onclick='return confirm("No subdivider yet")'>VIEW</button>
                                <?php } elseif ($row['code'] == 1) { ?>
                                    <button class="btn btn-success"><a href="edit.php">VIEW</a></button>
                                <?php } ?>
                            </td>
                            <th>

                                <!-- Will take Actions  -->
                                <?php if ($row['remarks'] == "Untitled") { ?>
                                    <a href=""><button class="btn btn-primary"
                                            onclick='return confirm("You want add Subdivider?")'>SUBDIVIDE</button></a>
                                    <a href=""><button class="btn btn-primary"
                                            onclick='return confirm("You want to edit this Lot?")'>EDIT</button></a>

                                    <!-- <button class="btn btn-danger" onclick='return confirm("No subdivider yet")'>DELETE</button> -->
                                <?php } elseif ($row['remarks'] == "Titled") { ?>
                                    <a href=""><button class="btn btn-primary"
                                            onclick='return confirm("Not available for subdivision")'>SUBDIVIDE</button></a>
                                    <a href=""><button class="btn btn-primary"
                                            onclick='return confirm("You want to edit this Lot?")'>EDIT</button></a>
                                <?php } ?>

                            </th>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>No subdivided titles found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


</body>

</html>