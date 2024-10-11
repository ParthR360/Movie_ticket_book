<?php
session_start();

// Verify CSRF token
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token");
}

// Retrieve the data from the form submission
$user_id = $_POST['user_id'];
$rating = $_POST['rating'];
$feedback = $_POST['feedback'];

// Include the database connection
require_once 'connection.php';

// Check if required fields are not empty
if (empty($user_id) || empty($rating) || empty($feedback)) {
    die("Required fields are missing.");
}

try {
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, rating, feedback) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $rating, $feedback);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect with a success message
        header("Location: feedback.php?success=true");
        exit();
    } else {
        // Redirect with an error message
        header("Location: feedback.php?success=false");
        exit();
    }

} catch (Exception $e) {
    // Redirect with an error message if the query fails
    header("Location: feedback.php?success=false");
    exit();
} finally {
    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>
