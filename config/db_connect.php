<?php 

    $conn = mysqli_connect('localhost', 'car_dealer', 'x8ZnpTG3QbnEqX4E', 'car_dealership');

    if(!$conn){
        echo 'Connection Error: ' . mysqli_connect_error();
    }
?>