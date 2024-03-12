<?php include '../connection.php'; ?>
<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location:index.php");
  $_SESSION['response'] = "Please Login First";
  $_SESSION['type'] = "danger";
}

if (isset($_POST['submit'])) {
  $purok = $_POST['purokss'];
  $id = $_POST['ids'];
  $name = $_POST['fullname'];
  $status = $_POST['status'];
  $age = $_POST['agee'];
  $violation = $_POST['violation'];
  $type = $_POST['type'];
  $com = $_POST['complainant'];
  $date = date('Y-m-d');
  $officer = "Admin";
  $sql = "INSERT into blotter (resident_id,fullname,purok,marital_status,age,violation,type,complainant,date_issued,officer_incharge) values (?,?,?,?,?,?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssssss", $id, $name, $purok, $status, $age, $violation, $type, $com, $date, $officer);
  $stmt->execute();
  $_SESSION['response'] = "Successfully Added";
  $_SESSION['type'] = "success";
}
if (isset($_POST['delete'])) {
  $id = $_POST['myids'];
  $query = "DELETE FROM blotter where id='$id'";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $_SESSION['response'] = "Successfully Deleted";
  $_SESSION['type'] = "success";
}
if (isset($_POST['update'])) {
  $id = $_POST['sd'];
  $violation = $_POST['violation1'];
  $type = $_POST['types1'];
  $complainant = $_POST['complainant1'];
  $query = "UPDATE blotter SET violation=?,type=?,complainant=? where id=?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssi", $violation, $type, $complainant, $id);
  $stmt->execute();
  $_SESSION['response'] = "Successfully Update";
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
  <link href="../img/logo/logo.png" rel="icon">
  <title>Brgy Poblacion Profiling/Management System</title>

  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
      <li class="nav-item">
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

      <li class="nav-item active">
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

              <h6 class="m-0 font-weight-bold text-primary">BLOTTER SECTION</h6>


            </div>

            <div class="table-responsive p-3">
              <?php
              $query = "SELECT * FROM blotter order by resident_id";
              $stmt = $conn->prepare($query);
              $stmt->execute();
              $result = $stmt->get_result();
              ?>
              <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th style="display: none">Purok</th>
                    <th>Resident ID</th>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th style="display: none">Purok</th>
                    <th style="display: none">Violation</th>
                    <th style="display: none">Status</th>
                    <th>Violation</th>
                    <th>Type</th>
                    <th>Complainant</th>
                    <th>Date Issued</th>
                    <th>Actions</th>

                  </tr>
                </thead>
                <tfoot>

                  <tr>
                    <th>#</th>
                    <th style="display: none">Purok</th>
                    <th>Resident ID</th>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th style="display: none">Purok</th>
                    <th style="display: none">Violation</th>
                    <th style="display: none">Status</th>
                    <th>Violation</th>
                    <th>Type</th>
                    <th>Complainant</th>
                    <th>Date Issued</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php $i = 1;
                  while ($row = $result->fetch_assoc()) {  ?>
                    <tr>
                      <td><?php echo $i++; ?></td>
                      <td style="display: none;"><?= $row['id']; ?></td>
                      <td><?= $row['resident_id']; ?></td>
                      <td><?= $row['fullname']; ?></td>
                      <td><?= $row['age']; ?></td>
                      <td style="display: none;"><?= $row['purok']; ?> </td>
                      <td style="display: none;"><?= $row['violation']; ?></td>
                      <td style="display: none;"><?= $row['marital_status']; ?></td>
                      <td><a href="#description" class="desc badge badge-info p-2"> Show </a></td>
                      <td><?= $row['type']; ?></td>
                      <td><?= $row['complainant']; ?></td>
                      <td><?= $row['date_issued']; ?></td>
                      <td><a href="#staticBackdrops" class="edit badge badge-success p-2"> Edit </a> |
                        <a href="#deleteModals" class="delete badge badge-danger p-2"> Delete </a>
                      </td>

                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!--MODAL FOR HOUSEHOLD--->
      <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="staticBackdropLabel">Add Blotter</h5>
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

                <div class="form-group">
                  <label for="exampleInputEmail1">Search Resident</label>
                  <input type='text' id='autocomplete' class="form-control">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Resident ID</label>
                  <input type="text" class="form-control" name="ids" readonly="readonly" id="mes" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Full Name</label>
                  <input type="text" class="form-control" id="fullname" name="fullname" readonly="readonly" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Purok</label>
                  <input type="text" class="form-control" id="purokss" name="purokss" readonly="readonly" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Marital Status</label>
                  <input type="text" class="form-control" id="statuss" name="status" readonly="readonly" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Age</label>
                  <input type="number" class="form-control" id="agess" name="agee" readonly="readonly" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Violation</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="violation"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Type</label>
                  <select name="type" class="form-control" required>
                    <option value="">-SELECT-</option>
                    <option value="Major Offense">Major Offense</option>
                    <option value="Minor Offense">Minor Offense</option>

                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Complainant</label>
                  <input type="text" class="form-control" name="complainant" required>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="submit" id="mysubmit" style="display:none;"></button>
              <input type="submit" class="submit btn btn-primary" name="submits" id="btn-submit" value="Submit">
            </div>
            </form>
          </div>

        </div>
        <div class="col-4" style="position: fixed;margin-top: -910px; margin-left: 420px;">
          <div class="list-group" id="show-list">

          </div>

        </div>
      </div>

    </div>

    <!---END-->

    <!--MODAL FOR HOUSEHOLD--->
    <div class="modal fade" id="staticBackdrops" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="staticBackdropLabel">Update Blotter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="overlays" style="display:none;">
              <div class="spinner"></div>
              <br />
              Loading...
            </div>
            <form action="" method="post">
              <input type="hidden" name="sd" id="sd">
              <div class="form-group">
                <label for="exampleInputPassword1">Resident ID</label>
                <input type="text" class="form-control" name="myid1" readonly="readonly" id="myid1" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Full Name</label>
                <input type="text" class="form-control" id="fullname1" name="fullname1" readonly="readonly" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Purok</label>
                <input type="text" class="form-control" id="purokss1" name="purokss1" readonly="readonly" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Marital Status</label>
                <input type="text" class="form-control" id="statuss1" name="statuss1" readonly="readonly" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Age</label>
                <input type="number" class="form-control" id="agee1" name="agee1" readonly="readonly" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Date Issued</label>
                <input type="text" readonly="readonly" class="form-control" name="datep" id="datep" required>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Violation</label>
                <textarea class="form-control" id="textarea1" rows="3" name="violation1"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Type</label>
                <select name="types1" class="form-control" id="types1" required>
                  <option value="">-SELECT-</option>
                  <option value="Major Offense">Major Offense</option>
                  <option value="Minor Offense">Minor Offense</option>

                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Complainant</label>
                <input type="text" class="form-control" name="complainant1" id="complainant1" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="update btn btn-primary" name="update" value="Update">
          </div>
          </form>
        </div>

      </div>
      <div class="col-4" style="position: fixed;margin-top: -910px; margin-left: 420px;">
        <div class="list-group" id="show-list">

        </div>

      </div>
    </div>

  </div>
  <!---END-->

  <!-- Modal delete -->
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
          <div id="overlay2" style="display:none;">
            <div class="spinner"></div>
            <br />
            Loading...
          </div>
          <form action="" method="post">
            <input type="hidden" name="myids" id="myids">
            <center>
              <p>Are you sure you want to delete this data?</p>
              <h4><b>RESIDENT ID</b></h4>
              <h4 id="dataa"></h4>
            </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="deleteb btn btn-primary" name="delete">Delete</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>


  <div class="modal fade" id="description" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabelLogout">Violation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="descp"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
        </div>
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
  <script src="../vendor/sweetalert/js/sweetalert.min.js"></script>
  <script src="../vendor/jquery/jquery-ui.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $('#btn-submit').on('click', function(e) {
      e.preventDefault();

      swal({
          title: "Are you sure?",
          text: "If you click 'Finish' button your exam will be cast!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Submit",
          cancelButtonText: "No",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm) {
          if (isConfirm) {
            $('#mysubmit').click();
          } else {
            swal("Cancelled", "", "error");

          }
        });

    });
    $(document).ready(function() {
      $("#autocomplete").autocomplete({
        source: function(request, response) {
          // Fetch data
          $.ajax({
            url: "fetch.php",
            type: "post",
            dataType: "json",
            data: {
              search: request.term
            },
            success: function(data) {
              response(data);
            }
          });
        },
        select: function(event, ui) {
          // Set selection
          $('#autocomplete').val(ui.item.label);
          $('#mes').val(ui.item.value);
          $('#fullname').val(ui.item.label);
          $('#purokss').val(ui.item.puroks);
          $('#statuss').val(ui.item.status);
          $('#agess').val(ui.item.age);
          return false;
        }
      });

      $('a.desc').on('click', function() {
        $('#description').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();

        }).get();
        console.log(data);
        $('#descp').html(data[6]);
      });


      $('a.edit').on('click', function() {
        $('#staticBackdrops').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();

        }).get();
        console.log(data);
        $('#sd').val(data[1]);
        $('#myid1').val(data[2]);
        $('#fullname1').val(data[3]);
        $('#purokss1').val(data[5]);
        $('#statuss1').val(data[7]);
        $('#agee1').val(data[4]);
        $('#textarea1').val(data[6]);
        $('#types1').val(data[9]);
        $('#complainant1').val(data[10]);
        $('#datep').val(data[11]);
      });

      $('a.delete').on('click', function() {
        $('#deleteModals').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();

        }).get();
        console.log(data);
        $('#dataa').html(data[2]);
        $('#myids').val(data[1]);
      });


      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover


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
      $('.deleteb').click(function() {
        $('#overlay2').fadeIn().delay(2000).fadeOut();
      });
      $('.logout').click(function() {
        $('#overlays1').fadeIn().delay(2000).fadeOut();
      });
    });
  </script>

</body>

</html>
<style type="text/css">
  .ui-autocomplete {
    z-index: 4000 !important;
    background-color: #f4f4f4;
    border-bottom: 1px solid #ccc;
  }

  .ui-autocomplete:hover {
    background-color: #ddd;
    font-weight: bold;
    border-bottom: 1px solid #ccc;
  }

  th,
  td {
    font-size: 11px;
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