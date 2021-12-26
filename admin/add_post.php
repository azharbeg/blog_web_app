
<?php
 require_once('incAdmin/topAdmin.php');


 // after login check (if are login or not)
 // if YES then redirect index page
 // if NO then redirect login page
 
 /*if(!isset($_SESSION['username'])){
   header('Location: login.php');

 }*/
//////////////////////
$session_username = $_SESSION['username'];
$session_author_image = $_SESSION['author_image'];


?>

  <body>
  
 <div id="wrapper">

   <?php
     require_once('incAdmin/header.php'); ?>


        <div class="container-fluid body-section">
            <div class="row">
                <div class="col-md-3">
                <!---------textarea start --------->
                <!---------84 video for good ui textarea start --------->

                   <?php require_once('incAdmin/sidebar.php');  ?>
                </div>
                <div class="col-md-9">
                    <h1>  <i class="fas fa-plus-square"></i> Add Post<small>Add New Post</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fas fa-users"></i> Dashboard</a></li>&nbsp; / &nbsp;
                        <li class="breadcrumb-item"><i class="fas fa-plus-square"></i> Add Post</li>

                 </ol>
                 <?php
                   if(isset($_POST['submit'])){
                       $date =time();
                       $title = mysqli_real_escape_string($con,$_POST['title']);
                       $post_data = mysqli_real_escape_string($con,$_POST['post_data']);
                       $categories = $_POST['categories'];
                       $tags = mysqli_real_escape_string($con,$_POST['tags']);
                       $status = $_FILES['image']['name'];
                       $image = $_POST['status'];
                       $tmp_name = $_FILES['image']['tmp_name'];

                       if(empty($title) or empty($post_data) or empty($tage)
                       or empty($image)){
                           $error = "All (*) feilds are required";

                       }
                       else{
                           $insert_query ="INSERT INTO posts (date, title, author,author_image, image,  categories, tags,
                           post_data, views,status) VALUES ('$date','$title','$session_username','$session_author_image','$image','$categories',
                           '$tags','$post_data','0','$status')";

                           if(mysqli_query($con, $insert_query)){
                               $msg = "Post has been added";
                               $path = "image/$image";
                               // if post add then all value became blank
                               $title = "";
                               $post_data = "";
                               $tags = "";
                               $status = "";
                               $categories = "";
                               /////////////////////////////

                                if(move_uploaded_file($tmp_name, $path)){
                                    copy($path, "../$path");
                                }
                           }
                           else{
                               $error = "Post has not been added";
                           }
                       }



                   }

                 ?>
                 
<!------------------------post image, categories, tags start------------------------->
                 <div class="row">
                     <div class="col-xs-12">
                         <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Title:*</label>
                                <?php 
                                   if(isset($msg)){
                                       echo "<span class='pull-right' style=
                                       'color:green;'>$msg</span>";
                                   }
                                   else if(isset($error)){
                                    echo "<span class='pull-right' style=
                                    'color:red;'>$error</span>";

                                   }

                                ?>
                                <input type="text" name="title" placeholder="Type Post Title Here" value="
                                <?php if(isset($title)){echo $title;}?>" class="form-control">
                            </div>
<br>
                            <div class="form-group">
                                <a href="media.php" class="btn btn-primary">Add Media</a>
                            </div><br>

                            <div class="form-group">
                                <textarea name="post_data" id="textarea"  rows="10" class="form-control">
                                <?php if(isset($post_data)){echo $post_data;}?>
                                

                                </textarea>                           
                             </div>
<!-----------------first row class------------------------>


                             <div class="row">
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                        <label for="file">Post Image:*</label>
                                        <input type="file" name="image" >
                                      </div>
                                 </div>
                                 <div class="col-sm-6"><br>
                                    <div class="form-group">
                                        <label for="categories">Categories:*</label>
                                        <select class="form-control" name="categories" id="categories">
                                             <?php 
                                              $cat_query = "SELECT * FROM categories ORDER BY id DESC";
                                               $cat_run = mysqli_query($con, $cat_query);

                                               if(mysqli_num_rows($cat_run) > 0){
                                                    while($cat_row = mysqli_fetch_array($cat_run)){
                                                        $cat_name = $cat_row['category'];

                                                        echo "<option value='".$cat_name."' ".((isset($categories) and 
                                                        $categories == $cat_name)?"selected":"").">".ucfirst($cat_name)."</option>";
                                                    }
                                               }
                                               else{

                                                echo "<center><h6>No Category Available</h6></center>";
                                               }

                                           ?> 

                                        </select>
                                    </div>
                                 </div>
                             </div>
<!----------------------------------------->
                             <div class="row">
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                        <label for="tags">Tags:*</label>
                                        <input type="text" name="tags" placeholder="Your Tags Here" value="<?php if(isset($tags)){echo $tags;}?>" class="form-control">
                                      </div>
                                 </div>
                                 <div class="col-sm-6"><br>
                                    <div class="form-group">
                                        <label for="status">Status:*</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="publish" <?php if(isset($status) and $status
                                            == 'public'){echo "selected";}?> >Publish</option>
                                            <option value="draft" <?php if(isset($status) and $status
                                            == 'draft'){echo "selected";}?>>Draft</option>
                                        </select>
                                    </div>
                                 </div>
                             </div>
                        
                             <input type="submit" class="btn btn-primary" value="Add Post" name="submit">
                        </form>
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