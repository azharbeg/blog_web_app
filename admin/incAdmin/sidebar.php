<?php

$session_role1 = $_SESSION['role'];

/// to fatch the pending comments comment by user
$get_comment = "SELECT * FROM comments WHERE status = 'pending'";
$get_comment_run = mysqli_query($con, $get_comment);
$num_of_rows = mysqli_num_rows($get_comment_run);

?>

<div class="list-group">
                      
                      <a href="index.php" class="list-group-item active">
                          <i class="fas fa-users"></i> Dashboard
                      </a>
                      <ol class="list-group list-group-numbered">
                         <a href="posts.php"> <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                              <div class="fw-bold"><i class="fas fa-portrait"></i> All Posts</div>
                            
                            </div>
                        </a>
                          </li>

                          <a href="media.php"><li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                              <div class="fw-bold"><i class="fas fa-database"></i> Media</div>
                            </a>
                             
                            </div>
                           </li>
      <!--------------- if admin login then below code show ,if author login then not show -->

                          <?php

                          if($session_role1 == 'admin'){
 
                          ?>

                          <a href="comments.php"><li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                              <div class="fw-bold"><i class="fas fa-comments"></i> Comments</div>
                            </a>
                             
                            </div>

                            <!-- to fetch the comment -->
                            <?php
                               if($num_of_rows > 0){
                                echo "<span class='badge bg-primary rounded-pill'>$num_of_rows</span>";

                               }

                            ?>
                          </li>
                          
                          <li class="list-group-item d-flex justify-content-between align-items-start">
                            <a href="category.php">
                            <div class="ms-2 me-auto">
                              <div class="fw-bold"><i class="fas fa-certificate"></i> Categories</div></a>
                              
                            </div>
                           </li>

                          <li class="list-group-item d-flex justify-content-between align-items-start">
                          <a href="users.php">
                              <div class="ms-2 me-auto">
                                <div class="fw-bold"><i class="fas fa-users"></i> Users</div></a>
                                 
                              </div>
                              
                              <?php   } ?>


                             </li>
                        </ol>
                  </div>