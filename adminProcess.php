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
            echo var_dump($debtorBalance);
            echo var_dump($ammount);
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
                $rminus = $minus->rowCount();
                if($rminus > 0){
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
    if(isset($_POST['proceedAdd'])){
        $balance = intval($_POST['balance']);
        $add=intval($_POST['ammount']);
        $newBalance = $balance + $add;
        $debtorID = $_GET['debtorID'];
        $addbal = balance($debtorID, $newBalance);
        $countbal = $addbal->rowCount();
        if($countbal > 0){
            echo "yey";
        }
        else{
            echo "yogs";
        }
    }
?>