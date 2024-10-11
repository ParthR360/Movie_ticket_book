<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$selection_id = $_GET['id'];

// Cancel the booking by updating the database
$sql = "UPDATE seat_selection SET is_booked = 0 WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $selection_id, $user_id);

if ($stmt->execute()) {
    header("Location: my_booking.php"); // Redirect back to my bookings page
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
