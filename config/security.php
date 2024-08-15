<?php
if (!isset($_SESSION['ADMINID']) || empty($_SESSION['ADMINID'])) 
{
    header('location:./index.php?msg=err');
    exit();
}
?>