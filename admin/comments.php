
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

$session_username = $_SESSION['username'];

<!--delet comments ---->


<!--- comment delet nhi ho rha ---->

<?php
    if(isset($_GET['del'])){
        $del_id = $_GET['del'];
      
        $del_check_query = "SELECT * FROM comments WHERE id = $del_id";
        $del_check_run = mysqli_query($con, $del_check_query);
        if(mysqli_num_rows($del_check_run) > 0){

            $del_query =  "DELETE FROM `comments` WHERE `comments`.`id` = $del_id";
        
            // if we login through ADMIN we can't delet comment
            if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                if(mysqli_query($con, $del_query)){
                    $msg = "Comment has been deleted";
                }
                else{
                    $error = "Comment has not been deleted";
       
                }
            }

        }
        else{
            header('Location: index.php');
        }
 
    }


    if(isset($_GET['approve'])){
        $approve_id = $_GET['approve'];
      
        $approve_check_query = "SELECT * FROM comments WHERE id = $approve_id";
        $approve_check_run = mysqli_query($con, $approve_check_query);
        if(mysqli_num_rows($approve_check_run) > 0){

            $approve_query =  "UPDATE `comments` SET `status` = 'approve' WHERE `comments`.`id` = $approve_id"
        
            // if we login through ADMIN we can't delet comment
            if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                if(mysqli_query($con, $approve_query)){
                    $msg = "Comments has been approve";
                }
                else{
                    $error = "Comments has not beet unapproved";
       
                }
            }

        }
        else{
            header('Location: index.php');
        }


    }



    if(isset($_GET['unapprove'])){
        $unapprove_id = $_GET['unapprove'];
      
        $unapprove_check_query = "SELECT * FROM comments WHERE id = $unapprove_id";
        $unapprove_check_run = mysqli_query($con, $unapprove_check_query);
        if(mysqli_num_rows($approve_check_run) > 0){

            $unapprove_query =  "UPDATE `comments` SET `status` = 'pending' WHERE `comments`.`id` = $unapprove_id"
        
            // if we login through ADMIN we can't delet comment
            if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                if(mysqli_query($con, $unapprove_query)){
                    $msg = "Comments has been Unapprove";
                }
                else{
                    $error = "Comments has not beet approved";
       
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
            $bulk_del_query = "DELETE FROM `comments` WHERE `comments`.`id` = $user_id";

            mysqli_query($con, $bulk_del_query);

        }
        else if($bulk_option1 == 'approve'){
            $bulk_author_query = "UPDATE `comments` SET `status` = 'approve' WHERE `comments`.`id` = $user_id";
            mysqli_query($con, $bulk_author_query);

        }
        else if($bulk_option1 == 'pending'){
            $bulk_admin_query = "UPDATE `comments` SET `status` = 'pending' WHERE `comments`.`id` = $user_id";
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
                  <!----- for reply------------->
                  <?php
                  if(isset($_GET['reply'])){
                      $reply_id = $_GET['reply'];
                      $reply_check = "SELECT * FROM comments Where post_id = $reply_id";

                      $reply_check_run = mysqli_query($con,$reply_check_run);
                      if(mysql_num_rows($reply_check_run) > 0){
                          if(isset($_POST['reply'])){
                              $comment_data = $_POST['comment'];
                              if(empty($comment_data)){
                                  $comment_error = "Must fill this feild";
                              }
                              else[
                                  $get_user_data =  "SELECT * FROM users Where username = '$session_username'";
                                  $get_user_run = mysqli_query($con,$get_user_data);
                                  $get_user_row = mysqli_fetch_array($get_user_run);

                                  $date = time();
                                  $first_name = $get_user_row['first_name'];
                                  $last_name = $get_user_row['last_name'];
                                  $full_name = "$first_name $last_name";
                                  $email = $get_user_row['email'];
                                  $image = $get_user_row['image'];

                                  $insert_comment_query = "INSERT INTO comments (date,name,username,post_id,email, image,comment
                                  ,status) VALUES ('$date','$full_name','$session_username',
                                  '$reply_id','$email','$image','$comment_data','approve')";

                                   if(mysqli_query($con, $insert_comment_query)){
                                       $comment_msg = "Comment Has Been Submitted";

                                       header('Location:comments.php');
                                   }
                                   else{
                                       $comment_error = "Comment Has Not Been Submitted";
                                   }

                              ]
                          }

                  
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="comment">Comment:*</label>
                                <?php
                                  if(isset($comment_error)){
                                      echo "<span class='pull-right' sytle='color:red;'>$comment_error</span>";
                                  }
                                  else if(isset($comment_msg)){
                                    echo "<span class='pull-right' sytle='color:green;'>$comment_msg</span>";
                                }
                                ?>
                                <textarea name="comment" id="comment" cols="30"
                                rows="10" placeholder="Your Comment Here" class="form-control"></textarea>
                            </div>
                            <input type="submit" name="reply" class="btn btn-primary">
                        </form>

                    </div>
                </div>
                <hr>
                <!------------------------>
                <div class="col-md-9">
                    <h1>  <i class="fas fa-comment"></i>Comments <small>View All Comment</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fas fa-users"></i> Dashboard /&nbsp;&nbsp; </a></li>
                        <li class="active"><i class="fas fa-comment"></i> Comments</li>

                    </ol> 
                </div>
                 <?php 

                      }  //reply if condition close
                    }
                 $query = "SELECT * FROM comments ORDER BY id DESC";
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
                                              <option value="approve">Approve</option>
                                              <option value="pending">Unapprove</option>

                                         </select>
                                     </div><br>
                                 </div>
                                 
                                 <div class="col-xs-8">
                                     <input type="submit" class="btn btn-success" value="Apply">
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
                             <th>Username</th>
                              <th>Comment</th>
                             <th>status</th>
                             <th>Approve</th>
                             <th>Unapprove</th>         
                             <th>Reply</th>
                             <th>Delete</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php  
                           while($row = mysqli_fetch_array($run)){

                                $id = $row['id'];
                                 $username = $row['username'];
                                 $status = $row['status'];
                                 $comment = $row['comment'];
                                 $post_id = $row['post_id'];
                                $date = getdate($row['date']);
                                $day = $date['mday'];
                                $month = substr($date['month'],0,3);                               
                                $year = $date['year'];

                               

                                ?>
                          
                         <tr>
                             <td><input type="checkbox " class="checkboxes"
                             name="checkboxes[]" value="<?php echo $id;?>"></td>
                             <td><?php echo $id;?></td>
                             <td><?php echo "$day $month $year";?></td>
                              <td><?php echo $username;?></td>
                              <td><?php echo $comment;?></td>
                              <td><span style="color:<?php 
                                  if($status == 'approve'){
                                      echo 'green';
                                  }
                                  else if($status == 'pending'){
                                      echo 'red';
                                  }

                              ?>"><?php echo ucfirst($status);?></span></td>
                              <td><a href="comments.php?approve=<?php echo $id;?>">Approve</a></td>
                              <td><a href="comments.php?unapprove=<?php echo $id;?>">Unapprove</a></td>


                              
                             <td><a href="comments.php?reply=<?php echo $post_id;?>"><i class="fas fa-reply"></i></a></td>
                             <td><a href="comments.php?del=<?php echo $id;?>"><i class="fas fa-times"></i></a></td>
                             
                         </tr>
                         <?php   }?>
                      
                     </tbody>
                 </table>
                 <?php  }
                 else{
                     echo "<center><h2>NO Users Comments Now</h2></center>";
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

  
  