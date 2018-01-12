<?php

include_once('employee.php');
/* Call the class User */
$obj = new Employee();
/* Assign userID into a variable $uid */
$uid = $_SESSION['user_id'];

if(isset($_GET['l'])){
    $obj->Logout();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/normalize.css"/>
    <link rel="stylesheet" href="assets/css/mystyle.css"/>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css"/>
    <link rel="icon" type="image/png" href="assets/images/favicon.png"> 
    <script src="bootstrap/js/jquery.min.js"></script>
    <title>Home</title>
</head>
<body>
    <div class="header">
        <div class="fixed-container">
            <div class="logo">
                <a href="#">HelpDesk</a>
            </div>
            <div class="nav">
                <ul>
                    <li>Welcome: <?php $obj->getUser($uid) ?> <a href="user_index.php?l=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="fixed-container">
        <div class="content">
            <a href="concern.php"><button class="btn btn-primary">Concern</button></a>
            <a href="request.php"><button class="btn btn-primary">Requests</button></a>
            <a href="history.php"><button class="btn btn-primary">MyHistory</button></a>
        </div>      
    </div>
    <footer> 
        
    </footer>
</body>
</html>