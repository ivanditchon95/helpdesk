<?php
include_once('employee.php');

if(isset($_POST['login'])) {
    $object = new Employee();
    $username = mysqli_real_escape_string($object->getConnection(), $_POST['username']);
    $password = mysqli_real_escape_string($object->getConnection(), $_POST['password']);
    $object->Login($username, $password);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/skeleton.css"/>
    <link rel="stylesheet" href="assets/css/mystyle.css"/>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">    
</head>
<body>
    <div class="container">
        <div class="row">
            <?php echo $_SESSION['msg']; ?>
            <form action="#" method="POST">
            <h1><strong>HelpDesk</strong></h1>
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" class="u-full-width" name="username" id="username" placeholder="Your Username"/>
            <label for="password">Password:</label>
            <input type="password" class="u-full-width" name="password" id="password" placeholder="Your Password"/>
            <label class="u-pull-right">
                <span>No account yet? <a href="emp_reg.php">Register here</a></span>
            </label>
            <input type="submit" name="login" class="button-primary" value="Login"/>
            </form>
        </div>
    </div>
</body>
</html>