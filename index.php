<?php
require './config/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin']) && $_POST['admin'] == 'login') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM `$table_admin` WHERE (username='$username' OR email='$username')";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        if (password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['ADMINNAME'] = $admin['username'];
            $_SESSION['ADMINID'] = $admin['id'];

            header('Location: ./home.php?success');
            exit();
        } else {
            header('Location: ./index.php?error=invalid_password');
            exit();
        }
    } else {
        header('Location: ./index.php?error=user_not_found');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/login.css">
  <title><?= $GLOBALS["name"]; ?> Login</title>
</head>

<body>
  <div class="login-container">
    <h2>Login</h2>
    <form action="./index.php" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Login">
      <input type="hidden" name="admin" value="login">
    </form>
  </div>
</body>

</html>