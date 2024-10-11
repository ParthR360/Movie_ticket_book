<?php
session_start();
require_once("connection.php"); // Ensure you include your database connection file

// Check if the user is logged in and booking data is available
if (!isset($_SESSION['user_id']) || !isset($_SESSION['movie_name']) || !isset($_SESSION['selected_seats'])) {
    header("Location: login.php");
    exit();
}

// Fetch booking data
$movieName = $_SESSION['movie_name'];
$selectedSeats = $_SESSION['selected_seats'];
$totalPrice = $_SESSION['total_price'];

// Fetch show time from the screens table based on the movie name
$sql_show_time = "
    SELECT s.show_time 
    FROM screens s 
    JOIN movies m ON s.movie_id = m.id 
    WHERE m.name = ?
";
$stmt = $conn->prepare($sql_show_time);
$stmt->bind_param("s", $movieName);
$stmt->execute();
$stmt->bind_result($showTime);
$stmt->fetch();
$stmt->close();

if (!$showTime) {
    $showTime = "Show time not available"; // Fallback if show time is not found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .print-btn {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .print-btn:hover {
            background-color: #0056b3;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .receipt-content {
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <?php require_once('clinteheader.php'); ?>
    
    <div class="container mt-5">
        <h2 class="text-center mb-4">Booking Receipt</h2>
        <div class="card p-4 receipt-content">
            <h3>Movie: <?php echo htmlspecialchars($movieName); ?></h3>
            <p><strong>Show Time:</strong> <?php echo htmlspecialchars($showTime); ?></p> <!-- Display show time -->
            <p><strong>Seats:</strong> <?php echo htmlspecialchars($selectedSeats); ?></p>
            <p><strong>Total Price:</strong> <?php echo number_format($totalPrice, 2); ?></p>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Go to Home</a>
            <button class="btn btn-primary" onclick="printReceipt()">Print Receipt</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php require_once('clintefooter.php'); ?>

    <script>
        // Function to trigger the print dialog
        function printReceipt() {
            window.print();
        }
    </script>
</body>
</html>

<?php
// Clear session data related to the booking after displaying the receipt
unset($_SESSION['movie_name']);
unset($_SESSION['selected_seats']);
unset($_SESSION['total_price']);
?>
