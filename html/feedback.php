<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Get the user's ID from the session
$userId = $_SESSION['user_id'];

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for stars -->
  <style>
    .star-rating {
      font-size: 2rem;
      color: #ddd;
      cursor: pointer;
    }

    .star-rating .checked {
      color: #ffc107;
    }
  </style>
</head>

<body>
    <?php
    require_once('clinteheader.php');
    ?>
  <div class="container mt-5">
    <h2>Feedback</h2>
    
    <?php
    // Feedback message
    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        echo '<div class="alert alert-success">Thank you for your feedback!</div>';
    } elseif (isset($_GET['success']) && $_GET['success'] == 'false') {
        echo '<div class="alert alert-danger">Something went wrong. Please try again.</div>';
    }
    ?>

    <form action="submit_feedback.php" method="POST">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      <input type="hidden" name="user_id" value="<?php echo $userId; ?>"> <!-- Automatically store user_id -->

      <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <div class="star-rating">
          <i class="fa fa-star" id="star1" data-value="1"></i>
          <i class="fa fa-star" id="star2" data-value="2"></i>
          <i class="fa fa-star" id="star3" data-value="3"></i>
          <i class="fa fa-star" id="star4" data-value="4"></i>
          <i class="fa fa-star" id="star5" data-value="5"></i>
        </div>
        <!-- Hidden input to store the selected rating value -->
        <input type="hidden" id="rating" name="rating" required>
      </div>

      <div class="mb-3">
        <label for="feedback" class="form-label">Your Feedback</label>
        <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      let stars = $('.star-rating .fa');
      let selectedRating = 0;

      // Handle star click event
      stars.on('click', function() {
        selectedRating = $(this).data('value');
        $('#rating').val(selectedRating); // Set the hidden input value

        // Highlight stars based on selection
        stars.each(function(index) {
          if (index < selectedRating) {
            $(this).addClass('checked');
          } else {
            $(this).removeClass('checked');
          }
        });
      });
    });
  </script>
  <?php
  require_once('clintefooter.php');
  ?>
</body>

</html>
