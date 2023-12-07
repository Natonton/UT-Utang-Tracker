<?php
    include "conn.php";
    session_start();
    
    //get admin info function
    function getAdmin($username, $password){
        global $conn;
        $get_admin = $conn->prepare("SELECT * FROM admin WHERE admin_username = ? AND admin_password = ?");
        $get_admin->bindParam(1, $username);
        $get_admin->bindParam(2, $password);
        $get_admin->execute();
        return $get_admin;
    }
    // add function
    function add($firstname, $lastname, $age, $number, $address, $balance){
        global $conn;
        $addNewDebtor = $conn->prepare("INSERT INTO debtors(debtor_firstname, debtor_lastname, debtor_age, debtor_number, debtor_address, debtor_balance) VALUES(?,?,?,?,?,?)");
        $addNewDebtor->bindParam(1, $firstname);
        $addNewDebtor->bindParam(2, $lastname);
        $addNewDebtor->bindParam(3, $age);
        $addNewDebtor->bindParam(4, $number);
        $addNewDebtor->bindParam(5, $address);
        $addNewDebtor->bindParam(5, $address);
        $addNewDebtor->bindParam(6, $balance);
        $addNewDebtor->execute();
        return $addNewDebtor;
    }
    //check if debtor exsists
    function checkDebtor($firstname, $lastname){
        global $conn;
        try{
            $check = $conn->prepare("SELECT * FROM debtors WHERE debtor_firstname = ? AND debtor_lastname = ?");
            $check->bindParam(1, $firstname);
            $check->bindParam(2, $lastname);
            $check->execute();
            return $check;
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    //edit debtor
    function editDebtor($debtorID, $firstname, $lastname, $age, $number, $address){
        global $conn;
        try{    
            $editDebtor = $conn->prepare("UPDATE debtors SET debtor_firstname = ?, debtor_lastname = ?, debtor_age = ?, debtor_number = ?, debtor_address = ? WHERE debtor_id = ?");
            $editDebtor->bindParam(1, $firstname);
            $editDebtor->bindParam(2, $lastname);
            $editDebtor->bindParam(3, $age);
            $editDebtor->bindParam(4, $number);
            $editDebtor->bindParam(5, $address);
            $editDebtor->bindParam(6, $debtorID);
            $editDebtor->execute();
            return $editDebtor;
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    //delete debtor
    function deleteDebtor($debtorID){
        global $conn;
        try{
            $delete_d = $conn->prepare("DELETE FROM debtors WHERE debtor_id = ?");
            $delete_d->bindParam(1, $debtorID);
            $delete_d->execute();
            return $delete_d;
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    //get current admin
    function getCurrentAdmin($adminID){
        global $conn;
        try{
            $getCurAdmin = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
            $getCurAdmin->bindParam(1, $adminID);
            $getCurAdmin->execute();
            $admin = $getCurAdmin->fetch();
            $info = [];
            if($admin){
                $adminUsername = $admin->admin_username;
                $adminPassword = $admin->admin_password;
                $info[] = [$adminUsername, $adminPassword];
            }
            return $info;
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    //get balance
    function balance($debtorID, $newBalance){
        global $conn;
        try{
            $updateBalance = $conn->prepare("UPDATE debtors SET debtor_balance = ? WHERE debtor_id = ?");
            $updateBalance->bindParam(1, $newBalance);
            $updateBalance->bindParam(2, $debtorID);
            $updateBalance->execute();
            return $updateBalance;
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    // time stamp
    function timeStamp(){
        $timezone = "Asia/Manila";
        date_default_timezone_set($timezone);
        setlocale(LC_TIME, "en_US");
        // $current_datetime = date('m-d-Y H:i:s');
        $current_datetime = date('Y/d/m l H:i:s');
        return $current_datetime;
    }
    // add history
    function addToHistory($history_adminName =  null, $history_debtorName =  null, $history_debtorID =  null, $history_item =  null, $history_note =  null, $history_action =  null, $history_newBal =  null, $history_remarks =  null, $history_dateTime = null){
        global $conn;
        try{
            $addHistory = $conn->prepare("INSERT INTO history (history_adminName, history_debtorName, history_debtorID, history_item, history_note, history_action, history_newBal, history_remarks, history_dateTime) VALUES(?,?,?,?,?,?,?,?,?)");
            $addHistory->bindParam(1, $history_adminName);
            $addHistory->bindParam(2, $history_debtorName);
            $addHistory->bindParam(3, $history_debtorID);
            $addHistory->bindParam(4, $history_item);
            $addHistory->bindParam(5, $history_note);
            $addHistory->bindParam(6, $history_action);
            $addHistory->bindParam(7, $history_newBal);
            $addHistory->bindParam(8, $history_remarks);
            $addHistory->bindParam(9, $history_dateTime);
            $addHistory->execute();
            return $addHistory;
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    //clear history
    function clearHistory($debtorID){
        global $conn;
        try{
            $clear = $conn->prepare("DELETE FROM history WHERE history_debtorID = ?");
            $clear->bindParam(1, $debtorID);
            $clear->execute();
            return $clear;
        }
        catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    //admin login
    if(isset($_POST['adminLogin'])){
        try{
            $get_username = $_POST['e_username'];
            $get_password = $_POST['e_password'];
            $get_result = getAdmin($get_username, $get_password);
            $get_row_count = $get_result->rowCount();
            if($get_row_count > 0 ){
                $_SESSION['adminName'] = $get_username;
                ?>
                    <script>
                        alert("LOGIN SUCCESS");
                        window.location.href="admin_home.php";
                    </script>
                <?php
            }
            else{
                ?>
                    <script>
                        alert("LOGIN FAILED");
                        window.location.href="index.php";
                    </script>
                <?php
            }
        }
        catch(PDOException $e){
            die("Error: " . $e->getMessage());
        }
    }
    // add new debtors
    if(isset($_POST['addNewDebtor'])){
        $firstname =strtoupper($_POST['fname']);
        $lastname = strtoupper($_POST['lname']);
        $age = strtoupper($_POST['age']);
        $number = strtoupper($_POST['number']);
        $address = strtoupper($_POST['address']);
        $balance = 0;
        $check = checkDebtor($firstname, $lastname);
        $checkRow = $check->rowCount();
        if($checkRow > 0){
            ?>
                <script>
                    alert("DEBTOR ALREADY EXISTS");
                    window.location.href="debtors.php";
                </script>
            <?php
        }
        else{
            $addDebtor = add($firstname, $lastname, $age, $number, $address, $balance);
            $count_add = $addDebtor->rowCount();

            if($count_add > 0){
                ?>
                    <script>
                        alert("NEW DEBTOR SUCCESSFULLY ADDED");
                        window.location.href="debtors.php";
                    </script>
                <?php
            }
            else{
                ?>
                    <script>
                        alert("NEW DEBTOR FAILED TO ADD");
                        window.location.href="debtors.php";
                    </script>
                <?php
            }
        }
    }
    // edit debtor
    if(isset($_POST['saveChanges'])){
        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
        $age = $_POST['age'];
        $number = $_POST['number'];
        $address = $_POST['address'];
        $debtorID = $_GET['debtorID'];
        
        $edit = editDebtor($debtorID, $firstname, $lastname, $age, $number, $address);
        $count_edit = $edit->rowCount();

        if($count_edit > 0){
            ?>
                <script>
                    alert("Success");
                    window.location.href="debtors.php";
                </script>
            <?php
        }
        else{
            ?>
                <script>
                    alert("Success");
                    window.location.href="debtors.php";
                </script>
            <?php
        }
    }
    //delete debtor
    if(isset($_POST['confirmDelete'])){
        $adminID = $_POST['adminID'];
        $username = $_POST['adminUsername'];
        $password = $_POST['adminPassword'];
        $getAdmin = getCurrentAdmin($adminID);
        foreach($getAdmin as $admin){
            $adminUsername = $admin[0];
            $adminPassword = $admin[1];
        }
        if($adminUsername === $username && $adminPassword === $password){
            $balance = intval($_POST['debtorBalance']);
            if($balance == 0){
                $debtorID = $_GET['debtorID'];
                $delete_d = deleteDebtor($debtorID);
                $delete_r = $delete_d->rowCount();
                if($delete_r > 0){
                    ?>
                    <script>
                        alert("Successfully Deleted");
                        window.location.href="debtors.php";
                    </script>
                <?php
                }
            }
            else{
                ?>
                    <script>
                        alert("Operation can't proceed, BALANCE: <?php echo $balance?>");
                        window.location.href="debtors.php";
                    </script>
                <?php
            }
        }
        else{
            ?>
                <script>
                    alert("Wrong Admin Username or Password");
                    window.location.href="debtors.php";
                </script>
            <?php
        }
    }
    //minus balance
    if(isset($_POST['proceedMinus'])){
        $adminID = $_GET['adminID'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $getAdmin = getCurrentAdmin($adminID);
        foreach($getAdmin as $admin){
            $adminUsername = $admin[0];
            $adminPassword = $admin[1];
        }
        if($username === $adminUsername && $password === $adminPassword){
            $debtorID = $_GET['debtorID'];
            $debtorBalance = intval($_POST['balance']);
            $ammount = intval($_POST['ammount']);
            $newBalance = $debtorBalance - $ammount;
            if($ammount > $debtorBalance){
                ?>
                    <script>
                        alert("Invalid deduction ammount");
                        window.location.href="debtors.php";
                    </script>
                <?php
            }
            else{
                $minus = balance($debtorID, $newBalance);
                $adminName = $_GET['adminName'];
                $debtorName = $_GET['debtorName'];
                $time = timeStamp();
                $note = $_POST['note'];
                $action = "-$ammount";
                $rminus = $minus->rowCount();
                if($rminus > 0){
                    $addToHistory = addToHistory($adminName, $debtorName, $debtorID, null, $note, $action, $newBalance, "DEDUCT BALANCE", $time);
                    ?>
                        <script>
                            alert("Deduction Succeed");
                            window.location.href="debtors.php";
                        </script>
                    <?php
                }
                else{
                    ?>
                        <script>
                            alert("Deduction Failed");
                            window.location.href="debtors.php";
                        </script>
                    <?php
                }
            }
        }
        else{
            ?>
                <script>
                    alert("WRONG ADMIN USERNAME OR PASSWORD");
                    window.location.href="debtors.php";
                </script>
            <?php
        }
    }
    //add balance
    if(isset($_POST['proceedAdd'])){
        $balance = intval($_POST['balance']);
        $adminName = $_GET['adminName'];
        $debtorName = $_GET['debtorName'];
        $item =$_POST['item'];
        $add=intval($_POST['ammount']);
        $newBalance = $balance + $add;
        $action = "+$add";
        $debtorID = $_GET['debtorID'];
        $note = $_POST['note'];
        $remarks = "ADD BALANCE";
        $time = timeStamp();
        $addbal = balance($debtorID, $newBalance);
        $countbal = $addbal->rowCount();
        if($countbal > 0){
            $history = addToHistory($adminName, $debtorName, $debtorID, $item, $note ,$action, $newBalance, $remarks, $time);
            ?>
                <script>
                    alert("Add Succeed");
                    window.location.href="debtors.php";
                </script>
            <?php
        }
        else{
            ?>
                <script>
                    alert("Add Failed");
                    window.location.href="debtors.php";
                </script>
            <?php
        }
    }
    //clear history
    if(isset($_POST['clearHistory'])){
        $balance = intval($_POST['balance']);
        // echo var_dump($balance);
        if($balance == 0){
            $debtorID = $_GET['debtorID'];
            $clear = clearHistory($debtorID);
            $clear_c = $clear->rowCount();
            if($clear_c > 0){
                ?>
                    <script>
                        alert("History Cleared");
                        window.location.href="debtors.php";
                    </script>
                <?php
            }
            else{
                ?>
                    <script>
                        alert("ERROR! Please try again.");
                        window.location.href="debtors.php";
                    </script>
                <?php
            }
        }
        else{
            ?>
                    <script>
                        alert("Operation can't proceed. REMAINING BALANCE: <?php echo $balance; ?>");
                        window.location.href="debtors.php";
                    </script>
                <?php
        }
    }
?>