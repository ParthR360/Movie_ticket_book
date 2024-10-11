<?php
$errors = array('email' => '', 'password' => '', 'loginFlag' => '');
if (isset($_POST['submit'])) {
  if (empty($_POST['email'])) {
    $errors['email'] = "Enter your mail id.";

  } elseif (empty($_POST['pwd'])) {
    $errors['password'] = "Enter your password.";
  } else {
    include('loginCheck.php');

    if ($loginFlag == "false") {
      $errors['loginFlag'] = "Either email is wrong or password, Try Again!.";
    }
    // if($loginFlag){
    //   header('Location:index.php');
    // }else{
    //   $errors['loginFlag'] = "Either email is wrong or password, Try Again!.";
    // }

  }
}
?>

<!-- Admin Login  -->

<!DOCTYPE html>
<html>

<head>
  <title>Log In</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    .wel-login {
      padding-bottom: 100px;
      background-image: url('images/loginbg.jpg');
      background-attachment: fixed;
      background-size: cover;
      background-repeat: no-repeat;
      font-family: 'Jost', sans-serif;
      margin-bottom: 50px;
      overflow: hidden;
    }
  </style>
</head>

<?php include('clinteheader.php') ?>

<body class="wel-login">

  <!-- Log In form -->
  <div class="container" style="margin-top:100px; margin-bottom:70px;">
    <div class="row">

      <div class="col-md-6">
        <div class="text-center">
          <h2 style="text-align: center; font-size: 40px; color: white;">
            <?php
            if (isset($_GET['alert'])) {
              echo "Log In to Book Tickets";
            } else {
              echo "Log In";
            }
            ?>
          </h2>
          <medium style="color: white;">Best Online Ticketing System In Town</medium>
        </div>
      </div>

      <div class="col-md-6 login">
        <div style="margin-left: 10%; margin-right:10%;">
          <form action="login.php" method="POST">
            <div class="form-group">
              <label for="email"><span style="color: black;">Email:</span></label>
              <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
              <div class="text-danger"><?php echo $errors['email']; ?></div>
            </div>
            <div class="form-group">
              <label for="pwd"><span style="color: black;">Password:</span></label>
              <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
              <div class="text-danger"><?php echo $errors['password']; ?></div>
            </div>

            <div class="row">
              <div class="col-8 text-left">
                <a href="signup.php"><span style="color: black;">Create New Account</span></a>

              </div>
              <div class="col-4 text-right">
                <button type="submit" name="submit" class="btn btn-primary btn-sm">Log In</button>
              </div>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>

  <!-- Include jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>

<!-- Footer -->
<?php include('clintefooter.php') ?>

</html>
