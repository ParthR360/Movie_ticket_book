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
$screen_id = $_GET['screen_id']; // Get the screen ID from the URL

// Fetch seats that are already booked for this screen
$sql = "SELECT seat_number FROM seat_selection WHERE screen_id = $screen_id AND is_booked = 1";
$result = $conn->query($sql);

$bookedSeats = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookedSeats[] = $row['seat_number']; // Store booked seat numbers in an array
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seats</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            background-color: #007bff;
            color: white;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            border-radius: 5px;
            position: relative;
            transition: 0.3s ease;
        }

        .selected {
            background-color: #28a745;
        }

        .booked {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .row-seats {
            display: flex;
            justify-content: center;
        }

        .card {
            border: none;
            background-color: transparent;
            text-align: center;
        }

        .confirm-btn {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .confirm-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    require_once('clinteheader.php');
    ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Select Seat</h2>
        <div class="row">
            <?php
            $seatNumber = 1; // Initialize seat number
            for ($i = 0; $i < 8; $i++): // 8 rows
                echo '<div class="row-seats">';
                for ($j = 0; $j < 10; $j++):
                    $isBooked = in_array($seatNumber, $bookedSeats) ? 'booked' : ''; // Check if the seat is booked
                    echo '<div class="seat ' . $isBooked . '" data-seat-id="' . $seatNumber . '">' . $seatNumber . '</div>';
                    $seatNumber++;
                endfor;
                echo '</div>';
            endfor;
            ?>
        </div>
        <button id="confirm-selection" class="confirm-btn">Confirm Selection</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedSeats = [];

            $('.seat').not('.booked').click(function() {
                const seatId = $(this).data('seat-id');

                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    selectedSeats = selectedSeats.filter(id => id !== seatId);
                } else {
                    $(this).addClass('selected');
                    selectedSeats.push(seatId);
                }
            });

            $('#confirm-selection').click(function() {
                if (selectedSeats.length === 0) {
                    alert('Please select at least one seat.');
                    return;
                }

                // Send the selected seats to the server via AJAX
                $.ajax({
                    url: 'store_seat_selection.php',
                    type: 'POST',
                    data: {
                        seats: selectedSeats,
                        screen_id: <?= $screen_id ?>,
                        user_id: <?= $user_id ?>
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            // Redirect to my_booking page
                            window.location.href = res.redirect;
                        } else {
                            alert(res.message); // Show any error messages
                        }
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    require_once('clintefooter.php');

    ?>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
