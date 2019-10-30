<?php 
    include('config/db_connect.php');
    $body_types = array("Sedan", "Hatchback", "Coupe", "Minivan", "Station Wagon", "Pickup");
    $transmission_types = array("Automatic", "Semi-Automatic", "Manual", "Tiptronic");
    $fuel_types = array("Gasoline", "Diesel", "Liquified Petroleum", "Compressed Natural Gas", "Hybrid", "Electricity");
    $traction_types = array("AWD", "FWD", "RWD", "4WD");
    $vehicle_to_edit="";

    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);        

        $sql ="SELECT vehicles.id, brands.name, brands.brand_logo_path, vehicles.model, vehicles.body_type, vehicles.transmission_type, vehicles.fuel, vehicles.current_mileage, ".
        "vehicles.manufacturing_year, vehicles.traction, vehicles.horsepower FROM vehicles JOIN brands ON vehicles.brand_id = brands.id WHERE vehicles.id=$id";        

        $result = mysqli_query($conn, $sql);

        $vehicle_to_edit=mysqli_fetch_assoc($result);

        // mysqli_free_result($result);   
    }

    if(isset($_POST['update_vehicle'])){     
        $vehicle_id=$vehicle_to_edit['id'];
        $brand=$_POST['brand_selection'];
        $brand_id = "";
        $model=$_POST['vehicle_model'];
        $body_type=$_POST['body_type_selection'];
        $transmission=$_POST['transmission_selection'];
        $fuel=$_POST['fuel_selection'];
        $mileage=$_POST['mileage'];
        $manufacturing_year=$_POST['manufacturing_year'];
        $traction=$_POST['traction_selection'];
        $horsepower=$_POST['horsepower'];

        // echo "<script type='text/javascript'>alert('$body_type');</script>";

        $sql_brand_id_fetcher = "SELECT id FROM brands WHERE name='$brand'";
        if($result = mysqli_query($conn, $sql_brand_id_fetcher)){
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result);
                $brand_id = $row['id'];                                      
            }
        }

        $sql = "UPDATE vehicles SET body_type='".$body_type."', model='".$model."', transmission_type='".$transmission."', fuel='".$fuel."', current_mileage='".$mileage."', manufacturing_year='".$manufacturing_year."', ".
        "horsepower='".$horsepower."', traction='".$traction."', brand_id='".$brand_id."' WHERE id='".$vehicle_id."'";

        if (mysqli_query($conn,$sql)) {
            $message="The vehicle has been updated.";            
        }
        else{
            $message="Error, the vehicle update failed.";
        }             
        echo "<script type='text/javascript'>alert('$sql');</script>";
        
        mysqli_close($conn);  
        header("location: manage_vehicles.php");
		exit();      
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
            #brand_selection, #body_type_selection, #transmission_selection, #fuel_selection, #traction_selection{
                width: 40%;
            }  
            #vehicle_model, #mileage, #manufacturing_year, #horsepower{
                background-color: #3E4B5B;
                color:white;
                width: 40%;
            }           
            .form-group input::placeholder{
                color:white;
            }         
            .form-group{
                padding-left:5%;
            }    
            label {
                display: flex;
                flex-direction: row; 
                justify-content: flex-end; 
                text-align: left;
                width: 800px;
                line-height: 26px;
                margin-bottom: 20px;
            }
            input {
                height: 50px;
                flex: 0 0 150px;
                margin-top:15px;
                margin-left: 10px;
            }
            .far{
                cursor: pointer; 
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
                                <?php if($vehicle_to_edit):?>
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <h1 class="card-title ">Edit Vehicle</h1>
                                    </div> 
                                    <div>
                                        <h2><?php echo htmlspecialchars("Editing " .$vehicle_to_edit['name'] . " " . $vehicle_to_edit['model']) ?></h2>
                                        <br/>
                                        <div class="form-group">                          
                                                <form method="post" enctype="multipart/form-data">                                                      
                                                    <label for="brand_selection">Brand:  
                                                        <select name="brand_selection" id="brand_selection" class="selectpicker form-control btn-dark btn-sm">      
                                                            <option value="">Brand</option>                                  
                                                                <?php                                                                 
                                                                    $sql = "SELECT brands.name FROM brands";    
                                                                    if($result = mysqli_query($conn, $sql)){
                                                                        if(mysqli_num_rows($result)>0){
                                                                            while($row = mysqli_fetch_array($result))
                                                                            {
                                                                                if($row['name'] == $vehicle_to_edit['name']){
                                                                                    echo '<option value="'. $row['name'] . '" selected="selected" >' . $row['name'] . '</a>';                                                      
                                                                                }else{
                                                                                    echo '<option value="'. $row['name'] . '" >' . $row['name'] . '</a>';                                                  
                                                                                }
                                                                            }
                                                                        }
                                                                    }                    
                                                                ?>
                                                        </select>    
                                                    </label>                                                                                                      
                                                    <br/>   
                                                    <label for="vehicle_model">Model: <input class="form-control" type="text" name="vehicle_model" id="vehicle_model" value=<?php echo($vehicle_to_edit['model']);?> placeholder="Model" /> </label>                                                                                                                                                      
                                                    <br/>
                                                    <label for="body_type_selection">Body Type: 
                                                        <select name="body_type_selection" id="body_type_selection" class="selectpicker form-control btn-dark btn-sm">  
                                                            <option value="">Body Type</option>   
                                                            <?php 
                                                                foreach($body_types as $body_type){
                                                                    if($body_type == $vehicle_to_edit['body_type']){
                                                                        echo("<option value='". $body_type . "' selected='selected' >" . $body_type . "</a>"); 
                                                                    }else{
                                                                        echo(" <option value='".$body_type."'>" .$body_type. "</option>");
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </label> 
                                                    <br/>
                                                    <label for="transmission_selection">Trasmission:                                              
                                                        <select name="transmission_selection" id="transmission_selection" class="selectpicker form-control btn-dark btn-sm">  
                                                            <option value="">Transmission</option>   
                                                            <?php 
                                                                foreach($transmission_types as $transmission_type){
                                                                    if($transmission_type == $vehicle_to_edit['transmission_type']){
                                                                        echo("<option value='". $transmission_type . "' selected='selected' >" . $transmission_type . "</a>"); 
                                                                    }else{
                                                                        echo(" <option value='".$transmission_type."'>" .$transmission_type. "</option>");
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </label>  
                                                    <br/>
                                                    <label for="fuel_selection">Fuel:                                               
                                                        <select name="fuel_selection" id="fuel_selection" class="selectpicker form-control btn-dark btn-sm">  
                                                            <option value="">Fuel</option>   
                                                            <?php 
                                                                foreach($fuel_types as $fuel_type){
                                                                    if($fuel_type == $vehicle_to_edit['fuel']){
                                                                        echo("<option value='". $fuel_type . "' selected='selected' >" . $fuel_type . "</a>"); 
                                                                    }else{
                                                                        echo(" <option value='".$fuel_type."'>" .$fuel_type. "</option>");
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </label> 
                                                    <br/>
                                                    <label for="mileage">Current Mileage: <input class="form-control" type="text" name="mileage" id="mileage" value=<?php echo($vehicle_to_edit['current_mileage']);?> placeholder="Mileage" /> </label>                                                                                                                                                      
                                                    <br/>
                                                    <label for="manufacturing_year">Manufacturing Year: <input class="form-control" type="text" name="manufacturing_year" id="manufacturing_year" value=<?php echo($vehicle_to_edit['manufacturing_year']);?> placeholder="Manufacturing Year" /> </label>
                                                    <br/>
                                                    <label for="traction_selection">Traction:                                                
                                                        <select name="traction_selection" id="traction_selection" value=<?php echo($vehicle_to_edit['traction']);?> class="selectpicker form-control btn-dark btn-sm">  
                                                            <option value="">Traction</option>  
                                                            <?php 
                                                                foreach($traction_types as $traction_type){
                                                                    if($traction_type == $vehicle_to_edit['traction']){
                                                                        echo("<option value='". $traction_type . "' selected='selected' >" . $traction_type . "</a>"); 
                                                                    }else{
                                                                        echo(" <option value='".$traction_type."'>" .$traction_type. "</option>");
                                                                    }
                                                                }
                                                            ?> 
                                                        </select>
                                                    </label>
                                                    <br/>
                                                    <label for="horsepower">Horsepower: <input class="form-control" type="text" name="horsepower" id="horsepower" value=<?php echo($vehicle_to_edit['horsepower']);?> placeholder="Horsepower" /> </label>                                                                                                                                                      
                                                    <div class="modal-footer ml-2">    
                                                        <input type="submit" class="btn btn-primary" id="update_vehicle" value="Update" name="update_vehicle"></button>
                                                        <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form> 
                                        </div>                                    
                                    </div>
                                <?php else: ?>
                                    <h5>No Such Vehicle Exists</h5>
                                <?php endif; ?>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>            
    </body>
</html>
