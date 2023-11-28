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

    // add new debtors
    if(isset($_POST['addNewDebtor'])){
        $firstname =strtoupper($_POST['fname']);
        $lastname = strtoupper($_POST['lname']);
        $age = strtoupper($_POST['age']);
        $number = strtoupper($_POST['number']);
        $address = strtoupper($_POST['address']);

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
            $addDebtor = add($firstname, $lastname, $age, $number, $address);
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
?>