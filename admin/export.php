<?php include '../connection.php'; ?>
<?php
session_start();

  if(!isset($_SESSION['username'])){
  header("Location:index.php");
  $_SESSION['response']="Please Login First";
  $_SESSION['type']="danger";
}


if (isset($_POST["import"])) {
    if ($_FILES["db"]["name"] != '') {
        $array = explode(".", $_FILES["db"]["name"]);
        $extension = end($array);
        if ($extension == 'sql') {
            $query_disable_checks = 'SET foreign_key_checks = 0';
            $connect = mysqli_connect("localhost", "root", "", "profiling");
            $connect->query('SET foreign_key_checks = 0');
            $qry_drop = "DROP TABLE IF EXISTS account,archive,blotter,certificate,clearance,official,purok,resident";
            $connect->query($qry_drop);
            $connect->query('SET foreign_key_checks = 1');


            $output = '';
            $count = 0;
            $file_data = file($_FILES["db"]["tmp_name"]);
            foreach ($file_data as $row) {
                $start_character = substr(trim($row), 0, 2);
                if ($start_character != '--' || $start_character != '/*' || $start_character != '//' || $row != '') {
                    $output = $output . $row;
                    $end_character = substr(trim($row), -1, 1);
                    if ($end_character == ';') {
                        if (!mysqli_query($connect, $output)) {
                            $count++;
                        }
                        $output = '';
                    }
                }
            }
            if ($count > 0) {
                $_SESSION['response'] = "There is an error in Database Import";
                $_SESSION['type'] = "warning";
            } else {

                $_SESSION['response'] = "Database Successfully Imported";
                $_SESSION['type'] = "success";
            }
        } else {

            $_SESSION['response'] = "Invalid File";
            $_SESSION['type'] = "warning";
        }
    } else {

        $_SESSION['response'] = "Please Select Sql File";
        $_SESSION['type'] = "warning";
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
      <li class="nav-item">
        <a class="nav-link" href="account.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Account Settings</span>
        </a>
      </li>
        <li class="nav-item active">
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
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
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
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="../img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">
                  <?php 
                  if(isset($_SESSION['username'])){
                   echo 'Welcome'." ".$_SESSION['username'] ;
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
      <?php if(isset($_SESSION['response'])){ ?>
<div class="alert alert-<?= $_SESSION['type']; ?> alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times </button>
  <?= $_SESSION['response']; ?>
  </div>
<?php  unset($_SESSION['response']); 
} ?>
</div>


            <div class="col-lg-12">
              <div class="card mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                  <h6 class="m-0 font-weight-bold text-primary">BACKUP AND RESTORE</h6>
 
                </div>
                
          
<br><Br><Br><br><br><br><br><br><br>
            <div class="card-block">
                                                        <div class="row">
                                                            <div class="col-lg-6"  >
                                                                <center >
                                                                    <h3>Export Database</h3><br>
                                                                    <span class="text-muted">Click "Export" Button to backup your database!</span><br><br>
                                                                    <a href="database.php" class="btn btn-danger">Export</a>
                                                                </center>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <center>
                                                                    <h3>Import Database</h3><br>
                                                                    <span class="text-muted">Select your database and click "Import" Button to restore your database!</span><br><br>
                                                                    <form action="" method="post" enctype="multipart/form-data">
                                                                        <input type="file" class="form-control w-50" name="db" id="db" required><br>
                                                                        <button type="submit" class="btn btn-primary" name="import">Import</button>
                                                                    </form>


                                                                </center>
                                                            </div>
                                                        </div>
                                                    </div>
   <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>






              </div>
            </div>
          </div>
            
         
    




          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
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
    <br/>
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
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
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

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
       $('a.edit').on('click', function(){
      $('#staticBackdrops').modal('show');
  
      $tr = $(this).closest('tr');
      var data= $tr.children("td").map(function(){
        return $(this).text();

      }).get();
      console.log(data);
      $('#residents').val(data[2]);
      $('#residents1').val(data[3]);
       });

       $('a.delete').on('click', function(){
      $('#deleteModals').modal('show');
  
      $tr = $(this).closest('tr');
      var data= $tr.children("td").map(function(){
        return $(this).text();

      }).get();
      console.log(data);
      $('#dataa').html(data[1]);
      $('#myids').val(data[3]);
       });


      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
 
</body>

</html>
  <script type="text/javascript">
  $(document).ready(function() {
  $('.submit').click(function(){
    $('#overlay').fadeIn().delay(2000).fadeOut();
  });
  $('.update').click(function(){
    $('#overlays').fadeIn().delay(2000).fadeOut();
  });
   $('.deleteb').click(function(){
    $('#overlay2').fadeIn().delay(2000).fadeOut();
  });
  $('.logout').click(function(){
    $('#overlays1').fadeIn().delay(2000).fadeOut();
  });
  $('.spin').click(function(){
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