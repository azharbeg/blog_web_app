
<?php
 require_once('incAdmin/topAdmin.php');

?>
<!---- if not login then it run---->
<?php
  /*if(!isset($_SESSION['username'])){
      header('Location: login.php');
  }*/
  ////////////////////////////

  //if role author we cant go user page
 /* else */  if(isset($_SESSION['username']) && $_SESSION['role'] == 'author'){
    header('Location: index.php'); // No authority to visit user's page..
  }
  ///////////////////////////////////////////
  ?>


<!--delet usesr ---->
<?php
    if(isset($_GET['del'])){
        $del_id = $_GET['del'];
      
        $del_check_query = "SELECT * FROM users WHERE id = $del_id";
        $del_check_run = mysqli_query($con, $del_check_query);
        if(mysqli_num_rows($del_check_run) > 0){

            $del_query =  "DELETE FROM `users` WHERE `users`.`id` = $del_id";
        
            // if we login through ADMIN we can't delet comment
            if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                if(mysqli_query($con, $del_query)){
                    $msg = "User has been deleted";
                }
                else{
                    $error = "User has not been deleted";
       
                }
            }

        }
        else{
            header('Location: index.php');
        }
 
    }

?>
<!---- form check ----->
<?php
if(isset($_POST['checkboxes'])){
    foreach($_POST['checkboxes'] as $user_id){
        $bulk_option1 = $_POST['bulk_option'];

        if($bulk_option1 == 'delete'){
            $bulk_del_query = "DELETE FROM `users` WHERE `users`.`id` = $user_id";

            mysqli_query($con, $bulk_del_query);

        }
        else if($bulk_option1 == 'author'){
            $bulk_author_query = "UPDATE `users` SET `role` = 'author' WHERE `users`.`id` = $user_id";
            mysqli_query($con, $bulk_author_query);

        }
        else if($bulk_option1 == 'admin'){
            $bulk_admin_query = "UPDATE `users` SET `role` = 'admin' WHERE `users`.`id` = $user_id";
            mysqli_query($con, $bulk_admin_query);
        }

    }
}
?>
 
<body>
  
 <div id="wrapper">

        <?php
        require_once('incAdmin/header.php');


        ?>

        <div class="container-fluid body-section">
            <div class="row">
                <div class="col-md-3">
                         <!---------sidebarr with badge start--------->
                         <?php
                          require_once('incAdmin/sidebar.php');


                          ?>

                </div>
                <div class="col-md-9">
                    <h1>  <i class="fas fa-users"></i> Users <small>View All Users</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fas fa-users"></i> Dashboard /&nbsp;&nbsp; </a></li>
                        <li class="active"><i class="fas fa-users"></i> Users</li>

                    </ol>
                </div>
              
                 <?php 

                 
                 $query = "SELECT * FROM users ORDER BY id DESC";
                 $run  = mysqli_query($con, $query);
                 if(mysqli_num_rows($run) > 0){


                ?>
                <form action="" method="post">
                 <div class="row">
                     <div class="col-sm-8">
                         
                             <div class="row">
                                 <div class="col-xs-4">
                                     <div class="form-group">
                                         <select name="bulk_option" id="" class="form-control">
                                             <option value="delete">Delete</option>
                                              <option value="author">Change to Author</option>
                                              <option value="admin">Change to admin</option>

                                         </select>
                                     </div><br>
                                 </div>
                                 
                                 <div class="col-xs-8">
                                     <input type="submit" class="btn btn-success" value="Apply">
                                     <a href="add_user.php" class="btn btn-primary">Add Users</a>
                                 </div>
                             </div>
                        
                     </div>
                 </div>
                 
                 <?php 
                 if(isset($error)){
                     echo "<span style='color:red;' class='pull-right'
                     >$error</span>";
                 }
                 else if(isset($msg)){
                    echo "<span style='color:green;' class='pull-right'
                    >$msg</span>";

                 }
                 ?>
                  
                 <table class="table table-bordered table-hover table-striped">
                     <thead>
                         <tr>
                             <th><input type="checkbox" id="selectallboxes"></th>
                             <th>Sr #</th>
                             <th>Date</th>
                             <th>Name</th>
                             <th>Username</th>
                             <th>Email</th>
                             <th>Image</th>
                             <th>Password</th>
                             <th>Role</th>
                            
                             <th>Edit</th>
                             <th>Delet</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php  
                           while($row = mysqli_fetch_array($run)){

                                $id = $row['id'];
                                $first_name = ucfirst($row['first_name']);
                                $last_name = ucfirst($row['last_name']);
                                $email = $row['email'];
                                $username = $row['username'];
                                $role = $row['role'];
                                $image = $row['image'];
                                $date = getdate($row['date']);

                                $day =  $date['mday'];
                                $month = substr($date['month'],0,3);                               
                                $year = $date['year'];

                               

                                ?>
                          
                         <tr>
                             <td><input type="checkbox " class="checkboxes"
                             name="checkboxes[]" value="<?php echo $id;?>"></td>
                             <td><?php echo $id;?></td>
                             <td><?php echo "$day $month $year";?></td>
                             <td><?php echo "$first_name $last_name";?></td>
                             <td><?php echo $username;?></td>
                             <td><?php echo $email;?></td>
                             <td><img src="image/<?php echo $image;?>" width="30px" alt="azhar"></td>
                             <td>*********</td>
                             <td><?php echo ucfirst($role);?></td>
                             
                             <td><a href="edit_user.php?edit=<?php echo $id;?>"><i class="fas fa-pencil-alt"></i></a></td>
                             <td><a href="users.php?del=<?php echo $id;?>"><i class="fas fa-times"></i></a></td>
                             
                         </tr>
                         <?php   }?>
                      
                     </tbody>
                 </table>
                 <?php  }
                 else{
                     echo "<center><h2>NO Users Available Now</h2></center>";
                 }

                 ?>
                  </form>
 
            </div>
        </div>

  </div>

  <?php
 require_once('incAdmin/footer.php');


  ?>  

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    -->
  

  </body>
  </html>

  
  