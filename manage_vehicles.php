<?php 
    include('config/db_connect.php');
    
    $main_car_table_qry="";
    
    $body_type_selector = <<<EOD
        <select name="body_type_selection" class="selectpicker form-control btn-dark btn-sm">  
            <option value="">Body Type</option>   
            <option> Sedan </option>
            <option> Hatchback </option>
            <option> Coupe </option>
            <option> Minivan </option>
            <option> Station Wagon </option>
            <option> Pickup </option>  
        </select>
    EOD;
    $transmission_selector = <<<EOD
        <select name="transmission_selection" class="selectpicker form-control btn-dark btn-sm">  
            <option value="">Transmission</option>   
            <option> Automatic </option>
            <option> Semi-Automatic </option>
            <option> Manual </option>
            <option> Tiptronic </option>
        </select>
    EOD;

    $fuel_selector = <<<EOD
        <select name="fuel_selection" class="selectpicker form-control btn-dark btn-sm">  
            <option value="">Fuel</option>   
            <option> Gasoline </option>
            <option> Diesel </option>
            <option> Liquified Petroleum </option>
            <option> Compressed Natural Gas </option>
            <option> Hybrid </option>
            <option> Electricity </option>
        </select>
    EOD;

    $mileage_selector = <<<EOD
        <select name="mileage_selection" class="selectpicker form-control btn-dark btn-sm">  
            <option value="">Current Mileage(km)</option>   
            <option value="BETWEEN 0 AND 10000"> 0-10.000 </option>
            <option value="BETWEEN 10000 AND 50000"> 10.000-50.000 </option>
            <option value="BETWEEN 50000 AND 100000"> 50.000-100.000 </option>
            <option value=">=100000"> 100.000+ </option>
        </select>
    EOD;
    $vehicle_age_selector = <<<EOD
        <select name="vehicle_age_selection" class="selectpicker form-control btn-dark btn-sm">  
            <option value="">Vehicle Age</option>   
            <option value="0,2"> 0-2 </option>
            <option value="2,5"> 2-5 </option>
            <option value="5,7"> 5-7 </option>
            <option value="7,10"> 7-10 </option>
            <option value="10,15"> 10-15 </option>
            <option value=">=15"> 15+ </option>
        </select>
    EOD;
    $traction_selector = <<<EOD
        <select name="traction_selection" class="selectpicker form-control btn-dark btn-sm">  
            <option value="">Traction</option>   
            <option> AWD </option>
            <option> FWD </option>
            <option> RWD </option>
            <option> 4WD </option>
        </select>
    EOD;
    $horsepower_selector = <<<EOD
        <select name="horsepower_selection" class="selectpicker form-control btn-dark btn-sm">  
            <option value="">Horsepower</option>   
            <option value="BETWEEN 0 AND 50"> 0-50 HP </option>
            <option value="BETWEEN 50 AND 75"> 50-75 HP </option>
            <option value="BETWEEN 75 AND 100"> 75-100 HP </option>
            <option value="BETWEEN 100 AND 200"> 100-200 HP </option>
            <option value="BETWEEN 200 AND 300"> 200-300 HP </option>
            <option value="BETWEEN 300 AND 400"> 300-400 HP </option>
            <option value="BETWEEN 400 AND 500"> 400-500 HP </option>
            <option value=">=500"> 500+ HP </option>
        </select>
    EOD;

    if(isset($_POST['apply_filter'])){
        $required = array('brand_selection', 'body_type_selection','transmission_selection', 'fuel_selection', 'mileage_selection', 'vehicle_age_selection', 'traction_selection', 'horsepower_selection');        

        $error = false;
        foreach($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        if ($error) {
            $message = "All fields are required.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $main_car_table_qry = "SELECT brands.name, brands.brand_logo_path, vehicles.model, vehicles.body_type, vehicles.transmission_type, vehicles.fuel, vehicles.current_mileage, vehicles.manufacturing_year, vehicles.traction, vehicles.horsepower FROM vehicles JOIN brands ON vehicles.brand_id = brands.id";                
        }else{            
            if($_POST['vehicle_age_selection'] == ">=15"){
                $mnf_year_qry = "<= " . (date('Y') - $_POST['vehicle_age_selection']);
            }else{
                $mnf_year_option_array = explode(",", $_POST['vehicle_age_selection']);
                $mnf_year_qry = "BETWEEN " . (date('Y') - $mnf_year_option_array[1]) . " AND " . (date('Y') - $mnf_year_option_array[0]);
            }            
            $brand=$_POST['brand_selection'];
            $brand_id = "";            
            $body_type=$_POST['body_type_selection'];
            $transmission=$_POST['transmission_selection'];
            $fuel=$_POST['fuel_selection'];
            $mileage=$_POST['mileage_selection'];
            $traction=$_POST['traction_selection'];
            $horsepower=$_POST['horsepower_selection'];                        

            $main_car_table_qry = "SELECT brands.name, brands.brand_logo_path, vehicles.model, vehicles.body_type, vehicles.transmission_type, vehicles.fuel, vehicles.current_mileage, vehicles.manufacturing_year, vehicles.traction, vehicles.horsepower ".
            "FROM vehicles JOIN brands ON vehicles.brand_id = brands.id ".
            "WHERE (name='$brand') AND (body_type='$body_type') AND (transmission_type='$transmission') AND (fuel='$fuel') AND (current_mileage $mileage) AND (manufacturing_year $mnf_year_qry) AND (traction='$traction') AND (horsepower $horsepower)";                                              
        }
    }
    else{
        $main_car_table_qry = "SELECT brands.name, brands.brand_logo_path, vehicles.model, vehicles.body_type, vehicles.transmission_type, vehicles.fuel, vehicles.current_mileage, vehicles.manufacturing_year, vehicles.traction, vehicles.horsepower FROM vehicles JOIN brands ON vehicles.brand_id = brands.id";        
    }

    

    if(isset($_POST['addVehicle'])){
        $required = array('brand_selection', 'vehicle_model', 'body_type_selection','transmission_selection', 'fuel_selection', 'mileage', 'manufacturing_year', 'traction_selection', 'horsepower');
        
        $error = false;
        foreach($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        if ($error) {
            $message = "All fields are required.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        
        } else {            
            // mysqli_close($conn);
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

            $sql_brand_id_fetcher = "SELECT id FROM brands WHERE name='$brand'";
            if($result = mysqli_query($conn, $sql_brand_id_fetcher)){
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result);
                    $brand_id = $row['id'];                                      
                }
              }
            // mysqli_close($conn);

            $sql = "INSERT INTO vehicles(body_type,model,transmission_type,fuel,current_mileage,manufacturing_year,horsepower,traction,brand_id) 
            VALUES('$body_type','$model','$transmission','$fuel','$mileage','$manufacturing_year','$horsepower','$traction','$brand_id')";       
            if (mysqli_query($conn,$sql)) {
                $message="The vehicle has been added to the database.";
            }
            else{
                $message="Error, the vehicle register failed.";
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
            .form-group input{
                padding-left: 15px;
                background-color: #3E4B5B;
                color: white;                
            }                
            #vehicle_model, #mileage, #manufacturing_year, #horsepower{
                background-color: #3E4B5B;
                color:white;
            }           
            .form-group input::placeholder{
                color:white;
            }                                         
            #apply_filter{
                background-color: #FF9300;
                border-color:  #FF9300;
            }
            #add{
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
                                <h1 class="card-title ">Vehicles Available</h1>
                            </div> 
                            <div id="vehiclemodal" class="modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add New Vehicle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>                        
                                        <div class="modal-body">
                                            <div class="form-group">                          
                                                <form method="post" enctype="multipart/form-data">  
                                                    <select name="brand_selection" class="selectpicker form-control btn-dark btn-sm">      
                                                        <option value="">Brand</option>                                  
                                                            <?php 
                                                                $sql = "SELECT brands.name FROM brands";    
                                                                if($result = mysqli_query($conn, $sql)){
                                                                    if(mysqli_num_rows($result)>0){
                                                                        while($row = mysqli_fetch_array($result))
                                                                        {
                                                                            echo '<option value="'. $row['name'] . '" >' . $row['name'] . '</a>';                                                  
                                                                        }
                                                                    }
                                                                }                    
                                                            ?>
                                                    </select>  
                                                    <br/>                                                 
                                                    <input class="form-control" type="text" name="vehicle_model" id="vehicle_model" placeholder="Model" />                                                                                                  
                                                    <br/>
                                                    <?php echo($body_type_selector) ?>
                                                    <br/>
                                                    <?php echo($transmission_selector) ?>
                                                    <br/>
                                                    <?php echo($fuel_selector) ?>
                                                    <br/>
                                                    <input class="form-control" type="text" name="mileage" id="mileage" placeholder="Mileage" />                                                                                                  
                                                    <br/>
                                                    <input class="form-control" type="text" name="manufacturing_year" id="manufacturing_year" placeholder="Manufacturing Year" />                                                                                                  
                                                    <br/>
                                                    <?php echo($traction_selector) ?>
                                                    <br/>
                                                    <input class="form-control" type="text" name="horsepower" id="horsepower" placeholder="Horsepower" />                                                                                                  

                                                    <div class="modal-footer ml-2">                                                                                  
                                                        <input type="submit" class="btn btn-primary" id="addVehicle" value="Add" name="addVehicle"></button>
                                                        <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form> 
                                            </div>
                                        </div>                       
                                    </div>
                                </div>
                            </div> 
                            <div>   
                                <h4>Filtering Options</h5>                                                
                                <br/>
                                    <form method="post" enctype="multipart/form-data">  
                                        <div class="btn-group">                                                        
                                            <select name="brand_selection" class="selectpicker form-control btn-dark btn-sm">      
                                                <option value="brand">Brand</option>                                  
                                                    <?php 
                                                        $sql = "SELECT brands.name FROM brands";    
                                                        if($result = mysqli_query($conn, $sql)){
                                                            if(mysqli_num_rows($result)>0){
                                                                while($row = mysqli_fetch_array($result))
                                                                {
                                                                    echo '<option value="'. $row['name'] . '" >' . $row['name'] . '</a>';                                                  
                                                                }
                                                            }
                                                        } 
                                                    ?>
                                            </select>  
                                        </div>
                                        <div class="btn-group">
                                            <?php echo($body_type_selector) ?>
                                        </div> 
                                        <div class="btn-group">
                                            <?php echo($transmission_selector) ?>
                                        </div> 
                                        <div class="btn-group">
                                            <?php echo($fuel_selector) ?>
                                        </div> 
                                        <div class="btn-group">
                                            <?php echo($mileage_selector) ?>
                                        </div> 
                                        <div class="btn-group">
                                            <?php echo($vehicle_age_selector) ?>
                                        </div>
                                        <div class="btn-group">
                                            <?php echo($traction_selector) ?>
                                        </div> 
                                        <div class="btn-group">
                                            <?php echo($horsepower_selector) ?>
                                        </div> 
                                        <div class="btn-group ml-3">
                                            <input type="submit" class="btn btn-info mr-auto" id="apply_filter" name="apply_filter" value="Apply Filter"></button>
                                        </div> 
                                    </form>  
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
                                                echo "<td>" .  $row['current_mileage'] . "</td>";                                  
                                                echo "<td>" .  $row['manufacturing_year'] . "</td>";                                  
                                                echo "<td>" .  $row['traction'] . "</td>";                                  
                                                echo "<td>" .  $row['horsepower'] . "</td>";                                  
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
                                    <button class="btn btn-success ml-auto btn-sm" data-toggle="modal" data-target="#vehiclemodal">Add New Vehicle</button>
                                </div> 
                            <br/>                                      
                        </div>        
                        </div>                
                    </div>              
                </div>
            </div> 
        </div>       
    </body>
</html>