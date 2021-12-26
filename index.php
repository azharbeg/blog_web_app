<?php
 require_once('inc/top.php');

 $number_of_posts = 2;

 if(isset($_GET['page'])){
   $page_id = $_GET['page'];
 }
else{
  $page_id = 1;
}

if(isset($_GET['cat'])){
  $cat_id = $_GET['cat'];
  $cat_query = "SELECT * FROM categories WHERE id = $cat_id";
  $cat_run = mysqli_query($con , $cat_query);
  $cat_row = mysqli_fetch_array($cat_run);
  $cat_name = $cat_row['category'];

}

 if(isset($_POST['search'])){
   $search = $_POST['search-title'];
   $all_posts_query = "SELECT * FROM post WHERE status = 'publish'";
   
   $all_posts_query .= "and tags LIKE '%search%'";
   
   
   $all_posts_run  = mysqli_query($con,$all_posts_query);
   $all_posts =    mysqli_num_rows($all_posts_run );

   $total_pages =  ceil($all_posts / $number_of_posts);
   $posts_start_from = ($page_id - 1) * $number_of_posts;

 }
 else{
    $all_posts_query = "SELECT * FROM post WHERE status = 'publish'";
    if(isset($cat_name)){
      $all_posts_query .= "and categories = '$cat_name'";
    }
    
    $all_posts_run  = mysqli_query($con,$all_posts_query);
    $all_posts =    mysqli_num_rows($all_posts_run );

    $total_pages =  ceil($all_posts / $number_of_posts);
    $posts_start_from = ($page_id - 1) * $number_of_posts;

 }

?>

  <body>

  <!---------nav------------------>
  <?php require_once('inc/header.php');  ?>


      <div class="jumbotron"> <!--jumbotron give area to heading, its a class-->
        <div class="container" class="animated slideOutUp">
          <div id="details">
            <h1>Azhar<span>Blog</span></h1>
            <p>
              This is an online tutorial Huge Portal.So now Shine With Us.
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
           

            <!-- carousel fetch dynamically---------------------------------------------------------->

            <?php
             $slider_query = "SELECT * FROM post WHERE status = 'publish' ORDER BY id DESC LIMIT 5";
             $run = mysqli_query($con, $slider_query);
             if(mysqli_num_rows($run) > 0){
               $count = mysqli_num_rows($run);
  
            ?>

   <!-- carousel---------------------------------------------------------->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">

            <?php
            
            for($i = 0 ; $i < $count; $i++){
              if($i == 0){
                echo "<li data-target='#carousel-example-
                generic' data-slide-to='".$i."' class='active'></li>";
              }
              else{

                echo "<li data-target='#carousel-example-
                generic' data-slide-to='".$i."'></li>";
              
              }
            }
            
            ?>
             </ol>




      <div class="carousel-inner" role="listbox">
        <?php 
        $check = 0;
             while($slider_row = mysqli_fetch_array($run)){
                 $slider_id = $slider_row['id'];
                 $slider_image = $slider_row['image'];
                 $slider_title = $slider_row['title'];

              
                 $check = $check + 1;
                  if($check ==1){
                    echo "<div class='carousel-item active'>";
                  }
                  else{
                    echo "<div class='carousel-item'>";

                  }
             
        ?>
              
               <a href="post.php?post_id=<?php echo $slider_id;?>"> <img class="d-block w-100" src="image/<?php echo $slider_image;?>"></a>
                  <div class="carousel-caption">
                     <?php echo $slider_title;?>
                  </div>
              </div>

             <?php }  ?>
              
      </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
    </div>
    <!-- carousel  end---------------------------------------------------------->

<!----------------------FIRST POST START---------------------------->
            
    <!----------------------fetch data from post table---------------------------->

    <?php

            }  // carousel while breaket close
  
        if(isset($_POST['search'])){
           $search = $_POST['search-title'];
           $query ="SELECT * FROM post WHERE status = 'publish'";     
           $query .= "and tags LIKE '%$search%'";
           $query .= " ORDER BY id DESC LIMIT $posts_start_from, $number_of_posts ";

        }
        else{
              $query ="SELECT * FROM post WHERE status = 'publish'";
            if(isset($cat_name)){
                $query .= "and categories = '$cat_name'";
            }
            $query .= " ORDER BY id DESC LIMIT $posts_start_from, $number_of_posts ";
        }
        $run = mysqli_query($con, $query);
        if(mysqli_num_rows($run) > 0){

          while($row = mysqli_fetch_array($run)){
            $id           = $row['id'];
            $date         = getdate($row['date']);
            $day          = $date['mday'];
            $month        = $date['month'];
            $year         = $date['year'];
            $title        = $row['title'];
            $author       = $row['author'];
            $author_image = $row['author_image'];
            $image        = $row['image'];
            $categories   = $row['categories'];
            $tags         = $row['tags'];
            $post_data    = $row['post_data'];
            $views        = $row['views'];
            $status       = $row['status'];

        


    ?>


       <div class="post">
               <div class="row">
                 <div class="col-md-2 post-date">
                   <div class="day"><?php echo $day;?></div>
                   <div class="month"><?php echo $month;?></div>
                   <div class="year"><?php echo $year;?></div>

                 </div>
                 <div class="col-md-8 post-title">
                   <a href="post.php?post_id=<?php echo $id;?>"><h2> <?php echo $title;?>
                   </h2></a>
                   <p>Written by: <span><?php echo $author;?> </span></p>
                 </div>
                 <div class="col-md-2 profile-picture">
                   <img src="image/<?php echo $author_image;?>" width= "100%" alt="profile picture" class="img-thumbnail">
                 </div>
               </div>
               <a href="post.php?post_id=<?php echo $id;?>"><img src="image/<?php echo $image;?>" alt="image"></a>
              <p class="desc">
              <?php echo substr($post_data,0,300)."......";?>
              </p>
              <a href="post.php?post_id=<?php echo $id;?>" class="btn btn-primary">Read More...</a>
               <div class="button">
                 <hr>
                 <span class="first"><i class="far fa-folders"></i><a href="#"> <?php echo ucfirst($categories);?></a> </span>|
                 <span class="second"><i class="fas fa-comments"></i><a href="#"> comments</a></span>
               </div>
       </div>

       <?php
         }
        }
        else{
          echo "<center><h2>No Posts Available</h2></center>";
        }
       ?>

 <!----------------------POST END---------------------------->
 
  <!----------------------SECOND POST START---------------------------->

 
 <!----------------------SECOND POST END---------------------------->
   <!----------------------THIRD POST START---------------------------->

 

  <!----------------------THIRD POST END---------------------------->

  <!----PAGINATION START------------------------>

  <nav aria-label="Page navigation example" id="pagination">
    <ul class="pagination text-center">

    <!------- current active page show with blue color-------->
     <?php 
        for($i = 1; $i <= $total_pages; $i++){
          echo "<li class='".($page_id == $i ? 'active': '')."'><a href='index.php?page=".$i."&".(isset($cat_name)?"cat=$cat_id":"")."'>$i</a></li>";
          
        }
        ?>
    </ul>
  </nav>

    <!----PAGINATION END------------------------>

         </div>
          <div class="col-md-4">
            <!-----------side bar------------>
            <?php include_once('inc/sidebar.php');  ?>

         <!------------------------------------------->
         </div>
       </div>
     </div>

   </section>

   <?php include_once('inc/footer.php'); ?>

 

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












