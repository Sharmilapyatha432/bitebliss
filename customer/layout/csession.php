<?php
session_start();
if (!isset($_SESSION["customer"])) {
    header("Location: ../customer/viewfooditem.php");
    exit();
} else {
    $cid = $_SESSION["customer"]; 
   

    
}
?>