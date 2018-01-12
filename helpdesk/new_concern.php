<?php
include_once('employee.php');

$obj = new Employee();
$uid = $_SESSION['user_id'];

if(isset($_POST['concern'])){
    $concerns = $_POST['concerns'];
    $severity = $_POST['severity'];
    $department = $_POST['department'];
    $uid = $_SESSION['user_id'];
    
    date_default_timezone_set('Asia/Manila');
    $date = date('l jS \of F Y h:i:s A');   
    
    $obj->newConcern($concerns, $severity, $department, $uid, $date);
}

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
    <title>New Concern</title>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#concern').click(function(){
                if(confirm('Are you sure you want to proceed?')){
                    window.location.href='new_concern.php';
                }
                else{
                    return false;
                }
            });
        });
    </script>
</head>
<body>
    <div class="header">
        <div class="fixed-container">
            <div class="logo">
                <a href="#">HelpDesk</a>
            </div>
            <div class="nav">
                <ul>
                    <li>Welcome: <?php $obj->getUser($uid); ?> <a href="user_index.php?l=logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="fixed-container">
        <div class="content">
            <a href="concern.php"><button class="btn btn-primary">Concern</button></a>
            <a href="request.php"><button class="btn btn-primary">Request</button></a>
            <a href="history.php"><button class="btn btn-primary">MyHistory</button></a>
        </div>
        <div class="content">
            <div class="row">
                <?php if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                }
                ?>
                <form action="new_concern.php" method="POST">
                <div class="row">
                    <label for="concerns" style="float: left;">Message:</label>
                    <textarea name="concerns" id="concerns" class="form-control" placeholder="Your Concern..." value="<?php echo isset($_POST['concerns']) ? $_POST['concerns']: ''; ?>"></textarea>
                </div>
                <div class="row">
                <label for="department" style="float: left">Your Department:</label>
                <select name="department" id="department" class="form-control">
                    <option value="CCS">CCS</option>
                    <option value="CAS">CAS</option>
                    <option value="CBA">CBA</option>
                    <option value="CEN">CEN</option>
                    <option value="CHS">CHS</option>
                    <option value="CED">CED</option>
                </select>
                </div>
                <div class="row">
                    <label for="severity" style="float: left">Issues Condition:</label>
                    <select name="severity" id="severity" class="form-control">
                        <option value="minor">MINOR</option>
                        <option value="major">MAJOR</option>
                        <option value="critical">CRITICAL</option>
                    </select>
                </div>
                <div class="row">
                    <button class="btn btn-success" name="concern" id="concern" style="margin-top: 10px;"><span class='fa fa-paper-plane'></span> Submit</button>
                </div>
                </form>
            </div>
        </div>      
    </div>
    <footer></footer>
</body>
</html>