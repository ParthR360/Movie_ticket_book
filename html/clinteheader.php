<?php
// No need to start session here as it's already done in the main file

// Assuming 'loggedIn' is set to true when the user logs in, you can set this in your login logic.
$isLoggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookMyShow Clone</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        :root {
            --primary-color: #E50914;
            --secondary-color: #333;
            --text-color: #fff;
            --hover-color: #ff3333;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        header {
            background-color: var(--primary-color);
            color: var(--text-color);
            padding: 15px;
            text-align: center;
        }

        nav {
            background-color: var(--secondary-color);
            padding: 10px;
        }

        nav a {
            color: var(--text-color);
            margin: 0 15px;
            text-decoration: none;
        }

        nav a:hover {
            color: var(--hover-color);
        }

        .carousel {
            width: auto;
            height: 400px;
            margin: 20px auto;
        }

        .carousel img {
            width: auto;
            height: 400px;
            object-fit: cover;
        }

        footer {
            background-color: var(--secondary-color);
            color: var(--text-color);
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <header>
        <h1>BookItNow</h1>
    </header>

    <nav class="d-flex justify-content-center">
        <a href="index.php">Theaters</a>

        <?php if ($isLoggedIn): ?>
            <a href="my_booking.php">My Bookings</a>
            <a href="feedback.php">Feedback</a>
            <a href="logout.php">Log Out</a>
            <a href="aboutus.php">About Us</a>
        <?php else: ?>
            <a href="login.php">Log In</a>
            <a href="signup.php">Sign Up</a>
        <?php endif; ?>

        
    </nav>

    <!-- Add your carousel or main content here -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
