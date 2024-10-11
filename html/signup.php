<?php
$errors = array('email' => '', 'password' => '', 'firstName' => '', 'lastName' => '');

if (isset($_POST['submit'])) {
    if (empty($_POST['first_name'])) {
        $errors['firstName'] = "Enter your First Name.";
    }
    if (empty($_POST['last_name'])) {
        $errors['lastName'] = "Enter your Last Name.";
    }
    if (empty($_POST['email'])) {
        $errors['email'] = "Enter your Email.";
    }
    if (empty($_POST['pwd'])) {
        $errors['password'] = "Enter your password.";
    }

    // Only run if there are no errors
    if (!array_filter($errors)) {
        $firstnameSign = $_POST['first_name'];
        $lastnameSign = $_POST['last_name'];
        $emailSign = $_POST['email'];
        $passwordSign = $_POST['pwd'];

        // Include the connection file
        include('connection.php');

        // Use prepared statements to prevent SQL Injection
        $stmt = $conn->prepare("INSERT INTO userinfo (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstnameSign, $lastnameSign, $emailSign, $passwordSign);

        if ($stmt->execute()) {
            // Redirect to login page after successful signup
            header('Location: login.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>

    <style>
        .wel-signup {
            overflow: hidden;
            padding-bottom: 100px;
            background-image: url('images/signupbg.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Jost', sans-serif;
            margin-bottom: 50px;
        }

        .form-control {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #E50914;
            border-color: #E50914;
        }

        .btn-primary:hover {
            background-color: #ff3333;
        }
    </style>
</head>

<body class="wel-signup">
    <?php include('clinteheader.php'); ?>

    <!-- Sign Up form -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 login">
                <div style="margin-left: 10%; margin-right:10%;">
                    <!-- Title of the page -->
                    <div class="text-center">
                        <h2 style="text-align: center; font-size: 40px; color: white;">Sign Up</h2>
                        <hr>

                    </div>

                    <form style="margin-top: 30px; margin-bottom:30px;" action="signup.php" method="POST">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="first_name" placeholder="Enter First Name" name="first_name">
                                    <div class="text-danger"><?php echo $errors['firstName']; ?></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name">
                                    <div class="text-danger"><?php echo $errors['lastName']; ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
                            <div class="text-danger"><?php echo $errors['email']; ?></div>
                        </div>

                        <div class="row">
                            <div class="col-9">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="pwd">
                                    <div class="text-danger"><?php echo $errors['password']; ?></div>
                                </div>
                            </div>
                            <div class="col-3">
                                <button style="float: right;" type="submit" class="btn btn-primary" name="submit">Sign Up</button>
                            </div>
                        </div>
                        <p style="font-size:15px; text-align:center;">Already have an account?<a href="login.php"> Log In</a>.</p>
                    </form>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>

    <?php include('clintefooter.php'); ?>
</body>
</html>
