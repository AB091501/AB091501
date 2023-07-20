<?php
    session_start();
    include "connection.php";
    date_default_timezone_set('Asia/Manila');

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        if (isset($_SESSION['customId'])) {
            $customerId = $_SESSION['customId'];

            if (isset($_SESSION['orderPlaced']) && $_SESSION['orderPlaced'] == true) {
                // Clear the success indicator from the session
                unset($_SESSION['orderPlaced']);
                // Show the modal after the page reloads
                echo '<script>window.onload = function() { $("#modalMessage").html("Ordered Successfully!"); $("#orderModal").modal("show"); }</script>';
            } 

            if (isset($_SESSION['createdAccount']) && $_SESSION['createdAccount']) {
                // Clear the success indicator from the session
                unset($_SESSION['createdAccount']);
                // Show the modal after the page reloads
                echo '<script>window.onload = function() { $("#modalMessage").html("Account Created Successfully!"); $("#orderModal").modal("show"); }</script>';
            }
        
            $min = 100000; // minimum value
            $max = 999999; // maximum value
            $nums = 1;
            while($nums == 1) { // For Unique ID generation
                $customerOrder = random_int($min, $max); //999999
                $query = "SELECT COUNT(*) AS num FROM customer_order WHERE orderId = $customerOrder;";
                $query_run = mysqli_query($con, $query);
                foreach ($query_run as $row) {
                    $nums = $row["num"]; 
                }
            }

            if (isset($_POST['addToCart'])) {
                $product = $_POST['dropdown']; 
                $size = $_POST['radioButtons'];
                $quantity = $_POST['quantity'];
                $currentDate = date("Y-m-d");
                $currentTime = date("H:i:s");
                $price = 0; 
                $flavors = array("Chocolate", "Strawberry", "Vanilla", "Coffee", "Peanut", "Mocha", "Tiramisu", "Rocky road", "Double dutch", "Cookies and cream");
        
                if (in_array($product, $flavors)) {
                    $flavor = 'Basic';
                    $price = 370;
                } else {
                    $flavor = 'Special';
                    $price = 400;
                }
        
                if ($size == '1 Liter') {
                    $price -= 55;
                } else if ($size == '1 Pint') {
                    $price -= 160;
                }
        
                if ($quantity > 1) {
                    $price *= $quantity;
                }
        
                $query = "INSERT INTO customer_order VALUES ('$customerId', '$customerOrder', ' ', '$product', '$flavor', '$size', '$quantity', '$price', '$currentDate', '$currentTime', 'cart')";
                $query_run = mysqli_query($con, $query);
        
                echo '<script>window.onload = function() { $("#modalMessage").html("Added to Cart Successfully!"); $("#orderModal").modal("show"); }</script>';
            }

            $total = 0;
            $cart = "SELECT COUNT(*) AS orders FROM customer_order WHERE customId = '$customerId' AND status = 'cart';";
            $query_run = mysqli_query($con, $cart);
            foreach ($query_run as $row) {
                $total= $row["orders"];
            }

            if (isset($_POST['DeleteButton'])) {
                $orderId = $_POST['orderId'];
                $query = "DELETE FROM customer_order WHERE orderId = '$orderId'";
                $result = mysqli_query($con, $query);
                echo '<script>window.onload = function() { $("#modalMessage").html("Deleted to Cart Successfully!"); $("#orderModal").modal("show"); }</script>';

            }

            if (isset($_POST['ProceedButton'])) {
                if (isset($_POST['selectedIds'])) {
                    $selectedIds = $_POST['selectedIds'];

                    $orderId = $selectedIds[0];
                    $customerId = "";
                    $query = "SELECT customId AS Id FROM customer_order WHERE orderId = '$orderId'";
                    $query_run = mysqli_query($con, $query);
                    foreach ($query_run as $row) {
                        $customerId = $row["Id"];
                    }

                    // Loop through the orderIdArray and process each orderId as needed
                    /*foreach ($orderIdArray as $orders) {
                        $updateQuery = "UPDATE customer_order SET status = 'ordered' WHERE orderId = '$orderId'";
                        $updateResult = mysqli_query($con, $updateQuery);
                    }*/

                    $orderIds = implode(',', $selectedIds); 
                    header("Location: /Espresso Dreams/Payment Page/Payment.php?customerId=" . $customerId . "&orderIds=" . $orderIds);
                } else {
                    echo '<script>window.onload = function() { $("#modalMessage").html("PLEASE SELECT YOUR ORDER FIRST!"); $("#orderModal").modal("show"); }</script>';
                }
            }

        }
    } else {
        header("Location: /Espresso Dreams/Shop Page/ShopPage.php");
        exit();
    }

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page - Espresso Dreams</title>

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
            <h3 class="basic-label">BASIC FLAVORS (2 Liters ₱370/1 Liters ₱315/1 Pint ₱210)</h3>
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
            <h3 class="special-label">SPECIAL FLAVORS (2 Liters ₱400/1 Liters ₱345/1 Pint ₱240)</h3>
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
                <button type="button" class="add" data-bs-toggle='modal' data-bs-target='#addCart'>ADD TO CART</button>
                <button type="button" class="view" data-bs-toggle='modal' data-bs-target='#viewCart'>VIEW MY CART (<?php echo $total ?>)</button>
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

    <!--ADD TO CART MODAL-->
    <div class="modal fade" id="addCart" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="background-color: #ECE0D1;">
                <div class="bg-color modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel"><strong>ESPRESSO DREAMS CART</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form method="POST">
                        <div class="dropdown">
                            <select style="background-color: #634832;" name="dropdown" class="btn btn-secondary dropdown-toggle" required>
                                <option value="" hidden>- Flavors -</option>
                                <option disabled class="dropdown-divider-option" style="background-color: white;">-- Basic Flavors --</option>
                                <option value="Chocolate">🍫 Chocolate</option>
                                <option value="Strawberry">🍓 Strawberry</option>
                                <option value="Vanilla">🍦 Vanilla</option>
                                <option value="Coffee">☕️ Coffee</option>
                                <option value="Peanut">🥜 Peanut</option>
                                <option value="Mocha">☕️🍫 Mocha</option>
                                <option value="Tiramisu">🍰 Tiramisu</option>
                                <option value="Rocky road">🍫🥜 Rocky road</option>
                                <option value="Double dutch">🍫🍦 Double dutch</option>
                                <option value="Cookies and cream">🍪🥛 Cookies and cream</option>
                                <option disabled class="dropdown-divider-option"> </option>
                                <option disabled class="dropdown-divider-option" style="background-color: white;">-- Special Flavors --</option>
                                <option value="Matcha">🍵 Matcha</option>
                                <option value="Cappuccino Heaven">☁️☕️ Cappuccino Heaven</option>
                                <option value="Espresso Dream">☁️☕️🌙 Espresso Dream</option>
                                <option value="Mocha Almond Fudge">☕️🌰 Mocha Almond Fudge</option>
                                <option value="Roasted Pecan">🌰 Roasted Pecan</option>
                                <option value="French Vanilla">French Vanilla</option>
                                <option value="Hazelnut Ground">🌰☕️ Hazelnut Ground</option>
                                <option value="Caramel Macchiato">☕️ Caramel Macchiato</option>
                                <option value="Pistachio">🥜 Pistachio</option>
                                <option value="Walnut Cinnamon">🌰🍁 Walnut Cinnamon</option>
                            </select>
                        </div>

                        <hr>

                        <h4>Size</h4>
                        <input type="radio" id="button1" name="radioButtons" value="2 Liters" style="display: none;" checked="checked">
                        <label for="button1" class="btn btn-primary" style="background-color: #634832; border: none;"> 2 Liters</label>

                        <input type="radio" id="button2" name="radioButtons" value="1 Liter" style="display: none;">
                        <label for="button2" class="btn btn-primary" style="background-color: #634832; border: none;"> 1 Liter </label>

                        <input type="radio" id="button3" name="radioButtons" value="1 Pint" style="display: none;"> 
                        <label for="button3" class="btn btn-primary" style="background-color: #634832; border: none;"> 1 Pint</label>

                        <hr>

                        <h4>Quantity</h4>

                        <div class="addSub2">
                          <button type="button" onclick="decrement()" class="sub">-</button>
                          <input type="number" name="quantity" id="quantity" value="1" readonly class="addSub" required>
                          <button type="button" onclick="increment()" class="sub">+</button>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #634832; border: none;">Close</button>
                    <button type="submit" name="addToCart" class="btn btn-primary" style="background-color: #634832; border: none;">Add To Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--VIEW MY CART MODAL-->
    <div class="modal fade" id="viewCart" data-bs-backdrop="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="background-color: #ECE0D1;">
                <div class="bg-color modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel"><strong>ESPRESSO DREAMS CART</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method='POST'>
                <div class="modal-body ">
                    <div class="row-md justify-content-center">
                        <div style="background-color: #634832;" class="table-wrapper table-responsive-md p-3 rounded shadow-lg">
                            <table style="border: 1px solid #ECE0D1;" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr style="height: 60px;">
                                        <th width="100px" scope="col">Check Out</th>
                                        <th scope="col">Flavor</th>
                                        <th width="300px" scope="col">Size</th>
                                        <th width="180px" scope="col">Quantity</th>
                                        <th width="290px" scope="col">Price</th>
                                        <th width="290px" scope="col">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = "SELECT orderId, product, size, quantity, price FROM customer_order WHERE customId = '$customerId' AND status = 'cart'";

                                        $result = mysqli_query($con, $query);

                                        if (mysqli_num_rows($result) > 0) {
                                            $rowNum = 0; // Counter for row number
                                            foreach ($result as $row) { 
                                                $orderId = $row["orderId"];
                                                $prod = $row["product"];
                                                $size = $row["size"];
                                                $quant = $row["quantity"];
                                                $price = $row["price"];

                                                $rowColor = ($rowNum % 2 == 0) ? '#FFFFFF' : '#634832'; // Alternating row color

                                                $rowText = ($rowNum % 2 == 0) ? '#000000' : '#ECE0D1'; // Alternating row text color

                                                echo "<tr style='background-color: " . $rowColor . "' data-custom-id='" . $orderId . "'>";
                                                echo "<td style='color: " . $rowText . "'><input class='form-check-input item-checkbox' type='checkbox' value='$orderId' name='selectedIds[]' id='flexCheckDefault' onclick='calculateTotal()'></td>";
                                                echo "<td style='color: " . $rowText . "'>" . $prod . "</td>";
                                                echo "<td style='color: " . $rowText . "'>" . $size . "</td>";
                                                echo "<td style='color:" . $rowText . "'>" . $quant . "</td>";
                                                echo "<td style='color: " . $rowText . "' class='price-cell'>". "₱ "  . $price . "</td>";
                                                
                                                echo "<td style='color: " . $rowText . "'>
                                                    <input type='hidden' name='orderId' value='" . $orderId . "'>
                                                    <button type='submit' name='DeleteButton' class='mx-1 btn btn-secondary' style='background-color: #6D6D6D'>Delete</button></td>";
                                                echo "</tr>";
                                                

                                                $rowNum++;
                                            }
                                        } else {
                                            echo "<tr>";
                                            echo "<td style='color: #ECE0D1'> - </td>";
                                            echo "<td style='color: #ECE0D1'> - </td>";
                                            echo "<td style='color: #ECE0D1'> - </td>";
                                            echo "<td style='color: #ECE0D1'> - </td>";
                                            echo "<td style='color: #ECE0D1'> - </td>";
                                            echo "<td style='color: #ECE0D1'> - </td>";
                                            echo "</tr>";
                                        }


                                    ?>
                        
                                </tbody>
                            </table>
                            <p id="total-price" style='color: #ECE0D1'><strong>TOTAL: ₱0.00</strong></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #634832; border: none;">Close</button>
                    <button type="submit" name="ProceedButton" id="proceed-button" class="btn btn-primary" style="background-color: #634832; border: none;">Proceed to Payment</button>
                </div>
                </form>;
            </div>
        </div>
    </div>

    <!-- MESSAGE MODAL -->
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
        const addCart = document.getElementById('addCart')
        addCart.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
           
        })

        function increment() {
            var quantityInput = document.getElementById('quantity'); 
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }

        function decrement() {
            var quantityInput = document.getElementById('quantity'); 
            var currentValue = parseInt(quantityInput.value); 
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        function changeLabelColor(label) {
            label.classList.toggle('selected-label');
        }

        var modal = document.getElementById("viewCart");

        // When the modal is closed
        modal.addEventListener("hidden.bs.modal", function () {
            var totalElement = document.getElementById("total-price");
            totalElement.innerText = "Total: ₱0.00";
          // Get all the checkboxes with class "form-check-input"
          var checkboxes = document.getElementsByClassName("form-check-input");

          // Loop through the checkboxes
          for (var i = 0; i < checkboxes.length; i++) {
            // Uncheck the checkbox
            checkboxes[i].checked = false;
          }
        });

        function calculateTotal() {
            var checkboxes = document.getElementsByClassName('item-checkbox');
            var totalPrice = 0;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    var row = checkboxes[i].parentNode.parentNode;
                    var priceCell = row.querySelector('.price-cell');
                    var price = parseFloat(priceCell.innerText.replace('₱', '').trim());

                    if (!isNaN(price)) {
                        totalPrice += price;
                    }
                }
            }

            // Display the total price
            var totalElement = document.getElementById('total-price');
            totalElement.innerText = "Total: ₱" + totalPrice.toFixed(2);

            // Enable or disable the "Proceed to Payment" button based on checkbox selection
            var proceedButton = document.getElementById("proceed-button");
            proceedButton.disabled = totalPrice === 0;
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