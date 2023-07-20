<?php
    include "connection.php";

    session_start();

    //for generating unique customer ID
    $min = 1000000; // minimum value
    $max = 9999999; // maximum value
    $num = 1;
    while($num == 1) { // For Unique ID generation
        $primaryKey = random_int($min, $max);
        $query = "SELECT COUNT(*) AS num FROM customer_info WHERE customId = $primaryKey;";
        $query_run = mysqli_query($con, $query);
        foreach ($query_run as $row) {
            $num = $row["num"];
        }
    }

    if (isset($_POST['logIn'])) { 
        $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $confirm = mysqli_real_escape_string($con, $_POST['confirmPass']);

        $num = 0;
        $query = "SELECT customId, COUNT(*) AS num FROM customer_info WHERE email = '$email' AND password = '$password';";
        $query_run = mysqli_query($con, $query);
        foreach ($query_run as $row) {
            $customId = $row["customId"];
            $num = $row["num"];
        }

        if ($password == $confirm && $num == 0) {
            $query = "INSERT INTO customer_info VALUES ('$primaryKey', '$password', '$firstname', '$lastname', '$email', '$phone', '$address')";
            $query_run = mysqli_query($con, $query);
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $email;
            $_SESSION['customId'] = $primaryKey;
            $_SESSION['createdAccount'] = true;
            header("Location: /Espresso Dreams/Order Page/OrderPage.php");
            exit();
        } else {
            header("Location: Login.php");
            exit;
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Espresso Dreams</title>
    <link rel="stylesheet" href="Login.css">
    <link rel="stylesheet" href="Login.js">

    <!-- Bootstrap Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


</head>

<body style="background-color: #ECE0D1;">
    <!-- Icon for alert message -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <div class="text-logo"></div>
        <ul>
            <li><a href="/Espresso Dreams/Home Page/HomePage.html" class="home">Home</a></li>
            <li><a href="/Espresso Dreams/About Us/AboutUs.html" class="story">Our Story</a></li>
            <li><a href="/Espresso Dreams/Shop Page/ShopPage.php" class="shop">Shop</a></li>
            <li><a href="/Espresso Dreams/Location Page/Location.html" class="location">Location</a></li>
            <li><a href="/Espresso Dreams/Contact Us/ContactPage.html" class="contact">Contact Us</a></li>
        </ul>

    </nav>
    <!--
    <div class="parent">
        <div class="child-1">
            <h1 class="login-heading">READY TO SIGN UP TO ESPRESSO DREAMS?</h1>
            <section class="login-form"></section>
                <h2 class="user-details">User Details</h2>
                <label for="fname"></label>
                <input type="text" id="fname" name="firstname" placeholder="  First Name">
                <label for="lname"></label>
                <input type="text" id="lname" name="lastname" placeholder="  Last Name">
                <label for="address"></label>
                <input type="text" id="address" name="address" placeholder="  Address">
                <h2 class="login-details">Login & Contact Details</h2>
                <label for="email"></label>
                <input type="text" id="email" name="email" placeholder="  Email">
                <label for="phone"></label>
                <input type="tel" id="phone" name="phone" placeholder="  Phone">
                <input type="password" placeholder="  Password" id="password" required>
                <input type="password" placeholder="  Confirm Password" id="confirm_password" required>

                <input type="checkbox" id="checkbox1" name="checkbox1">
        </div>
    </div>
    -->

    <div class="parent">
        <div class="child-1">
            <h1 class="login-heading">READY TO SIGN UP TO ESPRESSO DREAMS?</h1>
            <section class="login-form">
                <div class="scroll-container">
                    <form method="post">
                        <h2 class="user-details">User Details</h2>
                        <label for="fname"></label>
                        <input type="text" id="fname" name="firstname" placeholder="  First Name" required>
                        <label for="lname"></label>
                        <input type="text" id="lname" name="lastname" placeholder="  Last Name" required>
                        <label for="address"></label>
                        <input type="text" id="address" name="address" placeholder="  Complete Address" required>
                        <h2 class="login-details">Login & Contact Details</h2>
                        <label for="email"></label>
                        <input type="email" id="email" name="email" placeholder="  Email" required>
                        <label for="phone"></label>
                        <input type="number" id="phone" name="phone" placeholder="  Phone" required>
                        <input type="password" name="password" placeholder="  Password" onkeyup='check();' id="password" required>
                        <input type="password" name="confirmPass" placeholder="  Confirm Password" onkeyup='check();' id="confirm_password" required>  <span id='message' style="position: absolute; right: 60px; bottom: 362px;"></span>
                        <input type="checkbox" id="checkbox1" name="checkbox1" required>
                        <span class="checkbox1-description">I would like to receive announcements and promotions from
                            Espresso Dreams.</span>
                        <input type="checkbox" id="checkbox2" name="checkbox2" required>
                        <span class="checkbox2-description">I have fully read, understood, and agree to the Data Privacy
                            Policy, Terms & Conditions of Espresso Dreams.
                        </span>
                        <input type="submit" name="logIn" id="submit" value="Create your account">
                    </form>
                </div>
            </section>

            <footer>
                <div class="footerscroll-container">
                    <div class="secondlogo"></div>
                    <h3 class="Contact-Us">CONTACT US</h3>
                    <h3 class="footerinfo1">15 Crystal St. Rockville 2 Subdivision, Novaliches, Quezon City 1116,
                        Philippines <br>
                        espressodreams@gmail.com <br>
                        09171792602
                    </h3>
                    <h3 class="footerinfo2">Copyright © 2023, EspressoDreams.ph</h3>
                    <div class="line"></div>
                    <div class="footerfb"></div>
                    <div class="footertwitter"></div>
                    <div class="footerig"></div>
                    <div class="fordev">FOR DELIVERY</div>
                    <ul class="fordev-info">
                        <li>We use thermal bags for our delivery to ensure the quality of our products.</li>
                        <li>Upon payment, please allow 2-4 days of delivery.</li>
                        <li>You will be notified via text message on delivery day.</li>
                        <li>No deliveries on Sundays and nonworking Holidays.</li>
                    </ul>
                    <h3 class="Note">Note: We deliver within Metro Manila only.</h3>
                </div>
            </footer>
        </div>
    </div>

    <script type="text/javascript">
        var check = function() {
          if (document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'MATCHED';
          } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'NOT MATCHING';
          }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

</body>
</html>