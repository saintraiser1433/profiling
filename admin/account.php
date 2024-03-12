<?php include '../connection.php'; ?>
<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location:index.php");
  $_SESSION['response'] = "Please Login First";
  $_SESSION['type'] = "danger";
}

if (isset($_POST['submit'])) {
  $name = $_POST['fullname'];
  $username = $_POST['username'];
  $password = 'bppbms123';
  $role = $_POST['role'];
  $haspass = "";
  $active = 'Active';
  $date = date('Y-m-d');
  $querys = "SELECT * from account where username='$username'";
  $stmts = $conn->prepare($querys);
  $stmts->execute();
  $results = $stmts->get_result();
  $row = $results->fetch_assoc();
  if ($username == $row['username']) {
    $_SESSION['response'] = "This username is already exist try another one";
    $_SESSION['type'] = "danger";
  } else {
    $sql = "INSERT into account (fullname,username,password,role,status,date_created,hashpass) values (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $username, $password, $role, $active, $date, $haspass);
    $stmt->execute();
    $_SESSION['response'] = "Successfully Added";
    $_SESSION['type'] = "success";
  }
}



?>
<?php
if (isset($_POST['update'])) {
  $id = $_POST['myhiddenid'];
  $name = $_POST['fullnames'];
  $username = $_POST['usernames'];
  $password = $_POST['passwords'];
  $role = $_POST['roles'];
  $sql = "UPDATE account SET fullname=? ,username=?,password=?,role=? where id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssi", $name, $username, $password, $role, $id);
  $stmt->execute();
  $_SESSION['response'] = "Successfully Updated";
  $_SESSION['type'] = "success";
}
if (isset($_POST['delete'])) {
  $id = $_POST['myids'];
  $sql = "DELETE FROM account where id='$id'";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $_SESSION['response'] = "Information is successfully deleted";
  $_SESSION['type'] = "success";
}
if (isset($_GET['type']) && $_GET['type'] != '') {
  $type = $_GET['type'];
  if ($type == 'status') {
    $operation = $_GET['operation'];
    $id = $_GET['id'];
    if ($operation == 'active') {
      $status = 'Active';
    } else {
      $status = 'Deactive';
    }
    $updatesql = "update account set status='$status' where id='$id'";
    $stmt = $conn->prepare($updatesql);
    $stmt->execute();
  }
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
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="../vendor/sweetalert/css/sweetalert.css" rel="stylesheet">
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
      <li class="nav-item active">
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

              <h6 class="m-0 font-weight-bold text-primary">ACCOUNTS SECTION</h6>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                Add Users
              </button>
            </div>

            <div class="table-responsive p-3">
              <?php
              $query = "SELECT * FROM account where role='Clerk' OR role='Employee'";
              $stmt = $conn->prepare($query);
              $stmt->execute();
              $result = $stmt->get_result();
              ?>

              <div id="overlayactive" style="display:none;">
                <div class="spinner"></div>
                <br />
                Loading...
              </div>




              <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th style="display: none">id</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th style="display: none;">Password</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>

                  <tr>
                    <th>#</th>
                    <th style="display: none">id</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th style="display: none;">Password</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php $i = 1;
                  while ($row = $result->fetch_assoc()) {  ?>
                    <tr>
                      <td><?php echo $i++ ?></td>
                      <td style="display: none;"><?= $row['id']; ?></td>
                      <td><?= $row['fullname']; ?></td>
                      <td><?= $row['username']; ?></td>
                      <td style="display: none;"><?= $row['password']; ?></td>
                      <td><?= $row['role']; ?></td>
                      <td><?= $row['status']; ?></td>
                      <td><?= $row['date_created']; ?></td>
                      <td>
                        <?php
                        if ($row['status'] == 'Active') {
                          echo "<a class='spin badge badge-info p-2' href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a> |";
                        } else {
                          echo "<a class='spin badge badge-warning p-2' href='?type=status&operation=active&id=" . $row['id'] . "'>Deactive</a> | ";
                        }



                        ?>
                        <a href="#updateModals" class="update badge badge-success p-2"> Update </a> |
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
              <h5 class="modal-title" id="staticBackdropLabel">Add account</h5>
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

                <div class="col">
                  <label>Full Name</label>
                  <input type="text" class="form-control" name="fullname" placeholder="Enter your fullname" required>

                </div>
                <br>
                <div class="col">
                  <label>Username</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
                  <div id="availability"></div>
                </div><br>


                <div class="col">
                  <label>Role</label>
                  <select name="role" id="role" class="form-control" required>
                    <option value="">-SELECT-</option>

                    <option value="Employee">Employee</option>

                  </select>

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
      </div>
    </div>
    <!---END-->

    <!--EDIT MODAL FOR HOUSEHOLD--->
    <div class="modal fade" id="edits" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="staticBackdropLabel">Update User</h5>
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
              <input type="hidden" class="form-control" name="myhiddenid" id="myhiddenid" placeholder="Enter your fullname" required>
              <div class="col">
                <label>Full Name</label>
                <input type="text" class="form-control" name="fullnames" id="fullnames" placeholder="Enter your fullname" required>

              </div>
              <br>
              <div class="col">
                <label>Username</label>
                <input type="text" class="form-control" name="usernames" id="usernames" placeholder="Enter username" required>
                <div id="availability"></div>
              </div><br>
              <div class="col">
                <label>Password</label>
                <input type="password" class="form-control" name="passwords" id="passwords" placeholder="Enter password" required>

              </div>
              <br>
              <div class="col">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="confirms" id="confirms" placeholder="Enter password if match" required>
                <div id="errors"></div>
              </div><br>
              <div class="col">
                <label>Role</label>
                <select name="roles" id="roles" class="form-control" required>
                  <option value="">-SELECT-</option>

                  <option value="Employee">Employee</option>

                </select>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="updates btn btn-primary" name="update" value="Update">
          </div>
          </form>
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
              <h4><b>Full Name :</b></h4>
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
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
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
    $('#confirm').keyup(function() {


      var pwd = $('#password').val();
      var cpwd = $('#confirm').val();

      if (cpwd != pwd) {
        $('#error').html('Password are not matching');
        $('#error').css('color', 'red');
        return false;
      } else {
        $('#error').html('');
        return true;

      }

    });

    $('#confirms').keyup(function() {


      var pwd = $('#passwords').val();
      var cpwd = $('#confirms').val();

      if (cpwd != pwd) {
        $('#errors').html('Password are not matching');
        $('#errors').css('color', 'red');
        return false;
      } else {
        $('#errors').html('');
        return true;
      }

    });
  </script>


  <script>
    $(document).ready(function() {

      $('#username').blur(function() {
        var username = $(this).val();
        $.ajax({
          url: "checkaccount.php",
          method: "POST",
          data: {
            user_name: username
          },
          dataType: "text",
          success: function(html) {
            $('#availability').html(html);

          }
        });
      });



      $('a.update').on('click', function() {
        $('#edits').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();

        }).get();
        console.log(data);
        $('#myhiddenid').val(data[1]);
        $('#fullnames').val(data[2]);
        $('#usernames').val(data[3]);
        $('#passwords').val(data[4]);
        $('#confirms').val(data[4]);
        $('#roles').val(data[5]);
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
      $('.spin').click(function() {
        $('#overlayactive').fadeIn().delay(2000).fadeOut();
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
      padding-top: 20%;
      opacity: .80;
    }

    #overlayactive {
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