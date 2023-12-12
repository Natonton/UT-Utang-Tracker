<?php
    include "conn.php";
    include_once "inc/function.php";
    session_start();
    
    try{
        if(empty($_SESSION)){
            ?>
                <script>
                    alert("Session expired, please login again");
                    window.location.href="index.php";
                </script>
            <?php
        }
        else{
            $sessionName = $_SESSION['adminName'];

            $adminDetails = getAdminInfo($conn, $sessionName);
            foreach($adminDetails as $details){
                $adminName = strtoupper($details[1]);
                $adminID = $details[0];
                $adminPic = $details[3];
            }
        }
    }
    catch(PDOException $e){
        die("Error: " . $e->getMessage());
    }
    include "inc/header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Debtors</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
          <li class="breadcrumb-item active">Debtors</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <h5 class="card-title">Debtor Master List</h5>

            <!-- Table with hoverable rows -->
            <table class="table table-hover table-bordered table-responsive text-center " id="debtorTable">
              <thead>
                <tr class="table-danger">
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Age</th>
                  <th scope="col">Number</th>
                  <th scope="col">Address</th>
                  <th scope="col">Balance</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              
              <tbody>
              <div class="row">
                <div class="col">
                  
                  <div class="input-group mb-3 w-25">
                    <a href="debtors.php" class="me-3"><button type="button" class="btn btn-primary "><i class="fa-solid fa-arrows-rotate"></i></button></a>
                      <input type="text" class="form-control mx-1" placeholder="search.." id="search">
                  </div>
                </div>
                  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addNewDebtor">
                    Add new debtor
                  </button>
              </div>
                
                <!-- Add new debtor modal -->
                <div class="modal fade" id="addNewDebtor" tabindex="-1" aria-labelledby="addNewDebtorLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addNewDebtorLabel">ADD NEW DEBTOR</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="adminProcess.php" method="POST">
                          <div class="input-group mb-3">
                            <span class="input-group-text"></span>
                            <input type="text" aria-label="First name" class="form-control" placeholder="Enter First Name" name="fname">
                            <input type="text" aria-label="Last name" class="form-control" placeholder="Enter Last Name" name="lname">
                          </div>
                          <div class="input-group mb-3">
                            <span class="input-group-text"></span>
                            <input type="number" aria-label="Age" class="form-control" placeholder="Enter Age" name="age">
                          </div>
                          <div class="input-group mb-3">
                            <span class="input-group-text"></span>
                            <input type="number" aria-label="Number" class="form-control" placeholder="Enter Number" name="number">
                          </div>
                          <div class="input-group mb-3">
                            <span class="input-group-text"></span>
                            <input type="text" aria-label="Address" class="form-control" placeholder="Enter Address" name="address">
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="addNewDebtor" class="btn btn-primary">Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                  $debtorsDetails = getAllDebtorsInfo($conn);
                  foreach($debtorsDetails as $debtorInfo){
                    $debtorID = $debtorInfo[0];
                    $debtorFirstName = $debtorInfo[1];
                    $debtorLastName = $debtorInfo[2];
                    $debtorName = strtoupper("$debtorFirstName $debtorLastName");
                    $debtorAge = $debtorInfo[3];
                    $debtorNumber = $debtorInfo[4];
                    $debtorAddress = strtoupper($debtorInfo[5]);
                    $debtorBalance = $debtorInfo[6];
                    ?>
                      <tr>
                        <td><?php echo $debtorID;?></td>
                        <td><?php echo $debtorName;?></td>
                        <td><?php echo $debtorAge;?></td>
                        <td><?php echo $debtorNumber;?></td>
                        <td><?php echo $debtorAddress;?></td>
                        <td>
                          <div class="row">
                            <div class="col p-1">
                              <?php echo $debtorBalance;?>
                            </div>
                            <div class="col p-1">
                              <!-- minus balance -->
                              <i class="fa-solid fa-circle-minus text-warning" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#minusBalance<?php echo $debtorID;?>"></i>
                              <div class="modal fade" id="minusBalance<?php echo $debtorID;?>" tabindex="-1" aria-labelledby="minusBalance" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="minusBalance">Minus Balance</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="adminProcess.php?debtorID=<?php echo $debtorID?>&adminID=<?php echo $adminID;?>&adminName=<?php echo $adminName;?>&debtorName=<?php echo $debtorName;?>" method="POST">
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger">REMAINING BALANCE</span>
                                          <input type="number" class="form-control fw-bold" value="<?php echo $debtorBalance;?>" name="balance" readonly>
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger"></span>
                                          <input type="number" class="form-control" placeholder="Enter ammount to deduct" name="ammount">
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger"></span>
                                          <input type="text" class="form-control" placeholder="Enter Note" name="note">
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger"></span>
                                          <input type="text" class="form-control" placeholder="Enter Admin Username" name="username">
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger"></span>
                                          <input type="password" class="form-control" placeholder="Enter Admin Password" name="password">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" name="proceedMinus">Proceed</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- add balance -->
                              <i class="fa-solid fa-circle-plus text-danger" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#addBalance<?php echo $debtorID;?>"></i>
                              <div class="modal fade" id="addBalance<?php echo $debtorID;?>" tabindex="-1" aria-labelledby="minusBalance" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="minusBalance">Add Balance</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="adminProcess.php?debtorID=<?php echo $debtorID?>&adminName=<?php echo $adminName;?>&debtorName=<?php echo $debtorName;?>" method="POST">
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger">REMAINING BALANCE</span>
                                          <input type="number" class="form-control fw-bold" value="<?php echo $debtorBalance;?>" name="balance" readonly>
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger"></span>
                                          <input type="number" class="form-control" placeholder="Enter ammount to add" name="ammount">
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger"></span>
                                          <input type="text" class="form-control" placeholder="Enter Note" name="note">
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text text-danger"></span>
                                          <input type="text" class="form-control" placeholder="Enter Item" name="item" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" name="proceedAdd">Proceed</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="row text-center mx-1">
                            <a data-bs-toggle="modal" data-bs-target="#editDebtor<?php echo $debtorID;?>" class="p-2 mb-1" style="color: black; background-color: #faab00; border-radius: 3px; cursor: pointer;"><i class="fa-solid fa-pen-to-square fs-5"></i></a>
                              <!-- edit Modal -->
                              <div class="modal fade" id="editDebtor<?php echo $debtorID;?>" tabindex="-1" aria-labelledby="editDebtorLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="editDebtorLabel">Edit Debtor</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="adminProcess.php?debtorID=<?php echo $debtorID?>" method="POST">
                                        <div class="input-group mb-3">
                                          <span class="input-group-text"></span>
                                          <input type="text" aria-label="First name" class="form-control" value="<?php echo $debtorFirstName; ?>" name="fname">
                                          <input type="text" aria-label="Last name" class="form-control" value="<?php echo $debtorLastName; ?>" name="lname">
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text"></span>
                                          <input type="number" aria-label="Age" class="form-control" value="<?php echo $debtorAge; ?>" name="age">
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text"></span>
                                          <input type="number" aria-label="Number" class="form-control" value="<?php echo $debtorNumber; ?>" name="number">
                                        </div>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text"></span>
                                          <input type="text" aria-label="Address" class="form-control" value="<?php echo $debtorAddress; ?>" name="address">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" name="saveChanges">Save changes</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <a data-bs-toggle="modal" data-bs-target="#deleteDebtor<?php echo $debtorID;?>" class="p-2 mb-1" style="color: black; background-color: red; border-radius: 3px; cursor: pointer;"><i class="fa-solid fa-trash fs-5"></i></a>
                            <!-- delete modal -->
                            <div class="modal fade" id="deleteDebtor<?php echo $debtorID;?>" tabindex="-1" aria-labelledby="deleteDebtorLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="deleteDebtorLabel">Confirm Debtor</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="adminProcess.php?debtorID=<?php echo $debtorID?>">
                                      <p class="text-warning">Are you want to delete <?php echo $debtorName?></p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDelete<?php echo $debtorID?>">Confirm Delete</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- confirm delete modal-->
                            <div class="modal fade" id="confirmDelete<?php echo $debtorID?>" tabindex="-1" aria-labelledby="deleteDebtorLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="deleteDebtorLabel">Delete Debtor</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="adminProcess.php?debtorID=<?php echo $debtorID;?>" method="POST">
                                      <input type="hidden" name="debtorBalance" value="<?php echo $debtorBalance;?>">
                                      <input type="hidden" name="adminID" value="<?php echo $adminID;?>">
                                      <div class="input-group mb-3">
                                          <span class="input-group-text"></span>
                                          <input type="text" aria-label="Username" class="form-control" placeholder="Enter Admin Username" name="adminUsername" required>
                                      </div>
                                      <div class="input-group mb-3">
                                          <span class="input-group-text"></span>
                                          <input type="password" aria-label="Password" class="form-control" placeholder="Enter Admin Password" name="adminPassword" required>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteDebtor<?php echo $debtorID;?>">Cancel</button>
                                    <button type="submit" class="btn btn-danger" name="confirmDelete">Delete</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <a data-bs-toggle="modal" data-bs-target="#viewHistory<?php echo $debtorID;?>" class="p-2" style="color: black; background-color: skyblue; border-radius: 3px; cursor:pointer;"><i class="fa-solid fa-clock-rotate-left fs-5"></i></a>
                            <!-- view history Modal -->
                            <div class="modal fade" id="viewHistory<?php echo $debtorID;?>" tabindex="-1" aria-labelledby="viewhistory" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="viewhistory">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="card">
                                      <div class="card-body">
                                        <h5 class="card-title">History of <?php echo $debtorName;?></h5>
                                        <table class="table table-hover table-bordered datatable">
                                          <thead class="table-primary">
                                            <tr>
                                              <th scope="col">#</th>
                                              <th scope="col">Action</th>
                                              <th scope="col">Item</th>
                                              <th scope="col">Note</th>
                                              <th scope="col">New Balane</th>
                                              <th scope="col">By: </th>
                                              <th scope="col">Date and Time</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                              $histories = viewHistory($debtorID);
                                              foreach($histories as $history){
                                                $debtorName = $history[0];
                                                $action = $history[1];
                                                $item = $history[2];
                                                $note = $history[3];
                                                $newBal = $history[4];
                                                $adminName = $history[5];
                                                $dateTime = $history[6];
                                                $hisID = $history[7];
                                                ?>
                                                  <tr>
                                                    <th scope="row"><?php echo $hisID?></th>
                                                    <td><?php echo $action;?></td>
                                                    <td><?php echo $item;?></td>
                                                    <td><?php echo $note;?></td>
                                                    <td><?php echo $newBal;?></td>
                                                    <td><?php echo $adminName;?></td>
                                                    <td><?php echo $dateTime;?></td>
                                                  </tr>
                                                <?php
                                              }
                                            ?>
                                            
                                          </tbody>
                                        </table>

                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <form action="adminProcess.php?debtorID=<?php echo $debtorID;?>" method="POST">
                                      <input type="hidden" name="balance" value="<?php echo $debtorBalance;?>">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" name="clearHistory" class="btn btn-danger">Clear History</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script> //script for search table
    $(document).ready(function(){
      $("#search").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#debtorTable tbody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
      });
    });
</script>

</body>

</html>