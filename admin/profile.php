
<?php
 require_once('incAdmin/topAdmin.php');

 session_start();
 // after login check (if are login or not)
 // if YES then redirect index page
 // if NO then redirect login page
 
 /*if(!isset($_SESSION['username'])){
   header('Location: login.php');

 }   */
//////////////////////
$session_username = $_SESSION['username'];

$query = " SELECT * FROM users WHERE username = '$session_username'";
$run = mysqli_query($con,$query );
$row = mysqli_fetch_array($run);

$image = $row['image'];
$id = $row['id'];
$date = getdate($row['date']);
$day = $date['mday'];
$month = substr($date['month'],0,3);
$year = $date['year'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$username = $row['username'];
$email = $row['email'];
$role = $row['role'];
$details = $row['details'];

?>

  <body id="profile">
  
 <div id="wrapper">

   <?php
     require_once('incAdmin/header.php'); ?>


        <div class="container-fluid body-section">
            <div class="row">
                <div class="col-md-3">
                <!---------sidebarr with badge start--------->

                   <?php require_once('incAdmin/sidebar.php');  ?>
                </div>
                <div class="col-md-9">
                    <h1>  <i class="fas fa-user"></i> Profile <small>Personal Details</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-users"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-user"></i> Profile</li>

                    </ol>
                  
                    <div class="row">
                        <div class="col-xs-12">
                            <center><img src="image/<?php echo $image;?>" width="200px" 
                                class="img-cicle img-thumbnail" id="profile_image"></center><br>
                            <a href="edit_profile.php?edit=<?php echo $id;?>" class="btn btn-primary pull-right">Edit Profile</a><br><br>
                            <hr>
                            <center>
                                <h3> Profiel Details</h3>
                            </center>
                            <br>
                            <table class="table table-bordered ">
                                <tr>
                                    <td width="20%"><b>User ID:</b></td>
                                    <td width="30%"><?php echo $id;?></td>
                                    <td width="20%"><b>Signup Date:</b></td>
                                    <td width="30%"><?php echo "$day $month $year";?></td>
                                </tr>
                                <tr>
                                    <td width="20%"><b>First Name:</b></td>
                                    <td width="30%"><?php echo $first_name;?></td>
                                    <td width="20%"><b>Last Name:</b></td>
                                    <td width="30%"><?php echo $last_name;?></td>
                                </tr><tr>
                                    <td width="20%"><b>Username:</b></td>
                                    <td width="30%"><?php echo $username;?></td>
                                    <td width="20%"><b>Email:</b></td>
                                    <td width="30%"><?php echo $email;?></td>
                                </tr>
                                <tr>
                                    <td width="20%"><b>Role:</b></td>
                                    <td width="30%"><?php echo $role;?></td>
                                    <td width="20%"><b></b></td>
                                    <td width="30%"></td>
                                </tr>
                            </table>
                            <div class="row">
                                <div class="col-lg-8 col-sm-12">
                                    <b>Details:</b>
                                    <div>
                                    <?php echo $details;?>
                                    </div>
                                </div><br>
                            </div>
                        </div>
                    </div>
                </div>
             </div>

        </div>

  </div>
        <?php  require_once('incAdmin/footer.php');  ?>

























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