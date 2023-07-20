<?php
    include "connection.php";

    session_start();
    if(isset($_POST['logInBtn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $num = 0;
        $query = "SELECT customId, COUNT(*) AS num FROM customer_info WHERE email = '$email' AND password = '$password';";
        $query_run = mysqli_query($con, $query);
        foreach ($query_run as $row) {
            $customId = $row["customId"];
            $num = $row["num"];
        }

        if ($num == 1) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $email;
            $_SESSION['customId'] = $customId;

            if ($customId == 9999999) {
                header("Location: /Espresso Dreams/Admin Page/Admin.php");
                exit();
            }

            header("Location: /Espresso Dreams/Order Page/OrderPage.php");
            exit();
        } else {
            echo '<script>window.onload = function() { $("#modalMessage").html("Error Log In!"); $("#orderModal").modal("show"); }</script>';
        }
    }

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Page - Espresso Dreams</title>

    <!-- Bootstrap Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="shop.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
     
<body>
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

    <div class="parent">
        <div class="child-1">

            <div class="flex-item1">Our Flavors</div>
        </div>
        <div class="child-2">
            <div class="flex-item2"></div>
            <h3 class="basic-label">BASIC FLAVORS</h3>
            <ul class="basic-flavors1">
                <li>Chocolate</li>
                <li>Strawberry</li>
                <li>Vanilla</li>
                <li>Coffee</li>
                <li>Peanut</li>
            </ul>
            <!-- <h3 class="basic-price">(₱405.00)</h3> -->
            <ul class="basic-flavors2">
                <li>Mocha</li>
                <li>Tiramisu</li>
                <li>Rocky Road</li>
                <li>Double Dutch</li>
                <li>Cookies and Cream</li>
            </ul>
            <div class="image1"></div>
        </div>
        <div class="child-3">
            <div class="flex-item3"></div>
            <h3 class="special-label">SPECIAL FLAVORS</h3>
            <!-- <h3 class="special-price">(₱450.00)</h3> -->
            <ul class="special-flavors1">
                <li>Matcha</li>
                <li>Capuccino Heaven</li>
                <li>Espresso Dreams</li>
                <li>Mocha Almond Fudge</li>
                <li>Roasted Pecan</li>
            </ul>
            <ul class="special-flavors2">
                <li>French Vanilla</li>
                <li>Hazelnut Ground</li>
                <li>Caramel Macchiato</li>
                <li>Pistachio</li>
                <li>Walnut Cinnamon</li>
            </ul>
            <div class="image2"></div>
            <div class="button-section">
                <button type="button" class="view" data-bs-toggle='modal' data-bs-target='#logIn'>ORDER NOW</button>
            </div>
        </div>

    </div>
    
   
    <div class="container">
        <footer>
            <div class="secondlogo"></div>
            <h3 class="Contact-Us">CONTACT US</h3>
            <h3 class="footerinfo1">15 Crystal St. Rockville 2 Subdivision, Novaliches, Quezon City 1116,
                Philippines
                <br>
                espressodreams@gmail.com <br>
                09171792602
            </h3>
            <h3 class="footerinfo2">Copyright © 2023, EspressoDreams.ph</h3>
            <div class="line"></div>
            <div class="fb"></div>
            <div class="twitter"></div>
            <div class="ig"></div>
            <div class="fordev">FOR DELIVERY</div>
            <ul class="fordev-info">
                <li>We use thermal bags for our delivery to ensure the quality of our products.</li>
                <li>Upon payment, please allow 2-4 days of delivery.</li>
                <li>You will be notified via text message on delivery day.</li>
                <li>No deliveries on Sundays and nonworking Holidays.</li>
            </ul>
            <h3 class="Note">Note: We deliver within Metro Manila only.</h3>
        </footer>
    </div>
    </div>


    <!--LOG IN MODAL-->
    <div class="modal fade" id="logIn" data-bs-backdrop="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #F8F9F5; border: 2px solid #634832;">
                <div class="bg-color modal-header" style="border: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <div class="row-md">
                        <div class="table-wrapper table-responsive-md p-3 rounded">
                            <div class="thirdlogo"></div>
                            <div style="height: 100px;"></div>
                            <div style="height: 100px;"></div>
                            <h3 class="text-center" style="font-weight: 700;">Welcome Back!</h3>
                            <p class="text-center">Sign in to your account.</p>
                            <form method="post">
                                <label for="email"></label>
                                <input class="form-control"  type="email" id="email" name="email" placeholder="  Email" required style="margin-bottom: 20px;">
                                <input class="form-control" name="password" required type="password" placeholder="  Password" id="password" required style="margin-bottom: 20px;">
                                <div style="text-align: center;">
                                    <button type="submit" name="logInBtn" class="btn form-control btn-primary btn-block" style="background-color: #634832; border: none; width: 50%;">Log In</button>
                                </div>
                            </form>
                            <div style="height: 50px;"></div>
                            <div class="container line-2" style="background-color: black; width: 90%; height: 2px; margin-bottom: 20px;"></div>
                            <p class="text-center">By continuing, you agree to our <a><u>Terms & Conditions</u></a> and <a><u>Privacy Policy</u></a>.</p>
                            <p class="text-center">Don't have an Espresso Dreams account?</p>
                            <div style="text-align: center;">
                                <a href="/Espresso Dreams/Login Page/Login.php">
                                    <button type="button" class="btn form-control btn-primary btn-block" style="background-color: #634832; border: none; width: 50%;">Create Your Account</button>
                                </a>
                            </div>
                            <div style="height: 30px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ORDER MODAL -->
    <div class="modal fade" id="orderModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="background-color: #ECE0D1; border: 3px solid #634832;">
                <div class="bg-color modal-header" style="border: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center" style="color: #634832">
                    <div class="justify-content-end">
                        <div class="text-center">
                        <h2 id="modalMessage" style="font-weight: 600;"></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function changeLabelColor(label) {
            label.classList.toggle('selected-label');
        }

        var timeLimit = 3000; // 5 seconds

        // Close the modal after the specified time limit
        setTimeout(function() {
            $('#orderModal').modal('hide');
        }, timeLimit);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>