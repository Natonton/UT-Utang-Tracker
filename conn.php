
<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "uti";

    $dsn = "mysql:host=$host;dbname=$dbname";

    try {
        $conn = new PDO($dsn, $user, $password);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        // echo "Connected to the database successfully!";
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>