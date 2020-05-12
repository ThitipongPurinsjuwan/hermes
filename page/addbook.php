<!--
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
<?php include "../function.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url("/assets/img/apple-icon.png") ?>">
  <link rel="icon" type="image/png" href="<?php echo base_url("/assets/img/favicon.ico") ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Light Bootstrap Dashboard - Free Bootstrap 4 Admin Dashboard by Creative
    Tim
  </title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" name="viewport" />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <!-- CSS Files -->
  <link href="<?php echo base_url("/assets/css/bootstrap.min.css") ?>" rel="stylesheet" />
  <link href="<?php echo base_url("/assets/css/light-bootstrap-dashboard.css?v=2.0.0") ?> " rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url("/assets/css/demo.css") ?>" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=your_api_key_here"></script>
  <script src="https://maps.googleapis.com/maps/api/js"></script>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />
</head>

<body>
  <div class="wrapper">
    <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
      <!--
         Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
 
         Tip 2: you can also add an image using data-image tag
     -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="http://www.creative-tim.com" class="simple-text">
            Creative Tim
          </a>
        </div>
        <ul class="nav">
          <li>
            <a class="nav-link" href="dashboard.html">
              <i class="nc-icon nc-chart-pie-35"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="./user.html">
              <i class="nc-icon nc-circle-09"></i>
              <p>User Profile</p>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./table.html">
              <i class="nc-icon nc-notes"></i>
              <p>Reservation</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="./typography.html">
              <i class="nc-icon nc-paper-2"></i>
              <p>Typography</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="./icons.html">
              <i class="nc-icon nc-atom"></i>
              <p>Icons</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="./maps.html">
              <i class="nc-icon nc-pin-3"></i>
              <p>Maps</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="./notifications.html">
              <i class="nc-icon nc-bell-55"></i>
              <p>Notifications</p>
            </a>
          </li>
          <li class="nav-item active active-pro">
            <a class="nav-link active" href="upgrade.html">
              <i class="nc-icon nc-alien-33"></i>
              <p>Upgrade to PRO</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg" color-on-scroll="500">
        <div class="container-fluid">
          <a class="navbar-brand" href="#pablo"> Table List </a>
          <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="nav navbar-nav mr-auto">
              <li class="nav-item">
                <a href="#" class="nav-link" data-toggle="dropdown">
                  <i class="nc-icon nc-palette"></i>
                  <span class="d-lg-none">Dashboard</span>
                </a>
              </li>
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <i class="nc-icon nc-planet"></i>
                  <span class="notification">5</span>
                  <span class="d-lg-none">Notification</span>
                </a>
                <ul class="dropdown-menu">
                  <a class="dropdown-item" href="#">Notification 1</a>
                  <a class="dropdown-item" href="#">Notification 2</a>
                  <a class="dropdown-item" href="#">Notification 3</a>
                  <a class="dropdown-item" href="#">Notification 4</a>
                  <a class="dropdown-item" href="#">Another notification</a>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nc-icon nc-zoom-split"></i>
                  <span class="d-lg-block">&nbsp;Search</span>
                </a>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <span class="no-icon">Account</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="no-icon">Dropdown</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                  <div class="divider"></div>
                  <a class="dropdown-item" href="#">Separated link</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <span class="no-icon">Log out</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card strpied-tabled-with-hover">
                <section id="tabs" class="project-tab">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-12">
                        <nav>
                          <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-start-tab" data-toggle="tab" href="#nav-start" role="tab" aria-controls="nav-start" aria-selected="true">Start</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact information</a>
                            <a class="nav-item nav-link" id="nav-guest-tab" data-toggle="tab" href="#nav-guest" role="tab" aria-controls="nav-guest" aria-selected="false">Guset information</a>
                            <a class="nav-item nav-link" id="nav-summary-tab" data-toggle="tab" href="#nav-summary" role="tab" aria-controls="nav-summary" aria-selected="false">Summary</a>
                          </div>
                        </nav>
                        <!--start-->
                        <div class="tab-content" id="nav-tabContent">
                          <div class="tab-pane fade show active" id="nav-start" role="tabpanel" aria-labelledby="nav-start-tab">
                            <div class="row">
                              <div class="col">
                                <div class="row m-3">
                                  <div class="col-md-4">
                                    <form id="pai" method="GET">

                                      <p>
                                        Date checkin:
                                        <input class="form-control" type="text" name="datein" value="" id="datein" />
                                        <script>
                                          $("input[id$=datein]").datepicker({
                                            dateFormat: "yy-mm-dd",
                                            minDate: 0,
                                          });
                                        </script>
                                      </p>
                                  </div>
                                  <div class="col-md-4">

                                    <p>
                                      Date checkout:
                                      <input class="form-control" type="text" name="dateout" value="" id="dateout" />
                                      <script>
                                        $("input[id$=dateout]").datepicker({
                                          dateFormat: "yy-mm-dd",
                                          minDate: 0,

                                        });
                                      </script>
                                    </p>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <form id="getroomid" method="POST" action="">
                                  <table border="1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                      <tr class="bg-primary text-white">
                                        <th>#</th>
                                        <th>GUEST NAME</th>
                                        <th>ROOM</th>
                                        <th>AGENCY</th>
                                        <th>MOBILE</th>
                                        <th>CHECK IN</th>
                                        <th>CONTACT NAME</th>
                                        <th>BOOK DATES</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tblroom"></tbody>
                                  </table>
                                </form>
                              </div>
                            </div>
                          </div>
                          <!--contact-->
                          <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="code">Code</label>
                                  <input type="code" class="form-control" id="code" />
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="code">Agency</label>
                                  <br />
                                  <select class="custom-select" id="agency">
                                    <option selected>Choose...</option>
                                    <option value="1">Walk in</option>
                                    <option value="2">By Phone</option>
                                    <option value="3">Booking</option>
                                    <option value="4">Olympusintech</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="name">First Name</label>
                                  <input type="name" class="form-control" id="firstname" />
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="lastname">Last Name</label>
                                  <input type="lastname" class="form-control" id="lastname" />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="phone">Mobile Phone</label>
                                  <input type="phone" class="form-control" id="phone" />
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="email">Email</label>
                                  <input type="email" class="form-control" id="email" />
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-10">
                                <div class="form-group">
                                  <label for="notes">Notes</label>
                                  <input type="notes" class="form-control" id="notes" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--guest-->
                          <div class="tab-pane fade" id="nav-guest" role="tabpanel" aria-labelledby="nav-guest-tab">
                            <div class="container">
                              <div class="row">
                                <div class="col">
                                  <tr>
                                    <td>Frist name:</td>
                                    <td>
                                      <br />
                                      <input type="text" name="firstname" class="form-control" value="" id="gfname" />
                                    </td>
                                  </tr>
                                </div>
                                <div class="col">
                                  <tr>
                                    <td>Last name:</td>
                                    <td>
                                      <br /><input type="text" name="lastname" id="glname" value="" class="form-control" />
                                    </td>
                                  </tr>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <tr>
                                    <td>Phone:</td>
                                    <td>
                                      <br /><input type="text" name="phoneg" id="gphone" value="" class="form-control" />
                                    </td>
                                  </tr>
                                </div>
                                <div class="col">
                                  <tr>
                                    <td>Room price:</td>
                                    <td>
                                      <br /><input type="text" id="groom" value="" class="form-control" />
                                    </td>
                                  </tr>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <tr>
                                    <td>with Breakfast:</td>
                                    <td><br /></td>
                                  </tr>
                                  <select id="inputState" class="form-control">
                                    <option selected>Choose...</option>
                                    <option value="0">not included</option>
                                    <option value="1">included</option>
                                  </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <tr>
                                    <td>BF price:</td>
                                    <td>
                                      <br /><input type="text" class="form-control" id="bf" value="" />
                                    </td>
                                  </tr>
                                </div>
                                <div class="col">
                                  <tr>
                                    <td>Total price:</td>
                                    <td>
                                      <br /><input type="text" name="" class="form-control" id="total" value="" />
                                    </td>
                                  </tr>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--summary-->
                          <div class="tab-pane fade" id="nav-summary" role="tabpanel" aria-labelledby="nav-summary-tab">
                            <div class="container">
                              <div class="row">
                                <div class="col-6">
                                  <div class="card-header bg-info text-white card-bordered">
                                    <h5>Booking Details</h5>
                                  </div>
                                  <div class="card-body-bordered">
                                    <div class="row">
                                      <div class="col">
                                        <p> booking :</p>
                                      </div>
                                      <div class="col">
                                        <p id="codebook"></p>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <p> bookdate time :</p>
                                      </div>
                                      <div class="col">
                                        <p id="booktime"></p>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <p> check in :</p>
                                      </div>
                                      <div class="col">
                                        <p id="chin"></p>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <p> check out :</p>
                                      </div>
                                      <div class="col">
                                        <p id="chout" value=""></p>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <p> #room :</p>
                                      </div>
                                      <div class="col">
                                        <p id="roomlenght"></p>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <p> #night :</p>
                                      </div>
                                      <div class="col">
                                        <p id="night"></p>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <p> total :</p>
                                      </div>
                                      <div class="col">
                                        <p id="ttal"></p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="card-header bg-secondary text-white card-bordered">
                                    <h5>Room Information</h5>
                                  </div>
                                  <div class="card-body-bordered">
                                    <table class="table table-bordered table-striped table-hover">
                                      <thead>
                                        <tr class="bg-primary text-white">
                                          <th scope="col">Room</th>
                                          <th scope="col" class="text-nowrap">
                                            Guset
                                          </th>
                                          <th scope="col">Contact</th>
                                          <th scope="col">Price</th>
                                          <th scope="col">BF</th>
                                        </tr>
                                      </thead>
                                      <tbody id="tblroomm">
                                        <tr id="show0">
                                          <td class="text-nowrap" id="nameroomt0"></td>
                                          <td class="text-nowrap" id="name_r0">

                                          </td>
                                          <td class="text-nowrap" id="phone_r0"></td>
                                          <td class="text-nowrap" id="priceroomt0"></td>
                                          <td class="text-nowrap" id="bf_r0"></td>
                                        </tr>
                                        <tr id="show1">
                                          <td class="text-nowrap" id="nameroomt1"></td>
                                          <td class="text-nowrap" id="name_r1">

                                          </td>
                                          <td class="text-nowrap" id="phone_r1"></td>
                                          <td class="text-nowrap" id="priceroomt1"></td>
                                          <td class="text-nowrap" id="bf_r1"></td>
                                        </tr>
                                        <tr id="show2">
                                          <td class="text-nowrap" id="nameroomt2"></td>
                                          <td class="text-nowrap" id="name_r2">

                                          </td>
                                          <td class="text-nowrap" id="phone_r2"></td>
                                          <td class="text-nowrap" id="priceroomt2"></td>
                                          <td class="text-nowrap" id="bf_r2"></td>
                                        </tr>
                                        <tr id="show3">
                                          <td class="text-nowrap" id="nameroomt3"></td>
                                          <td class="text-nowrap" id="name_r3">

                                          </td>
                                          <td class="text-nowrap" id="phone_r3"></td>
                                          <td class="text-nowrap" id="priceroomt3"></td>
                                          <td class="text-nowrap" id="bf_r3"></td>
                                        </tr>
                                        <tr id="show4">
                                          <td class="text-nowrap" id="nameroomt4"></td>
                                          <td class="text-nowrap" id="name_r4">

                                          </td>
                                          <td class="text-nowrap" id="phone_r4"></td>
                                          <td class="text-nowrap" id="priceroomt4"></td>
                                          <td class="text-nowrap" id="bf_r4"></td>
                                        </tr>
                                        <tr id="show5">
                                          <td class="text-nowrap" id="nameroomt5"></td>
                                          <td class="text-nowrap" id="name_r5">

                                          </td>
                                          <td class="text-nowrap" id="phone_r5"></td>
                                          <td class="text-nowrap" id="priceroomt5"></td>
                                          <td class="text-nowrap" id="bf_r5"></td>
                                        </tr>
                                        <tr id="show6">
                                          <td class="text-nowrap" id="nameroomt6"></td>
                                          <td class="text-nowrap" id="name_r6">

                                          </td>
                                          <td class="text-nowrap" id="phone_r6"></td>
                                          <td class="text-nowrap" id="priceroomt6"></td>
                                          <td class="text-nowrap" id="bf_r6"></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="card-header bg-success text-white card-bordered">
                                    <h5>Customer Information</h5>
                                  </div>
                                  <div class="card-body-bordered">
                                    <div class="row">
                                      <div class="col">
                                        <p>customer name :</p>
                                      </div>
                                      <div class="col">

                                        <p id="c"></p>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col">
                                        <p>phone number :</p>
                                      </div>
                                      <div class="col">
                                        <p id="ph"></p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <p> email :</p>
                                    </div>
                                    <div class="col">
                                      <p id="e"></p>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <p> agency :</p>
                                    </div>
                                    <div class="col">
                                      <p id="a"></p>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <button type="button" class="btn btn-primary btn-block btn-round" onclick="location.href='index.php'" id="btn_confirm">
                                      Confirm
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  </div>
  <footer class="footer">
    <div class="container-fluid">
      <nav>
        <ul class="footer-menu">
          <li>
            <a href="#">
              Home
            </a>
          </li>
          <li>
            <a href="#">
              Company
            </a>
          </li>
          <li>
            <a href="#">
              Portfolio
            </a>
          </li>
          <li>
            <a href="#">
              Blog
            </a>
          </li>
        </ul>
        <p class="copyright text-center">
          ©
          <script>
            document.write(new Date().getFullYear());
          </script>
          <a href="http://www.creative-tim.com">Creative Tim</a>, made
          with love for a better web
        </p>
      </nav>
    </div>
  </footer>
  </div>
  </div>
</body>
<!--   Core JS Files   -->
<script src="<?php echo base_url("/assets/js/core/jquery.3.2.1.min.js")?>" type="text/javascript"></script>
<script src="<?php echo base_url("/assets/js/core/popper.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("/assets/js/core/bootstrap.min.js") ?>" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="<?php echo base_url("/assets/js/plugins/bootstrap-switch.js") ?>"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="<?php echo base_url("/assets/js/plugins/chartist.min.js") ?>"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url("/assets/js/plugins/bootstrap-notify.js") ?>"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="<?php echo base_url("/assets/js/light-bootstrap-dashboard.js?v=2.0.0") ?> " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url("/assets/js/demo.js")?>"></script>
<script src="<?php echo base_url("/application/jquery1.js")?>"></script>

</html>