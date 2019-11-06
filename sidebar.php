<?php 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <style>
      #sidebar{
        position:fixed;
        height: 100%;
        z-index: 1; /* Stay on top */        
        left: 0;
        overflow-x: hidden; 
      }      
    </style>
  </head>
  <body>
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
        <br/>
        <br/>
        <br/>
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="profile-image">
                <img class="img-xs rounded-circle" src=<?php echo($_SESSION['profile_picture_path']);?> alt="profile image">
                <div class="dot-indicator bg-success"></div>
              </div>
              <div class="text-wrapper">
                <p class="profile-name"><?php echo($_SESSION['user_first_name'] ." ". $_SESSION['user_last_name']) ?></p>
                <p class="designation">Administrator</p>
              </div>                               
            </a>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Vehicle Management</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage_brands.php">
              <span class="menu-title">Manage Brands</span>
              <i class="fas fa-copyright menu-icon"></i>
              </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage_vehicles.php">
              <span class="menu-title">Manage Vehicles</span>                
              <i class="fas fa-car menu-icon"></i>                
              </a>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Client Management</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage_clients.php">
              <span class="menu-title">Manage Client Info</span>
              <i class="fas fa-users menu-icon"></i>
            </a>              
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage_rentals.php">
              <span class="menu-title">Manage Rentals</span>
              <i class="fas fa-clipboard-list menu-icon"></i>
            </a>              
          </li>                               
        </ul>
      </nav>        
  </body>
</html>