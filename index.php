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

    <title>Con Fusion</title>


  </head>

  <body class="bg">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top" >
    <a href="#" class="navbar-brand">conFUSION</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse  text-right " id="navbarCollapse">

            <a data-target="#signup" data-toggle="modal"  id="MainNavHelp"
       href="#signup" class="nav-item nav-link" style="color:white;">Sign Up</a>
            <a data-target="#signin" data-toggle="modal"  id="MainNavHelp"
       href="#signin" class="nav-item nav-link" style="color:white;">Sign In</a>
            <a href="#" class="nav-item nav-link" style="color:white;">Logout</a>
        </div>
    </div>
  </nav>

    <div class="container">
      <div class="row logo">
        <h1 class="col cname">conFUSION</h1>
      </div>

      <div class="row">
        <h3 class="tag">Experience the great food</h3>
      </div>

      <div class="row ">
        <form class="offset-2 col-12" action="MenuOnSearch.php" method="post" >
        <input class="  search" style="width:60%" type="text" name="search" placeholder="    Search..">
        <button class="col-1 btn btn1" type="submit" name="button"> Go </button>
        </form>
      </div>

      <div class="row">
        <a class="col-2 btn btn2"  href="Menu.php" >Explore Menu</a>
      </div>
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


    <script src="jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.bundle.js" type="text/javascript"></script>
    <script>
      // Get the modal
      var modal = document.getElementById('signin');

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    </script>

  </body>

  </html>
