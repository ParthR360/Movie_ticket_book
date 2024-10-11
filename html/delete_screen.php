<?php
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['screen_id'])) {
    $screen_id = $_POST['screen_id'];

    // Delete the selected screen
    $sql_delete = "DELETE FROM screens WHERE id = '$screen_id'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Screen deleted successfully!";
    } else {
        echo "Error deleting screen: " . $conn->error;
    }

    // Redirect back to the main page
    header("Location: screentable.php"); // Change to your main page
    exit();
}
