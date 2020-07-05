<?php
session_start();

?>
<DOCTYPE html>
  <html lang="en">

  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="node_modules/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="css/styles.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="css/stylesmenu.css" type="text/css" rel="stylesheet">

    <title>ConFusion</title>
  </head>

  <body class="bg">
    <!--     <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">  for dark navbar-->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark  fixed-top">
    <a href="index.php" class="navbar-brand">conFUSION</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">

        <form class="form-inline ml-auto " action="MenuOnSearch.php" method="post">
            <input type="text" class="form-control mr-sm-2" name="search" placeholder="Search">
            <button type="submit" class="btn btn-outline-light" style="  justify-content: flex-end;" >Search</button>
        </form>
        <div class="navbar-nav text-right">
          <?php
          error_reporting(0);
            if (!$_SESSION['email']) { ?>
              <a  data-target="#signup" data-toggle="modal"  id="MainNavHelp"
         href="#signup" class="nav-item nav-link" style="color:white;">Sign Up</a>
              <a data-target="#signin" data-toggle="modal"  id="MainNavHelp"
         href="#signin" class="nav-item nav-link" style="color:white; ">Sign In</a>
         <?php
            } else {
                ?>
          <a data-target="#signin" data-toggle="modal"  id="MainNavHelp"href="#signin" class="nav-item nav-link" style="color:white;">Cart</a>
          <button class="btn btn5" data-toggle="modal" data-target=".bs-example-modal-sm">Logout </button>

            <?php
            }
          ?>
        </div>
    </div>
</nav>
<div class="container" style="color:white;    padding-top: 65px; ">
  <div class="row" style="margin:30px;">

  <?php
    require_once 'scripts/DbOperations.php';

    $db = new DbOperations();
    $res=$db->menudata();
  //  print_r($res);
    $data = $res->get_result();
    while ($dt = $data->fetch_assoc()) { ?>
  <div class="col-lg-4 col-md-3 col-xs-12 d-flex align-items-stretch no-gutters" >
  <form>
      <div class="card  bg-dark " style="height:550px;" >

          <h6 class="card-title " style="margin:20px "> <?php echo $dt['dish_name']; ?> </h6>
          <div class="card-body">
            <img class="img-fluid "  width="200" height="100"
            <?php echo' src = "data:image/jpeg;base64,'.base64_encode($dt['image']).'"' ?>/>
            <h6 style="margin-top:10px"> Price: Rs. <?php echo  $dt['price']; ?> </h6>
            <h6 class="badge badge-success"> 4.5 <i class="fa fa-star"> </i> </h6>
            <h6 > <?php
              if ($dt['isveg']) {
                  echo "Veg";
              } else {
                  echo "Non-Veg";
              }
             ?>
           </h6>
           <h6> Offered by: <?php echo $dt['restaurant']; ?></h6>
           <h6> Contact: <?php echo $dt['resturant_email']; ?> </h6>
            <button type="submit" class="btn btn-success" style="  justify-content: flex-end;" >Add to Cart</button>

        </div>
      </div>
    </form>

    </div>
<?php
}
  ?>
</div>

<!-- Modal Sign In-->
<div class="modal fade" id="signin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Sign In</h4>

      </div>
      <div class="modal-body">
        <form class="animate" action="scripts/login.php" method="post">
          <div class="container">
            <div class="row-2">
              <label for="email" style="margin-top:2vw;color:black;"><b>Email</b></label>
              <input type="email" class="col-12 txtfeild" placeholder="Enter Email" name="email" required>
            </div>
            <div class="row-2">
              <label for="psw" style="color:black;"><b>Password</b></label>
              <input type="password" class="col-12 txtfeild" placeholder="Enter Password" name="psw" required>
            </div>
            <label>
              <input type="checkbox" checked="checked" style="font-color:white;" name="remember"> Remember me
            </label>
            <div class="row-2">
              <button class="btn col btn3" type="submit">Login</button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- Modal Sign Up -->
<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header gen">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

        </button>
        <h4 class="modal-title" id="myModalLabel">Sign Up</h4>

      </div>
      <div class="modal-body gen">
        <div role="tabpanel">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="nav-item"><a class="nav-link active" href="#foodies" aria-controls="foodies" role="tab" data-toggle="tab">Foodies</a>

            </li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="#resturants" aria-controls="resturants" role="tab" data-toggle="tab">Resturants</a>

            </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="foodies">
              <form class="animate" action="scripts/foodies_register.php" method="post">
                <div class="container">
                  <div class="row-2">
                    <label for="name" style="margin-top:2vw;color:black;"><b>Name</b></label>
                    <input type="name" class="col-12 txtfeild" placeholder="Enter Name" name="uname" required>
                  </div>
                  <div class="row-2">
                    <label for="email" style="color:black;"><b>Email</b></label>
                    <input type="email" class="col-12 txtfeild" placeholder="Enter Email" name="email" required>
                  </div>
                  <div class="row-2">
                    <label for="psw" style="color:black;"><b>Password</b></label>
                    <input type="password" class="col-12 txtfeild" placeholder="Enter Password" name="psw" required>
                  </div>
                  <label>
                    <input type="checkbox" checked="checked" style="font-color:white;" name="isveg" value="veg"> Veg
                  </label>
                  <div class="row-2">
                    <button class="btn col btn3" type="submit">Sign Up</button>
                  </div>
                </div>
              </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="resturants">
              <form class="animate" action="scripts/restaurants_register.php" method="post">
                  <div class="row-2">
                    <label for="name" style="margin-top:2vw;color:black;"><b>Resturant Name</b></label>
                    <input type="name" class="col-12 txtfeild " placeholder="Enter Name" name="uname" required>
                  </div>
                  <div class="row-2">
                    <label for="email" style="color:black;"><b>Email</b></label>
                    <input type="email" class="col-12 txtfeild" placeholder="Enter Email" name="email" required>
                  </div>
                  <div class="row-2">
                    <label for="psw" style="color:black;"><b>Password</b></label>
                    <input type="password" class="col-12 txtfeild" placeholder="Enter Password" name="psw" required>
                  </div>
                  <div class="row-2">
                    <button class="btn col btn3" name="submit" type="submit">Sign Up</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
  <div class="modal-header"><h4>Logout <i class="fa fa-lock"></i></h4></div>
  <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to log-off?</div>
  <div class="modal-footer"><a href="scripts/logout.php" class="btn btn-block btn4">Logout</a></div>
</div>
</div>
</div>

    <script src="jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.js" type="text/javascript"></script>
  </body>

  </html>
