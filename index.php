<?php 
   
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="css/panel.css">
    </head>
    <body>              
        <?php include("header.php");?>
        <?php include("sidebar.php");?> 
        <div id="main-panel">
            <h1>Welcome, <?php echo($_SESSION['user_first_name'] . " " . $_SESSION['user_last_name']);?></h1>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        </div>  
                    </div>
                </div>
            </div>
        </div>                
    </body>
</html>