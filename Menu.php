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
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a href="#" class="navbar-brand">conFUSION</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">

        <form class="form-inline ml-auto ">
            <input type="text" class="form-control mr-sm-2" placeholder="Search">
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
  <?php
    require_once 'scripts/DbOperations.php';

    $db = new DbOperations();
    $res=$db->menudata();
  //  print_r($res);
    $data = $res->get_result();
    while ($dt = $data->fetch_assoc())
{
    //$items[] = $dt;
  //  print_r($items);
    echo'
    <div class= "container">
        <div class = "row" >
          <form>
            <div class="card">
              <h6 class = "card-title">'$dt['dish_name']'</h6>
            </div>
            <div class="card-body">
            <img class="img-fluid" src = "data:image/jpeg;base64,'.base64_encode($dt['image']).'"/>
            </div>
          </form>
        </div>

    </div>
    ';

}
  ?>
</div>

    <script src="jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.js" type="text/javascript"></script>
  </body>

  </html>
