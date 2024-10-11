<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they're not logged in
    header("Location: login.php");
    exit();
}

require_once("connection.php");

$user_id = $_SESSION['user_id']; // The logged-in user's ID

// Fetch all bookings for the user
$sql = "
    SELECT 
        s.id AS selection_id,
        s.seat_number, 
        m.name AS movie_name, 
        t.name AS theater_name, 
        sc.screen_number, 
        sc.show_time, 
        sc.price
    FROM 
        seat_selection s
    JOIN 
        screens sc ON s.screen_id = sc.id
    JOIN 
        movies m ON sc.movie_id = m.id
    JOIN 
        theater t ON m.theater_id = t.id
    WHERE 
        s.user_id = $user_id AND s.is_booked = 1
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once("clinteheader.php");
    ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">My Bookings</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Movie Name</th>
                        <th>Theater Name</th>
                        <th>Screen Number</th>
                        <th>Show Time</th>
                        <th>Seat Number</th>
                        <th>Price (₹)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['movie_name']) ?></td>
                            <td><?= htmlspecialchars($row['theater_name']) ?></td>
                            <td><?= htmlspecialchars($row['screen_number']) ?></td>
                            <td><?= htmlspecialchars($row['show_time']) ?></td>
                            <td><?= htmlspecialchars($row['seat_number']) ?></td>
                            <td><?= htmlspecialchars($row['price']) ?></td>
                            <td>
                                <a href="cancel_booking.php?id=<?= $row['selection_id'] ?>" class="btn btn-danger btn-sm">Cancel</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">You have no bookings yet.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    require_once('clintefooter.php');
    ?>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
