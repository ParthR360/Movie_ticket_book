<?php 
session_start(); // Start the session
require_once("connection.php");

// Fetch active theaters from the database
$sql = "SELECT id, name, poster FROM theater WHERE is_active = 1";
$result = $conn->query($sql);

// Fetch the latest 10 feedback entries with a 5-star rating
$feedback_sql = "SELECT feedback, user_id FROM feedback WHERE rating = 5 ORDER BY created_at DESC LIMIT 10"; // Adjust 'created_at' to your actual timestamp column
$feedback_result = $conn->query($feedback_sql);

// Check for errors in the feedback query
if (!$feedback_result) {
    die("Error fetching feedback: " . $conn->error);
}

// Function to get the user's name by ID
function getUserNameById($user_id) {
    global $conn; // Access the database connection
    $stmt = $conn->prepare("SELECT firstName FROM userinfo WHERE id = ?"); // Use your actual table and column names
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['firstName'];
    }
    
    return "Unknown User"; // Default name if not found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookItNow</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once("clinteheader.php"); // No session_start() here
    ?>

    <!-- Bootstrap Carousel for Slider -->
    <div id="theaterCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="uploads/aaa.jpg" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="uploads/Qube-Epiq-Press-Photos_04-653x435.jpg" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="uploads/screen-x-cover-800x450.jpg" class="d-block w-100" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#theaterCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#theaterCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Theater Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Available Theaters</h2>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a href="redirect.php?theater_id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['poster']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <a 
                                    href="redirect.php?theater_id=<?php echo $row['id']; ?>" 
                                    class="btn btn-primary">View Movies
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No theaters available.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Feedback Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Recent 5-Star Feedback</h2>
        <div class="row">
            <?php
            if ($feedback_result->num_rows > 0) {
                while ($feedback = $feedback_result->fetch_assoc()) {
                    $user_name = getUserNameById($feedback['user_id']);
                    ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($user_name); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($feedback['feedback']); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No 5-star feedback available.</p>";
            }
            ?>
        </div>
    </div>

    <?php
    include_once("clintefooter.php");
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
