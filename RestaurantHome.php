<?php
session_start();
  if (strcmp($_SESSION['type'], "restaurants")!=0) {
      header('Location: http://localhost/skel/index.php?msg=' . urlencode(base64_encode("Not authorized")));
  }
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

  <body class="bg">
    <!--     <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">  for dark navbar-->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark  fixed-top">
    <a href="index.php" class="navbar-brand">conFUSION</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" style="justify-content:flex-end;" id="navbarCollapse">


        <div class="navbar-nav text-right">
          <button class="btn btn5" data-toggle="modal" data-target="#orders">Orders </button>
          <button class="btn btn5" data-toggle="modal" data-target=".bs-example-modal-sm">Logout </button>
        </div>
    </div>
</nav>
<div class="container" style="color:white;    padding-top: 65px; ">
  <div class="row" style="margin:30px;">


  <?php
    require_once 'scripts/DbOperations.php';

    $db = new DbOperations();
    $res=$db->menudatares($_SESSION['email']);
    $data = $res->get_result();
    while ($dt = $data->fetch_assoc()) { ?>
  <div class="col-lg-4 col-md-3 col-xs-12 d-flex align-items-stretch no-gutters" >
  <form>
      <div class="card  bg-dark " style="height:380px;" >

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

        </div>
      </div>
    </form>
    </div>
<?php
}
  ?>
  <div class="col-lg-4 col-md-3 col-xs-12 d-flex align-items-stretch no-gutters" >
  <form>
      <div class="card  bg-dark ele" style="height:380px; max-width:230px;" >
          <div class="card-body" >
            <a data-target="#addItems" data-toggle="modal"  >Add Items</a>
            <a data-target="#addItems" data-toggle="modal" >
              <img class="img-fluid "  width="200" height="100"  style="margin-top:20%"src ="img/Add.png" />
            </a>
          </div>
      </div>
    </form>

    </div>
</div>

<?php
require_once 'scripts/DbOperations.php';

$db = new DbOperations();
if (isset($_POST["insert"])) {
    if ($db->uniquefood($_POST['dishname'], $_SESSION['email'])) {
        $file = addslashes(file_get_contents($_FILES['image']['tmp_name']));

        $user = $db->getrestaurantname($_SESSION['email']);

        echo' <img src = "data:image/jpeg;base64,'.base64_encode($file).'" />';
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
        } else {
            $response['message'] = "Failed";
        }

        header("Location: http://localhost/skel/RestaurantHome.php");
    } else {
        echo '<script>alert("Duplicate Dish.Insertion Failed")</script>';
    }
}
?>
<!-- Add Items -->

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
              <input type="text" class="col-12 txtfeild" placeholder="Enter Price" name="price" required>
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

<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
  <div class="modal-header"><h4>Logout <i class="fa fa-lock"></i></h4></div>
  <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to log-off?</div>
  <div class="modal-footer"><a href="scripts/logout.php" class="btn btn-block btn4">Logout</a></div>
</div>
</div>
</div>


  <!--Order Modal -->
  <div class="modal fade " id="orders" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark">
      <div class="modal-content bg-dark">
        <div class="modal-header">
          <h4 class="modal-title" style="color:white" id="myModalLabel">Orders</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container overflow-auto" style="max-height:35vw">
              <div class="row" >

                <?php
                $tot=0;
                $res=$db->orderData($_SESSION['email']);
                //  print_r($res);
                $data = $res->get_result();
                while ($dt = $data->fetch_assoc()) { ?>
                  <div class="card col-12  bg-dark " style="color:white"  >

                    <h6 class="card-title " style="margin-left:20px;padding-bottom:-30px;color:white"  name="dish_name">Dish Name: <?php echo $dt['dish_name']; ?> </h6>
                    <input type="hidden" name="dish_name" value=<?php echo $dt['dish_name'];?>>
                    <div class="card-body">
                      <h6> Customer Name: <?php
                        $arr = $db->getName($dt['cust_email']);
                        echo $arr['name'];
                       ?>
                      <h6 > Price: Rs. <?php
                      $tot=$tot+1;
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
              </div>
            </div>
          </div>
      </div>

    </div>
  </div>


    <script src="jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.js" type="text/javascript"></script>
  </body>

  </html>
