<?php
 require_once('inc/top.php');


?>


  <body>

  <?php require_once('inc/header.php');  ?>
    
  <?php

    if(isset($_GET['post_id'])){
      $post_id = $_GET['post_id'];
 
      $views_query = "UPDATE `post` SET `views` = views + 1 WHERE `post`.`id` = $post_id";
   //   $mysqli_query($con, $views_query);


      $query  = "SELECT * FROM post WHERE status = 'publish' and id = $post_id";
      $run = mysqli_query($con, $query);
      if(mysqli_num_rows($run) > 0){
          $row = mysqli_fetch_array($run);
          $id = $row['id'];
          $date = getdate($row['date']);
          $day = $date['mday'];
          $month = $date['month'];
          $year = $date['year'];
          $title = $row['title'];
          $image = $row['image'];
          $author_image = $row['author_image'];
          $author = $row['author'];
          $categories = $row['categories'];
          $post_data = $row['post_data'];

      }
      else
      {
        header('Location: index.php');
      }


    }

    ?>

      <!----------------------------->
      <div class="jumbotron"> <!--jumbotron give area to heading, its a class-->
        <div class="container" class="animated slideOutUp">
          <div id="details">
            <h1>Custom<span>Post</span></h1>
            <p>
              Here you can put your own tag line to make it more attractive.
            </p>
          </div>
        </div>
        <img src="image/lp2.jpg" alt="azhar">
      </div>

