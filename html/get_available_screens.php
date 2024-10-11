<?php
require_once("connection.php");

if (isset($_POST['movie_id'])) {
    $movie_id = intval($_POST['movie_id']);

    // Query to fetch assigned screen numbers for the selected movie
    $sql = $conn->prepare("SELECT screen_number FROM screens WHERE movie_id = ?");
    $sql->bind_param('i', $movie_id);
    $sql->execute();
    $result = $sql->get_result();

    // Collect all assigned screen numbers in an array
    $assigned_screens = [];
    while ($row = $result->fetch_assoc()) {
        $assigned_screens[] = $row['screen_number'];
    }

    // Return the array of assigned screen numbers as JSON
    echo json_encode($assigned_screens);
}
?>
