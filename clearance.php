<?php include 'connection.php'; ?>
<?php
session_start();

if (!isset($_SESSION['name'])) {
  header("Location:index.php");
  $_SESSION['response'] = "Please Login First";
  $_SESSION['type'] = "danger";
}

$queryss = "SELECT invoice_no from clearance order by invoice_no desc";
$stmt = $conn->prepare($queryss);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$lastid = $row['invoice_no'];
if (empty($lastid)) {
  $number = "I-00001";
} else {
  $idd = str_replace("I-", "", $lastid);
  $id = str_pad($idd + 1, 5, 0, STR_PAD_LEFT);
  $number = 'I-' . $id;
}
?>
<?php

if (isset($_POST['delete'])) {
  $id = $_POST['myids'];
  $sql = "DELETE FROM resident where resident_id='$id'";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $_SESSION['response'] = "Information is successfully deleted";
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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="css/spinner.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link href="vendor/sweetalert/css/sweetalert.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
        <div class="sidebar-brand-icon">
          <img src="img/logo/polomolok.png">
        </div>
        <div class="sidebar-brand-text mx-2">Brgy Poblacion</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="home.php">
          <i class="fas fa-fw fa-chart-bar"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>

      <li class="nav-item">
        <a class="nav-link" href="household.php">
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
        <a class="nav-link" href="clearance.php">
          <i class="fas fa-fw fa-book"></i>
          <span>Clearance</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="blotter.php">
          <i class="fas fa-fw fa-columns"></i>
          <span>Blotter</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="archive.php">
          <i class="fas fa-fw fa-archive"></i>
          <span>Archive</span>
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
                <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">
                  <?php
                  if (isset($_SESSION['name'])) {
                    echo 'Welcome' . " " . $_SESSION['name'];
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

              <h6 class="m-0 font-weight-bold text-primary">Clearance Form</h6>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                Clearance
              </button>
            </div>

            <div class="table-responsive p-3">

              <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <?php
                $query = "SELECT * FROM clearance order by invoice_no";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Inv.#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th colspan="11" style="text-align:right">Total:</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $i = 1;
                  while ($row = $result->fetch_assoc()) {  ?>
                    <tr>

                      <td><?php echo $i++ ?></td>
                      <td><?php echo $row['invoice_no']; ?></td>
                      <td><?php echo $row['fullname']; ?></td>
                      <td><?php echo $row['clearance_type']; ?></td>
                      <td><?php echo $row['purpose']; ?></td>
                      <td><?php echo $row['civilstatus']; ?></td>
                      <td><?php echo $row['address']; ?></td>
                      <td><?php echo $row['qty']; ?></td>
                      <td><?php echo $row['amount']; ?></td>
                      <td><?php echo $row['total']; ?></td>
                      <td><?php echo $row['date_issued']; ?></td>
                      <td>
                        <?php
                        if ($row['status'] == 1) {
                          echo "Expired";
                        } else if ($row['clearance_type'] == 'Barangay Clearance') {
                          echo "<a href='pdf.php?pdf=" . $row['id'] . "' class='badge badge-info p-2'>PRINT</a>";
                        } else if ($row['clearance_type'] == 'Indigency') {
                          echo "<a href='indigency.php?pdf=" . $row['id'] . "' class='badge badge-info p-2'>PRINT</a>";
                        } else if ($row['clearance_type'] == 'Business Clearance') {
                          echo "<a href='business.php?pdf=" . $row['id'] . "' class='badge badge-info p-2'>PRINT</a>";
                        } else {
                          echo "No one else";
                        }



                        ?>


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
              <h5 class="modal-title" id="staticBackdropLabel">CLEARANCE FORM</h5>
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
              <form action="invoice.php" method="post">
                <div class="form-group">
                  <label for="exampleInputEmail1">Search Resident</label>

                  <input type='text' id='autocomplete' class="form-control" required>
                  <span id="availability"></span>
                  <input type="text" name="available" id="available" style="display: none;">
                </div>
                <?php
                $date = date('Y-m-d');
                ?>
                <table>
                  <th>
                    <h5><b>Date:</b></h5>
                  </th>
                  <td></td>
                  <td>
                    <h5 style="font-weight: bold; color: red;"><?php echo $date ?></h5>
                  </td>
                  <input type="hidden" name="dates" value="<?php echo $date; ?>">
                  <tr>&nbsp;&nbsp;&nbsp;</tr>
                  <th>
                    <h5><b>Transaction No:</b></h5>
                  </th>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td>
                    <h5 style="font-weight: bold; color: red;" id='ino'><?php echo $number; ?></h5>
                  </td>
                  <input type="hidden" name="invoice" value="<?php echo $number; ?>">
                  <tr></tr>
                  <th>
                    <h5><b>Full Name:</b></h5>
                  </th>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td>
                    <h5 style="font-weight: bold; color: red;" id="fullname"></h5>
                  </td>
                  <input type="hidden" name="fullnames" id="fullnames">
                  <tr></tr>
                  <th>
                    <h5><b>Civil Status:</b></h5>
                  </th>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td>
                    <h5 style="font-weight: bold; color: red;" id="statuss"></h5>
                  </td>
                  <input type="hidden" name="status" id="statusss">
                  <tr></tr>
                  <th>
                    <h5><b>Address:</b></h5>
                  </th>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td>
                    <h5 style="font-weight: bold; color: red;" id="address"></h5>
                  </td>
                  <input type="hidden" name="address" id="addresss">
                  <tr></tr>
                  <tr></tr>
                </table>
                <hr>

                <script>
                  function callme(s) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("amountss").innerHTML = this.responseText;
                      }
                    };
                    xmlhttp.open("GET", "amount.php?in=" + s, true);
                    xmlhttp.send();
                  }
                </script>
                <div class="form-group">
                  <label for="exampleInputPassword1">Type</label>
                  <?php
                  $sql = "SELECT * FROM certificate where status='1' ORDER BY certificate ASC";
                  $result = $conn->query($sql);
                  ?>
                  <select name="type" class="form-control" id="type" onchange="return callme(this.value);" required>
                    <option>-SELECT-</option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                      $cat = $row['certificate'];
                      if ($cat)
                        echo "<option value='$cat'>$cat</option>";

                    ?>
                    <?php
                    }
                    ?>

                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Purpose</label>
                  <input type="text" class="form-control" id="purpose" name="purpose" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Quantity</label>
                  <input class="form-control" id="qty" name="qty" type="number" onkeyup="calculate();javascript:checkNumber(this);" required>
                </div>
                <div class="form-group" id="amountss">
                  <label for="exampleInputPassword1">Amount</label>
                  <input class="form-control input-sm" id="amount" name="amount" readonly="readonly" type="text" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Total</label>
                  <input type="text" class="form-control" id="total" name="total" readonly="readonly" required>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="submit" id="mysubmit" style="display:none;"></button>
              <input type="submit" class="submit btn btn-primary" name="mysubmit" id="btn-submit" value="Submit">

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
          <div class="modal-header">
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
          <div id="overlays1" style="display:none;">
            <div class="spinner"></div>
            <br />
            Loading...
          </div>
          <p>Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
          <a href="logout.php" class="logout btn btn-primary">Logout</a>
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


  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/sweetalert/js/sweetalert.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
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
      $('#autocomplete').blur(function() {
        var username = $(this).val();
        $.ajax({
          url: "check.php",
          method: "POST",
          data: {
            user_name: username
          },
          dataType: "text",
          success: function(html) {
            $('#availability').html(html);
            $('#available').val(html);
          }
        });
      });
    });
  </script>

  <script type="text/javascript">
    function calculate() {
      var first = document.getElementById('qty').value;
      var second = document.getElementById('amounts').value;

      var totalVal = parseFloat(first) * parseFloat(second).toFixed(2);
      document.getElementById('total').value = totalVal;
      if (first == "" || first == "0") {
        document.getElementById('total').value = '0.00';
      }

    }
  </script>
  <script>
    $(document).ready(function() {


      $("#autocomplete").autocomplete({
        source: function(request, response) {
          // Fetch data
          $.ajax({
            url: "fetchclearance.php",
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
          $('#fullname').html(ui.item.label);
          $('#fullnames').val(ui.item.label);
          $('#address').html(ui.item.address);
          $('#addresss').val(ui.item.address);
          $('#statuss').html(ui.item.status);
          $('#statusss').val(ui.item.status);
          return false;
        }
      });
      $('#staticBackdrop').on('hidden.bs.modal', function() {
        $('#fullname').html("");
        $('#address').html("");
        $('#statuss').html("");
        $('#autocomplete').html("");
        $('#type').val("-SELECT-");
        $('#purpose').val("");
        $('#qty').val("");
        $('#amount').val("");
        $('#amounts').val("");
        $('#total').val("0.00");
      })

      $('#dataTableHover').DataTable({
        "footerCallback": function(row, data, start, end, display) {
          var api = this.api(),
            data;

          // Remove the formatting to get integer data for summation
          var intVal = function(i) {
            return typeof i === 'string' ?
              i.replace(/[\$,]/g, '') * 1 :
              typeof i === 'number' ?
              i : 0;
          };

          // Total over all pages
          total = api
            .column(9)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(9, {
              page: 'current'
            })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(9).footer()).html(
            '&#8369; ' + pageTotal + ' ( &#8369; ' + total + ' total)'
          );
        }
      });
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
      font-size: 11px;
    }

    td {
      font-size: 10px;
    }

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
  </style>
</body>

</html>