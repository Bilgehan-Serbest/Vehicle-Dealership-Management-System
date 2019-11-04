<?php 
    include('config/db_connect.php');
    $main_car_table_qry = "SELECT vehicles.id, brands.name, brands.brand_logo_path, vehicles.model, vehicles.body_type, vehicles.transmission_type, vehicles.fuel, vehicles.current_mileage, vehicles.manufacturing_year, vehicles.traction, vehicles.horsepower FROM vehicles JOIN brands ON vehicles.brand_id = brands.id WHERE vehicles.owner_id IS NULL";

    if(isset($_POST['rent_vehicle'])){        

        if (empty($_POST['client_selection'])) {                
            $message = "Please select a client to rent the vehicle to.";
            echo "<script type='text/javascript'>alert('$message');</script>";          
        }                   
        else {            
            $vehicle_id=$_POST['vehicle_to_rent_id'];
            $client_id = $_POST['client_selection'];

            $sql = "UPDATE vehicles SET owner_id='".$client_id."' WHERE id='".$vehicle_id."'";
            if (mysqli_query($conn,$sql)) {
                $message="The vehicle has been rented.";
            }
            else{
                $message="Error, the vehicle rent failed.";
            }     
            echo "<script type='text/javascript'>alert('$message');</script>";
            
            mysqli_close($conn);

            header("location: manage_rentals.php");
            exit();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="css/panel.css">
        <style>
            .form-group input{
                padding-left: 15px;
                background-color: #3E4B5B;
                color: white;                
            }            
            .form-group input::placeholder{
                color:white;
            } 
            .far{
                cursor: pointer; 
            }
            #client_selection{
                width:75%;  
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
                                <h1 class="card-title ">Vehicles Available For Rental</h1>
                            </div>
                            <form method="post" enctype="multipart/form-data">
                                <div class="btn-group">
                                    <label for="client_selection">Select Client: </label>
                                    <select id="client_selection" name="client_selection" class="selectpicker form-control btn-dark btn-sm">      
                                        <option value="">Clients</option>                                  
                                            <?php                                                                 
                                                $sql = "SELECT clients.id, clients.first_name, clients.last_name FROM clients";    
                                                if($result = mysqli_query($conn, $sql)){
                                                    if(mysqli_num_rows($result)>0){
                                                        while($row = mysqli_fetch_array($result))
                                                        {
                                                            echo '<option value="'. $row['id'] . '" >' . $row['first_name'] . " " . $row['last_name'] .  '</a>';                                                  
                                                        }
                                                    }
                                                }                    
                                            ?>
                                    </select> 
                                </div> 
                                <br/>
                                <br/>                            
                                <div class="table-responsive border rounded p-1">
                                    <table class="table">
                                        <thead>
                                            <tr>                            
                                            <th class="font-weight-bold">Brand</th>
                                            <th class="font-weight-bold">Model</th>
                                            <th class="font-weight-bold">Body Type</th>                             
                                            <th class="font-weight-bold">Transmission</th>                                                      
                                            <th class="font-weight-bold">Fuel</th>                                                      
                                            <th class="font-weight-bold">Current Mileage(km)</th>                                                      
                                            <th class="font-weight-bold">Manufacturing Year</th>                                                      
                                            <th class="font-weight-bold">Traction</th>
                                            <th class="font-weight-bold">Horsepower</th>
                                            <th class="font-weight-italic">Select Vehicle</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                            <?php                            
                                                $sql = $main_car_table_qry;                                         
                                                if($result = mysqli_query($conn, $sql)){
                                                    if(mysqli_num_rows($result)>0){
                                                        while($row = mysqli_fetch_array($result))
                                                        {      
                                                        echo "<tr>";
                                                        echo "<td>" . " <img src='".$row['brand_logo_path'] . "'/> &nbsp;" . $row['name'] . "</td>";
                                                        echo "<td>" .  $row['model'] . "</td>"; 
                                                        echo "<td>" .  $row['body_type'] . "</td>";
                                                        echo "<td>" .  $row['transmission_type'] . "</td>";
                                                        echo "<td>" .  $row['fuel'] . "</td>";
                                                        echo "<td>" .  number_format($row['current_mileage']) . "</td>";
                                                        echo "<td>" .  $row['manufacturing_year'] . "</td>";
                                                        echo "<td>" .  $row['traction'] . "</td>";
                                                        echo "<td>" .  $row['horsepower'] . "</td>";
                                                        echo "<td> <input type='radio' id='vehicle_to_rent_id' name='vehicle_to_rent_id' value='".$row['id']."'> </td>";
                                                        echo "</tr>";
                                                        }
                                                    }
                                                }                          
                                            ?>                                    
                                        </tbody>
                                    </table>
                                    <div class="d-sm-flex align-items-auto mb-3">
                                        <input type="submit" class='btn btn-success ml-auto btn-sm' id='rent_vehicle' name='rent_vehicle' value='Rent Selected Vehicle'></button>
                                    </div>    
                                </div> 
                            </form>
                        </div>                                        
                    </div>              
                </div>                
            </div> 
        </div>               
    </body>
</html>
