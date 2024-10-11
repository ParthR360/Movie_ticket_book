<?php
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $movie_name = htmlspecialchars(trim($_POST['movie_name']));
    $movie_description = htmlspecialchars(trim($_POST['movie_description']));
    $release_date = htmlspecialchars(trim($_POST['release_date']));
    $theater_id = intval($_POST['theater_id']);
    $movie_trailer = htmlspecialchars(trim($_POST['movie_trailer']));  // Treat as string
    $is_active = intval($_POST['is_active']);

    // Handle file upload
    if (isset($_FILES['movie_poster']) && $_FILES['movie_poster']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["movie_poster"]["name"]);
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Sanitize and ensure proper file name
        $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "", $file_name);
        $target_file = $target_dir . $file_name;

        // Allowed file types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }

        // Move file to uploads directory
        if (move_uploaded_file($_FILES["movie_poster"]["tmp_name"], $target_file)) {
            // Prepare SQL query with corrected trailer link type
            $sql = $conn->prepare("INSERT INTO movies (name, poster, description, theater_id, release_date, is_active, trailer_link) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sql->bind_param('sssssss', $movie_name, $target_file, $movie_description, $theater_id, $release_date, $is_active, $movie_trailer);  // Use 's' for the trailer link

            if ($sql->execute()) {
                echo "<script> alert('Added successfully'); </script>";
            } else {
                echo "Error: " . $conn->error;
            }
            $sql->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Please upload a valid movie poster.";
    }
}

// Fetch all active theaters
$sql = "SELECT id, name FROM theater WHERE is_active = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $theaters = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $theaters = [];
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
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Add Movies</h4>
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
                        <form class="form-horizontal" name="form" action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <h4 class="card-title">Movies Info</h4>
                                <div class="form-group row">
                                    <label for="movie_name" class="col-sm-3 text-end control-label col-form-label">Movie
                                        Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="movie_name" name="movie_name"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="movie_trailer"
                                        class="col-sm-3 text-end control-label col-form-label">Movie
                                        Trailer Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="movie_trailer" name="movie_trailer"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="movie_poster"
                                        class="col-sm-3 text-end control-label col-form-label">Movie Poster</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" id="movie_poster" name="movie_poster"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="movie_description"
                                        class="col-sm-3 text-end control-label col-form-label">Movie Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="movie_description" name="movie_description"
                                            rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="theater_id"
                                        class="col-sm-3 text-end control-label col-form-label">Theater</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="theater_id" name="theater_id" required>
                                            <option value="">Select Theater</option>
                                            <?php foreach ($theaters as $theater): ?>
                                                <option value="<?= $theater['id'] ?>">
                                                    <?= htmlspecialchars($theater['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label for="release_date"
                                        class="col-sm-3 text-end control-label col-form-label">Release Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="release_date" name="release_date"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="is_active" class="col-sm-3 text-end control-label col-form-label">Is
                                        Active</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="is_active" name="is_active" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

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
</body>

</html>