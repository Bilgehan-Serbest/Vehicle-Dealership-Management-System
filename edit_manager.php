<?php 
    include('config/db_connect.php');
    session_start();
    $user_first_name = $_SESSION['user_first_name'];
    $user_last_name = $_SESSION['user_last_name'];
    $user_email = $_SESSION['user_email'];
    $user_picture = $_SESSION['profile_picture_path'];
    $user_id = $_SESSION['user_id'];

    if(isset($_POST['update_profile'])){    
        $target_dir = "images/faces/";
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
            $manager_first_name=$_POST['first_name'];
            $manager_last_name=$_POST['last_name'];
            $manager_email=$_POST['email'];              
            $profile_picture_path = $target_file;
            $sql = "UPDATE managers SET first_name='".$manager_first_name. "', last_name='".$manager_last_name."', email='".$manager_email."', profile_picture_path='".$profile_picture_path."' WHERE id='".$user_id."'";
            
            if (mysqli_query($conn,$sql)) {
            $message = "The profile has been updated.";          
            } else {
            $message = "Sorry, there was an error updating your profile.";
            }          
            mysqli_close($conn);
          } else {
            $message = "Sorry, there was an error updating your profile.";
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
            .form-group input{
                padding-left: 15px;
                background-color: #3E4B5B;
                color: white;                
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
                                    <h1 class="card-title ">Edit Profile</h1>
                                </div> 
                                <div>
                                    <div class="form-group">                          
                                            <form method="post" enctype="multipart/form-data">                                                    
                                                <label for="first_name">First Name: <input class="form-control" type="text" name="first_name" id="first_name" value=<?php echo($user_first_name);?> placeholder="First Name" /> </label>                                                    
                                                <br/>
                                                <label for="last_name">Last Name: <input class="form-control" type="text" name="last_name" id="last_name" value=<?php echo($user_last_name);?> placeholder="Last Name" /> </label>
                                                <br/>
                                                <label for="email">E-mail: <input class="form-control" type="text" name="email" id="email" value=<?php echo($user_email);?> placeholder="E-mail" /> </label>
                                                <br/>
                                                <label for="fileToUpload">Profile Picture: <input class="form-control" type="file" name="fileToUpload" id="fileToUpload"/></label>                                                
                                                <br/>
                                                <div class="modal-footer ml-2">    
                                                    <input type="submit" class="btn btn-primary" id="update_profile" value="Update" name="update_profile"></button>
                                                    <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                                                </div>
                                            </form> 
                                    </div>                                    
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>            
    </body>
</html>
