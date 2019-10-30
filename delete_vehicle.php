<?php 
    include('config/db_connect.php');

    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);        

        $sql ="DELETE FROM vehicles WHERE vehicles.id=$id";        

        $delete_result = mysqli_query($conn, $sql);   

        if (mysqli_query($conn,$sql)) {
            $message="The vehicle has been deleted.";                        
        }
        else{
            $message="Error, the vehicle deletion failed.";
        }             
        echo "<script type='text/javascript'>alert('$message');</script>";    
        mysqli_close($conn);  
        header("location: manage_vehicles.php");
		exit(); 
               
    }
?>
