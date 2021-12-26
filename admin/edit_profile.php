
<?php
 require_once('incAdmin/topAdmin.php');

// if not login then it run---->

 /*if(!isset($_SESSION['username'])){
     header('Location: login.php');
 }  
 
 // dusre user ki id open na ho
 $session_username = $_SESSION['username'];
 
 */
 /////////////////////////////

 //if role author we cant go user page
/* else if(isset($_SESSION['username']) && $_SESSION['role'] == 'author'){
    header('Location: index.php'); // No authority to visit user's page..
  }  */
  ///////////////////////////////////////////

  if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = "SELECT  * FROM users WHERE id = '$edit_id'";
      $edit_query_run = mysqli_query($con, $edit_query);
      if(mysqli_num_rows($edit_query_run) > 0){
          $edit_row = mysqli_fetch_array($edit_query_run);
         
         // Apni id m rhte huye dusre user ki id open na kr ske , so we apply below condition
         $e_username = $edit_row['username'];
                
                if($e_username = $session_username){  // dusre user ki id open na ho

                    $e_first_name = $edit_row['first_name'];
                    $e_last_name = $edit_row['last_name'];
                    $e_image = $edit_row['image'];
                    $e_details = $edit_row['details'];
                }
                else{
                    header('Location:index.php');
                }
        
 
      }
      else{
          header('Location: index.php');
      }
  }
  else{
      header('Locatio: index.php');
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
                    <h1>  <i class="fas fa-user-plus"></i> Edit User <small>Edit Users Details</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fas fa-users"></i> Dashboard /&nbsp;&nbsp; </a></li>
                        <li class="active"><i class="fas fa-user-plus"></i>Edit User</li>

                    </ol>

                    <?php 
                     if(isset($_POST['submit']))
                     {
                         $first_name = mysqli_real_escape_string($con,$_POST['first-name']);             
                         $last_name = mysqli_real_escape_string($con,$_POST['last-name']);
                           $password = mysqli_real_escape_string($con,$_POST['password']);
                         $image = $_FILES['image']['name'];
                         $image_tmp = $_FILES['image']['tmp_name'];
                         $details = mysqli_real_escape_string($con,$_POST['details']);             


                         if(empty($image))
                         {
                             $image = $e_image;

                         }


                     

                        // salt query (user table attribute)
                        $salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                        $salt_run = mysqli_query($con, $salt_query);
                        $salt_row = mysqli_fetch_array($salt_run);
                        $salt = $salt_row['salt'];

                        $insert_password = crypt($password, $salt);  // passward ko crypt(aise kr dia ki koi pd na ske)


                           if(empty($first_name) or empty($last_name)  
                            or empty($image))
                           {
                                 $error = "All (*) feilds are required";
                           }
           
                         else{
 
                                $update_query = "UPDATE `users` SET `first_name` = '$first_name', 
                                `last_name` = '$last_name', `image` = '$image',
                                'details' = '$details' ";

                                  if(isset($password))
                                  {
                                    $update_query .= ",'password' = '$insert_password'";

                                  }

                                  // JB hum update kr rhe hai user ko
                                  $update_query .= " WHERE `users`.`id` = $edit_id";
                                  if(mysqli_query($con,$update_query))
                                  {
                                      $msg = "User Has been updated";
                                      header("refresh:0; url=edit_profile.php?edit=$edit_id");

                                      if(!empty($image))
                                      {
                                          move_uploaded_file($image_tmp,"image/$image" );
                                      }


                                  }
                                  else
                                  {
                                      $error ="Sorry! User has not been updated ";
                                  }
                                
                             }
                                
                     }
                
                
                     ?>
                    <div class="row">
                        <div class="col-md-8">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="first-name">First Name:*</label>
                                <?php
                                    if(isset($error)){
                                        echo "<span class='pull-right' sytle='color:red;'>$error</span>"; // span not working
                                    }
                                    else if(isset($msg)){
                                        echo "<span class='pull-right' sytle='color:green; font-weight:bold'>$msg</span>";  // span not working
                                    }

                                ?>
                                <input type="text" id="first-name" name="first-name" class="form-control"
                             value="<?php echo $e_first_name;?>" 
                                 placeholder="First-Name">

                            </div>

                            <div class="form-group">
                                <label for="last-name">Last Name:*</label>
                                <input type="text" id="last-name" name="last-name" class="form-control" value="<?php echo $e_last_name;?>"  placeholder="Last-Name">
                            </div>
 

                             

                            <div class="form-group">
                                <label for="password">Password:*</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

       

                            <div class="form-group">
                                <label for="image">Profile Picture:*</label><br>
                                <input type="file" id="image" name="image">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="details">Details:*</label><br>
                                <textarea   id="details" name="details" cols="30" rows="10" class="form_control">
                                    <?php echo $e_details?>
                                </textarea>
                            </div>

          

                            <input type="submit" value="Update User" name="submit" class="btn btn-primary">
                         </form>
                    </div>
                        <div class="col-md-4">
                            <?php 
                           
                                echo "<img src= 'image/$e_image' width= '100%'>";
                           
                            ?>
                        </div>
                    </div>
                </div>
            
 
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

  
  