<?php include '../connection.php' ?>
<?php session_start();


if (!isset($_SESSION['username'])) {
  header("Location:index.php");
  $_SESSION['response'] = "Please Login First";
  $_SESSION['type'] = "danger";
}



?>

<?php
$year = date('Y');
if (isset($_GET['year'])) {
  $year = $_GET['year'];
}

$chart_data = '';
$query = "SELECT MONTHNAME(date_issued) as months,COUNT(*) as resident, MONTH(date_issued) as p, YEAR(date_issued) as years from blotter where YEAR(date_issued) ='$year' group by months order by p ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

foreach ($result as $row) {
  $chart_data .= "{ time:'" . $row["months"] . "', Blotter:" . $row["resident"] . " }, ";
}
$chart_data = substr($chart_data, 0, -2);




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../img/logo/logo.png" rel="icon">
  <title>Brgy Poblacion Profiling/Management System</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../morris/morris.css">
  <link href="../css/style.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon">
          <img src="../img/logo/polomolok.png">
        </div>
        <div class="sidebar-brand-text mx-2">Brgy Poblacion</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-chart-bar"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>

      <li class="nav-item">
        <a class="nav-link" href="residents.php">
          <i class="fas fa-fw fa-male"></i>
          <span>Residents</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="purok.php">
          <i class="far fa-fw fa-building"></i>
          <span>Purok</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="officials.php">
          <i class="fas fa-fw fa-ankh"></i>
          <span>Officials</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="blotter.php">
          <i class="fas fa-fw fa-columns"></i>
          <span>Blotter</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="clearance.php">
          <i class="fas fa-fw fa-columns"></i>
          <span>Clearance</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="archive.php">
          <i class="fas fa-fw fa-archive"></i>
          <span>Archive</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="settings.php">
          <i class="fas fa-fw fa-cogs"></i>
          <span>Settings</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="account.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Account Settings</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="export.php">
          <i class="fas fa-fw fa-list"></i>
          <span>Back-Up Database</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Log Out</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="version">Developed by: John Franklin M. Lanoy</div>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?" aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button" name="search">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="../img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">
                  <?php
                  if (isset($_SESSION['username'])) {
                    echo 'Welcome' . " " . $_SESSION['username'];
                  }


                  ?>


                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->





        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Residents</div>
                      <?php
                      $query = "SELECT COUNT(*) AS tots FROM resident";
                      $stmt = $conn->prepare($query);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      $row = $result->fetch_assoc();
                      ?>
                      <div class="h1 mb-0 font-weight-bold text-gray-800"><?php
                                                                          if ($row['tots'] == '') {
                                                                            echo "0";
                                                                          } else {
                                                                            echo $row['tots'];
                                                                          } ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">

                      </div>
                    </div>
                    <div class="col-auto">
                      <a href="household.php"><i class="fas fa-users fa-2x text-info"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <?php
                      $query = "SELECT COUNT(*) AS blotters FROM blotter";
                      $stmt = $conn->prepare($query);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      $row = $result->fetch_assoc();
                      ?>
                      <div class="text-xs font-weight-bold text-uppercase mb-1">BLOTTER</div>
                      <div class="h1 mb-0 font-weight-bold text-gray-800"><?php
                                                                          if ($row['blotters'] == '') {
                                                                            echo "0";
                                                                          } else {
                                                                            echo $row['blotters'];
                                                                          } ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      </div>
                    </div>
                    <div class="col-auto">
                      <a href="blotter.php"><i class="fa fa-folder fa-2x text-success"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <?php
                      $query = "SELECT COUNT(*) AS puroks FROM purok";
                      $stmt = $conn->prepare($query);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      $row = $result->fetch_assoc();
                      ?>
                      <div class="text-xs font-weight-bold text-uppercase mb-1">PUROK</div>
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800"><?php
                                                                                if ($row['puroks'] == '') {
                                                                                  echo "0";
                                                                                } else {
                                                                                  echo $row['puroks'];
                                                                                } ?>

                      </div>
                      <div class="mt-2 mb-0 text-muted text-xs">

                      </div>
                    </div>
                    <div class="col-auto">
                      <a href="purok.php"><i class="fa fa-home fa-2x text-primary"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <?php
                      $query = "SELECT SUM(total) AS income FROM clearance";
                      $stmt = $conn->prepare($query);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      $row = $result->fetch_assoc();
                      ?>
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Income</div>
                      <div class="h3 mb-0 font-weight-bold text-gray-800"><?php

                                                                          if ($row['income'] == '') {
                                                                            echo "&#8369" . " " . "0.00";
                                                                          } else {
                                                                            echo "&#8369" . " " . $row['income'];
                                                                          }

                                                                          ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">

                      </div>
                    </div>
                    <div class="col-auto">
                      <a href="clearance.php"><i class="fa fa-money-bill-alt fa-2x  text-warning"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>




            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                  <h6 class="m-0 font-weight-bold text-primary">Blotters Chart Every Month</h6>
                  <?php
                  $sql = "SELECT YEAR(date_issued) as years FROM blotter GROUP BY years ORDER BY years ASC";
                  $result = $conn->query($sql);
                  ?>

                  <select name="cars" class="form-control w-25" id="cars">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                      $cat = $row['years'];

                      echo "<option value='$cat'>$cat</option>";

                    ?>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <div class="card-body">
                  <div class="panel-body">

                    <div id="chart"></div>
                  </div>

                  <!-- Donut Chart -->




                  <!-- Modal Logout -->
                  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div id="overlay" style="display:none;">
                            <div class="spinner"></div>
                            <br />
                            Loading...
                          </div>
                          <p>Are you sure you want to logout?</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                          <a href="../logout.php" class="logout btn btn-primary">Logout</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!---Container Fluid-->
              </div>
              <!-- Footer -->
              <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                  <div class="copyright text-center my-auto">
                    <span>copyright &copy; <script>
                        document.write(new Date().getFullYear());
                      </script> - developed by
                      <b><a href="facebook.com/SyInvasionz" target="_blank">John Franklin M. Lanoy</a></b>
                    </span>
                  </div>
                </div>
              </footer>
              <!-- Footer -->
            </div>
          </div>



          <!-- Scroll to top -->
          <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
          </a>


          <script src="../vendor/jquery/jquery.min.js"></script>


          <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
          <script src="../morris/morris.min.js"></script>
          <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
          <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
          <script src="../js/ruang-admin.min.js"></script>
          <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
          <script src="../js/jquery-1.11.2.min.js"></script>
          <script src="../js/plugins.min.js"></script>

</body>

</html>
<script>
  $('#cars').change(function() {
    window.location.href = 'home.php?year=' + $(this).val();
  });


  Morris.Bar({
    element: 'chart',
    data: [<?php echo $chart_data; ?>],
    xkey: 'time',
    ykeys: ['Blotter'],
    labels: ['Blotter'],
    hideHover: 'auto',
    stacked: true
  });
  $(document).ready(function() {
    $('.logout').click(function() {
      $('#overlay').fadeIn().delay(2000).fadeOut();
    });
  });
</script>
<style type="text/css">
  #overlay {
    background: #ffffff;
    color: #666666;
    position: fixed;
    height: 100%;
    width: 100%;
    z-index: 5000;
    top: 0;
    left: 0;
    float: left;
    text-align: center;
    padding-top: 25%;
    opacity: .80;
  }

  .spinner {
    margin: 0 auto;
    height: 64px;
    width: 64px;
    animation: rotate 0.8s infinite linear;
    border: 5px solid firebrick;
    border-right-color: transparent;
    border-radius: 50%;
  }

  @keyframes rotate {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .nav-link {

    cursor: pointer;
  }
</style>