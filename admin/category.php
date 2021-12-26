
<?php
 require_once('incAdmin/topAdmin.php');

// if not login then it run---->

/*if(!isset($_SESSION['username'])){
    header('Location: login.php');
}   */


/*else */  if(isset($_SESSION['username']) && $_SESSION['role'] == 'author'){
    header('Location: index.php'); // No authority to visit user's page..
  }
/////////////////////////////

// update categery name section
if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];
}
////////////////////////////////

if(issetf($GET['del'])){
    $del_id = $_GET['del'];

       if(isset($_SESSION['username'] and $_SESSION['role'] == 'admin')){
            $del_query = "DELETE FROM categories WHERE id = '$del_Id'";
            if(mysqli_query($con, $del_query)){
                $del_msg = "Category has been deleted";
        
        
            }
            else{
                $del_error = "Category has not been deleted";
            }
       }
}



//  NOT WORKING ( CATEGORY NOT ADD)
if(isset($_POST['submit'])){
    $cat_name = mysqli_real_escape_string($con, strtolower($_POST['cat_name']));

   if(empty($cat_name)){
       $error = "Must fiil this field";
   }
   else {
        $check_query = "SELECT * FROM categories WHERE category = '$cat_name'";
        $check_run = mysqli_query($con, $check_query);
            if(mysqli_num_rows($check_run) > 0){
                $error = "Category Already Exist";
            }
            else{
                    $insert_query = "INSERT INTO categories (category) VALUES ('$cat_name')";
                    if(mysqli_query($con, $insert_query)){
                        $msg ="Category Has been added";

                    }
                    else{
                        $error = "Categry has not been Added";
                    }
            }

        }
   }
////////// update query
   if(isset($_POST['update'])){
    $cat_name = mysqli_real_escape_string($con, strtolower($_POST['cat_name']));

   if(empty($cat_name)){
       $up_error = "Must fiil this field";
   }
   else {
        $check_query = "SELECT * FROM categories WHERE category = '$cat_name'";
        $check_run = mysqli_query($con, $check_query);
            if(mysqli_num_rows($check_run) > 0){
                $up_error = "Category Already Exist";
            }
            else{
                    $update_query = UPDATE `categories` SET `category` = '$cat_name' WHERE `categories`.`id` = $edit_id;
                    
                    if(mysqli_query($con, $update_query)){
                        $up_msg ="Category Has been Updated";

                    }
                    else{
                        $up_error = "Categry has not been Updated";
                    }
            }

        }
   }
///////////////////////////////////////////////////////
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
                    <h1>  <i class="fas fa-folder-open"></i> Categories<small> Different Categories</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.html"><i class="fas fa-users"></i> Dashboard /&nbsp;&nbsp;</a></li>
                        <li class="active"><i class="fas fa-folder-open"></i> Categories</li>

                 </ol>
  
                 <div class="row">
                     <div class="col-md-6">
                         <form action="" method="post">
                             <div class="form-group">
                                 <label for="category">Category Name:</label>
                                 <?php
                                   if(isset($msg)){
                                       echo " <span class ='pull-right' style='color:green;'>$msg</span>";
                                   }

                                  else if(isset($error)){
                                    echo " <span class ='pull-right' style='color:red;'>$error</span>";
                                }
                                 ?>
                                 <input type="text" placeholder="Category Name" name="cat_name" class="form-control">

                             </div>
                             <br>
                             <input type="submit" value="Add Category" name="submit" class="btn btn-primary">
                         </form>

                         <?php  
                            if(isset($_GET['edit'])){
                                $edit_check_query = "SELECT * FROM categories WHERE id = $edit_id";
                                $edit_check_run = mysqli_query($con, $edit_check_query);

                                if(mysqli_num_rows($edit_check_run) > 0){

                           
                                    $edit_row = mysqli_fetch_array($edit_check_run);
                                      $up_category =  $edit_row['category'];
                            ?>
                         <hr>

                         <form action="" method="post">
                             <div class="form-group">
                                 <label for="category">Update Category Name:</label>
                                 <?php
                                   if(isset($up_msg)){
                                       echo " <span class ='pull-right' style='color:green;'>$up_msg</span>";
                                   }

                                  else if(isset($up_error)){
                                    echo " <span class ='pull-right' style='color:red;'>$up_error</span>";
                                }
                                 ?>
                                 <input type="text" value="<?php echo $up_category;?>" placeholder="Category Name" name="cat_name" class="form-control">

                             </div>
                             <br>
                             <input type="submit" value="Update Category" name="update" class="btn btn-primary">
                         </form>

                         <?php          
                                }

                            }
                            ?>


                     </div>
                     <div class="col-md-6">
                         <?php
                             
                             $get_query = "SELECT * FROM categories ORDER BY id DESC";
                             $get_run = mysqli_query($con, $get_query);
                             if(mysqli_num_rows($get_run) > 0){

                               
                                    if(isset($del_msg)){
                                        echo " <span class ='pull-right' style='color:green;'>$del_msg</span>";
                                    }

                                      else if(isset($del_error)){
                                             echo " <span class ='pull-right' style='color:red;'>$del_error</span>";
                                      }
                                
                         ?>
                         <table class="table table-hover table-bordered table-striped">
                             <thead>
                                 <?php
                                    while($get_row = mysqli_fetch_array($get_run)){
                                        
                                        $category_id = $get_row['id'];            
                                        $category_name = $get_row['category'];
 
                                ?>
 
                                 <tr>
                                     <th>SR #</th>
                                     <th>Category Name</th>
                                     <th>Posts</th>
                                     <th>Edit</th>
                                     <th>Delet</th>
                                 </tr>
                                 <?php  }  ?>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td><?php echo $category_id;?></td>
                                     <td><?php echo ucfirst($category_name);?></td>
                                     <td>12</td>
                                     <td><a href="categories.php?edit=<?php echo $category_id;?>"><i class="fas fa-pencil-alt"></i></a></td>
                                     <td><a href="categories.php?del=<?php echo $category_id;?>"><i class="fas fa-times"></i></a></td>
                                 </tr>
                                
                             </tbody>
                         </table>
                         <?php 
                         }
                         
                         else{
                                 echo "<center><h3>No Categories Found</h3></center>";
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


    </div>

























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