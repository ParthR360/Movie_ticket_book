<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    // User is logged in, redirect to movies page
    $theater_id = $_GET['theater_id'];
    header("Location: movies.php?theater_id=" . $theater_id);
} else {
    // User is not logged in, redirect to login page
    header("Location: login.php");
}
exit();
?>
