<?php 
    $conn = mysqli_connect('localhost', 'root', 'admin', 'project');

    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }
?>