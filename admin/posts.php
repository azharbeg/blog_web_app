
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
 

$session_username = $_SESSION['username'];
?>
<!--delet usesr ---->
<?php
    if(isset($_GET['del'])){
        $del_id = $_GET['del'];
      
        if($_SESSION['role'] == 'admin'){
             $del_check_query = "SELECT * FROM posts WHERE id = $del_id";
             $del_check_run = mysqli_query($con, $del_check_query);
        }
        else if($_SESSION['role'] == 'author'){
             $del_check_query = "SELECT * FROM posts WHERE id = $del_id and author = '$session_username'";
             $del_check_run = mysqli_query($con, $del_check_query);
        }


        if(mysqli_num_rows($del_check_run) > 0){

            $del_query =  "DELETE FROM `posts` WHERE `posts`.`id` = $del_id";
        
            // if we login through ADMIN we can't delet comment
                    if(mysqli_query($con, $del_query)){
                        $msg = "Post has been deleted";
                    }
                    else{
                        $error = "Post has not been deleted";
        
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
            $bulk_del_query = "DELETE FROM `posts` WHERE `posts`.`id` = $user_id";

            mysqli_query($con, $bulk_del_query);

        }
        else if($bulk_option1 == 'publish'){
            $bulk_author_query = "UPDATE `posts` SET `status` = 'publish' WHERE `posts`.`id` = $user_id";
            mysqli_query($con, $bulk_author_query);

        }
        else if($bulk_option1 == 'draft'){
            $bulk_admin_query = "UPDATE `posts` SET `status` = 'draft' WHERE `posts`.`id` = $user_id";
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
                    <h1>  <i class="fas fa-file"></i> Posts <small>View All Posts</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fas fa-users"></i> Dashboard /&nbsp;&nbsp; </a></li>
                        <li class="active"><i class="fas fa-file"></i> Posts</li>

                    </ol>
                </div>
              
                 <?php 

                 // if role admin then it's see all post.
                 // if role author it's just see own post and edit if he want.
                 if($_SESSION['role'] == 'admin'){
                    $query = "SELECT * FROM posts ORDER BY id DESC";
                    $run  = mysqli_query($con, $query);
                 }
                 else if($_SESSION['role'] == 'author'){
                    $query = "SELECT * FROM posts WHERE author = '$session_username' ORDER BY id DESC";
                    $run  = mysqli_query($con, $query);

                 }
                 /////////////////////////////////////////////////////////////////

                 
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
                                              <option value="publish">Publish</option>
                                              <option value="draft">Draft</option>

                                         </select>
                                     </div><br>
                                 </div>
                                 
                                 <div class="col-xs-8">
                                     <input type="submit" class="btn btn-success" value="Apply">
                                     <a href="add_post.php" class="btn btn-primary">Add Post</a>
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
                             <th>Title</th>
                             <th>Author</th>
                             <th>Image</th>
                             <th>Categories</th>
                             <th>Views</th>
                             <th>Status</th>
                            
                             <th>Edit</th>
                             <th>Delet</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php  
                           while($row = mysqli_fetch_array($run)){

                                $id = $row['id'];
                                $title = $row['title'];

                              
                                $author = $row['author'];
                                $views = $row['views'];
                                $categories = $row['categories'];
                                $image = $row['image'];
                                $status = $row['status'];
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
                             <td><?php echo "$title";?></td>
                             <td><?php echo $author;?></td>
                             <td><img src="image/<?php echo $image;?>" width="30px" alt="azhar"></td>
                             <td><?php echo "$categories";?></td>
                             <td><?php echo "$views";?></td>
                             <td><span style="color:<?php
                                  if($status == 'publish'){
                                      echo 'green';
                                  }
                                  else if($status == 'draft'){
                                      echo 'red';
                                  }
                                  ?>
                             
                             <?php echo "ucfirst($status)";?></span></td>
                             
                             <td><a href="edit_post.php?edit=<?php echo $id;?>"><i class="fas fa-pencil-alt"></i></a></td>
                             <td><a href="posts.php?del=<?php echo $id;?>"><i class="fas fa-times"></i></a></td>
                             
                         </tr>
                         <?php   }?>
                      
                     </tbody>
                 </table>
                 <?php  }
                 else{
                     echo "<center><h2>NO Posts Available Now</h2></center>";
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

  
  