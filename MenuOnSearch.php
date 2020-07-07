<?php
session_start();
error_reporting(0);

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
    <link rel="stylesheet" href="css/stylesmenu.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="css/stylessupp.css" type="text/css" rel="stylesheet">

    <title>ConFusion</title>
  </head>

  <body class="bg ">
    <!--     <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">  for dark navbar-->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark  fixed-top">
      <a href="Menu.php" class="navbar-brand">conFUSION</a>
      <div class="row">
        <div class="col" style="margin-left:35vw;">
          <?php
          require_once 'scripts/DbOperations.php';

          $db = new DbOperations();

          if (isset($_POST['cart']) && isset($_SESSION['email'])) {
            //print_r($_POST);
            $res = $db->addOrder($_POST['dish_name'], $_POST['price'], $_SESSION['email'], $_POST['restaurant'], $_POST['restaurant_email']);
            if ($res == 1) {
              $response['message'] = "Success";
            } else {
              $response['message'] = "Failed";
            }
            echo '<div class="alert alert-success alert "> "Added to Cart" </div>';
          }

          ?>
        </div>
      </div>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse-md navbar-collapse" id="navbarCollapse">

        <form class="form-inline ml-auto " action="MenuOnSearch.php" style="margin-top:12px" method="post">
          <input type="text" class="btn btn5" style="  border-radius: 25px; color:white" name="search" placeholder="Search">
          <button type="submit" class="btn btn5" >Search</button>
        </form>
        <div class="navbar-nav text-right">
          <?php
          if (!$_SESSION['email']) { ?>
            <button class="btn btn5" data-toggle="modal" data-target="#signup">Sign Up </button>
            <button class="btn btn5" data-toggle="modal" data-target="#signin">Sign In </button>

            <?php
          } else {
            if (strcmp($_SESSION['type'], "restaurants")!=0) {            ?>

              <button class="btn btn5" data-toggle="modal" data-target="#carts">Cart </button>
            <?php } ?>
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
        $res=$db->searchmenu($_POST['search']);
        //  print_r($res);
        $data = $res->get_result();
        while ($dt = $data->fetch_assoc()) { ?>
          <div class=" col-xl-3 col-md-4 col-xs-12 col-sm-6 d-flex align-items-stretch no-gutters" >
            <form method="post">
              <div class="card  bg-dark " style=" margin-top: 40px;height:500px;" >

                <h6 class="card-title " style="margin:20px " name="dish_name"> <?php echo $dt['dish_name']; ?> </h6>
                <input type="hidden" name="dish_name" value=<?php echo $dt['dish_name'];?>>
                <div class="card-body">
                  <img class="img-fluid "  width="200" height="100" style="max-height:200px;min-height:200px"
                  <?php echo' src = "data:image/jpeg;base64,'.base64_encode($dt['image']).'"' ?>/>
                  <h6 style="margin-top:10px" name="price"> Price: Rs. <?php echo  $dt['price']; ?> </h6>
                  <input type="hidden" name="price" value=<?php echo $dt['price'] ;?>>
                  <h6 class="badge badge-success"> 4.5 <i class="fa fa-star"> </i> </h6>
                  <h6 > <?php
                  if ($dt['isveg']) {
                    echo "Veg";
                  } else {
                    echo "Non-Veg";
                  }
                  ?>
                </h6>
                <h6 > Offered by: <?php echo $dt['restaurant']; ?></h6>
                <input type="hidden" name="restaurant" value=<?php echo $dt['restaurant'] ;?> >
                <h6 name= > Contact: <?php echo $dt['restaurant_email']; ?> </h6>
                <input type="hidden" name="restaurant_email" value=<?php echo $dt['restaurant_email'] ;?> >
                <?php if (strcmp($_SESSION['type'], "restaurants")!=0) {
                  if ($_SESSION['email']) { ?>
                    <button type="submit" name="cart" id="cart" class="btn btn-success" style="  justify-content: flex-end;" >Add to Cart</button>
                  <?php } else { ?>
                    <a class="btn btn-success" data-toggle="modal" data-target="#signin">Add to Cart </a>
                  <?php } ?>                  <?php
                } ?>
              </div>
            </div>
          </form>
        </div>
        <?php
      }
      ?>
    </div>
  </div>



  <!-- Modal Sign In-->
  <div class="modal fade" id="signin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" style="color:white"id="myModalLabel">Sign In</h4>

        </div>
        <div class="modal-body ">
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
      <div class="modal-content bg-dark">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

          </button>
          <h4 class="modal-title" style="color:white" id="myModalLabel">Sign Up</h4>

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
                      <input type="text" class="col-12 txtfeild" placeholder="Enter Name" name="uname" required>
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
                    <input type="text" class="col-12 txtfeild " placeholder="Enter Name" name="uname" required>
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

  <!-- Logout modal -->
  <div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content bg-dark">
        <div class="modal-header" style="color:white"><h4>Logout <i class="fa fa-lock"></i></h4></div>
        <div class="modal-body" style="color:white"><i class="fa fa-question-circle"></i> Are you sure you want to log-out?</div>
        <div class="modal-footer"><a href="scripts/logout.php" class="btn btn-block btn4">Logout</a></div>
      </div>
    </div>
  </div>

  <!--Cart Modal -->
  <div class="modal fade " id="carts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark">
      <div class="modal-content bg-dark">
        <div class="modal-header">
          <h4 class="modal-title" style="color:white" id="myModalLabel">Cart</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="animate"  method="post">
            <div class="container">
              <div class="row" >

                <?php
                $tot=0;
                $res=$db->cartData($_SESSION['email']);
                //  print_r($res);
                $data = $res->get_result();
                while ($dt = $data->fetch_assoc()) { ?>
                  <div class="card col-12  bg-dark " style="color:white"  >

                    <h6 class="card-title " style="margin-left:20px;padding-bottom:-30px;color:white"  name="dish_name"> <?php echo $dt['dish_name']; ?> </h6>
                    <input type="hidden" name="dish_name" value=<?php echo $dt['dish_name'];?>>
                    <div class="card-body">

                      <h6  name="price"> Price: Rs. <?php
                      $tot=$tot+($dt['price']*$dt['count']);
                      echo  $dt['price'];
                      ?> </h6>
                      <h6 >  No. of Items: <?php echo $dt['count'];                   ?>
                      </h6>
                      <h6 > Offered by: <?php echo $dt['restaurant']; ?></h6>
                    </div>
                  </div>
                  <?php
                }
                ?>
                <h4 style="color:white;margin-top:10px;">Total Amount: <?php echo $tot; ?> </h4>
              </div>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>


<script>
//disappearing alert after 2 sec
window.setTimeout(function() {
  $(".alert").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();
  });
}, 2000);
</script>

<script src="jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.js" type="text/javascript"></script>
</body>

</html>
