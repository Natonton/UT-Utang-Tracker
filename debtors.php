<?php
    include "conn.php";
    include "inc/function.php";
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
            }
        }
    }
    catch(PDOException $e){
        die("Error: " . $e->getMessage());
    }
    
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

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="admin_home.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">NiceAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $adminName; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $adminName; ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="admin_home.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="debtors.php">
          <i class="bi bi-person"></i>
          <span>Debtors</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Alerts</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Accordion</span>
            </a>
          </li>
          <li>
            <a href="components-badges.html">
              <i class="bi bi-circle"></i><span>Badges</span>
            </a>
          </li>
          <li>
            <a href="components-breadcrumbs.html">
              <i class="bi bi-circle"></i><span>Breadcrumbs</span>
            </a>
          </li>
          <li>
            <a href="components-buttons.html">
              <i class="bi bi-circle"></i><span>Buttons</span>
            </a>
          </li>
          <li>
            <a href="components-cards.html">
              <i class="bi bi-circle"></i><span>Cards</span>
            </a>
          </li>
          <li>
            <a href="components-carousel.html">
              <i class="bi bi-circle"></i><span>Carousel</span>
            </a>
          </li>
          <li>
            <a href="components-list-group.html">
              <i class="bi bi-circle"></i><span>List group</span>
            </a>
          </li>
          <li>
            <a href="components-modal.html">
              <i class="bi bi-circle"></i><span>Modal</span>
            </a>
          </li>
          <li>
            <a href="components-tabs.html">
              <i class="bi bi-circle"></i><span>Tabs</span>
            </a>
          </li>
          <li>
            <a href="components-pagination.html">
              <i class="bi bi-circle"></i><span>Pagination</span>
            </a>
          </li>
          <li>
            <a href="components-progress.html">
              <i class="bi bi-circle"></i><span>Progress</span>
            </a>
          </li>
          <li>
            <a href="components-spinners.html">
              <i class="bi bi-circle"></i><span>Spinners</span>
            </a>
          </li>
          <li>
            <a href="components-tooltips.html">
              <i class="bi bi-circle"></i><span>Tooltips</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="forms-elements.html">
              <i class="bi bi-circle"></i><span>Form Elements</span>
            </a>
          </li>
          <li>
            <a href="forms-layouts.html">
              <i class="bi bi-circle"></i><span>Form Layouts</span>
            </a>
          </li>
          <li>
            <a href="forms-editors.html">
              <i class="bi bi-circle"></i><span>Form Editors</span>
            </a>
          </li>
          <li>
            <a href="forms-validation.html">
              <i class="bi bi-circle"></i><span>Form Validation</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="tables-general.html">
              <i class="bi bi-circle"></i><span>General Tables</span>
            </a>
          </li>
          <li>
            <a href="tables-data.html">
              <i class="bi bi-circle"></i><span>Data Tables</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="charts-chartjs.html">
              <i class="bi bi-circle"></i><span>Chart.js</span>
            </a>
          </li>
          <li>
            <a href="charts-apexcharts.html">
              <i class="bi bi-circle"></i><span>ApexCharts</span>
            </a>
          </li>
          <li>
            <a href="charts-echarts.html">
              <i class="bi bi-circle"></i><span>ECharts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="icons-bootstrap.html">
              <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-remix.html">
              <i class="bi bi-circle"></i><span>Remix Icons</span>
            </a>
          </li>
          <li>
            <a href="icons-boxicons.html">
              <i class="bi bi-circle"></i><span>Boxicons</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li><!-- End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

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