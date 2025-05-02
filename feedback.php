<?php
session_start();
include 'connection.php';

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $msg = $_POST['message'];

    // Sanitize inputs
    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_name = mysqli_real_escape_string($connection, $name);
    $sanitized_msg = mysqli_real_escape_string($connection, $msg);

    // Insert into feedback table
    $query = "INSERT INTO user_feedback(name, email, message) 
              VALUES('$sanitized_name', '$sanitized_emailid', '$sanitized_msg')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        // Redirect with success flag
        header("Location: contact.html?success=1");
        exit();
    } else {
        echo '<script>alert("Data not saved. Please try again.");</script>';
    }
}
?>
