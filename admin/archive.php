<?php include '../connection.php'; ?>
<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location:index.php");
  $_SESSION['response'] = "Please Login First";
  $_SESSION['type'] = "danger";
}
if (isset($_POST['submit'])) {
  $id = $_POST['resident'];
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $suffix = $_POST['suffix'];
  $bdate = $_POST['bdate'];
  $citizen = $_POST['citizen'];
  $age = $_POST['age'];
  $sex = $_POST['sex'];
  $religon = $_POST['religion'];
  $occupation = $_POST['occupation'];
  $contact = $_POST['contact'];
  $status = $_POST['status'];
  $voter = $_POST['vote'];
  $address = $_POST['address'];
  $fullname = $lname . " " . $fname . " " . $mname . " " . $suffix;
  $querys = "SELECT * from resident where resident_id='$id'";
  $stmts = $conn->prepare($querys);
  $stmts->execute();
  $results = $stmts->get_result();
  $row = $results->fetch_assoc();
  if ($id == $row['resident_id']) {
    $_SESSION['response'] = "This information is already exist";
    $_SESSION['type'] = "danger";
  } else {
    $query = "INSERT INTO resident (resident_id,fname,mname,lname,suffix,bdate,age,sex,religion,citizenship,status,occupation,cont_no,purok,address,fullname) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssssssss", $id, $fname, $mname, $lname, $suffix, $bdate, $age, $sex, $religon, $citizen, $status, $occupation, $contact, $voter, $address, $fullname);
    $stmt->execute();
    $_SESSION['response'] = "Information is successfully submitted";
    $_SESSION['type'] = "success";
  }
}
if (isset($_POST['delete'])) {
  $id = $_POST['myids'];
  $sqlb = "SELECT * FROM resident where resident_id='$id'";
  $stmts = $conn->prepare($sqlb);
  $stmts->execute();
  $results = $stmts->get_result();
  $row = $results->fetch_assoc();
  if ($row['resident_id'] == $id) {
    $_SESSION['response'] = "Opps you have same Resident ID in Resident Section";
    $_SESSION['type'] = "danger";
  } else {

    $sqls = "INSERT into resident(SELECT * from archive where resident_id='$id')";
    $stmt = $conn->prepare($sqls);
    $stmt->execute();
    $sql = "DELETE FROM archive where resident_id='$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $_SESSION['response'] = "Information is successfully retrieve";
    $_SESSION['type'] = "success";
  }
}

