<?php
session_start();
include "connection.php";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  if (isset($_POST['logOut'])) {
    session_unset();
    session_destroy();
    header("Location: /Espresso Dreams/Home Page/HomePage.html");
    exit();
  }
} else {
  header("Location: /Espresso Dreams/Shop Page/ShopPage.php");
  exit();
}

function getData($sql_code)
{
  include "connection.php";
  $query_run = mysqli_query($con, $sql_code);

  if (mysqli_num_rows($query_run) > 0) {
    $rowNum = 0;
    foreach ($query_run as $row) {
      $fullname = $row["fullname"];
      $email = $row["email"];
      $phoneNumber = $row["phoneNumber"];
      $address = $row["address"];
      $orderId = $row["orderId"];
      $zip = $row["zip"];
      $product = $row["product"];
      $flavor = $row["flavor"];
      $size = $row["size"];
      $quantity = $row["quantity"];
      $price = $row["price"];
      $date = $row["date"];
      $status = $row["status"];

      // Alternating row color
      $rowColor = ($rowNum % 2 == 0) ? '#FFFFFF' : '#634832';

      // Alternating row text color
      $rowText = ($rowNum % 2 == 0) ? '#000000' : '#ECE0D1';

      echo "<tr style='background-color: " . $rowColor . "'>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $fullname . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $email . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $phoneNumber . "</td>";
      echo "<td style='color: " . $rowText . "'>" . $address . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $zip . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $orderId . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $product . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $flavor . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $size . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $quantity . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $price . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $date . "</td>";
      echo "<td style='color: " . $rowText . "; text-align: center;'>" . $status . "</td>";
      echo "</tr>";
      $rowNum++;
    }
  } else {
    echo '<script>window.onload = function() { $("#modalMessage").html("No records Found."); $("#orderModal").modal("show"); }</script>';
  }
}


?>


<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Espresso Dreams</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="Admin.css">

</head>

