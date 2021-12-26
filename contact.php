<?php include_once('inc/top.php'); ?>


  <body>

  <?php include_once('inc/header.php'); ?>

              
             

      <div class="jumbotron"> <!--jumbotron give area to heading, its a class-->
        <div class="container" class="animated slideOutUp">
          <div id="details">
            <h1>Contact<span>Us</span></h1>
            <p>
              We are availabe 24*7. So feel Free to Contact Us.
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
          
            <!----------new content start------------------>
            <div class="row"> 
                <div class="col-md-12">
                    <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" 
                    src="https://maps.google.com/maps?width=100%&amp;height=400&amp;hl=en&amp;q=LANE%20CHIJANA%20TOWN%20TIKRI%20BAGHPAT%20BAGHPAT+(Tikri%20Rural)&amp;
                    t=&amp;z=10&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a href='https://www.symptoma.com/en/info/covid-19'>Corona Disease</a> 
                    <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=81179aed761457178b6bdc902f31457496ec6b96'></script>
                </div>
                <br>
                <!----from start----------------------------------------->

               <div class="col-md-12 contact_form">
                 <?php

                    if(isset($_POST['submit'])){
                      $name = mysqli_real_escape_string($con,$_POST['name']);
                      $email = mysqli_real_escape_string($con,$_POST['email']);
                      $website = mysqli_real_escape_string($con,$_POST['website']);
                      $comment = mysqli_real_escape_string($con,$_POST['comment']);

                      /// for an email we received
                      $to ="azharsubhan10@gmail.com";
                      $header = "From: $name<$email>";
                      $subject = "Message From $name";
                      $message = "Name: $name \n\n
                      Emil: $email \n\n
                      Website: $website \n\n
                      Message: $comment";
                      ////////////////////////////////////////

                      if(empty($name) or empty($email) or empty($comment)){
                        $error = "All (*) fields are required";

                    }
                    //
                    else{

                        if(mail($to,$subject,$message,$header)){
                          $msg ="Message has been sent";
                        }
                        else{
                          $error = "Message has not been sent";
                        }
                    }

                 ?>
                  <h2>Contact Form</h2><hr>
                    <form action="" method="post">
                      <div class="form-group">
                        <label for="name">Name*</label>
                        
                        <?php 
                          if(isset($error)){
                            echo "<span class='pull-right' style='color:red'>$error</span>";
                          }
                       
                         if(isset($msg)){
                            echo "<span class='pull-right' style='color:green'>$msg</span>";
                          }

                          ?>

                        <input type="text" class="form-control" id="name" placeholder="name" name="name">
                      </div>
                      <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                      </div>
                      <div class="form-group">
                        <label for="website">Website</label>
                        <input type="text" class="form-control" id="website" placeholder="website" name="website">
                      </div>
                      <div class="form-group">
                        <label for="message">Message</label>
                        <textarea  id="message" cols="30" rows="10" class="form-control" placeholder="your message should be here" name="comment"></textarea>
                      </div>
                      <br>
                      <button type="submit"  name ="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

            </div>

         <!---new content end----------------------------->

  
         </div>
          <div class="col-md-4">
             
 
          <?php include_once('inc/sidebar.php'); ?>

        <!--widgets close-->
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












