<?php 
    include('config/db_connect.php');

    if(isset($_POST['register_client'])){
        $required = array('first_name', 'last_name', 'email', 'address');
        
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
            $first_name=$_POST['first_name'];
            $last_name=$_POST['last_name'];
            $email=$_POST['email'];  
            $address=$_POST['address'];  


            $sql = "INSERT INTO clients(first_name, last_name, email, address) ". 
            "VALUES('$first_name','$last_name','$email','$address')";       
            if (mysqli_query($conn,$sql)) {
                $message="The client has been registered.";
            }
            else{
                $message="Error, the client register failed.";
            }     
            echo "<script type='text/javascript'>alert('$sql');</script>";
            
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
                                <h1 class="card-title ">Client List</h1>
                            </div> 
                            <div id="client_register_modal" class="modal" tabindex="-1" role="dialog">                           
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">                                        
                                            <h5 class="modal-title">Register Client</h5>;
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>                        
                                        <div class="modal-body">
                                            <div class="form-group">                          
                                                <form method="post" enctype="multipart/form-data">  
                                                    <input class="form-control" type="text" name="first_name" id="first_name" placeholder="First Name" />
                                                    <br/>
                                                    <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Last Name" />
                                                    <br/>
                                                    <input class="form-control" type="text" name="email" id="email" placeholder="E-mail" />     
                                                    <br/>
                                                    <textarea class="form-control" type="text" name="address" id="address" placeholder="Address"></textarea>
                                                    <div class="modal-footer ml-2">    
                                                        <input type="submit" class="btn btn-primary" id="register_client" value="Register" name="register_client"></button>
                                                        <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
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
                                    <th class="font-weight-bold">First Name</th>
                                    <th class="font-weight-bold">Last Name</th>
                                    <th class="font-weight-bold">E-Mail</th>
                                    <th class="font-weight-bold">Address</th>
                                    <th class="font-weight-italic">Edit/Delete</th>
                                    </tr>
                                </thead>
                                <tbody>                                    
                                    <?php                            
                                        $sql = "SELECT id, first_name, last_name, email, address FROM clients";                                         
                                        if($result = mysqli_query($conn, $sql)){
                                            if(mysqli_num_rows($result)>0){
                                                while($row = mysqli_fetch_array($result))
                                                {      
                                                echo "<tr>";                            
                                                echo "<td>" .  $row['first_name'] . "</td>";                                  
                                                echo "<td>" .  $row['last_name'] . "</td>"; 
                                                echo "<td>" .  $row['email'] . "</td>";
                                                echo "<td>" .  $row['address'] . "</td>";  
                                                echo "<td> &nbsp; &nbsp; <a class='far fa-edit' id='client_edit_option' href='edit_client.php?id=".$row['id']."'></a> &nbsp; <a class='far fa-trash-alt' id='client_edit_option' href='delete_client_prompt.php?id=".$row['id']."' ></a> </td>";  
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
                                    <button class="btn btn-success ml-auto btn-sm" data-toggle="modal" data-target="#client_register_modal">Client Register</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>