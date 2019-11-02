<?php 
include('config/db_connect.php');

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);  
        
    echo "<script>javascript:
    var ask = confirm('Are you sure to remove this client?');
    if(ask==true)
    {
        window.location = 'delete_client.php?id=".$id."';  
    }
    else
    {
        window.location = 'manage_clients.php';  
    }
    </script>";
}

?>