if (isset($_POST['deletes'])) {
  $id = $_POST['myidss'];
  $sql = "DELETE FROM archive where resident_id='$id'";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $_SESSION['response'] = "Information is successfully delete";
  $_SESSION['type'] = "success";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Brgy Poblacion Profiling/Management System</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>

<body id="page-top">
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
      <li class="nav-item ">
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
      <li class="nav-item active">
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
                      <button class="btn btn-primary" type="button">
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
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
          <?php if (isset($_SESSION['response'])) { ?>
            <div class="alert alert-<?= $_SESSION['type']; ?> alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times </button>
              <?= $_SESSION['response']; ?>
            </div>
          <?php unset($_SESSION['response']);
          } ?>
        </div>




        <div class="col-lg-12">


          <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

              <h6 class="m-0 font-weight-bold text-primary">Archive Data</h6>

            </div>

            <div class="table-responsive p-3">

              <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <?php
                $query = "SELECT * FROM archive";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Resident ID</th>
                    <th>Full Name</th>
                    <th style="display: none;">f</th>
                    <th style="display: none;">m</th>
                    <th style="display: none;">l</th>
                    <th style="display: none;">s</th>
                    <th>Sex</th>
                    <th style="display: none;">Age</th>
                    <th style="display: none;">Bday </th>
                    <th style="display: none;">Religion</th>
                    <th style="display: none;">Citizen</th>
                    <th style="display: none;">Status</th>
                    <th>Occupation</th>
                    <th style="display: none;">Voter</th>
                    <th>Address</th>
                    <th>Cell #</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Resident ID</th>
                    <th>Full Name</th>
                    <th style="display: none;">f</th>
                    <th style="display: none;">m</th>
                    <th style="display: none;">l</th>
                    <th style="display: none;">s</th>
                    <th>Sex</th>
                    <th style="display: none;">Age</th>
                    <th style="display: none;">Bday </th>
                    <th style="display: none;">Religion</th>
                    <th style="display: none;">Citizen</th>
                    <th style="display: none;">Status</th>
                    <th>Occupation</th>
                    <th style="display: none;">Voter</th>
                    <th>Address</th>
                    <th>Cell #</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $i = 1;
                  while ($row = $result->fetch_assoc()) {  ?>
                    <tr>

                      <td><?php echo $i++ ?></td>
                      <td><?= $row['resident_id'] ?></td>
                      <td><?= $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . " " . $row['suffix']; ?></td>
                      <td style="display: none;"><?= $row['fname'] ?></td>
                      <td style="display: none;"><?= $row['mname'] ?></td>
                      <td style="display: none;"><?= $row['lname'] ?></td>
                      <td style="display: none;"><?= $row['suffix'] ?></td>
                      <td><?= $row['sex'] ?></td>
                      <td style="display: none;"> <?= $row['age'] ?></td>
                      <td style="display: none;"><?= $row['bdate'] ?></td>
                      <td style="display: none;"><?= $row['religion'] ?></td>
                      <td style="display: none;"><?= $row['citizenship'] ?></td>
                      <td style="display: none;"><?= $row['status'] ?></td>
                      <td><?= $row['occupation'] ?></td>
                      <td style="display: none;"><?= $row['purok'] ?></td>
                      <td><?= $row['address'] ?></td>
                      <td><?= $row['cont_no'] ?></td>
                      <td>
                        <a href="#deleteModals" class="delete badge badge-success p-2"> Retrieve </a> |




                      </td>
                    </tr>
                  <?php } ?>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>





      <!-- Modal Logout -->
      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
              <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal retrieve -->
    <div class="modal fade" id="deleteModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
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
            <form action="" method="post">
              <input type="hidden" name="myids" id="myids">
              <center>
                <p>Are you sure you want to retrieve this data?</p>
                <h4><b>Resident ID:</b></h4>
                <h4 id="dataa"></h4>
              </center>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="submit btn btn-primary" name="delete">Retrieve</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal delete -->
  <div class="modal fade" id="deletedModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="overlay2" style="display:none;">
            <div class="spinner"></div>
            <br />
            Loading...
          </div>
          <form action="" method="post">
            <input type="hidden" name="myidss" id="myidss">
            <center>
              <p>Are you sure you want to delete this data?</p>
              <h4><b>Resident ID:</b></h4>
              <h4 id="dataab"></h4>
            </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="deletes btn btn-primary" name="deletes">Delete</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>




  <!-- Modal Logout -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="overlays1" style="display:none;">
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
          <b><a href="https://indrijunanda.gitlab.io/" target="_blank">John Franklin M. Lanoy</a></b>
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
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <link href="../vendor/sweetalert/css/sweetalert.css" rel="stylesheet">

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function() {

      $('#dataTable').DataTable();
      $('#dataTableHover').DataTable();

      $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4'
      });
      $('#datepickers').datepicker({
        uiLibrary: 'bootstrap4'
      });
      $('a.delete').on('click', function() {
        $('#deleteModals').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();

        }).get();
        console.log(data);
        $('#dataa').html(data[1]);
        $('#myids').val(data[1]);
      });

      $('a.deletep').on('click', function() {
        $('#deletedModals').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();

        }).get();
        console.log(data);
        $('#dataab').html(data[1]);
        $('#myidss').val(data[1]);
      });


      $('a.edit').on('click', function() {
        $('#editt').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();

        }).get();
        console.log(data);
        $('#residents').val(data[1]);
        $('#fnames').val(data[3]);
        $('#mnames').val(data[4]);
        $('#lnames').val(data[5]);
        $('#suffixs').val(data[6]);
        $('#datepickers').val(data[9]);
        $('#ages').val(data[8]);
        $('#sexs').val(data[7]);
        $('#religions').val(data[10]);
        $('#citizens').val(data[11]);
        $('#occupations').val(data[13]);
        $('#contacts').val(data[16]);
        $('#statuss').val(data[12]);
        $('#voterss').val(data[14]);
        $('#addresss').val(data[15]);
      });




    });
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.submit').click(function() {
        $('#overlay').fadeIn().delay(2000).fadeOut();
      });
      $('.update').click(function() {
        $('#overlays').fadeIn().delay(2000).fadeOut();
      });
      $('.deletes').click(function() {
        $('#overlay2').fadeIn().delay(2000).fadeOut();
      });
      $('.logout').click(function() {
        $('#overlays1').fadeIn().delay(2000).fadeOut();
      });
    });
  </script>
  <style type="text/css">
    th {
      font-size: 12px;
    }

    td {
      font-size: 13px;
    }

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
      padding-top: 20%;
      opacity: .80;
    }

    #overlay2 {
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
      padding-top: 20%;
      opacity: .80;
    }

    #overlays1 {
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
      padding-top: 20%;
      opacity: .80;
    }

    #overlays {
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
      padding-top: 20%;
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
</body>

</html>