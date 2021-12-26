<?php

$session_role2 = $_SESSION['role'];
$session_username2 = $_SESSION['username'];


?>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">Azhar | Admin</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto  ">

            
            <li class="nav-item">
                    <a class="nav-link" href="#">Welcome:<i class="fas fa-user"></i><?php echo ucfirst($session_username2);?> </a>
                  </li>

                <li class="nav-item">
                    <a class="nav-link" href="add_post.php"><i class="fas fa-folder-plus"></i>Add Post</a>
                  </li>
      <!--------------- if admin login then below code show ,if author login then not show -->
                  <?php
                        if($SESSION_role2 == 'admin'){

                  ?>


              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="add_user.php"><i class="fas fa-user-plus"></i>Add User</a>
              </li>

              <?php  }  ?>



              <li class="nav-item">
                <a class="nav-link" href="profile.php"><i class="fas fa-user-alt"></i> Profile</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fas fa-power-off"></i> Logout</a>
              </li>
            </ul>
          
          </div>
        </div>
    </nav>