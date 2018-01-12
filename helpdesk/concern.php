<?php

include_once('employee.php');
// Call the class User 
$obj = new Employee();
// Assign userID into a variable $uid 
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
    <link rel="stylesheet" href="assets/css/mystyle.css"/>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css"/>
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="assets/images/favicon.png"> 
    <script src="bootstrap/js/jquery.min.js"></script>
    <title>Concern</title>
    <script type="text/javascript">
        function updConfirm(){
            if(confirm('Are you sure you want to update this?')){
                window.location = 'edit_con.php';
            }
            else{
               return false;
            }
        }

        function delConfirm(){
            if(confirm('Are you sure you want to delete this?')){
                window.location = 'edit_con.php';
            }
            else{
               return false;
            }
        }

        $(document).ready(function(){
            $("#checkAll").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });
        });
    </script>
</head>
<body>
    <div class="header">
        <div class="fixed-container">
            <div class="logo">
                <a href="#">HelpDesk</a>
            </div>s
            <div class="nav">
                <ul>
                    <li>Welcome: <?php $obj->getUser($uid); ?> <a href="user_index.php?l=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="fixed-container">
        <div class="content">
            <a href="concern.php"><button class="btn btn-primary" id="active">Concern</button></a>
            <a href="request.php"><button class="btn btn-primary">Request</button></a>
            <a href="history.php"><button class="btn btn-primary">MyHistory</button></a>
        </div>
        <div class="content">
             <?php echo $obj->Concern($uid); ?>   
        </div>      
    </div>
    <footer> 
        
    </footer>
</body>
</html>