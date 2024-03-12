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
  $sqls = "INSERT into archive(SELECT * from resident where resident_id='$id')";
  $stmt = $conn->prepare($sqls);
  $stmt->execute();
  $sql = "DELETE FROM resident where resident_id='$id'";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $_SESSION['response'] = "Information is successfully archive";
  $_SESSION['type'] = "success";
}
if (isset($_POST['update'])) {
  $id = $_POST['residents'];
  $fname = $_POST['fnames'];
  $mname = $_POST['mnames'];
  $lname = $_POST['lnames'];
  $suffix = $_POST['suffixs'];
  $bdate = $_POST['bdates'];
  $citizen = $_POST['citizens'];
  $age = $_POST['ages'];
  $sex = $_POST['sexs'];
  $religon = $_POST['religions'];
  $occupation = $_POST['occupations'];
  $contact = $_POST['contacts'];
  $status = $_POST['statuss'];
  $voter = $_POST['vote'];
  $address = $_POST['addresss'];
  $fullname = $lname . " " . $fname . " " . $mname . " " . $suffix;
  $sql = "UPDATE resident SET fname=?,mname=?,lname=?,suffix=?,bdate=?,age=?,sex=?,religion=?,citizenship=?,status=?,occupation=?,cont_no=?,purok=?,address=?,fullname=? where resident_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssssssssssss", $fname, $mname, $lname, $suffix, $bdate, $age, $sex, $religon, $citizen, $status, $occupation, $contact, $voter, $address, $fullname, $id);
  $stmt->execute();
  $_SESSION['response'] = "Information is successfully Update";
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
  <link href="../css/spinner.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link href="../vendor/sweetalert/css/sweetalert.css" rel="stylesheet">

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
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-fw fa-chart-bar"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>

      <li class="nav-item active">
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

              <h6 class="m-0 font-weight-bold text-primary">RESIDENTS LIST</h6>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                Add Residents
              </button>
            </div>

            <div class="table-responsive p-3">

              <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <?php
                $query = "SELECT * FROM resident";
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
                        <a href="#editt" class="edit badge badge-success p-2"> Edit </a> |
                        <a href="#deleteModals" class="delete badge badge-danger p-2"> Archive </a>



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

        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="staticBackdropLabel">Add Resident</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div id="overlay" style="display: none;">
                <div class="spinner"></div>
                <br />
                Loading...
              </div>
              <form action="" method="post">
                <div class="form-row">
                  <div class="col-3">
                    <label>Resident ID</label>
                    <input type="text" class="form-control" name="resident" placeholder="ex. 1234-567" required>
                  </div>
                  <div class="col-3">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="fname" placeholder="ex. Juan" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                  <div class="col-3">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" name="mname" placeholder="ex. Medina" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                  <div class="col-3">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lname" placeholder="ex. Dela Cruz" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-3">
                    <label>Suffix</label>
                    <select name="suffix" class="form-control">
                      <option value="">-SELECT-</option>
                      <option value="Jr">Jr</option>
                      <option value="Sr">Sr</option>

                    </select>
                  </div>
                  <div class="col-3">
                    <label>Birth Date</label>
                    <input id="datepicker" name="bdate" class="form-control" placeholder="ex. 01/01/1998" required>
                  </div>
                  <div class="col-3">
                    <label>Age</label>
                    <input type="number" class="form-control" name="age" placeholder="ex. 20" required>
                  </div>
                  <div class="col-3">
                    <label>Sex</label>
                    <select name="sex" class="form-control" required>
                      <option value="">-SELECT-</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="BiSexual">BiSexual</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-3">
                    <label>Religion</label>
                    <select name="religion" class="form-control" required>
                      <option value="">-SELECT-</option>
                      <option value="Roman Catholic">Roman Catholic</option>
                      <option value="Iglesia">Iglesia</option>
                      <option value="Muslim">Muslim</option>
                    </select>
                  </div>
                  <div class="col-3">
                    <label>Citizenship</label>
                    <input type="text" name="citizen" class="form-control" placeholder="ex. Filipino" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                  <div class="col-3">
                    <label>Occupation</label>
                    <input type="text" name="occupation" class="form-control" placeholder="Ex. Driver" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                  <div class="col-3">
                    <label>Contact No.</label>
                    <input type="text" name="contact" class="form-control" maxlength="11" placeholder="Ex. 09xxxxxxx" onkeypress="return /[0-9]/i.test(event.key)" required>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-3">
                    <label>Marital Status</label>
                    <select name="status" class="form-control" required>
                      <option value="">-SELECT-</option>
                      <option value="Single">Single</option>
                      <option value="Married">Married</option>
                      <option value="Seperated">Seperated</option>
                    </select>
                  </div>
                  <?php
                  $query = "SELECT * FROM purok";
                  $stmt = $conn->prepare($query);
                  $stmt->execute();
                  $result = $stmt->get_result();


                  ?>
                  <div class="col-3">
                    <label>Purok</label>

                    <select name="vote" class="form-control" required>
                      <option value="">-SELECT-</option>
                      <?php while ($row = $result->fetch_assoc()) {
                        $me = $row['purok'];
                      ?>
                        <option value="<?php echo $me; ?>"><?php echo $me; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-6">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" placeholder="Your Address" required>
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


      <!--MODAL FOR EDIT HOUSEHOLD--->
      <div class="modal fade" id="editt" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="staticBackdropLabel">Edit Resident</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div id="overlays" style="display: none;">
                <div class="spinner"></div>
                <br />
                Loading...
              </div>
              <form action="" method="post">
                <div class="form-row">
                  <div class="col-3">
                    <label>Resident ID</label>
                    <input type="text" class="form-control" readonly="readonly" name="residents" id="residents" placeholder="ex. 1234-567" required>
                  </div>
                  <div class="col-3">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="fnames" id="fnames" placeholder="ex. Juan" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                  <div class="col-3">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" name="mnames" id="mnames" placeholder="ex. Medina" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                  <div class="col-3">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lnames" id="lnames" placeholder="ex. Dela Cruz" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-3">
                    <label>Suffix</label>
                    <select name="suffixs" id="suffixs" class="form-control">
                      <option value="">-SELECT-</option>
                      <option value="Jr">Jr</option>
                      <option value="Sr">Sr</option>
                    </select>
                  </div>
                  <div class="col-3">
                    <label>BIRTH DATE</label>
                    <input id="datepickers" name="bdates" class="form-control" placeholder="ex. 01/01/1998" required>
                  </div>
                  <div class="col-3">
                    <label>Age</label>
                    <input type="text" class="form-control" id="ages" name="ages" placeholder="ex. 20" required>
                  </div>
                  <div class="col-3">
                    <label>Sex</label>
                    <select name="sexs" id="sexs" class="form-control" required>
                      <option value="">-SELECT-</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="BiSexual">BiSexual</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-3">
                    <label>Religion</label>
                    <select name="religions" id="religions" class="form-control" required>
                      <option value="">-SELECT-</option>
                      <option value="Roman Catholic">Roman Catholic</option>
                      <option value="Iglesia">Iglesia</option>
                      <option value="Muslim">Muslim</option>
                    </select>
                  </div>
                  <div class="col-3">
                    <label>Citezenship</label>
                    <input type="text" name="citizens" id="citizens" class="form-control" placeholder="ex. Filipino" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                  <div class="col-3">
                    <label>Occupation</label>
                    <input type="text" name="occupations" id="occupations" class="form-control" placeholder="Ex. Driver" onkeypress="return /[a-z, ]/i.test(event.key)" required>
                  </div>
                  <div class="col-3">
                    <label>Contact No.</label>
                    <input type="text" name="contacts" id="contacts" class="form-control" maxlength="11" onkeypress="return /[0-9]/i.test(event.key)" placeholder="Ex. 09xxxxxxx" required>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-3">
                    <label>Marital Status</label>
                    <select name="statuss" id="statuss" class="form-control" required>
                      <option value="">-SELECT-</option>
                      <option value="Single">Single</option>
                      <option value="Married">Married</option>
                      <option value="Seperated">Seperated</option>
                    </select>
                  </div>
                  <?php
                  $query = "SELECT * FROM purok";
                  $stmt = $conn->prepare($query);
                  $stmt->execute();
                  $result = $stmt->get_result();


                  ?>
                  <div class="col-3">
                    <label>Purok</label>

                    <select name="vote" id="voterss" class="form-control" required>
                      <option value="">-SELECT-</option>
                      <?php while ($row = $result->fetch_assoc()) {
                        $me = $row['purok'];
                      ?>
                        <option value="<?php echo $me; ?>"><?php echo $me; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-6">
                    <label>Address</label>
                    <input type="text" name="addresss" id="addresss" class="form-control" placeholder="Your Address">
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <input type="submit" class="update btn btn-primary" name="update" value="Update"></input>

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
              <div id="overlay2" style="display: none;">
                <div class="spinner"></div>
                <br />
                Loading...
              </div>
              <form action="" method="post">
                <input type="hidden" name="myids" id="myids">
                <center>
                  <p>Are you sure you want to delete this data?</p>
                  <h4><b>Resident ID:</b></h4>
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
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="modal-body">
              <div id="overlays1" style="display: none;">
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
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

  <!-- Page level custom scripts -->
  <script>
    $('#btn-submit').on('click', function(e) {
      e.preventDefault();

      swal({
          title: "Are you sure?",
          text: "If you click 'Finish' button your data will be cast!",
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
      $('.deleteb').click(function() {
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