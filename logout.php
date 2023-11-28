<?php
    include "conn.php";
    session_start();
    session_destroy();
?>
<script>
    alert("YOU'VE LOGGED OUT");
    window.location.href="index.php";
</script>