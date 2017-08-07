<?php
session_start();

if(!isset($_SESSION['loggedin'])) {
    echo "<script>window.location.href='login.php'</script>";
}?>