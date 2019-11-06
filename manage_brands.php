<?php 
  include('config/db_connect.php');  

  if(isset($_POST['addBrand'])){    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));    

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {     
      $uploadOk = 1;
    } else {   
      $uploadOk = 0;
    }    

    if (file_exists($target_file)) {
      $message =  "Sorry, file already exists.";
      echo "<script type='text/javascript'>alert('$message');</script>";
      $uploadOk = 0;
    }
    if ($_FILES["fileToUpload"]["size"] > 500000) {
      $message = "Sorry, your file is too large.";
      echo "<script type='text/javascript'>alert('$message');</script>";
      $uploadOk = 0;
    }  
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
      $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      echo "<script type='text/javascript'>alert('$message');</script>";
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          $brand_name=$_POST['brand_name'];
          $brand_logo_path = $target_file;
          $sql = "INSERT INTO brands(name,brand_logo_path) VALUES('$brand_name','$brand_logo_path')";
          
          if (mysqli_query($conn,$sql)) {
            $message = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";          
          } else {
            $message = "Sorry, there was an error uploading your file.";
          }          
          mysqli_close($conn);
      } else {
        $message = "Sorry, there was an error uploading your file.";
      }
      echo "<script type='text/javascript'>alert('$message');</script>";
      } 
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="css/panel.css">
        <style>
            input::placeholder {
            color: blue;
            font-size: 1.4em;
            font-style: bold;
            }
            .form-group input{
                padding-left: 15px;                
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
                      <h4 class="card-title">Vehicle Brands Available</h4>
                    </div>  
                    <div class="d-sm-flex align-items-auto mb-3">                                                                 
                      <button class="btn btn-success ml-auto btn-sm" data-toggle="modal" data-target="#brandModal">Add New Brand</button>
                    </div>   
                    <div id="brandModal" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Brand</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <div class="form-group">                          
                            <form method="post" enctype="multipart/form-data">  
                                <label for="Brand_Name">Brand Name:</label>                            
                                <input class="form-control" name="brand_name" id="brand_name" /> 
                                <br/>                                                  
                                <label for="fileToUpload">Brand Logo:</label>                         
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <div class="modal-footer">                              
                                <input type="submit" class="btn btn-primary" value="Add" name="addBrand"></button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form> 
                            </div>
                            </div>                       
                            </div>
                        </div>
                    </div>                       
                    <div class="table-responsive border rounded p-1">
                      <table class="table">
                        <thead>
                          <tr>                            
                            <th class="font-weight-bold">Brand</th>                             
                            <th class="font-weight-bold">Number of Vehicles In Stock</th>                                                      
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $sql = "SELECT brands.name, brands.brand_logo_path, count(vehicles.brand_id) as vehicles_in_stock FROM brands LEFT JOIN vehicles on (brands.id = vehicles.brand_id) GROUP BY brands.name";
                            if($result = mysqli_query($conn, $sql)){
                              if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_array($result))
                                {      
                                  echo "<tr>";                            
                                  echo "<td>" . " <img src='".$row['brand_logo_path'] . "'/> &nbsp;" . $row['name'] . "</td>";                                  
                                  echo "<td>" . $row['vehicles_in_stock'] . "</td>";                                  
                                  echo "</tr>";
                                }
                              }
                            }                          
                          ?>
                        </tbody>
                      </table>
                    </div> 
                    <br/>                                                  
                </div>              
            </div>
        </div>        
    </body>
</html>