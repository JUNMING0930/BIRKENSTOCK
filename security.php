<?php

    if(!isset($_SESSION['ID']))
    {
        header("Location: index.php");
    }
?>