<?php 
    include('config/db_connect.php');
    $client_to_edit="";

    if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn, $_GET['id']);        

        $sql ="SELECT clients.id, clients.first_name, clients.last_name, clients.email, clients.address FROM clients WHERE clients.id=$id";        

        $result = mysqli_query($conn, $sql);

        $client_to_edit=mysqli_fetch_assoc($result);

        // $message=$client_to_edit['address'];
        // echo "<script type='text/javascript'>alert('$message');</script>";
    }

    if(isset($_POST['update_client'])){     
        $client_id=$client_to_edit['id'];
        $first_name=$_POST['first_name'];
        $last_name=$_POST['last_name'];
        $email=$_POST['email'];
        $address=$_POST['address'];

        $sql = "UPDATE clients SET first_name='".$first_name."', last_name='".$last_name."', email='".$email."', address='".$address."' WHERE id='".$client_id."'";

        if (mysqli_query($conn,$sql)) {
            $message="The client has been updated.";            
        }
        else{
            $message="Error, the client update failed.";
        }             
        echo "<script type='text/javascript'>alert('$sql');</script>";
        
        mysqli_close($conn);  
        header("location: manage_clients.php");
		exit();      
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
                                <?php if($client_to_edit):?>
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <h1 class="card-title ">Edit Client</h1>
                                    </div> 
                                    <div>
                                        <h3><?php echo htmlspecialchars("Editing " .$client_to_edit['first_name'] . " " . $client_to_edit['last_name']) ?></h2>
                                        <br/>
                                        <div class="form-group">                          
                                                <form method="post" enctype="multipart/form-data">      
                                                    <label for="first_name">First Name: <input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo($client_to_edit['first_name']);?>" placeholder="First Name" /> </label>
                                                    <br/>
                                                    <label for="last_name">Last Name: <input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo($client_to_edit['last_name']);?>" placeholder="Last Name" /> </label>
                                                    <br/>
                                                    <label for="email">E-mail: <input class="form-control" type="text" name="email" id="email" value="<?php echo($client_to_edit['email']);?>" placeholder="E-Mail" /> </label>
                                                    <br/>
                                                    <label for="address">Address: <textarea class="form-control" type="text" name="address" id="address" placeholder="Address"><?php echo($client_to_edit['address']);?></textarea> </label>
                                                    <div class="modal-footer ml-2">    
                                                        <input type="submit" class="btn btn-primary" id="update_client" value="Update" name="update_client"></button>
                                                        <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form> 
                                        </div>                                    
                                    </div>
                                <?php else: ?>
                                    <h5>No Such Client Exists</h5>
                                <?php endif; ?>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>            
    </body>
</html>