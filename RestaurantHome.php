<?php
session_start();
error_reporting(0);
//Check if the user is Resturant or else redirect back to index page
if (strcmp($_SESSION['type'], "restaurants")!=0) {
    header('Location:index.php?msg=' . urlencode(base64_encode("Not authorized")));
}?>

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


    <title>ConFusion</title>
  </head>

<!--Body-->
  <body class="bg">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark  fixed-top">
      <a href="index.php" class="navbar-brand">conFUSION</a>
      <div class="row">
        <div class="col" style="margin-left:35vw;">
          <?php
          //Reading Encoded message in the return URL once
          if ($_GET['msg'] && $_SESSION['index']==0) {
              echo '<div class="alert alert-success alert">' . base64_decode(urldecode($_GET['msg'])) . '</div>';
              $_SESSION['index']=1;
          }
          //Calling DbOperations
          require_once 'scripts/DbOperations.php';
          //Intitializing
          $db = new DbOperations();
          //if Delete Item button is clicked remove the certain item from the Menu
          if (isset($_POST['delete_items'])) {
              //print_r($_POST['dish_name']);
              $res=$db->menu_data_delete($_SESSION['email'], $_POST['dish_name']);
              if ($res==1) {
                  echo '<div class="alert alert-success alert "> "Removed Item" </div>';
              } else {
                  echo '<div class="alert alert-danger alert "> "Failed" </div>';
              }
          }?>
        </div>
      </div>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!--Navbar-->
      <div class="collapse navbar-collapse" style="justify-content:flex-end;" id="navbarCollapse">
        <div class="navbar-nav text-right">
          <button class="btn btn5" data-toggle="modal" data-target="#orders">Orders </button>
          <button class="btn btn5"onclick="location.href='Menu.php'" >Menu </button></a>
          <button class="btn btn5" data-toggle="modal" data-target=".bs-example-modal-sm">Logout </button>
        </div>
      </div>
    </nav>
    <!--Load the items provided by the restaurant-->
    <div class="container" style="color:white;    padding-top: 65px; ">
      <div class="row" style="margin:30px;">
        <?php
        $res=$db->menudatares($_SESSION['email']);
        $data = $res->get_result();
        while ($dt = $data->fetch_assoc()) { ?>
          <div class="col-xl-3 col-md-4 col-xs-12 col-sm-6 d-flex align-items-stretch no-gutters" >
            <form method="post">
              <div class="card  bg-dark card_prop " >
                <div class="row " style="margin-left:5px;margin-right:5px;">
                  <h6 class="card-title " style="margin:20px; "> <?php echo $dt['dish_name']; ?> </h6>
                  <button type="submit" name="delete_items" id="delete_items" class="close" style="margin-top:-5px" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="card-body">
                  <img class="img-fluid img-prop"
                  <?php echo' src = "data:image/jpeg;base64,'.base64_encode($dt['image']).'"' ?>/>
                  <h6 style="margin-top:10px"> Price: Rs. <?php echo  $dt['price']; ?> </h6>
                  <h6 class="badge badge-success"> 4.5 <i class="fa fa-star"> </i> </h6>
                  <input type="hidden" name="dish_name" value= "<?php echo $dt['dish_name'];?>"/>
                  <h6 ><?php if ($dt['isveg']) {
            echo "Veg";
        } else {
            echo "Non-Veg";
        }?>
                </h6>
              </div>
            </div>
          </form>
        </div>
        <?php
      }
      ?>

      <!--Code to delete order from the order when clicked on order done-->
      <?php
        if (isset($_POST['order_done'])) {
            $res=$db->order_done($_POST['dish_name'], $_POST['cust_email']);
        }
       ?>

       <!--Add Items Card-->
      <div class="col-lg-4 col-md-3 col-xs-12 d-flex align-items-stretch no-gutters" >
        <form>
          <div class="card  bg-dark addItem card_prop" >
            <div class="card-body addItem" >
              <a data-target="#addItems" data-toggle="modal"  >Add Items</a>
              <a data-target="#addItems" data-toggle="modal" >
                <img class="img-fluid "  width="200" height="100"  style="margin-top:20%"src ="img/Add.png" />
              </a>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

