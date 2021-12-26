
<?php
 require_once('incAdmin/topAdmin.php');


 // after login check (if are login or not)
 // if YES then redirect index page
 // if NO then redirect login page
 
 /*if(!isset($_SESSION['username'])){
   header('Location: login.php');

 }*/
//////////////////////

/// fetch data for 4 boxes...
$comment_tag_query = "SELECT * FROM comments WHERE status = 'pending'";
$category_tag_query ="SELECT * FROM category  ";
$users_tag_query =  "SELECT * FROM users  ";
$posts_tag_query =  "SELECT * FROM posts ";

$com_tag_run = mysqli_query($con, $commnent_tag_query);
$cat_tag_run = mysqli_query($con, $category_tag_query);
$user_tag_run = mysqli_query($con, $users_tag_query);
$post_tag_run = mysqli_query($con, $posts_tag_query);

$com_rows = mysqli_num_rows($con_tag_run);
$cat_rows = mysqli_num_rows($cat_tag_run);
$user_rows = mysqli_num_rows($user_tag_run);
$post_rows = mysqli_num_rows($post_tag_run);


?>

  <body>
  
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
                    <h1>  <i class="fas fa-users"></i> Dashboard <small>Statictics Overview</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-users"></i> Dashboard</li>
                 </ol>
<!------------------------boxes start------------------------->
                 <div class="row tag-boxes">
                     <div class="col-md-6 col-lg-3">
                         <div class="panel-red">
                             <div class="panel-heading">
                                 <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fas fa-comments fa-5x"></i>
                                     </div>
                                     <div class="col-xs-9">
                                         <div class="text-right huge"><?php echo $com_rows;?></div>
                                         <div class="text-right">New Comments</div>

                                     </div>
                                 </div>

                             </div>
                             <a href="comments.php">
                                 <div class="panel-footer">
                                     <span class="pull-right">View All Comments</span>
                                     <span class="pull-right"><i class="fas fa-arrow-circle-right"></i></span>
                                     <div class="clearfix"></div>
                                 </div>
                             </a>
                         </div>

                     </div>
                     <div class="col-md-6 col-lg-3">
                        <div class="panel panel-yellow ">
                            <div class="panel-heading">
                                <div class="row">
                                   <div class="col-xs-3">
                                       <i class="fas fa-comments fa-5x"></i>
                                     </div>
                                    <div class="col-xs-9">
                                        <div class="text-right huge"><?php echo $post_rows;?></div>
                                        <div class="text-right">All Posts</div>

                                    </div>
                                </div>

                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-right">View All Post</span>
                                   
                                    <span class="pull-right"><i class="fas fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                   <div class="col-xs-3">


                                    <i class="fas fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="text-right huge"><?php echo $user_rows;?></div>
                                        <div class="text-right">All Users</div>

                                    </div>
                                </div>

                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-right">View All Users</span>
                                    <span class="pull-right"><i class="fas fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                   <div class="col-xs-3">
                                       <i class="fas fa-folder-open fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="text-right huge"><?php echo $cat_rows;?></div>
                                        <div class="text-right">All Categories</div>

                                    </div>
                                </div>

                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-right">View All Categorie</span>
                                    <span class="pull-right"><i class="fas fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                 </div>
                       
                
 <!------------------------table start------------------------->

                 <hr>

                 <!-- fetch users table-------->
                 <?php
                    $get_users_query ="SELECT * FROM users ORDER BY id
                      DESC LIMIT 5";
                    
                    $get_users_run = mysqli_query($con, $get_users_query);
                    if(mysqli_num_rows($get_users_run) > 0){

                    

                 ?>

                 <h3>New users</h3>
                 <table class="table table-hover table-striped">
                   <thead>
                     <tr>
                       <th>serial No.</th>
                       <th>Date</th>
                       <th>Name</th>
                       <th>Username</th>
                       <th>Role</th>
                     </tr>
                   </thead>
                   <tbody>
                     <?php 
                        while($get_users_row = mysqli_fetch_array($get_users_run)){
                          $users_id = $get_users_row['id'];
                          $users_date = getdate($get_users_row['date']);
                          $users_day  = $users_date['mday'];
                          $users_month  = substr($users_date['month'],0,3);
                          $users_year  = $users_date['year'];

                          $users_firstname = $get_users_row['first_name'];
                          $users_lastname = $get_users_row['last_name'];
                          $users_fullname  =  "$users_firstname $users_lastname";
                          $users_username = $get_users_row['username'];
                          $users_role = $get_users_row['role'];

                        

                     ?>
                     <tr>
                       <td><?php echo $users_id; ?></td>
                       <td><?php echo " $users_day $users_month $users_year";?></td>
                       <td><?php echo $users_fullname; ?></td>
                       <td><?php echo ucfirst($users_username);?></td>
                       <td><?php echo ucfirst($users_role);?></td>
                     </tr>
                   <?php } ?>

                   </tbody>
                 </table>
                 <a href="users.php" class="btn btn-primary">View All Users</a><hr>

                  <?php  } ?>


                  <!--- fetch for post table ------------->
                  <?php
                    $get_posts_query ="SELECT * FROM posts ORDER BY id
                      DESC LIMIT 5";
                    
                    $get_posts_run = mysqli_query($con, $get_posts_query);
                    if(mysqli_num_rows($get_posts_run) > 0){

                    

                 ?>
       

                 <h3>New Posts</h3>
                 <table class="table">
                   <thead>
                     <tr>
                       <th>SR no.</th>
                       <th>Date</th>
                       <th>Post Title</th>
                       <th>Category</th>
                       <th>Views</th>
                     </tr>
                   </thead>
                   <tbody>
                     
                   <?php 
                        while($get_posts_row = mysqli_fetch_array($get_posts_run)){
                          $posts_id = $get_posts_row['id'];
                          $posts_date = getdate($get_posts_row['date']);
                          $posts_day  = $posts_date['mday'];
                          $posts_month  = substr($posts_date['month'],0,3);
                          $posts_year  = $posts_date['year'];

                          $posts_title = $get_posts_row['title'];
                          $posts_categories = $get_posts_row['categories'];
                          $posts_views = $get_posts_row['views'];

                        

                     ?>

                     <tr>
                       <td><?php echo $posts_id; ?></td>
                       <td><?php echo " $posts_day $posts_month $posts_year";?></td>
                       <td><?php echo $posts_title;?></td>
                       <td><?php echo ucfirst($posts_categories); ?></td>
                       <td><i class="fa fa-eye"></i><?php echo $posts_view;?></td>
                     </tr>
                     <?php   } ?>  <!-- while loop closed -->
                     
                   </tbody>
                 </table>
                 <a href="posts.php" class="btn btn-primary">View All Posts</a>

                 <?php  } ?>  <!--if condintion close--->

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