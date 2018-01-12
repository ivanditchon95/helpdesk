<?php
include 'db.php';
session_start();

$_SESSION['msg'] = '';
    
 
    class Employee{
        
        private $db;

        function __construct() {
            
            $this->db = new mysqli(DB_SERVER, DB_USER, DB_PWD, DB_DATABASE); 
            //Error Handling 
            if(mysqli_connect_errno()) {
		echo "Error: Could not connect to database.";
		exit();
            }
        }
        //Get Connection 
        public function getConnection(){
            return $this->db;
        }
        //Login 
        public function Login($username, $password){
            $sql = "SELECT * FROM accounts WHERE acc_username = '{$username}' AND acc_password = '{$password}'";
            $qry = $this->db->query($sql);
            $user_data = $qry->fetch_assoc();
            $num_rows = $qry->num_rows;
            
            try{
                if(!empty($username) && !empty($password)){
                    if($num_rows == 1){
                        if($user_data['acc_type'] == 'admin'){
                            $_SESSION['is_login'] = TRUE;
                            $_SESSION['admin_id'] = $user_data['acc_id'];
                            $redirectURL = 'http://localhost/helpdesk/admin_index.php';
                            echo "<script type='text/javascript'>window.location.href='$redirectURL'</script>";
                        }
                        else {
                            $_SESSION['is_login'] = TRUE;
                            $_SESSION['user_id'] = $user_data['acc_id'];
                            $redirectURL = 'http://localhost/helpdesk/user_index.php';
                            echo "<script type='text/javascript'>window.location.href='$redirectURL'</script>";
                    
                        }
                    }
                    else {
                        echo "<script type='text/javascript'>alert('Invalid Login. Please check your Username and Password ');history.back();</script>";
                    }
                }
                else {
                    $_SESSION['msg'] = '<p style=color:red>Login failed. Please fill all the details below!. This page will be refreshed in 10seconds.</p>';
                    header("Refresh: 10");
                    throw new Exception($_SESSION['msg']);
                }
            }
            catch(Exception $ex){
                $_SESSION['msg'] = '<b style="color:red;">WARNING:</b>   '.$ex->getMessage();
            }
        }
        //Logout 
        public function Logout(){
            $_SESSION['is_login'] == FALSE;
            session_destroy();
            header('location:index.php');
        }

        public function Emp_reg($f_name, $m_name, $l_name, $username, $password, $email, $conf_pass){
            //Check Email if already exist 
            $check_sql = "SELECT * FROM employee WHERE emp_email = '{$email}'";
            $check_qry = $this->db->query($check_sql);
            $num_rows = $check_qry->num_rows;
            //Check Username if already exist 
            $check_username_sql = "SELECT * FROM accounts WHERE acc_username = '{$username}'";
            $check_username_qry = $this->db->query($check_username_sql);
            $username_num_rows = $check_username_qry->num_rows;
            //Exceptions
            try{
                if(empty($f_name) || empty($m_name) || empty($l_name) || empty($username) || empty($password) || empty($conf_pass) || empty($email)){
                    $_SESSION['msg'] = '<p style="color: red;">Please fill all the fields below.</p>';
                    throw new Exception($_SESSION['msg']);
                }
                else{
                    if($num_rows > 0){
                        $_SESSION['msg'] = '<p style="color: red;">Emailaddress '.$email.' is already exist.</p>';
                        throw new Exception($_SESSION['msg']);
                    }
                    else if($username_num_rows > 0){
                        $_SESSION['msg'] = '<p style="color: red;">Username '.$username.' is already exist.</p>';
                        throw new Exception($_SESSION['msg']);
                    }
                    else if($conf_pass != $password){
                        $_SESSION['msg'] = '<p style="color: red;">Confirm password did not match to your Password.</p>';
                        throw new Exception($_SESSION['msg']);
                    }
                    else {
                        //Insert Account 
                        $acc_sql = "INSERT INTO `accounts`(`acc_id`, `acc_type`, `acc_username`, `acc_password`) 
                        VALUES (NULL, 'user', '$username', '$password')";
                        $acc_qry = $this->db->query($acc_sql);
                        $_SESSION['acc_id'] = mysqli_insert_id($this->db);
                        $acc_id = $_SESSION['acc_id'];
                        //Insert Employee Info 
                        $emp_sql = "INSERT INTO `employee`(`employee_id`, `acc_id`, `emp_fname`, `emp_mname`, `emp_lname`, `emp_email`) 
                        VALUES (NULL,'$acc_id', '$f_name', '$m_name', '$l_name', '$email')";
                        $emp_qry = $this->db->query($emp_sql);
                            
                        if($acc_qry && $emp_qry == true){
                            $_SESSION['msg'] = '<p style="color: #1EA926">Successfully Register. This page will refreshed in 10seconds.<p>';
                            header('Refresh:10');
                        }
                        else{
                            $_SESSION['msg'] = 'No result!';
                            throw new Exception($_SESSION['msg']);
                        }
                    }
                }
            }
            catch(Exception $ex){
                $_SESSION['msg'] = '<b style="color:red">WARNING:</b>  '.$ex->getMessage(); 
            }
        }
        //Getting the User Info 
        public function getUser($uid){
            $emp_sql = "SELECT * FROM employee WHERE acc_id = '{$uid}'";
            $emp_qry = $this->db->query($emp_sql);
            $row = $emp_qry->fetch_assoc();
            echo $row['emp_fname'];
        }
        //New Added Concern 
        public function newConcern($concerns, $severity, $department, $uid, $date){
            //Select severity ID
            $sev_sql = "SELECT * FROM severity WHERE severity = '{$severity}'";
            $sev_qry = $this->db->query($sev_sql);
            $num_row = $sev_qry->num_rows;
            $row = $sev_qry->fetch_assoc();
            $sev_id = $row['severity_id'];
            $sev_name = $row['severity'];
            //Select department ID 
            $dep_sql = "SELECT * FROM department WHERE department = '{$department}'";
            $dep_qry = $this->db->query($dep_sql);
            $num_row = $dep_qry->num_rows;
            $row = $dep_qry->fetch_assoc();
            $dep_id = $row['department_id'];
            $sev_name = $row['department'];
            //Select employee ID
            $sql = "SELECT * FROM employee WHERE acc_id = '{$uid}'";
            $qry = $this->db->query($sql);
            $num_row = $qry->num_rows;
            $row = $qry->fetch_assoc();
            $emp_id = $row['employee_id'];
            
            $pending = "Pending/Approved/Ongoing";

            try{
                if(empty($concerns)){
                    $_SESSION['msg'] = '<p style="color: red">Please fill all the details below!</p>';
                    throw new Exception($_SESSION['msg']);
                }
                else{
                    $sql = "INSERT INTO `helpdesk`(`id`, `employee_id`, `severity_id`, `status_id`, `department_id`, `concerns`, `date`, `date2`) 
                    VALUES (NULL,'$emp_id','$sev_id','1','$dep_id','$concerns', '$date', '$pending')";
                    $qry = $this->db->query($sql);

                    if($qry == true) {  
                        $_SESSION['msg'] = '<p style="color: #1EA926">Successfully Added. This page will be refreshed in 10seconds.</p>';
                        header('Refresh:10');
                    }
                    else{
                        $_SESSION['msg'] = 'No result!';
                        throw new Exception($_SESSION['msg']);
                    }
                }
            }
            catch(Exception $ex){
                $_SESSION['msg'] =  '<b style="color:red">WARNING:</b>  ' .$ex->getMessage();
            }
        }

        public function Concern($uid){
            //InnerJoin tables to access data in different tables
            $sql = "SELECT employee.employee_id AS emp_id,
                           employee.acc_id,
                           helpdesk.id AS id,
                           helpdesk.concerns AS concerns 
                    FROM employee INNER JOIN accounts ON employee.acc_id = accounts.acc_id INNER JOIN helpdesk ON employee.employee_id = helpdesk.employee_id
                    WHERE accounts.acc_id = '{$uid}'";
            
            $qry = $this->db->query($sql);
            $num_row = $qry->num_rows;

            echo "<a href='new_concern.php'><button class='btn addconcern'><span class='fa fa-plus'></span> Add New</button></a>";    
            echo "<label style='float: right; padding-top: 13px;'><input type='checkbox' id='checkAll'/> Check all</label>"; 
            echo "<form action='edit_con.php' method='POST'>";
            echo "<button name='edit' class='btn updateConcern' onclick='return updConfirm()'><span class='fa fa-check'></span> Edit</button>";
            echo "<button name='delete' class='btn deleteAllconcern' onclick='return delConfirm()'><span class='fa fa-remove'></span> Delete </button>";
            echo "<table class='table table-striped' border='1'>";
            echo "<thead>
                    <tr>
                        <th style='text-align:center;'><span class='fa fa-bug'></span> Issues</th>
                        <th style='text-align:center' colspan='2'><span class='fa fa-superpowers'></span> Action
                  </thead>";

            try{
                if($num_row > 0){
                    echo "<tbody>";
                    while($row = $qry->fetch_assoc()){
                        echo "<tr>";
                            echo "<td class='issues' style='padding-top: 15px;'>".$row['concerns']."</td>";
                            echo "<td width='10%' style='padding-top: 13px;'><input type='checkbox' name='checkbox[]' value=".$row['id']."></td>";
                        echo "</tr>";  
                    }
                }
                else{
                    throw new Exception('There is no Concern right now :D');
                }
            }
            catch(Exception $ex){
                echo '<b>Message:</b>  '.$ex->getMessage();
            }
            echo "</tbody>";
            echo "</table>"; 
            echo "</form>";
        }
        
        public function Request($uid){ 
            //InnerJoin tables to access data in different tables
            $req_sql = "SELECT employee.employee_id,
                               employee.acc_id,
                               helpdesk.id AS id,   
                               helpdesk.concerns AS concerns,
                               severity.severity AS severity,   
                               stat.stat AS stat, 
                               helpdesk.date AS date_time
                        FROM employee INNER JOIN accounts ON employee.acc_id = accounts.acc_id INNER JOIN helpdesk 
                        ON employee.employee_id = helpdesk.employee_id INNER JOIN severity ON helpdesk.severity_id = severity.severity_id
                        INNER JOIN stat ON helpdesk.status_id = stat.status_id  WHERE accounts.acc_id = '{$uid}'";
            
            $req_qry = $this->db->query($req_sql);
            $num_row = $req_qry->num_rows;

            echo "<form action='search.php' method='POST'>";
            echo "<input type='text' name='search' class='searchEmp' placeholder='Search...'required><button name='searchBtn' class='searchBtn'>Search</button>";
            echo "</form>";
            echo "<form action='request.php' method='POST'>";
            echo "<button name='submit' class='btn btn-danger fbButton' onclick='return feedback()'><span class='fa fa-paper-plane'></span> Submit feedback</button>";
            echo "<label style='float: right; padding-top: 13px;'><input type='checkbox' id='checkAll'/> Check all</label>";
            echo "<table class='table table-striped' border='1'>";
            echo "<thead>
                    <tr>
                        <th style='text-align: center;'><span class='fa fa-bug'></span> Issues</th>
                        <th style='text-align: center;'><span class='fa fa-exclamation-triangle'></span> Severity</th>
                        <th style='text-align: center;'><span class='fa fa-asterisk'></span> Status</th>
                        <th style='text-align: center;'><span class='fa fa-comments'></span> Feedback</th>
                    </tr>
                    </thead>";
            try{      
                if($num_row > 0){
                    echo "<tbody>";
                    while($row = $req_qry->fetch_assoc()){ 
                        echo "<tr id=".$row['id'].">";
                            echo "<td class='issues' style='max-width: 900px; padding-top: 12px;'>".$row['concerns']."</td>";
                             //Switch Color for Severity
                            if($row['severity'] == 'MINOR'){
                                echo "<td class='severityMinor' style='padding-top: 10px;'>".$row['severity']."</td>";
                            }
                            else if($row['severity'] == 'MAJOR'){
                                echo "<td class='severityMajor' style='padding-top: 10px;'>".$row['severity']."</td>";
                            }
                            else if($row['severity'] == 'CRITICAL'){
                                echo "<td class='severityCritical' style='padding-top: 10px;'>".$row['severity']."</td>";
                            }
                            //Switch Color for status 
                            if($row['stat'] == 'Pending'){
                                echo "<td class='statusPending' style='padding-top: 10px;'>".$row['stat']."</td>";
                                echo "<td style='width: 30%;'><input type='checkbox' name='checkbox[]' value=".$row['id']."> Check this if the issue is solved</td>";
                            }
                            else if($row['stat'] == 'Approved'){
                                echo "<td class='statusApproved' style='padding-top: 10px;'>".$row['stat']."</td>";
                                echo "<td style='width: 30%;'><input type='checkbox' name='checkbox[]' value=".$row['id']."> Check this if the issue is solved</td>";
                            }
                            else if($row['stat'] == 'Ongoing'){
                                echo "<td class='statusOngoing' style='padding-top: 10px;'>".$row['stat']."</td>";
                                echo "<td style='width: 30%;'><input type='checkbox' name='checkbox[]' value=".$row['id']."> Check this if the issue is solved</td>";
                            }
                            else if($row['stat'] == 'Solved'){
                                echo "<td class='statusSolved' style='padding-top: 10px;'>".$row['stat']."</td>";
                                echo "<td style='width: 30px;'><span style='font-size: 18px;' class='fa fa-thumbs-up'></span></td>";
                            }
                        echo "</tr>";  
                    }   
                }
                else{
                    throw new Exception('There is no Request right now :D');
                }
            }
            catch(Exception $ex){
                echo "<p style='padding-top: 15px;'><b>Message:</b></p>".$ex->getMessage();
            }
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
        }

        public function searchEmp($uid, $keyword){
            $search_sql = "SELECT employee.employee_id,
                                  employee.acc_id,
                                  helpdesk.id AS id,   
                                  helpdesk.concerns AS concerns,
                                  severity.severity AS severity,
                                  stat.stat AS stat, 
                                  helpdesk.date AS date_time
                           FROM employee INNER JOIN accounts ON employee.acc_id = accounts.acc_id INNER JOIN helpdesk 
                           ON employee.employee_id = helpdesk.employee_id INNER JOIN severity ON helpdesk.severity_id = severity.severity_id
                           INNER JOIN stat ON helpdesk.status_id = stat.status_id  WHERE helpdesk.concerns LIKE '%$keyword%' OR severity.severity LIKE '%$keyword%'  
                           OR stat.stat LIKE '%$keyword%' AND accounts.acc_id = '{$uid}'";
            $search_qry = $this->db->query($search_sql);
            $num_row = $search_qry->num_rows;
            
            echo "<form action='request.php' method='POST'>";
            echo "<button name='submit' class='btn btn-danger fbButton' onclick='return feedback()' style='margin-bottom: 15px;'><span class='fa fa-paper-plane'></span> Submit feedback</button>";
            echo "<table class='table table-striped' border='1'>";
            echo "<thead>
                    <tr>
                        <th style='text-align: center;'><span class='fa fa-bug'></span> Issues</th>
                        <th style='text-align: center;'><span class='fa fa-exclamation-triangle'></span> Severity</th>
                        <th style='text-align: center;'><span class='fa fa-asterisk'></span> Status</th>
                        <th style='text-align: center;'><span class='fa fa-comments'></span> Feedback</th>
                    </tr>
                    </thead>";

            try{      
                if($num_row > 0){
                    echo "<tbody>";
                    while($row = $search_qry->fetch_assoc()){ 
                        echo "<tr id=".$row['id'].">";
                            echo "<td class='issues' style='max-width: 900px; padding-top: 12px;'>".$row['concerns']."</td>";
                             //Switch Color for Severity
                            if($row['severity'] == 'MINOR'){
                                echo "<td class='severityMinor' style='padding-top: 10px;'>".$row['severity']."</td>";
                            }
                            else if($row['severity'] == 'MAJOR'){
                                echo "<td class='severityMajor' style='padding-top: 10px;'>".$row['severity']."</td>";
                            }
                            else if($row['severity'] == 'CRITICAL'){
                                echo "<td class='severityCritical' style='padding-top: 10px;'>".$row['severity']."</td>";
                            }
                            //Switch Color for status 
                            if($row['stat'] == 'Pending'){
                                echo "<td class='statusPending' style='padding-top: 10px;'>".$row['stat']."</td>";
                                echo "<td style='width: 30%;'><input type='checkbox' name='checkbox[]' value=".$row['id']."> Check this if the issues is complete</td>";
                            }
                            else if($row['stat'] == 'Approved'){
                                echo "<td class='statusApproved' style='padding-top: 10px;'>".$row['stat']."</td>";
                                echo "<td style='width: 30%;'><input type='checkbox' name='checkbox[]' value=".$row['id']."> Check this if the issues is complete</td>";
                            }
                            else if($row['stat'] == 'Ongoing'){
                                echo "<td class='statusOngoing' style='padding-top: 10px;'>".$row['stat']."</td>";
                                echo "<td style='width: 30%;'><input type='checkbox' name='checkbox[]' value=".$row['id']."> Check this if the issues is complete</td>";
                            }
                            else if($row['stat'] == 'Solved'){
                                echo "<td class='statusSolved' style='padding-top: 10px;'>".$row['stat']."</td>";
                                echo "<td style='width: 30px;'><span style='font-size: 18px;' class='fa fa-thumbs-up'></span></td>";
                            }
                        echo "</tr>";  
                    }   
                }
                else{
                    throw new Exception('Not Found!');
                }
            }
            catch(Exception $ex){
                echo 'Message:   '.$ex->getMessage();
            }
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
        }

        public function Feedback($box, $fb, $dateFin){
            if($box == 0){
                echo "<script>alert('Please Select atleast one checkbox!')</script>";
                $redirectURL = 'http://localhost/helpdesk/request.php';
                echo "<script>window.location.href='$redirectURL'</script>";
            }
            else{    
                while(list($key, $val) = @each($box)){
                    //Get Status ID
                    $fb_sql = "SELECT * FROM stat WHERE stat = '{$fb}'";
                    $fb_qry = $this->db->query($fb_sql);
                    $num_row = $fb_qry->num_rows;
                    $row = $fb_qry->fetch_assoc();
                    $stat = $row['status_id'];
                    //Date finished
                    $date_sql = "UPDATE helpdesk SET date2 = '{$dateFin}' WHERE id = '{$val}'";
                    $date_qry = $this->db->query($date_sql);
                    //Update Status to solved 
                    $updFb_sql = "UPDATE helpdesk SET status_id = '{$stat}' WHERE id = '{$val}'";
                    $updFb_qry = $this->db->query($updFb_sql);

                    try{
                        if($updFb_qry && $date_qry == true){
                            echo "<script>alert('Successfully Submitted')</script>";
                            $redirectURL = 'http://localhost/helpdesk/request.php';
                            echo "<script>window.location.href='$redirectURL'</script>";
                        }
                        else{
                            throw new Exception('No result');
                        }
                    }
                    catch(Exception $ex){
                        echo "Error:  ".$ex->getMessage();
                    }
                }
            }
        }

        public function History($uid){
            $his_sql = "SELECT employee.employee_id,
                               employee.acc_id,
                               helpdesk.concerns AS concerns,
                               severity.severity AS severity,
                               stat.stat AS stat, 
                               helpdesk.date AS date_time,
                               helpdesk.date2 AS date_time2
                        FROM employee INNER JOIN accounts ON employee.acc_id = accounts.acc_id INNER JOIN helpdesk 
                        ON employee.employee_id = helpdesk.employee_id INNER JOIN severity ON helpdesk.severity_id = severity.severity_id
                        INNER JOIN stat ON helpdesk.status_id = stat.status_id  WHERE accounts.acc_id = '{$uid}'";
            $his_qry = $this->db->query($his_sql);
            $num_row = $his_qry->num_rows;

            echo "<table class='table table-striped' border='1'>";
            echo "<thead>
                    <tr>
                        <th style='text-align: center;'><span class='fa fa-bug'></span> Issues</strong></th>
                        <th style='text-align: center;'><span class='fa fa-calendar'></span> DateSubmitted</th>
                        <th style='text-align: center;'><span class='fa fa-calendar'></span> DateFinished</th>
                    </tr>
                  </thead>";
            try{
                if($num_row > 0){
                    echo "<tbody>";
                    while($row = $his_qry->fetch_assoc()){
                        echo "<tr>";
                            echo "<td class='issues' style='padding-top: 17px;'>".$row['concerns']."</td>";
                            echo "<td class='dateSub1'>".$row['date_time']."</td>";
                            echo "<td class='dateSub2'>".$row['date_time2']."</td>";
                        echo "</tr>";  
                    }
                }
                else{
                    throw new Exception('There is no History right now :D');
                }
            }
            catch(Exception $ex){
                echo '<b>Message:</b>  '.$ex->getMessage();
            }   
                    echo "</tbody>";
            echo "</table>";
        }

        /*public function deleteCon($id){
            $del_sql = "DELETE FROM helpdesk WHERE id = '{$id}'";
            $del_qry = $this->db->query($del_sql);
            
            try{
                if($del_qry == true){
                    echo "<script type='text/javascript'>alert('Successfully Deleted')</script>";
                    $redirectURL = "http://localhost/helpdesk/concern.php";
                    echo "<script type='text/javascript'>window.location.href='$redirectURL'</script>";
                }
                else{
                    throw new Exception('Cant Deleted');
                }
            }
            catch(Exception $ex){
                echo 'Error:   '.$ex->getMessage();
            }
        }*/

        /*public function geteditCon($id){
            $edit_sql = "SELECT helpdesk.id AS id,
                                helpdesk.concerns AS concerns,
                                severity.severity AS severity,
                                department.department AS department
                         FROM helpdesk INNER JOIN severity ON helpdesk.severity_id = severity.severity_id 
                         INNER JOIN department ON helpdesk.department_id = department.department_id WHERE helpdesk.id = '{$id}'";
            $edit_qry = $this->db->query($edit_sql);
            $edit_num_rows = $edit_qry->num_rows;
            $row = $edit_qry->fetch_assoc();
            $concern = $row['concerns'];
            $_SESSION['concern'] = $concern; 
            $severity = $row['severity'];
            $_SESSION['severity'] = $severity;
            $department = $row['department']; 
            $_SESSION['department'] = $department;
        }*/

        public function Delete($box){
            if($box == 0){
                echo "<script>alert('Please Select atleast one checkbox!')</script>";
                $redirectURL = 'http://localhost/helpdesk/concern.php';
                echo "<script>window.location.href='$redirectURL'</script>";
            }
            else{    
                while(list($key, $val) = @each($box)){
                    $delAll_sql = "DELETE FROM helpdesk WHERE id = '{$val}'";
                    $delAll_qry = $this->db->query($delAll_sql);

                    try{
                        if($delAll_qry == true){
                            echo "<script>alert('Successfully Deleted')</script>";
                            $redirectURL = 'http://localhost/helpdesk/concern.php';
                            echo "<script>window.location.href='$redirectURL'</script>";
                        }
                        else{
                            throw new Exception('No result');
                        }
                    }
                    catch(Exception $ex){
                        echo "Error:  ".$ex->getMessage();
                    }
                }
            }
        }

        public function editCon($id, $new_concern){
            $N = count($id);
            for($i=0; $i < $N; $i++){
                //Get Severity ID 
                /*$sev_sql = "SELECT * FROM severity WHERE severity = '$new_severity[$i]'";
                $sev_qry = $this->db->query($sev_sql);
                $num_row = $sev_qry->num_rows;
                $row = $sev_qry->fetch_assoc();
                $sev_id = $row['severity_id'];
                //Get Department ID 
                $dep_sql = "SELECT * FROM department WHERE department = '$new_department[$i]'";
                $dep_qry = $this->db->query($dep_sql);
                $num_row = $dep_qry->num_rows;
                $row = $dep_qry->fetch_assoc();
                $dep_id = $row['department_id'];
                */
                
                $updt_sql = "UPDATE helpdesk SET concerns = '$new_concern[$i]' WHERE id = '$id[$i]'";
                $updt_qry = $this->db->query($updt_sql);
                try{
                    if($updt_qry == true){
                        $_SESSION['msg'] = '<p style="color: #1EA926;">Successfully Updated. This page will be refreshed in 10seconds.</p>';
                        header("Refresh:10");
                    }
                    else{
                        $_SESSION['msg'] = '<b style="font-size: 20px;">Cant Updated!</b>';
                        throw new Exception($_SESSION['msg']);
                    }
                }
                catch(Exception $ex){
                    $_SESSION['msg'] = '<b style="color: red; font-size: 20px;"><span class="fa fa-exclamation-triangle"></span> WARNING:</b>  '.$ex->getMessage();
                }
            }
        }
    }   

?>
