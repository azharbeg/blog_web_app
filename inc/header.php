<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
        <div class="container">
          <a class="navbar-brand" href="index.php"><img src="image/logo.jpg" width=30px alt="logo">    Blog!</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav navbar-right">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php"><i class="fal fa-home"></i> Home</a>
              </li>
              
          

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-list-ul"></i> Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                  <!--------------Category fetch dynamically --------------->
                  <?php
                     $query = "SELECT * FROM categories ORDER BY id DESC";
                     $run = mysqli_query($con, $query);
                     if(mysqli_num_rows($run) > 0){
                         while($row = mysqli_fetch_array($run)){
                           $category = ucfirst($row['category']);
                           $id = $row['id'];
                           echo  "<li><a href='index.php?cat=".$id."'>$category</a></li>";
                         }
                     }
                     else{
                       echo "<li><a href='#'>No Category Yet</a></li>";
                     }
                  
                  ?>
           <!--------------Category fetch dynamically end --------------->

                </ul>
              </li>
              
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="contact.php"><i class="far fa-phone"></i> contact us</a>
              </li>


            </ul>
            
          </div>
        </div>
    </nav>