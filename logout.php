<?php
session_start();
if(isset($_POST['logout']))
{
    session_destroy();
    unset($_SESSION['Name']);
    header("location: index.php");
    exit;
}

?>