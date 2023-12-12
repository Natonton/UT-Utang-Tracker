<?php
    include "conn.php";
    //get admin info function
    function verAdmin($username, $password){
        global $conn;
        $get_admin = $conn->prepare("SELECT * FROM admin WHERE admin_username = ? AND admin_password = ?");
        $get_admin->bindParam(1, $username);
        $get_admin->bindParam(2, $password);
        $get_admin->execute();
        return $get_admin;
    }
    // getting all admin info
    function getAdminInfo($conn, $adminUsername){
        $getAdmin = $conn->prepare("SELECT * FROM admin WHERE admin_username = ? ");
        $getAdmin->bindParam(1, $adminUsername);
        $getAdmin->execute();
        $infos = $getAdmin->fetchAll();
        $adminInfo = [];
        foreach($infos as $info){
            $adminID = $info->admin_id;
            $adminName = $info->admin_name;
            $adminUsername = $info->admin_username;
            $adminPic = $info->admin_pic;
            $adminInfo[] = [$adminID, $adminName, $adminUsername, $adminPic];
        }
        return $adminInfo;
    }
    //change admin password
    function changeAdminPW($newPass, $adminUsername){
        try{
            global $conn;
            $change = $conn->prepare("UPDATE admin SET admin_password = ? WHERE admin_username = ? ");
            $change->bindParam(1, $newPass);
            $change->bindParam(2, $adminUsername);
            $change->execute();
            return $change;
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    //edit admin info
    function editAdmin($admin_name, $admin_pic, $admin_id){
        global $conn;
        try{
            $edit = $conn -> prepare("UPDATE admin SET admin_name = ?, admin_pic = ? WHERE admin_id = ?");
            $edit->bindParam(1, $admin_name);
            $edit->bindParam(2, $admin_pic);
            $edit->bindParam(3, $admin_id);
            $edit->execute();
            $count = $edit->rowCount();
            return $count;
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
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
                $adminName =$admin->admin_name;
                $info[] = [$adminUsername, $adminPassword, $adminName];
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
    function getAllDebtorsInfo($conn){
        $getDebtors = $conn->prepare("SELECT * FROM debtors");
        $getDebtors->execute();
        $infos = $getDebtors->fetchAll();
        $debtorsInfo = [];
        foreach($infos as $debtor){
            $d_id = $debtor->debtor_id;
            $d_firstname = $debtor->debtor_firstname;
            $d_lastname = $debtor->debtor_lastname;
            $d_age = $debtor->debtor_age;
            $d_number = $debtor->debtor_number;
            $d_address = $debtor->debtor_address;
            $d_balance = $debtor->debtor_balance;
            $debtorsInfo[] = [$d_id, $d_firstname, $d_lastname, $d_age, $d_number, $d_address, $d_balance]; 
        }
        return $debtorsInfo;
    }
    function viewHistory($debtorID){
        global $conn;
        try{
            $view = $conn->prepare("SELECT * FROM history WHERE history_debtorID = ? ORDER BY history_dateTime DESC");
            $view->bindParam(1, $debtorID);
            $view->execute();
            $viewHis = $view->fetchAll();
            $info = [];
            foreach($viewHis as $view){
                $hisID = $view->history_id;
                $debtorName = $view->history_debtorName;
                $action = $view->history_action;
                $item = $view->history_item;
                $note = $view->history_note;
                $newBal = $view->history_newBal;
                $adminName = $view->history_adminName;
                $dateTime = $view->history_dateTime;
                $info[] = [$debtorName, $action, $item, $note, $newBal, $adminName, $dateTime, $hisID];
                }
                return $info;
            }
            catch(PDOException $e){
                die("Error: " . $e->getMessage());
            }
    }
?>
