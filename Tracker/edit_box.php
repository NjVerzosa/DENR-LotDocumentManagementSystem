<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];

    // Search Logic
    $sql = "SELECT * FROM boxes WHERE cadastral = '$search'";
    $result = mysqli_query($conn, $sql);
} else {
    // Select all records
    $sql = "SELECT * FROM boxes";
    $result = mysqli_query($conn, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/style.css">
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

    <div class="search_update">
        <div class="container mt-5 pt-1">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <select name="search" class="dropdown">
                    <option value="">Select Cadastral</option>
                    <?php
                    $sql = "SELECT DISTINCT cadastral FROM boxes";
                    $result_dropdown = mysqli_query($conn, $sql);

                    if ($result_dropdown && mysqli_num_rows($result_dropdown) > 0) {
                        while ($row = mysqli_fetch_assoc($result_dropdown)) {
                            $selected = ($_POST['search'] == $row["cadastral"]) ? 'selected' : '';
                            echo "<option value='" . $row["cadastral"] . "' $selected>" . $row["cadastral"] . "</option>";
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
                    <th>ID</th>
                    <th>Category</th>
                    <th>Cadastral</th>
                    <th>Case Number</th>
                    <th>Location</th>
                    <th>Range</th>
                    <th>No Records</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td>" . $row['cadastral'] . "</td>";
                        echo "<td>" . $row['case_number'] . "</td>";
                        echo "<td>" . $row['location'] . "</td>";
                        echo "<td>" . $row['range_val'] . "</td>";
                        echo "<td>" . $row['no_records'] . "</td>";
                        echo "<td>
                                <a href='update.php?id=" . $row['id'] . "' class='btn btn-primary'>Update</a>
                                <button class='btn btn-danger' onclick='confirmDelete(" . $row['id'] . ", \"" . $row['cadastral'] . "\");'>Delete</button>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No results found.</td></tr>";
                }

                ?>
            </tbody>
        </table>
    </div>

    <script>

        function confirmDelete(id, cadastral) {
            if (confirm("Are you sure you want to delete record ID: " + id + " with Cadastral: " + cadastral + "?")) {
                window.location.href = "delete.php?id=" + id;
            }
        }

    </script>

</body>

</html>