<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }
        .au-header {
            background-image: url("images/aboutusbg.jpg");
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            padding: 100px 0;
            color: white;
            text-align: center;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        .card img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <?php require_once('clinteheader.php'); ?>

    <div class="au-header">
        <h2>About Us</h2>
        <p>Teamwork begins by building trust and the only way to do that is by overcoming our invulnerabilities.</p>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Meet Our Team</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4>Rathod Parth</h4>
                        <h6>Developer</h6>
                        <p>A budding coder with zeal towards learning new advancements in software development.</p>
                        <h6>parthmax360@gmail.com</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4>Yash Javiya</h4>
                        <h6>Developer</h6>
                        <p>An enthusiastic developer skilled in handling Frontend and Backend tools alike.</p>
                        <h6>yashjaviya3@gmail.com</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4>Patel Sahil</h4>
                        <h6>Developer</h6>
                        <p>A team-oriented companion who displays an insatiable thirst for knowledge.</p>
                        <h6>sahiljp01@gmail.com</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4>Upale Rutvesh</h4>
                        <h6>Developer</h6>
                        <p>A great team-player who always caters to the best interests of the team.</p>
                        <h6>Rutvesh123@gmail.com</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('clintefooter.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
