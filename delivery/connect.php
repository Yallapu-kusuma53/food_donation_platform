<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Include the database connection
include '../connection.php';  // Use connect.php if you've standardized it

$msg = 0;

if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input
    $sanitized_email = mysqli_real_escape_string($connection, $email);
    $sanitized_password = mysqli_real_escape_string($connection, $password);

    // Check if user exists
    $sql = "SELECT * FROM admin WHERE email = '$sanitized_email'";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($sanitized_password, $row['password'])) {
            // Set session variables
            $_SESSION['email']    = $row['email'];
            $_SESSION['name']     = $row['name'];
            $_SESSION['location'] = $row['location'];
            $_SESSION['Aid']      = $row['Aid'];

            header("Location: admin.php");
            exit();
        } else {
            $msg = 1; // Wrong password
        }
    } else {
        echo "<h1 style='text-align:center; color:red;'>Account does not exist</h1>";
    }
}
?>