<body style="background-color:#ECE0D1;">
  <nav>
    <div class="text-logo"></div>
    <div class="dropdown">
      <a class="btn btn-success dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Welcome Admin!
      </a>
      <form method="POST">
        <ul class="dropdown-menu">
          <li><button class="dropdown-item" name="logOut" type="submit"><strong>Sign Out</strong></button></li>
        </ul>

    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-lg-5" style="margin-top: 60px;">
        <div class="input-group input-group-lg">
          <input type="text" name="search" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" onkeydown="disableEnterKey(event)">
          <button class="btn btn-primary" type="submit" style="background-color:#634832;" name="searchBtn">Search</button>
        </div>
      </div>

      <div class="col-lg-3" style="margin-top: 80px;">
        <div class="dropdown">
          <select style="background-color: #634832; height: 52px;" name="dropdown" class="btn btn-secondary dropdown-toggle">
            <option value="" hidden>Filter by status</option>
            <option value="ordered"><strong>Order</strong></option>
            <option value="cart"><strong>Cart</strong></option>
          </select>
        </div>
      </div>

      <div class="col-lg-4" style="margin-top: 80px;">
        <input type="date" name="date2" class="form-control dateEdit">
      </div>
      </form>
    </div>
  </div>


  <br>

  <!--TABLE-->
  <div class="row-md justify-content-center">
    <div style="background-color: #634832;" class="table-wrapper table-responsive-md p-3 rounded shadow-lg">
      <table class="table table-bordered table-hover table-striped" style="border: 1px solid black;">
        <thead style="background-color: #634832;">
          <tr style="height: 60px;">
            <th style="width: 150px;" scope="col">Name</th>
            <th style="width: 30px;" scope="col">Email</th>
            <th style="width: 130px;" scope="col">Phone Number</th>
            <th style="width: 300px;" scope="col">Address</th>
            <th style="width: 90px;" scope="col">Zip Code</th>
            <th style="width: 80px;" scope="col">Order ID</th>
            <th style="width: 100px;" scope="col">Product</th>
            <th style="width: 50px;" scope="col">Flavor</th>
            <th style="width: 70px;" scope="col">Size</th>
            <th style="width: 80px;" scope="col">Quantity</th>
            <th style="width: 50px;" scope="col">Price</th>
            <th style="width: 120px;" scope="col">Date</th>
            <th style="width: 50px;" scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($_POST['searchBtn'])) {
            if (!empty($_POST['search']) && !empty($_POST['dropdown']) && !empty($_POST['date2'])) {
              $search = $_POST['search'];
              $drop = $_POST['dropdown'];
              $date = $_POST['date2'];

              $get_data = "SELECT concat(info.firstName, ' ', info.lastName) AS fullname, info.email, info.phoneNumber, info.address, cust.orderId, cust.zip, cust.product, cust.flavor, cust.size, cust.quantity, cust.price, cust.date, cust.status 
                      FROM customer_info AS info 
                      INNER JOIN customer_order AS cust 
                      ON info.customId = cust.customId
                      WHERE status = '$drop' AND date LIKE '%$date%' AND concat(info.firstName, ' ', info.lastName) LIKE '%$search%' OR orderId LIKE '%$search%' OR product LIKE '%$search%' OR flavor LIKE '%$search%' OR size LIKE '%$search%' OR quantity LIKE '%$search%' OR price LIKE '%$search%' OR status LIKE '%$search%' 
                      ORDER BY info.customId";
              getData($get_data);
            } else if (!empty($_POST['search']) && !empty($_POST['dropdown'])) {
              $search = $_POST['search'];
              $drop = $_POST['dropdown'];

              $get_data = "SELECT concat(info.firstName, ' ', info.lastName) AS fullname, info.email, info.phoneNumber, info.address, cust.orderId, cust.zip, cust.product, cust.flavor, cust.size, cust.quantity, cust.price, cust.date, cust.status 
                      FROM customer_info AS info 
                      INNER JOIN customer_order AS cust 
                      ON info.customId = cust.customId
                      WHERE status = '$drop' AND concat(info.firstName, ' ', info.lastName) LIKE '%$search%' OR orderId LIKE '%$search%' OR product LIKE '%$search%' OR flavor LIKE '%$search%' OR size LIKE '%$search%' OR quantity LIKE '%$search%' OR price LIKE '%$search%' OR status LIKE '%$search%' 
                      ORDER BY info.customId";
              getData($get_data);
            } else if (!empty($_POST['search']) && !empty($_POST['date2'])) {
              $search = $_POST['search'];
              $date = $_POST['date2'];

              $get_data = "SELECT concat(info.firstName, ' ', info.lastName) AS fullname, info.email, info.phoneNumber, info.address, cust.orderId, cust.zip, cust.product, cust.flavor, cust.size, cust.quantity, cust.price, cust.date, cust.status 
                      FROM customer_info AS info 
                      INNER JOIN customer_order AS cust 
                      ON info.customId = cust.customId
                      WHERE date LIKE '%$date%' AND concat(info.firstName, ' ', info.lastName) LIKE '%$search%' OR orderId LIKE '%$search%' OR product LIKE '%$search%' OR flavor LIKE '%$search%' OR size LIKE '%$search%' OR quantity LIKE '%$search%' OR price LIKE '%$search%' OR status LIKE '%$search%' 
                      ORDER BY info.customId";
              getData($get_data);
            } else if (!empty($_POST['dropdown']) && !empty($_POST['date2'])) {
              $drop = $_POST['dropdown'];
              $date = $_POST['date2'];

              $get_data = "SELECT concat(info.firstName, ' ', info.lastName) AS fullname, info.email, info.phoneNumber, info.address, cust.orderId, cust.zip, cust.product, cust.flavor, cust.size, cust.quantity, cust.price, cust.date, cust.status 
                      FROM customer_info AS info 
                      INNER JOIN customer_order AS cust 
                      ON info.customId = cust.customId
                      WHERE status = '$drop' AND date LIKE '%$date%' 
                      ORDER BY info.customId";
              getData($get_data);
            } else if (!empty($_POST['search'])) {
              $search = $_POST['search'];

              $get_data = "SELECT concat(info.firstName, ' ', info.lastName) AS fullname, info.email, info.phoneNumber, info.address, cust.orderId, cust.zip, cust.product, cust.flavor, cust.size, cust.quantity, cust.price, cust.date, cust.status 
                      FROM customer_info AS info 
                      INNER JOIN customer_order AS cust 
                      ON info.customId = cust.customId
                      WHERE concat(info.firstName, ' ', info.lastName) LIKE '%$search%' OR orderId LIKE '%$search%' OR product LIKE '%$search%' OR flavor LIKE '%$search%' OR size LIKE '%$search%' OR quantity LIKE '%$search%' OR price LIKE '%$search%' OR status LIKE '%$search%' 
                      ORDER BY info.customId";
              getData($get_data);
            } else if (!empty($_POST['dropdown'])) {
              $drop = $_POST['dropdown'];

              $get_data = "SELECT concat(info.firstName, ' ', info.lastName) AS fullname, info.email, info.phoneNumber, info.address, cust.orderId, cust.zip, cust.product, cust.flavor, cust.size, cust.quantity, cust.price, cust.date, cust.status 
                      FROM customer_info AS info 
                      INNER JOIN customer_order AS cust 
                      ON info.customId = cust.customId
                      WHERE status = '$drop' 
                      ORDER BY info.customId";
              getData($get_data);
            } else if (!empty($_POST['date2'])) {
              $date = $_POST['date2'];

              $get_data = "SELECT concat(info.firstName, ' ', info.lastName) AS fullname, info.email, info.phoneNumber, info.address, cust.orderId, cust.zip, cust.product, cust.flavor, cust.size, cust.quantity, cust.price, cust.date, cust.status 
                      FROM customer_info AS info 
                      INNER JOIN customer_order AS cust 
                      ON info.customId = cust.customId
                      WHERE date LIKE '%$date%'
                      ORDER BY info.customId";
              getData($get_data);
            } else {
              echo '<script>window.onload = function() { $("#modalMessage").html("Please use the search bar, filter by, or the date!"); $("#orderModal").modal("show"); }</script>';
            }
          } else {
            unset($_SESSION['searchBtn']);
            $get_data = "SELECT concat(info.firstName, ' ', info.lastName) AS fullname, info.email, info.phoneNumber, info.address, cust.orderId, cust.zip, cust.product, cust.flavor, cust.size, cust.quantity, cust.price, cust.date, cust.status 
                    FROM customer_info AS info 
                    INNER JOIN customer_order AS cust 
                    ON info.customId = cust.customId 
                    ORDER BY info.customId";
            getData($get_data);
          }

          ?>
        </tbody>
      </table>
    </div>
  </div>



  <br>
  <br>
  <br>
  <br>


  <section class="container-fluid footer" style="background-color: #634832; margin-top: 50px; margin-bottom: 0px;">
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
        <div class="line" style="margin-top: -30px; width:350px;"></div>
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

  <script type="text/javascript">
    var timeLimit = 3000; // 5 seconds

    // Close the modal after the specified time limit
    setTimeout(function() {
      $('#orderModal').modal('hide');
    }, timeLimit);

    function disableEnterKey(event) {
      if (event.key === "Enter" || event.keyCode === 13) {
        event.preventDefault();
      }
    }
  </script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>