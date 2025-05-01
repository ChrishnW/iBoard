<?php 
    include('../include/connect.php');

    if(mysqli_ping($conn)){
        echo 'Connected';
    }
    else{
        echo 'Disconnected';
    }
?>