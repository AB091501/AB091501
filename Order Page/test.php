<?php 
  session_start();

  if (isset($_POST['yesButton'])) {
    $applicantId = $_POST['applicantId']
    $updateQuery = "UPDATE applications SET application_status = 'Approved' WHERE applicant_id = '$applicantId'";
    $updateResult = mysqli_query($conn, $updateQuery);
  }

  if (isset($_POST['noButton'])) {
    $applicantId = $_POST['applicantId']
    $updateQuery = "UPDATE applications SET application_status = 'Rejected' WHERE applicant_id = '$applicantId'";
    $updateResult = mysqli_query($conn, $updateQuery);
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laborer Approval</title>

    <!--default-->
    <link rel="icon" type="favicon" href="../icons/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;800&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/6dac587466.js"
      crossorigin="anonymous"
    ></script>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="../app.css" />

    <!--For navbar-->
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  </head>

  <body>
    <div class="container-fluid main-pages">
      <div class="row">
        <!--Navigation bar-->
        <div
          id="nav-placeholder"
          class="bg-light col-1 min-vh-100 d-flex flex-column justify-content-center text-truncate"
        ></div>
        <script>
          $(function () {
            $("#nav-placeholder").load("../admin/nav.html");
          });
        </script>
        <!--end of Navigation bar-->

        <!--MAIN-->
        <div class="col p-4">
          <main
            class="col-12 rounded-4 oranges orange-font others-envelope g-0 z-0"
          >
            <div class="row p-3 g-1">
              <div
                class="col-12 rounded rounded-4 border border-4 whites profile-container p-3"
              >
                <header class="row align-items-center">
                  <div class="col ms-4">
                    <h1 class="display-1 blue-font header">Laborer Approval</h1>
                  </div>
                </header>
                <hr />

                <section class="row mt-5">
                  <header>
                    <h2 class="header orange-font text-normal mt-3">
                      Applicants
                    </h2>
                  </header>

                  <article
                    class="row border border-4 rounded rounded-4 mx-auto overflow-auto"
                    style="height: 590px"
                  >
                    <div class="col-12 p-2">
                      <div class="table-responsive">
                        <table
                          class="table table-striped table-hover text-center"
                        >
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Applicant ID</th>
                              <th scope="col">Full Name</th>
                              <th scope="col">Specialization</th>
                              <th scope="col">Type of Employment</th>
                              <th scope="col">Employer</th>
                              <th scope="col">Valid ID</th>
                              <th scope="col">
                                Proof/Certificates
                              </th>
                              <th scope="col">Date of Application</th>
                              <th scope="col">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <form method="POST">
                            <?php 
                            $num = 0; 
                            $query = "SELECT A.applicant_id, concat(U.first_name, ' ' , U.last_name, ' ', U.suffix) AS fullName, A.specialization, A.employment_type, A.employer, A.valid_id, A.certification_proof, A.created_at FROM users AS U INNER JOIN applications AS A ON U.user_id = A.user_id;";
                            $query_run = mysqli_query($conn, $query);
                            foreach ($query_run as $row) {
                              ++$num;
                              $applicantId = $row["applicant_id"];
                              $fullName = $row["fullName"];
                              $specialization = $row["specialization"];
                              $employment_type = $row["employment_type"];
                              $employer = $row["employer"];
                              $valid_id = $row["valid_id"];
                              $certification_proof = $row["certification_proof"];
                              $created_at = $row["created_at"];

                              echo "
                              <tr class='text-normal font-normal'>
                                <th scope='row'>$num</th>
                                <td>$applicantId</td>
                                <td>$fullName</td>
                                <td>$specialization</td>
                                <td>$employment_type</td>
                                <td>$employer</td>
                                <td>$valid_id</td>
                                <td>$certification_proof</td>
                                <td>$created_at</td>
                                <td>
                                  <input type='hidden' name='applicantId' value='$applicantId'>
                                  <button
                                  class='btn yesno'
                                  type='submit'
                                  name='yesButton'
                                >
                                  <img
                                    class='img-fluid'
                                    src='icons/yesno/accept.png'
                                    alt='yes'
                                  />
                                </button>
                                <button
                                  class='btn btn-link yesno'
                                  type='submit'
                                  name='noButton'
                                >
                                  <img
                                    class='img-fluid'
                                    src='icons/yesno/decline.png'
                                    alt='no'
                                  />
                                </button>
                                </td>
                              </tr>
                              ";
                            }

                            ?>
                            </form>

                            <!--BLANK-->
                            <tr>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                            </tr>
                            <!----->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </article>
                </section>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
