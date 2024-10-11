<?php
session_start(); // Start the session
require_once("connection.php");

$movie_id = $_GET['movie_id'];

// Fetch available screens for the selected movie
$sql = "SELECT * FROM screens WHERE movie_id = $movie_id"; // Assuming you have a screens table
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Screens</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once("clinteheader.php"); // Include header
    ?>

    <!-- Available Screens Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Available Screens</h2>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">Screen <?php echo htmlspecialchars($row['screen_number']); ?></h5>
                                <p class="card-text">Time: <?php echo htmlspecialchars($row['show_time']); ?></p>
                                <p class="card-text">Price: <?php echo htmlspecialchars($row['price']); ?> ₹</p>
                                <!-- "Proceed to Book" button -->
                                <a href="seat_selection.php?screen_id=<?php echo $row['id']; ?>" class="btn btn-primary">Proceed to Book</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No screens available for this movie.</p>";
            }
            ?>
        </div>
    </div>

    <?php
    include_once("clintefooter.php"); // Include footer
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