<!--Insert New dish in table php Code-->
    <?php
    if (isset($_POST["insert"])) {
        if ($db->uniquefood($_POST['dishname'], $_SESSION['email'])) {
            $file = file_get_contents(addslashes($_FILES['image']['tmp_name']));
            $user = $db->getrestaurantname($_SESSION['email']);
            //echo' <img src = "data:image/jpeg;base64,'.base64_encode($file).'" />';
            //Converting the checkbox value into boolean
            $isveg;
            if (isset($_POST['isveg'])) {
                $isveg=1;
            } else {
                $isveg=0;
            }
            $res = $db->addfood($_POST['dishname'], $_POST['price'], $isveg, $file, $user['name'], $_SESSION['email']);
            if ($res == 1) {
                $response['message'] = "Success";
                echo '<script>location = self.location</script>';
            } else {
                $response['message'] = "Failed";
                //reload page
                echo '<script>location = self.location</script>';
            }
        } else {
            echo '<script>alert("Duplicate Dish.Insertion Failed")</script>';
        }
    }
    ?>

    <!-- Add Items Modal-->
    <div class="modal fade " id="addItems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-dark">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Items</h4>

          </div>
          <div class="modal-body">
            <form class="animate"  enctype="multipart/form-data"  method="post">
              <div class="container">
                <div class="row-2">
                  <label for="dishname" style="margin-top:2vw;color:black;"><b>Dish Name</b></label>
                  <input type="text" class="col-12 txtfeild" placeholder="Enter Dish Name" name="dishname" required>
                </div>
                <div class="row-2">
                  <label for="price" style="color:black;"><b>Price</b></label>
                  <input type="number" step="0.01" min=0 class="col-12 txtfeild" placeholder="Enter Price" name="price" required>
                </div>
                <label for="image" style="color:black;"><b>Image</b></label>
                <input type="file" class="col-12" id="image" style="margin-bottom:1vw;" name="image" required>
                <label>
                  <input type="checkbox" checked="checked" style="font-color:white;" name="isveg"> Veg
                </label>
                <div class="row-2">
                  <button class="btn col btn3" id ="insert" name="insert" type="submit">Submit</button>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

<!--Logout Modal-->
    <div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content bg-dark">
          <div class="modal-header" style="color:white"><h4>Logout <i class="fa fa-lock"></i></h4></div>
          <div class="modal-body" style="color:white"><i class="fa fa-question-circle"></i> Are you sure you want to log-out?</div>
          <div class="modal-footer"><a href="scripts/logout.php" class="btn btn-block btn4">Logout</a></div>
        </div>
      </div>
    </div>


    <!--Orders Modal -->
    <div class="modal fade " id="orders" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog bg-dark">
        <div class="modal-content bg-dark">
          <div class="modal-header">
            <h4 class="modal-title" style="color:white" id="myModalLabel">Orders</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container overflow-auto" id="style-1" style="max-height:35vw">
              <div class="row" >
                <!--Display orders-->
                <?php
                $tot=0;
                $res=$db->orderData($_SESSION['email']);
                //  print_r($res);
                $data = $res->get_result();
                while ($dt = $data->fetch_assoc()) { ?>
                  <div class="card col-12  bg-dark " style="color:white"  >
                    <form method="post">
                      <div class="row">
                        <h6 class="card-title col-9" style="margin-left:20px;margin-top:20px;color:white"  name="dish_name">Dish Name: <?php echo $dt['dish_name']; ?> </h6>
                        <button type="submit" name="order_done" class="btn btn-5 btn-success" style="font-size:1vw;margin-top:20px;height:40px;line-height:20px;" >Done</button>
                        </div>
                        <input type="hidden" name="dish_name" value="<?php echo $dt['dish_name'];?>">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-6">
                          <h6> Customer Name: <?php
                          $arr = $db->getName($dt['cust_email']);
                          echo $arr['name'];
                          ?>
                          <!--Hidden Inputs for deleting orders -->
                          <input type="hidden" name="dish_name" value="<?php echo $dt['dish_name'];?>">
                          <input type="hidden" name="cust_email" value="<?php echo $dt['cust_email'];?>">
                          <h6 > Price: Rs. <?php
                          $tot=$tot+1;
                          echo  $dt['price'];
                          ?> </h6>
                          <h6 >  No. of Items: <?php echo $dt['count'];?>
                          <h6 >  Delivery address: <?php
                          $arr=$db->get_addr($dt['cust_email']);
                          echo $arr['address'];?>
                          </div>
                            <div class="row-4 ">
                              <?php $image=$db->get_image($dt['dish_name']) ?>
                              <img class="img-fluid thumbn2"
                              <?php echo' src = "data:image/jpeg;base64,'.base64_encode($image['image']).'"' ?>/>
                            </div>
                        </div>
                      </div>
                      </form>
                    </div>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!--Java Scripts -->

      <!--Script to stop the resubmission pop up occuring on refresh-->

      <script>
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
      }
      </script>
      <!--Script to make alerts go away after 2 sec -->

      <script>
        //disappearing alert after 2 sec
      window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
        });
      }, 2000);
      </script>

      <script src="jquery/myscripts.js" type="text/javascript"></script>
      <script src="jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
      <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.js" type="text/javascript"></script>
    </body>

    </html>
