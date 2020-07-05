<? php
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
            <a href="#" class="nav-item nav-link active">Cart</a>

            <a href="#" class="nav-item nav-link">Sign Up</a>
            <a href="#" class="nav-item nav-link">Sign In</a>
            <a href="#" class="nav-item nav-link">Logout</a>
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
    while ($dt = $data->fetch_assoc())
{ ?>
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
              if($dt['isveg'])
                echo "Veg";
              else
                echo "Non-Veg";
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

    <script src="jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.js" type="text/javascript"></script>
  </body>

  </html>
