<?php
require_once("connection.php");

// Handle the update action if a movie is selected and form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id_update'])) {
    $movie_id = $_POST['movie_id_update'];

    // Check if active_status is set in POST
    if (isset($_POST['active_status'])) {
        $active_status = $_POST['active_status'] == 'active' ? 1 : 0; // 1 for active, 0 for inactive

        // Update the selected movie's active status
        $sql_update = "UPDATE movies SET is_active = '$active_status' WHERE id = '$movie_id'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Movie status updated successfully!";
        } else {
            echo "Error updating movie status: " . $conn->error;
        }
    }
}

// Fetch all movies with their respective theater names
$sql_movies = "SELECT movies.id, movies.name AS movie_name, theater.name AS theater_name, movies.is_active 
               FROM movies 
               JOIN theater ON movies.theater_id = theater.id";
$result_movies = $conn->query($sql_movies);

$movies = [];
if ($result_movies->num_rows > 0) {
    while ($row = $result_movies->fetch_assoc()) {
        $movies[] = $row;
    }
}
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
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Manage Movies</h4>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <form class="form-horizontal" action="" method="POST">
                            <div class="card-body">
                                <h4 class="card-title">Update Movie Status</h4>

                                <!-- Movie Select for Updating Status -->
                                <div class="form-group row">
                                    <label for="movie_id_update" class="col-sm-3 text-end control-label col-form-label">Select Movie</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="movie_id_update" name="movie_id_update" required>
                                            <option value="">Choose a movie</option>
                                            <?php
                                            foreach ($movies as $movie) {
                                                echo "<option value='" . $movie['id'] . "'>" . $movie['movie_name'] . " (" . $movie['theater_name'] . ") - " . ($movie['is_active'] ? 'Active' : 'Inactive') . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="active_status" class="col-sm-3 text-end control-label col-form-label">Set Active Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="active_status" name="active_status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button for Updating Status -->
                            <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success">Update Status</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once("foot.php"); ?>
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
</body>

</html>