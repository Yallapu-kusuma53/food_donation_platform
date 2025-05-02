<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "demo";

// Establish connection
$connection = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch distinct locations from the database
$locationQuery = "SELECT DISTINCT location FROM food_donations";
$locationResult = mysqli_query($connection, $locationQuery);
$locations = [];
while ($row = mysqli_fetch_assoc($locationResult)) {
    $locations[] = $row['location'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>

            <span class="logo_name">ADMIN</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li> -->
                <li><a href="analytics.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-heart"></i>
                    <span class="link-name">Donates</span>
                </a></li>
                <li><a href="feedback.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Feedbacks</span>
                </a></li>
                <li><a href="adminprofile.php">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Profile</span>
                </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li> -->
            </ul>
            
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>


    <section class="dashboard">
        <div class="top">
            <!-- Top bar content -->
        </div>

        <div class="activity">
            <div class="location">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <label for="location" class="logo">Select Location:</label>
                    <select id="location" name="location">
                        <?php foreach ($locations as $city): ?>
                            <option value="<?php echo htmlspecialchars($city); ?>">
                                <?php echo htmlspecialchars($city); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Get Details">
                </form>
                <br>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['location'])) {
                    $location = mysqli_real_escape_string($connection, $_POST['location']);

                    // Query the database for donations in the selected location
                    $sql = "SELECT * FROM food_donations WHERE location='$location'";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo "<div class=\"table-container\">";
                        echo "<div class=\"table-wrapper\">";
                        echo "<table class=\"table\">";
                        echo "<thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Food</th>
                                    <th>Category</th>
                                    <th>Phone No</th>
                                    <th>Date/Time</th>
                                    <th>Address</th>
                                    <th>Quantity</th>
                                </tr>
                              </thead>
                              <tbody>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td data-label=\"Name\">".htmlspecialchars($row['name'])."</td>
                                    <td data-label=\"Food\">".htmlspecialchars($row['food'])."</td>
                                    <td data-label=\"Category\">".htmlspecialchars($row['category'])."</td>
                                    <td data-label=\"Phone No\">".htmlspecialchars($row['phoneno'])."</td>
                                    <td data-label=\"Date/Time\">".htmlspecialchars($row['date'])."</td>
                                    <td data-label=\"Address\">".htmlspecialchars($row['address'])."</td>
                                    <td data-label=\"Quantity\">".htmlspecialchars($row['quantity'])."</td>
                                  </tr>";
                        }
                        echo "</tbody></table></div></div>";
                    } else {
                        echo "<p>No results found for the selected location.</p>";
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <script src="admin.js"></script>
</body>
</html>