<br>
   <section>
     <div class="container">
       <div class="row">
         <div class="col-md-8">

    <!--------------Post start------------------->
          <div class="post">
            <div class="row">
              <div class="col-md-2 post-date">
                <div class="day"><?php echo $day;?></div>
                <div class="month"><?php echo $month;?></div>
                <div class="year"><?php echo $year;?></div>

              </div>
              <div class="col-md-8 post-title">
                <a href="post.php?post_id=<?php echo $id;?>"><h2> <?php echo $title;?>.
                </h2></a>
                <p>Written by: <span><?php echo ucfirst($author);?></span></p>
              </div>
              <div class="col-md-2 profile-picture">
                <img src="image/<?php echo $author_image;?>" width="120%" alt="profile picture" class="img-thumbnail">
              </div>
            </div>
            <a href="image/<?php echo $image;?>"><img src="image/<?php echo $image;?>" alt="image"></a>
           <p class="desc">
           <?php echo $post_data;?>
            </p>

             <div class="button">
              <hr>
              <span class="first"><i class="far fa-folders"></i><a href="#"> <?php echo ucfirst($categories);?></a> </span>|
              <span class="second"><i class="fas fa-comments"></i><a href="#"> comments</a></span>
            </div>
           </div>
     <!--------------Post end------------------->

 <!-------------- releted Post start------------------->
           <div class="related_post">
               <div class="row">
                 <?php 
                 $r_query = "SELECT * FROM post WHERE status = 'publish' AND title LIKE '%$title%' LIMIT 3";
                 $r_run = mysqli_query($con, $r_query);
                 while($r_row = mysqli_fetch_array($r_run)){
                        $r_id = $r_row['id'];
                        $title = $r_row['title'];
                        $image = $r_row['image'];

                 
                 
                 ?>
                   <h3>Related Post</h3><hr>

                   <div class="col-sm-4">
                      

                      <a href="post.php?post_id=<?php echo $r_id?>">
                          <img src="image/<?php echo $image?>" alt="slider one">
                          <h4><?php echo $title;?></h4>
                      </a>
                   </div>
                    <?php  }   ?>
               </div>
           </div>

  <!-------------- releted Post end------------------->

    <!-------------- author Post start------------------->
                <div class="author">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="image/<?php echo $author_image;?>" alt="profile image" class="img-thumbnail">
                        </div>
                        <div class="col-sm-9">
                            <h4><?php echo ucfirst($author);?></h4>
                           
                           <!--author bio---------------------------------------------------->
                           
                            <!--ERROR: AUTHOR DETAILS NOT FATCHED------>
                           <?php
                              $bio_query= "SELECT * FROM users WHERE username = '$author'";
                              $bio_run = mysqli_query($con, $bio_query);
                              if(mysqli_num_rows($bio_run) > 0){

                                $bio_row = mysqli_fetch_array($bio_run);
                                $author_details = $bio_row['details'];

                     
                           ?>
                           
                        

                            <p>
                            <?php echo $author_details;?> 
                            </p>
                            <?php  }?>
                               <!--author bio------------------------------------------------------>
                        </div>

                    </div>



                </div>
           

    <!-------------- author Post end------------------->

 <!--------------comment Post start------------------->
       <?php
            $c_query = "SELECT * FROM comments WHERE status = 'approve' and post_id = $post_id ORDER BY id DESC";
            $c_run = mysqli_query($con,$c_query);
            if(mysqli_num_rows($c_run) > 0){
  
        ?>
 
            <div class="comments">
                    <h3>Comments</h3
                    <?php 
                       
                    while($c_row = mysqli_fetch_array($c_run)){
                      $c_id = $c_row['id'];
                      $c_name = $c_row['name'];
                      $c_username = $c_row['username'];
                      $c_image = $c_row['image'];
                      $c_comment = $c_row['comment'];


                 
                    
                    ?>
                    
                    ><hr>
                    <div class="row single_comment">
                        <div class="col-sm-3">
                            <img src="image/<?php echo $c_image;?>" alt="" >
                        </div>
                        <div class="col-sm-9">
                            <h4><?php echo ucfirst($c_name);?></h4>
                            <p><?php echo $c_comment;?></p>
                        </div>
                    </div>
                   <?php } ?>  <!-- while  ---->
              </div>

              <?php  }  ?>

  <!--------------comment Post end------------------->

   <!--------------Comment box start------------------->

   <?php  
     
     if(isset($_POST['submit'])){
       $cs_name = $_POST['name'];
       $cs_email = $_POST['email'];
       $cs_website = $_POST['website'];
       $cs_comment = $_POST['comment'];
       $cs_date  = time();
       if(empty($cs_name) or empty($cs_email) or empty($cs_comment)){
         $error_msg = "All (*) fields are Required";

       }
       else{
         $cs_query = "INSERT INTO `comments` (`id`, `date`, `name`,
          `username`, `post_id`, `email`, `website`, `image`, `comment`,
           `status`) VALUES (NULL, '$cs_date', '$cs_name', 'user', '$post_id',
            '$cs_email', '$cs_website', 'author2.jpg',
             '$cs_comment', 'pending')";  
             
             if(mysqli_query($con, $cs_query)){
               $msg = "comment submitted and waiting for Approval";

               $cs_name    = "";
               $cs_email   = "";
               $cs_website = "";
               $cs_comment = "";


             }
             else{
               $error_msg = "Comment has not be submited";
             }
             
            
            }

     }
   
   ?>
            <div class="comment-box">
                <div class="col-md-12 contact_form">
                    <h2>Contact Form</h2><hr>
                      <form action="" method="post">
                        <div class="form-group">
                          <label for="name">Name*</label>
                          <input type="text" value="<?php if(isset($cs_name)){echo $cs_name;}?>" name="name" class="form-control" id="name" placeholder="name">
                        </div>
                        <div class="form-group">
                          <label for="email">Email*</label>
                          <input type="text"  name="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?php if(isset($cs_email)){echo $cs_email;}?>" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                          <label for="website">Website</label>
                          <input type="text" name="website" class="form-control" id="website" value="<?php if(isset($cs_website)){echo $cs_website;}?>" placeholder="website">
                        </div>
                        <div class="form-group">
                          <label for="message">Comment*</label>
                          <textarea  id="message" name="comment" cols="30" rows="10" class="form-control" <?php if(isset($cs_comment)){echo $cs_comment;}?> placeholder="your message should be here"></textarea>
                        </div>
                        <br>
                        <button type="submit"  name ="submit" class="btn btn-primary">Submit</button>

                        <?php
                            if(isset($error_msg)){
                              echo "<span style='color:red;' class='pull-right'>$error_msg</span>";
                            }
                            else if(isset($msg)){
                              echo "<span style='color:green;' class='pull-right'>$msg</span>";

                            }
                        ?>
                      </form>
                  </div>
            </div>

    <!--------------comment box end------------------->


      </div>
        <div class="col-md-4">
         
        <?php require_once('inc/sidebar.php');  ?>
         <!------------------------------------------->
         </div>
       </div>
     </div>

   </section>

   <?php require_once('inc/footer.php');  ?>








































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












