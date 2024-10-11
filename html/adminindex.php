<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords"
    content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template" />
  <meta name="description"
    content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework" />
  <meta name="robots" content="noindex,nofollow" />
  <title>index</title>
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" />
  <!-- Custom CSS -->
  <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
  <!-- Custom CSS -->
  <link href="../dist/css/style.min.css" rel="stylesheet" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <?php
  require_once("topbar.php")
    ?>
  <?php
  require_once("leftside.php")
    ?>
  <!-- ============================================================== -->
  <!-- Page wrapper  -->
  <!-- ============================================================== -->
  <div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">Dashboard</h4>
          <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Library
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
      <!-- ============================================================== -->
      <!-- Sales Cards  -->
      <!-- ============================================================== -->
      <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
          <div class="card card-hover">
            <div class="box bg-cyan text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-account"></i>
              </h1>
              <h6 class="text-white">
                <?php
                require_once("connection.php"); // Include your database connection
                
                if (!$conn) {
                  echo "Connection not found";
                  exit();
                }

                // Query to count total number of users
                $query = "SELECT COUNT(*) as total_users FROM userinfo";
                $result = mysqli_query($conn, $query);

                if ($result) {
                  $data = mysqli_fetch_assoc($result);
                  $totalUsers = $data['total_users'];
                  echo "Total users: " . $totalUsers;
                } else {
                  echo "Error: " . mysqli_error($conn);
                }

                // Close the database connection
                $conn->close();
                ?>
              </h6>
            </div>
          </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-3">
          <div class="card card-hover">
            <div class="box bg-success text-center">
              <h1 class="font-light text-white">
                <i class="mdi mdi-ticket"></i>
              </h1>
              <h6 class="text-white">
                <?php
                // Include your database connection file
                include('connection.php');

                // Check connection
                if (!$conn) {
                  die("Connection failed: " . mysqli_connect_error());
                }

                // SQL query to count total tickets booked
                $sql = "SELECT COUNT(*) AS total_tickets FROM seat_selection";
                $result = mysqli_query($conn, $sql);

                // Check if the query was successful
                if ($result) {
                  $row = mysqli_fetch_assoc($result);
                  $totalTickets = $row['total_tickets'];
                  echo "Tickets booked: " . $totalTickets;
                } else {
                  echo "Error: " . mysqli_error($conn);
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
              </h6>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- Recent comment and chats -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <?php
    require_once("foot.php")
      ?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Page wrapper  -->
  <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap tether Core JavaScript -->
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
  <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
  <!--Wave Effects -->
  <script src="../dist/js/waves.js"></script>
  <!--Menu sidebar -->
  <script src="../dist/js/sidebarmenu.js"></script>
  <!--Custom JavaScript -->
  <script src="../dist/js/custom.min.js"></script>
  <!--This page JavaScript -->
  <!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
  <!-- Charts js Files -->
  <script src="../assets/libs/flot/excanvas.js"></script>
  <script src="../assets/libs/flot/jquery.flot.js"></script>
  <script src="../assets/libs/flot/jquery.flot.pie.js"></script>
  <script src="../assets/libs/flot/jquery.flot.time.js"></script>
  <script src="../assets/libs/flot/jquery.flot.stack.js"></script>
  <script src="../assets/libs/flot/jquery.flot.crosshair.js"></script>
  <script src="../assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
  <script src="../dist/js/pages/chart/chart-page-init.js"></script>
</body>

</html>