

<?php
 require_once('incAdmin/topAdmin.php');


 // after login check (if are login or not)
 // if YES then redirect index page
 // if NO then redirect login page
 
 /*if(!isset($_SESSION['username'])){
   header('Location: login.php');

 }*/
//////////////////////

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
                    <h1>  <i class="fas fa-database"></i> Media <small>Add Or View Media Files</small><hr>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fas fa-tachometer"></i>
                        Dashboard </a></li>&nbsp; / &nbsp;

                        <li class="active"><i class ="fas fa-database"></i>Media</li>
                 </ol>
                 
<!------------------------fetch the image and move to the media folder------------------------->
                 
                    <?php   
                       if(isset($_POST['submit'])){
                           if(count($_FILES['media']['name']) > 0){
                               for($i = 0; $i < count($_FILES['media']['name']); $i++){
                                    
                                     $image = $_FILES['media']['name'][$i];
                                     $tmp_name = $_FILES['media']['tmp_name'][$i];

                                     $query ="INSERT INTO media (image) VALUES('$image')";

                                    if(mysqli_query($con, $query)){
                                        $path = "media/$image";
                                        if(move_uploaded_file($tmp_name, "$path")){
                                                copy($path,"../$path");
                                        }
                                     }
                               }
                           }
                       }


                    ?>
                       <form action="" method="post" enctype="multipart/form-data">
                           <div class="row">
                               <div class="col-sm-4 col-xs-8">
                                   <input type="file" name="media[]" required multiple>
                               </div>
                               <div class="col-sm-4 col-xs-4">
                                   <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Add Media">
                               </div>
                           </div>
                       </form><hr>

                       <div class="row">
                           <?php 
                              $get_query ="SELECT * FROM media ORDER BY id  DESC";
                              $get_run = mysqli_query($con, $get_query);
                              if(mysqli_num_rows($get_run) > 0){

                                while($get_row = mysqli_fetch_array($get_run)){
                                     $get_image = $get_row['image'];
                                
                            
                             
                           ?>
                           <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 thumb">
                               <a href="media/<?php echo $get_image;?>" class="thumbnail">
                                   <img src="media/<?php echo $get_image;?>" width="100%" alt="">
                                </a>
                           </div>
                           <?php 
                              }   // while loop  (double value fatch ho rhi hai jb referesh kr rhe toh image increase ho rhi ha)
                           }    // if condition
                            else{
                                echo "<center><h2>No Media Available</h2></center>";
                            }

                            ?>
                           
                       </div>
                
 <!------------------------table start------------------------->

                
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