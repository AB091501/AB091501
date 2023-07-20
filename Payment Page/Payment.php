<?php 
    session_start();
    include "connection.php";

    if (isset($_GET['customerId']) && isset($_GET['orderIds'])) {
        $orderIds = explode(',', $_GET['orderIds']);
        $customerId = $_GET['customerId'];

        $query = "SELECT firstName, lastName, email, address FROM customer_info WHERE customId = '$customerId'";
        $query_run = mysqli_query($con, $query);
        foreach ($query_run as $row) {
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $email = $row['email'];
            $address = $row['address'];
        }


    } else {
        // Redirect the user if the login information is not present
        header("Location: /Espresso Dreams/Order Page/OrderPage.php");
        exit;
    }


    if (isset($_POST['orderPost'])) {
        $zip = $_POST['zipCode']; 
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        foreach ($orderIds as $orderId) {
            $updateQuery = "UPDATE customer_info AS info JOIN customer_order AS cust ON info.customId = cust.customId SET info.firstName = '$firstName', info.lastName = '$lastName', info.email = '$email', info.address = '$address', cust.zip = '$zip', cust.status = 'ordered' WHERE orderId = '$orderId'";
            $updateResult = mysqli_query($con, $updateQuery);
        }

        $_SESSION['orderPlaced'] = true;

        // Redirect to the same page or another page
        header("Location: /Espresso Dreams/Order Page/OrderPage.php");
        exit;
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Espresso Dreams</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="Payment.css">

</head>

<body style="background-color:#ECE0D1;">

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

    <div class="container-fluid">
        <div class="bgpaymentpic"></div>
        <div class="row-6">
            <div class="checkout-title">CHECKOUT</div>
        </div>
    </div>

    <div class="container">
        <h1 class="display-7 billing">BILLING DETAILS</h1>
        <div class="container-fluid line" style="width: 1315px;"></div>
        <form method="POST">
            <div class="row">
                <div class="form-group col-sm-6 col-lg-4">
                    <label for="first-name" style="color:black">First Name</label>
                    <input type="text" name="firstName" class="form-control" id="first-name" value="<?php echo $firstName; ?>" required>
                </div>
                <div class="form-group col-sm-6 col-lg-4">
                    <label for="last-name" style="color:black">Last Name</label>
                    <input type="text" name="lastName" class="form-control" id="last-name" value="<?php echo $lastName; ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="company-name" style="color:black">Company Name (optional)</label>
                        <input type="text" class="form-control" id="company-name">
                    </div>

                    <div class="form-group">
                        <label for="address" style="color:black">Address</label>
                        <input type="text" name="address" class="form-control" id="address" value="<?php echo $address; ?>"required>
                    </div>

                    <div class="form-group">
                        <label for="postcode" style="color:black">Postcode/ZIP</label>
                        <input type="number" name="zipCode" class="form-control" id="postcode">
                    </div>

                    <div class="form-group">
                        <label for="email" style="color:black">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?php echo $email; ?>" required>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="order-summary">
                        <h6 class="order-label">YOUR ORDER</h6>
                        <div class="container line-2" style="width: 853px; margin-left: 20px;"></div>
                        <table class="table table-bordered order-table table-hover table-striped" style="border: 1px solid black;">
                            <thead style="background-color: #634832;">
                                <tr>
                                    <th scope="col" style="padding-left: 20px; color: #ECE0D1;">PRODUCT</th>
                                    <th scope="col" style="padding-left: 20px; color: #ECE0D1;">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $rowNum = 0;
                                    $totalPrice = 0;
                                    foreach ($orderIds as $orderId) {
                                        $query = "SELECT product, price FROM customer_order WHERE orderId = '$orderId'";
                                        $query_run = mysqli_query($con, $query);
                                        
                                        foreach ($query_run as $row) {
                                            $product = $row["product"];
                                            $price = $row["price"];
                                            $totalPrice += $price;
                                            // Alternating row color
                                            $rowColor = ($rowNum % 2 == 0) ? '#FFFFFF' : '#634832';

                                            // Alternating row text color
                                            $rowText = ($rowNum % 2 == 0) ? '#000000' : '#ECE0D1'; 

                                             echo "<tr style='background-color: " . $rowColor . "'>";
                                            echo "<td style='padding-left: 20px; color: " . $rowText . "'>" . $product . "</td>";
                                            echo "<td style='padding-left: 20px; color: " . $rowText . "' class='price-cell'>". "₱ "  . $price . "</td>";
                                            echo "</tr>";
                                                
                                            $rowNum++;
                                        }
                                    }
                                    $rowColor = ($rowNum % 2 == 0) ? '#FFFFFF' : '#634832';

                                ?>

                                <tr style="background-color: <?php echo $rowColor;  ?>">
                                    <td style="padding-left: 20px;"><strong>TOTAL:</strong></td>
                                    <td style="padding-left: 20px;"><strong>₱ <?php echo $totalPrice;  ?></strong></td>
                                </tr>



                            </tbody>
                        </table>
                        <br>
                        <div class="form-check bayad">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Cash on Delivery
                            </label>
                        </div>
                        <div class="form-check bayad">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2"
                                checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Gcash No: 09171794590
                            </label>
                        </div>
                        <h5 class="privacy">Your personal data will be used to process your order, support your
                            experience throughout this website, and for other purposes described in our privacy policy.
                        </h5>
                        <button type="submit" name="orderPost" class="btn btn-success order-button">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <section class="container-fluid footer"
        style="background-color: #634832; margin-top: 50px; margin-bottom: 0px;">
        <div class="row">
            <div class="col-3">
                <div class="secondlogo"></div>
            </div>
            <div class="col-3">
                <h3 class="Contact-Us">CONTACT US</h3>
                <h3 class="footerinfo1">15 Crystal St. Rockville 2 Subdivision, Novaliches, Quezon City 1116,
                    Philippines
                    <br>
                    espressodreams@gmail.com <br>
                    09171792602
                </h3>
                <h3 class="footerinfo2">Copyright © 2023, EspressoDreams.ph</h3>
                <div class="line" style="margin-top: -25px; width:350px;"></div>
                <div class="fb"></div>
                <div class="ig"></div>
                <div class="twitter"></div>
            </div>
            <div class="col-6">
                <div class="fordev">FOR DELIVERY</div>
            <ul class="fordev-info">
                <li>We use thermal bags for our delivery to ensure the quality of our products.</li>
                <li>Upon payment, please allow 2-4 days of delivery.</li>
                <li>You will be notified via text message on delivery day.</li>
                <li>No deliveries on Sundays and nonworking Holidays.</li>
            </ul>
            <h3 class="Note">Note: We deliver within Metro Manila only.</h3>
            </div>

        </div>
    </section>

    <!-- ORDER MODAL -->
    <div class="modal fade" id="orderModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body ">
                    <form method='POST'>
                        <div class="justify-content-end">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>