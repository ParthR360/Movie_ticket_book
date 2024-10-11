<?php
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize and validate inputs
  $movie_id = intval($_POST['movie_id']);
  $screen_number = intval($_POST['screen_number']);
  $show_time = htmlspecialchars(trim($_POST['show_time']));
  $price = floatval($_POST['price']);

  // Prepare SQL query to insert screen details
  $sql = $conn->prepare("INSERT INTO screens (movie_id, screen_number, show_time, price) 
                            VALUES (?, ?, ?, ?)");
  $sql->bind_param('iisd', $movie_id, $screen_number, $show_time, $price);

  if ($sql->execute()) {
    echo "<script> alert('Added successfully'); </script>";
  } else {
    echo "Error: " . $conn->error;
  }
  $sql->close();
}

// Fetch all active movies with their theater names
$sql = "
    SELECT m.id, m.name AS movie_name, t.name AS theater_name 
    FROM movies m 
    JOIN theater t ON m.theater_id = t.id 
    WHERE m.is_active = 1 AND t.is_active = 1
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $movies = $result->fetch_all(MYSQLI_ASSOC);
} else {
  $movies = [];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Screens</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" />
  <link rel="stylesheet" type="text/css" href="../dist/css/style.min.css" />
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

</head>

<body>
  <?php require_once("topbar.php"); ?>
  <?php require_once("leftside.php"); ?>

  <div class="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <form class="form-horizontal" action="" method="post" onsubmit="return validateForm()">
              <div class="card-body">
                <h4 class="card-title">Screen Info</h4>

                <!-- Movie Selection -->
                <div class="form-group row">
                  <label for="movie_id" class="col-sm-3 text-end control-label col-form-label">Movie</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="movie_id" name="movie_id" required
                      onchange="fetchAvailableScreens()">
                      <option value="">Select Movie</option>
                      <?php foreach ($movies as $movie): ?>
                        <option value="<?= $movie['id'] ?>">
                          <?= htmlspecialchars($movie['movie_name']) ?> (<?= htmlspecialchars($movie['theater_name']) ?>)
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <!-- Screen Number (1 to 5) -->
                <div class="form-group row">
                  <label for="screen_number" class="col-sm-3 text-end control-label col-form-label">Screen
                    Number</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="screen_number" name="screen_number" required>
                      <option value="">Select Screen Number</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                    <div class="error" id="screen_number_error"></div>
                  </div>
                </div>

                <!-- Show Time -->
                <div class="form-group row">
                  <label for="show_time" class="col-sm-3 text-end control-label col-form-label">Show Time</label>
                  <div class="col-sm-9">
                    <input type="time" class="form-control" id="show_time" name="show_time" required>
                  </div>
                </div>

                <!-- Price -->
                <div class="form-group row">
                  <label for="price" class="col-sm-3 text-end control-label col-form-label">Price</label>
                  <div class="col-sm-9">
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="card-body">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php require_once("foot.php"); ?>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../dist/js/custom.min.js"></script>
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
    function fetchAvailableScreens() {
      const movieId = document.getElementById('movie_id').value;
      const screenNumberSelect = document.getElementById('screen_number');

      // Reset the screen number select options
      $('#screen_number option').prop('disabled', false);

      if (movieId) {
        $.ajax({
          url: 'get_available_screens.php',
          type: 'POST',
          data: { movie_id: movieId },
          success: function (response) {
            const assignedScreens = JSON.parse(response);

            // Disable the screen numbers that are already assigned
            assignedScreens.forEach(function (screen) {
              $(`#screen_number option[value="${screen}"]`).prop('disabled', true);
            });
          },
          error: function () {
            alert('Error fetching screen numbers. Please try again.');
          }
        });
      }
    }

    function validateForm() {
      const screenNumberError = document.getElementById('screen_number_error');
      screenNumberError.textContent = '';

      // Additional client-side validation can be added here
      return true;
    }
  </script>
</body>

</html>