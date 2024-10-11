<?php
session_start(); // Start the session
require_once("connection.php");

$theater_id = intval($_GET['theater_id']); // Sanitize theater_id to prevent SQL injection

// Fetch the theater name
$theater_sql = "SELECT name FROM theater WHERE id = $theater_id";
$theater_result = $conn->query($theater_sql);
$theater_name = "Unknown Theater"; // Default in case no theater is found

if ($theater_result->num_rows > 0) {
    $theater_row = $theater_result->fetch_assoc();
    $theater_name = htmlspecialchars($theater_row['name']); // Sanitize output
}

// Fetch movies for the selected theater including trailer links
$sql = "SELECT * FROM movies WHERE theater_id = $theater_id AND is_active = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies at <?php echo $theater_name; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style for card hover and blur effect */
        .card {
            position: relative;
            overflow: hidden;
        }

        .card-img-top {
            transition: 0.5s ease;
        }

        /* Blur the image on hover */
        .card:hover .card-img-top {
            filter: blur(4px);
        }

        /* Show the "Book Now" and "Watch Trailer" buttons on hover */
        .card:hover .book-btn,
        .card:hover .trailer-btn {
            opacity: 1;
        }

        /* Style for the "Book" and "Watch Trailer" buttons */
        .book-btn,
        .trailer-btn {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            opacity: 0;
            transition: 0.5s ease;
            font-size: 18px;
            cursor: pointer;
        }

        .book-btn {
            top: 50%;
        }

        .trailer-btn {
            bottom: 10%;
        }

        .book-btn:focus,
        .trailer-btn:focus {
            outline: none;
        }
    </style>
</head>

<body>
    <?php
    require_once("clinteheader.php"); // Include header
    ?>

    <!-- Movies Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Movies Playing at <?php echo $theater_name; ?></h2>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <!-- Movie poster -->
                            <img src="<?php echo $row['poster']; ?>" class="card-img-top" alt="Movie Poster">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                
                                <!-- "Watch Trailer" button placed below description -->
                                <?php if (!empty($row['trailer_link'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['trailer_link']); ?>" target="_blank" class="btn btn-outline-primary mt-3">Watch Trailer</a>
                                <?php endif; ?>
                            </div>

                            <!-- "Book Now" button -->
                            <a href="screens.php?movie_id=<?php echo $row['id']; ?>" class="book-btn">Book Now</a>

                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No movies available for this theater.</p>";
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
