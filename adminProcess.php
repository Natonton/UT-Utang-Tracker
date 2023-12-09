<?php
    include "conn.php";
    include "inc/function.php";
    session_start();
    

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