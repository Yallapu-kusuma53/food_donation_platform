<?php
session_start();
include '../connection.php';

$msg = "";

if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sanitized_email = mysqli_real_escape_string($connection, $email);
    $sanitized_password = mysqli_real_escape_string($connection, $password);

    $sql = "SELECT * FROM delivery_persons WHERE email = '$sanitized_email'";
    $result = mysqli_query($connection, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($sanitized_password, $row['password'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['city'] = $row['city']; // ✅ SET city
                $_SESSION['Did'] = $row['Did'];   // ✅ SET delivery ID

                header("Location: delivery.php");
                exit();
            } else {
                $msg = "Invalid password!";
            }
        } else {
            $msg = "Account does not exist!";
        }
    } else {
        // Debugging line – optional
        $msg = "Query failed: " . mysqli_error($connection);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delivery Login</title>
  <link rel="stylesheet" href="deliverycss.css" />
</head>
<body>
  <div class="center">
    <h1>Delivery Login</h1>
    <form method="post">
      <div class="txt_field">
        <input type="email" name="email" required />
        <span></span>
        <label>Email</label>
      </div>
      <div class="txt_field">
        <input type="password" name="password" required />
        <span></span>
        <label>Password</label>
      </div>
      <?php if (!empty($msg)) : ?>
        <p class="error"><?= htmlspecialchars($msg) ?></p>
      <?php endif; ?>
      <br>
      <input type="submit" value="Login" name="sign">
      <div class="signup_link">
        Not a member? <a href="deliverysignup.php">Signup</a>
      </div>
    </form>
  </div>
</body>
</html>
