<?php
include_once('employee.php');

if(isset($_POST['register'])){
    $f_name = $_POST['emp_fname'];
    $m_name = $_POST['emp_mname'];
    $l_name = $_POST['emp_lname'];
    $username = $_POST['emp_username'];
    $password = $_POST['emp_password'];
    $email = $_POST['emp_email'];
    $conf_pass = $_POST['emp_conf_password'];
    
    $obj = new Employee();
    $obj->Emp_reg($f_name, $m_name, $l_name, $username, $password, $email, $conf_pass);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/skeleton.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css"/>
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="assets/images/favicon.png"> 
    <script src="bootstrap/js/jquery.min.js"></script>
    <title>Registration</title>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#confirm').click(function(){
                if(confirm("Are you sure you want to proceed?")){
                    window.location.href = 'emp_reg.php';
                }
                else {
                    return false;
                }
            })
        });
    </script>
</head>
<body>
    <div class="container">
        <header class="u-pull-right">
            <a href="index.php"><span class="fa fa-home" style='color:#181919; font-size:30px;'></span>Home</a>
        </header>
        <?php if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
        } ?>
        <h1><strong>Registration</strong></h1>
        <form action="emp_reg.php" method="POST">
        <div class="row">
            <label for="emp_fname">Firstname:</label>
            <input type="text" class="u-full-width" name="emp_fname" id="emp_fname" value="<?php echo isset($_POST['emp_fname']) ? $_POST['emp_fname'] : ''; ?>">
        </div>
        <div class="row">
            <label for="emp_mname">Middlename:</label>
            <input type="text" class="u-full-width" name="emp_mname" id="emp_mname" value="<?php echo isset($_POST['emp_mname']) ? $_POST['emp_mname'] : ''; ?>">
        </div>
        <div class="row">
            <label for="emp_lname">Lastname:</label>
            <input type="text" class="u-full-width" name="emp_lname" id="emp_lname" value="<?php echo isset($_POST['emp_lname']) ? $_POST['emp_lname'] : ''; ?>">
        </div>
        <div class="row">
            <label for="emp_email">Emailaddress:</label>
            <input type="email" class="u-full-width" name="emp_email" id="emp_email" value="<?php echo isset($_POST['emp_email']) ? $_POST['emp_email'] : ''; ?>">
        </div>
        <div class="row">
            <label for="emp_username">Username:</label>
            <input type="text" class="u-full-width" name="emp_username" id="emp_username" value="<?php echo isset($_POST['emp_username']) ? $_POST['emp_username'] : ''; ?>">
        </div>
        <div class="row">
            <label for="emp_password">Password:</label>
            <input type="password" class="u-full-width" name="emp_password" id="emp_password">
        </div>
        <div class="row">
            <label for="emp_conf_password">Confirm Password:</label>
            <input type="password" class="u-full-width" name="emp_conf_password" id="emp_conf_password">
        </div>
        <div class="row">
            <button class="button button-primary" id="confirm" name="register">REGISTER</button>
        </div>
        </form>
    </div>
</body>
</html>