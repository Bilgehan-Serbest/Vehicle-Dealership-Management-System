<?php 
    include('config/db_connect.php');

    if(isset($_POST['remove_rent'])){    

        if (empty($_POST['rented_vehicle_id'])) {                
            $message = "Please select a rent to remove.";
            echo "<script type='text/javascript'>alert('$message');</script>";          
        }                   
        else {            
            $vehicle_id=$_POST['rented_vehicle_id'];            
            $sql = "UPDATE vehicles SET vehicles.owner_id=NULL WHERE vehicles.id='".$vehicle_id."'";
            echo "<script type='text/javascript'>alert('$sql');</script>";

            if (mysqli_query($conn,$sql)) {
                $message="The rent has been removed.";
            }
            else{
                $message="Error, the rent removal failed.";
            }     
            echo "<script type='text/javascript'>alert('$message');</script>";
            
            
            mysqli_close($conn);            
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="css/panel.css">
        <style>
            .form-group input, .form-group textarea{
                padding-left: 15px;
                background-color: #3E4B5B;
                color: white;                
            }                    
            .form-group input::placeholder, .form-group textarea::placeholder{
                color:white;
            }
            #first_name, #last_name, #email, #address{
                background-color: #3E4B5B;
                color:white;
            }    
            #register_client{
                background-color:#38CE3C;
                border-color:#38CE3C;
            }
        </style>
    </head>
    <body>              
        <?php include("header.php");?>
        <?php include("sidebar.php");?>      
        <div id="main-panel">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                <h1 class="card-title ">Rental List</h1>
                            </div> 
                            <form method="post" enctype="multipart/form-data">
                                <div class="table-responsive border rounded p-1">
                                    <table class="table">
                                    <thead>
                                        <tr>                            
                                        <th class="font-weight-bold">Client Name</th>
                                        <th class="font-weight-bold">Vehicle Brand</th>
                                        <th class="font-weight-bold">Vehicle Model</th>
                                        <th class="font-weight-bold">Vehicle Man. Year</th>
                                        <th class="font-weight-bold">Vehicle Transmission</th>
                                        <th class="font-weight-bold">Vehicle Fuel</th>
                                        <th class="font-weight-bold">Vehicle Mileage</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        <?php                            
                                            $sql = "SELECT clients.first_name, clients.last_name, vehicles.manufacturing_year, brands.name, vehicles.id, vehicles.model, vehicles.transmission_type, vehicles.fuel, vehicles.current_mileage FROM vehicles, brands, clients WHERE vehicles.brand_id=brands.id AND vehicles.owner_id = clients.id";                                         
                                            if($result = mysqli_query($conn, $sql)){
                                                if(mysqli_num_rows($result)>0){
                                                    while($row = mysqli_fetch_array($result))
                                                    {      
                                                    echo "<tr>";                            
                                                    echo "<td>" .  $row['first_name'] . " " . $row['last_name'] ."</td>";                                                
                                                    echo "<td>" .  $row['manufacturing_year'] . "</td>";
                                                    echo "<td>" .  $row['name'] . "</td>";
                                                    echo "<td>" .  $row['model'] . "</td>";  
                                                    echo "<td>" .  $row['transmission_type'] . "</td>";  
                                                    echo "<td>" .  $row['fuel'] . "</td>";  
                                                    echo "<td>" .  $row['current_mileage'] . "</td>";
                                                    echo "<td> <input type='radio' id='rented_vehicle_id' name='rented_vehicle_id' value='".$row['id']."'> </td>";                                                    
                                                    echo "</tr>";
                                                    }
                                                }
                                            }                          
                                        ?>                                    
                                    </tbody>
                                    </table>                                
                                </div>
                                <br/>
                                <div class="d-sm-flex align-items-auto mb-3">                      
                                    <input type='submit' class='btn btn-danger ml-auto btn-sm' id='remove_rent' name='remove_rent' value='Remove Rent'></button>
                                    <input type='button' class="btn btn-success ml-3 btn-sm" value='New Rental' onclick="location.href='rent_vehicle.php'"></button>
                                </div>                                 
                            </form>                                                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>