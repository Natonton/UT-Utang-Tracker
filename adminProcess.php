<?php
    include "conn.php";
    include_once "inc/function.php";
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;


    require 'inc/PHPMailer/src/PHPMailer.php';
    require 'inc/PHPMailer/src/Exception.php';
    require 'inc/PHPMailer/src/SMTP.php';
    session_start();
    

    //admin login
    if(isset($_POST['adminLogin'])){
        try{
            $get_username = $_POST['e_username'];
            $get_password = $_POST['e_password'];
            $get_result = verAdmin($get_username, $get_password);
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
    //edit admin
    if(isset($_POST['editAdmin'])){
        $adminID = $_GET['adminID'];
        $picName = $_FILES['pp']['name'];
        $tempName = $_FILES['pp']['tmp_name'];
        $newAdminName = $_POST['fullName'];
        $cur = getCurrentAdmin($adminID);
        foreach ($cur as $adminName){
            $adminUsername = $adminName[0];
        }
        $edit = editAdmin($newAdminName, $picName, $adminID);
        if($edit > 0 ){
            $des = 'assets/img/'.$picName;
            move_uploaded_file($tempName, $des);
            // echo var_dump($des);
            ?>
                <script>
                    alert("Edit Succeed");
                    window.location.href="admin-profile.php";
                </script>
            <?php
        }
        else{
            ?>
                <script>
                    alert("Edit Failed");
                    window.location.href="admin-profile.php";
                </script>
            <?php
        }

    }
    //change password admin
    if(isset($_POST['changePW'])){
        $curpass = $_POST['password'];
        $adminUsername = $_GET['adminUsername'];
        $ver = verAdmin($curpass, $adminUsername);
        $countVer = $ver->rowCount();
        if($countVer > 0 ){
            $newPW = $_POST['newpassword'];
            $change = changeAdminPW($newPW, $adminUsername);
            $countChange = $change->rowCount();
            if($countChange > 0){
                ?>
                    <script>
                        alert("PASSWORD CHANGED SUCCESSFULLY");
                        window.location.href="admin-profile.php";
                    </script>
                <?php
            }
        }
        else{
            ?>
                <script>
                    alert("WRONG CURRENT PASSWORD");
                    window.location.href="admin-profile.php";
                </script>
            <?php
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
    //notify thru sms
    if(isset($_POST['notify'])){
        $number = $_POST['number'];
        $messagee = $_POST['message'];

        $service_plan_id = "5103d9ee24154b8db545db030b847884";
        $bearer_token = "bc552468af7f4031b86eb8bce2df45b6";

        //Any phone number assigned to your API
        $send_from = "+447520651367";
        //May be several, separate with a comma ,
        $recipient_phone_numbers = $number; 
        // $message = "Test message to {$recipient_phone_numbers} from {$send_from}";

        // Check recipient_phone_numbers for multiple numbers and make it an array.
        if(stristr($recipient_phone_numbers, ',')){
        $recipient_phone_numbers = explode(',', $recipient_phone_numbers);
        }else{
        $recipient_phone_numbers = [$recipient_phone_numbers];
        }

        // Set necessary fields to be JSON encoded
        $content = [
        'to' => array_values($recipient_phone_numbers),
        'from' => $send_from,
        'body' => $messagee
        ];

        $data = json_encode($content);

        $ch = curl_init("https://us.sms.api.sinch.com/xms/v1/{$service_plan_id}/batches");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
        curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $bearer_token);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            // echo $result;
            ?>
                <script>
                    alert("Notification successfully sent");
                    window.location.href="debtors.php";
                </script>
            <?php
        }
        curl_close($ch);
        
    }
    //notify thru email
    if(isset($_POST['emailnotif'])){
        $debtorEmail = $_POST['email'];
        $messageSubject = "UTANG MO";
        $message = $_POST['message'];


        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'utanng.proj@gmail.com';
        $mail->Password = 'njfyvvwdccoplomr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('utanng.proj@gmail.com');
        $mail->addAddress($debtorEmail);
        $mail->isHTML(true);
        $mail->Subject = $messageSubject;
        $mail->Body = $message;

        if ($mail->send()) {
            ?>
                <Script>
                    alert("Message sent");
                    window.location.href="debtors.php";
                </Script>
            <?php
        } else {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

    }
?>