
<?php
 require_once('incAdmin/topAdmin.php');

// if not login then it run---->

 /*if(!isset($_SESSION['username'])){
     header('Location: login.php');
 }   */
 /////////////////////////////

 //if role author we cant go user page
 /*else */  if(isset($_SESSION['username']) && $_SESSION['role'] == 'author'){
    header('Location: index.php'); // No authority to visit user's page..
  }
  ///////////////////////////////////////////
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
                    <h1>  <i class="fas fa-user-plus"></i> Add User <small>Add New Users</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fas fa-users"></i> Dashboard /&nbsp;&nbsp; </a></li>
                        <li class="active"><i class="fas fa-user-plus"></i>Add New User</li>

                    </ol>

                    <?php 
                     if(isset($_POST['submit'])){
                         $date = time();
                         $first_name = mysqli_real_escape_string($con,$_POST['first-name']);             
                         $last_name = mysqli_real_escape_string($con,$_POST['last-name']);
                         $username = mysqli_real_escape_string($con,strtolower($_POST['username']));
                         $username_trim =  preg_replace('/\s/','',$username); // avoid space in the username feild
                         $email =     mysqli_real_escape_string($con, strtolower($_POST['email']));
                         $password = mysqli_real_escape_string($con,$_POST['password']);
                         $role = $_POST['role'];
                         $image = $_FILES['image']['name'];
                         $image_tmp = $_FILES['image']['tmp_name'];


                         // find duplicate username and email
                         $check_query = "SELECT * FROM users WHERE username = '$username
                          or email = '$email' ";   
                          $check_run = mysqli_query($con, $check_query);
                        /////////////////////////////////////////////////

                        // salt query (user table attribute)
                        $salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                        $salt_run = mysqli_query($con, $salt_query);
                        $salt_row = mysqli_fetch_array($salt_run);
                        $salt = $salt_row['salt'];

                     //   $password = crypt($password, $salt);  // passward ko crypt(aise kr dia ki koi pd na ske)


                         if(empty($first_name) or empty($last_name) or empty($username)
                         or empty($email) or empty($password) or empty($image)){
                             $error = "All (*) feilds are required";
                         }
                         else if($username != $username_trim){
                             $error = "Don't Use spaces in Username";

                         }
                         else if(mysqli_num_rows($check_run) > 0){
                             $error = "Username And Email Already Exist";
                         }
                         else{
                             $insert_query = "INSERT INTO `users` (`id`, `date`, 
                             `first_name`, `last_name`, `username`, `email`, 
                             `image`, `password`, `role`) 
                             VALUES (NULL, '$date', '$first_name', '$last_name', 
                             '$username', '$email', '$image', 
                             '$password', '$role')";
                                 if(mysqli_query($con,$insert_query)){
                                     $msg = "User Has Been Added";
                                    
                                     move_uploaded_file($image_tmp, "image/$image"); // image move to admin image folder(bcoz we reterive image from any location of our computer)
                                    // check image
                                    $image_check = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                                    $image_run = mysqli_query($con, $image_check);
                                    $image_row = mysqli_fetch_array($image_run);
                                    $check_image = $image_row['image'];

                                    // data submit hone ke baad usko null krenge
                                    // kyoki 1 field wrong hone pr baki ka hmara data save rhta h
                                    $first_name = "";     
                                    $last_name = "";
                                    $username = "";
                                    $email  = "";

                                    }
                                 else{
                                       $error = "User Has Not Been Added";
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
                             value="<?php if(isset($first_name)){echo $first_name;}?>" 
                                 placeholder="First-Name">

                            </div>

                            <div class="form-group">
                                <label for="last-name">Last Name:*</label>
                                <input type="text" id="last-name" name="last-name" class="form-control" value="<?php if(isset($last_name)){echo $last_name;}?>"  placeholder="Last-Name">
                            </div>

                            <div class="form-group">
                                <label for="usesrname">Username:*</label>
                                <input type="text" id="username" name="username" class="form-control" 
                                value="<?php if(isset($username)){echo $username;}?>"  placeholder="Username">
                            </div>

                            <div class="form-group">
                                <label for="email">Email:*</label>
                                <input type="text" id="email" name="email" class="form-control"
                                value="<?php if(isset($email)){echo $email;}?>"  placeholder="Email Address">
                            </div>

                            <div class="form-group">
                                <label for="password">Password:*</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>

                            <div class="form-group">
                                <label for="role">Role:*</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="author">Author</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Profile Picture:*</label><br>
                                <input type="file" id="image" name="image">
                            </div><br>

          

                            <input type="submit" value="Add User" name="submit" class="btn btn-primary">
                         </form>
                    </div>
                        <div class="col-md-4">
                            <?php 
                            if(isset($check_image)){
                                echo "<img src= 'image/$check_image' width= '100%'>";
                            }
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

  
  