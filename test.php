<?php
    include "conn.php";
    session_start();
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
            $adminInfo[] = [$adminID, $adminName, $adminUsername];
        }
        return $adminInfo;
    }


    try{
        if(empty($_SESSION)){
            ?>
                <script>
                    alert("Session expired, please login again");
                    window.location.href="index.php";
                </script>
            <?php
        }
        else{
            $sessionName = $_SESSION['adminName'];

            $adminDetails = getAdminInfo($conn, $sessionName);
            foreach($adminDetails as $details){
                $adminName = $details[1];
            }
        }
    }
    catch(PDOException $e){
        die("Error: " . $e->getMessage());
    }
?>