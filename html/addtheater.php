<?php
require_once("connection.php");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $errors = [];

  // Server-side validation
  $theater_name = trim($_POST['theater_name']);
  $owner_name = trim($_POST['owner_name']);
  $contact_no = trim($_POST['contact_no']);
  $address = trim($_POST['address']);
  $owner_email = trim($_POST['owner_email']);
  $is_active = trim($_POST['is_active']);

  // Validate required fields
  if (empty($theater_name))
    $errors[] = "Theater name is required.";
  if (empty($owner_name))
    $errors[] = "Owner name is required.";
  if (empty($contact_no) || !preg_match('/^[0-9]{10}$/', $contact_no))
    $errors[] = "A valid 10-digit contact number is required.";
  if (empty($address))
    $errors[] = "Address is required.";
  if (empty($owner_email) || !filter_var($owner_email, FILTER_VALIDATE_EMAIL))
    $errors[] = "A valid email is required.";
  if (!in_array($is_active, ['0', '1']))
    $errors[] = "Invalid status for 'Is Active'. Please use 0 (inactive) or 1 (active).";

  // Handle file upload
  if (isset($_FILES['theater_poster']) && $_FILES['theater_poster']['error'] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["theater_poster"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
      $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // If no errors, move the uploaded file and insert data into DB
    if (empty($errors)) {
      if (move_uploaded_file($_FILES["theater_poster"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO theater (name, poster, owner, mobileno, address, email, is_active)
                VALUES ('$theater_name','$target_file','$owner_name','$contact_no','$address','$owner_email','$is_active')";
        if ($conn->query($sql) === TRUE) {
          echo "<script> alert('Added successfully'); </script>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else {
        $errors[] = "Error uploading the file.";
      }
    }
  } else {
    $errors[] = "Please upload a valid theater poster.";
  }

  if (!empty($errors)) {
    foreach ($errors as $error) {
      echo "<p style='color:red;'>$error</p>";
    }
  }
}

$conn->close();
?>

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
  <title>Matrix Admin Lite Free Versions Template by WrapPixel</title>
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" />
  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/libs/select2/dist/css/select2.min.css" />
  <link rel="stylesheet" type="text/css" href="../assets/libs/jquery-minicolors/jquery.minicolors.css" />
  <link rel="stylesheet" type="text/css"
    href="../assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" />
  <link rel="stylesheet" type="text/css" href="../assets/libs/quill/dist/quill.snow.css" />
  <link href="../dist/css/style.min.css" rel="stylesheet" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <?php
  require_once("topbar.php")
    ?>

  <?php
  require_once("leftside.php")
    ?>
  <!-- ============================================================== -->
  <!-- End Topbar header -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Left Sidebar - style you can find in sidebar.scss  -->
  <!-- ============================================================== -->

  <!-- ============================================================== -->
  <!-- End Left Sidebar - style you can find in sidebar.scss  -->
  <!-- ============================================================== -->
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
          <h4 class="page-title">Add Theater</h4>
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
      <!-- Start Page Content -->
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <form class="form-horizontal" name="theaterForm" action="" method="post" enctype="multipart/form-data"
              onsubmit="return validateForm()">
              <div class="card-body">
                <h4 class="card-title">Theater Info</h4>

                <!-- Theater Name -->
                <div class="form-group row">
                  <label for="theater_name" class="col-sm-3 text-right control-label col-form-label">Theater
                    Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="theater_name" name="theater_name"
                      placeholder="Theater Name Here" required minlength="2" maxlength="100">
                    <div class="error" id="theater_name_error"></div>
                  </div>
                </div>

                <!-- Theater Poster -->
                <div class="form-group row">
                  <label for="theater_poster" class="col-sm-3 text-right control-label col-form-label">Theater
                    Poster</label>
                  <div class="col-sm-9">
                    <input type="file" class="form-control" id="theater_poster" name="theater_poster" accept="image/*"
                      required>
                    <div class="error" id="theater_poster_error"></div>
                  </div>
                </div>

                <!-- Owner Name -->
                <div class="form-group row">
                  <label for="owner_name" class="col-sm-3 text-right control-label col-form-label">Owner Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="owner_name" name="owner_name"
                      placeholder="Owner Name Here" required minlength="2" maxlength="50">
                    <div class="error" id="owner_name_error"></div>
                  </div>
                </div>

                <!-- Contact No -->
                <div class="form-group row">
                  <label for="contact_no" class="col-sm-3 text-right control-label col-form-label">Contact No</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="contact_no" name="contact_no"
                      placeholder="Contact No Here" required pattern="^\d{10}$">
                    <div class="error" id="contact_no_error"></div>
                  </div>
                </div>

                <!-- Address -->
                <div class="form-group row">
                  <label for="address" class="col-sm-3 text-right control-label col-form-label">Address</label>
                  <div class="col-sm-9">
                    <textarea id="address" name="address" class="form-control" placeholder="Address Here"
                      required></textarea>
                    <div class="error" id="address_error"></div>
                  </div>
                </div>

                <!-- Owner Email -->
                <div class="form-group row">
                  <label for="owner_email" class="col-sm-3 text-right control-label col-form-label">Owner Email</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="owner_email" name="owner_email"
                      placeholder="Owner Email Here" required>
                    <div class="error" id="owner_email_error"></div>
                  </div>
                </div>

                <!-- Is Active -->
                <div class="form-group row">
                  <label for="is_active" class="col-sm-3 text-right control-label col-form-label">Is Active</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="is_active" name="is_active"
                      placeholder="1 for active, 0 for inactive" required min="0" max="1">
                    <div class="error" id="is_active_error"></div>
                  </div>
                </div>
              </div>

              <div class="border-top">
                <div class="card-body">
                  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>




          <!-- editor -->

          <!-- ============================================================== -->
          <!-- End PAge Content -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Right sidebar -->
          <!-- ============================================================== -->
          <!-- .right-sidebar -->
          <!-- ============================================================== -->
          <!-- End Right sidebar -->
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
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!-- This Page JS -->
    <script src="../assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="../dist/js/pages/mask/mask.init.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="../assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="../assets/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
    <script src="../assets/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="../assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
    <script src="../assets/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="../assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/libs/quill/dist/quill.min.js"></script>
    <script>
      //***********************************//
      // For select 2
      //***********************************//
      $(".select2").select2();

      /*colorpicker*/
      $(".demo").each(function () {
        //
        // Dear reader, it's actually very easy to initialize MiniColors. For example:
        //
        //  $(selector).minicolors();
        //
        // The way I've done it below is just for the demo, so don't get confused
        // by it. Also, data- attributes aren't supported at this time...they're
        // only used for this demo.
        //
        $(this).minicolors({
          control: $(this).attr("data-control") || "hue",
          position: $(this).attr("data-position") || "bottom left",

          change: function (value, opacity) {
            if (!value) return;
            if (opacity) value += ", " + opacity;
            if (typeof console === "object") {
              console.log(value);
            }
          },
          theme: "bootstrap",
        });
      });
      /*datwpicker*/
      jQuery(".mydatepicker").datepicker();
      jQuery("#datepicker-autoclose").datepicker({
        autoclose: true,
        todayHighlight: true,
      });
      var quill = new Quill("#editor", {
        theme: "snow",
      });
    </script>
    <script>
      function validateForm() {
        let isValid = true;

        // Validate Theater Name
        const theaterName = document.getElementById('theater_name');
        const theaterNameError = document.getElementById('theater_name_error');
        if (theaterName.value.length < 2 || theaterName.value.length > 100) {
          theaterNameError.textContent = "Theater name must be between 2 and 100 characters.";
          isValid = false;
        } else {
          theaterNameError.textContent = "";
        }

        // Validate Contact No (only numbers, exactly 10 digits)
        const contactNo = document.getElementById('contact_no');
        const contactNoError = document.getElementById('contact_no_error');
        const contactPattern = /^\d{10}$/;
        if (!contactPattern.test(contactNo.value)) {
          contactNoError.textContent = "Contact number must be exactly 10 digits.";
          isValid = false;
        } else {
          contactNoError.textContent = "";
        }

        // Validate Owner Name
        const ownerName = document.getElementById('owner_name');
        const ownerNameError = document.getElementById('owner_name_error');
        if (ownerName.value.length < 2 || ownerName.value.length > 50) {
          ownerNameError.textContent = "Owner name must be between 2 and 50 characters.";
          isValid = false;
        } else {
          ownerNameError.textContent = "";
        }

        // Validate Poster Upload
        const poster = document.getElementById('theater_poster');
        const posterError = document.getElementById('theater_poster_error');
        if (!poster.value) {
          posterError.textContent = "Please upload a theater poster.";
          isValid = false;
        } else {
          posterError.textContent = "";
        }

        // Validate Owner Email
        const email = document.getElementById('owner_email');
        const emailError = document.getElementById('owner_email_error');
        if (!email.value.includes('@')) {
          emailError.textContent = "Please enter a valid email address.";
          isValid = false;
        } else {
          emailError.textContent = "";
        }

        // Validate Is Active (only 0 or 1)
        const isActive = document.getElementById('is_active');
        const isActiveError = document.getElementById('is_active_error');
        if (isActive.value !== '0' && isActive.value !== '1') {
          isActiveError.textContent = "Is Active must be 0 or 1.";
          isValid = false;
        } else {
          isActiveError.textContent = "";
        }

        return isValid;
      }
    </script>
</body>

</html>