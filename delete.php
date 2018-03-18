<?php
//Our Php Code Will Be Goes Here.
$id = $_GET['id'];
$id = (int) $id;
$connection = mysqli_connect('localhost','root','','sample_db');
if ($connection == false){
    echo mysqli_connect_errno();
    exit();
}else{
    $sql = "DELETE FROM users WHERE id='$id'";
    $stmt = mysqli_query($connection,$sql);
    if ($stmt == false){
        echo mysqli_error($connection);
        exit();
    }else{
        header('Location:view.php');
    }
}


?>