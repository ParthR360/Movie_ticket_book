<?php
session_start();
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $screen_id = $_POST['screen_id'];
    $selectedSeats = $_POST['seats'];

    // Fetch the price per seat from the screen table
    $priceQuery = "SELECT price FROM screens WHERE id = $screen_id";
    $priceResult = $conn->query($priceQuery);

    if ($priceResult->num_rows > 0) {
        $seatPrice = $priceResult->fetch_assoc()['price']; // Get the seat price from the screen table
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid screen ID or no price found.'
        ]);
        exit();
    }

    // Calculate total price
    $totalPrice = count($selectedSeats) * $seatPrice;

    // Insert each selected seat into the seat_selection table
    foreach ($selectedSeats as $seat) {
        $sql = "INSERT INTO seat_selection (screen_id, user_id, seat_number, is_booked) 
                VALUES ($screen_id, $user_id, $seat, 1)";
        $conn->query($sql);
    }

    // Get the movie name from the screen table
    $movieQuery = "SELECT m.name FROM screens s JOIN movies m ON s.movie_id = m.id WHERE s.id = $screen_id";
    $movieResult = $conn->query($movieQuery);
    $movieName = $movieResult->fetch_assoc()['name'];

    // Store booking details in the session to pass to the receipt page
    $_SESSION['movie_name'] = $movieName;
    $_SESSION['selected_seats'] = implode(", ", $selectedSeats); // Convert seat array to a string
    $_SESSION['total_price'] = $totalPrice;

    // Redirect to receipt.php with success response
    echo json_encode([
        'status' => 'success',
        'redirect' => 'receipt.php'
    ]);
}
$conn->close();
