<?php

ob_start();
session_start(); 
  

require_once('../inc/db.php');

require_once('incAdmin/topAdmin.php'); // for css

if(isset($_POST['submit']))
{
    $username = mysqli_real_escape_string($con,strtolower($_POST['username']));
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $check_username_query = "SELECT * FROM users WHERE username ='$username'";
    
    $check_username_run = mysqli_query($con, $check_username_query);
    var_dump($check_username_run);
    echo mysqli_num_rows($check_username_run);
      if(mysqli_num_rows($check_username_run) > 0){
        $row = mysqli_fetch_array($check_username_run);

        $db_username = $row['username'];
        $db_password = $row['password'];
        $db_role     = $row['role'];
        $db_author_image = $row['image'];

        
     
      
     //   $password = crypt($password, $db_password);

                  if($username == $db_username && $password == $db_password){
                      $_SESSION['username'] = $db_username;
                      $_SESSION['role'] = $db_role;
                      $_SESSION['image'] = $db_author_image;
                      header('Location: index.php');

                    // for restriction if we are not login
                    // also we need to restriciton on index page
                  

                  }
                  else{
                    $error = "Wrong Username or Password.";
                  }


  }
  else{
    $error = "second Wrong Username or Password";
  }

}
 
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Login |  Admin</title>

  
    <!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link href="css/animated.css" rel="stylesheet">
 <link href="css/signin.css" rel="stylesheet">

<link rel="stylesheet" href="css/login.css">
 <link rel="icon" href="image/fevicon.png">  
    <!-- Custom styles for this template -->
  </head>
  
  <body class="text-center">

  
    <form class="form-signin animated shake" action="" method="post">
   <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <label for="inputEmail" class="sr-only">Username</label>
  <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required autofocus><br>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
  <div class="checkbox mb-3">
    <label>

    <?php  
       if(isset($error)){
         echo "$error";

       }

       ?>

    </label>
  </div>
  <input type="submit" name="submit" value="Sign In" class="btn btn-lg btn-primary btn-block">
  <p class="mt-5 mb-3 text-muted">&copy; 2021-2022</p>
</form>
</body>

</html>
