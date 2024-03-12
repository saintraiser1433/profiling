<?php include 'connection.php'; ?>
<?php session_start();
if(!isset($_SESSION['name'])){
  header("Location:index.php");
  $_SESSION['response']="Please Login First";
  $_SESSION['type']="danger";
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
  <link href="img/logo/logo.png" rel="icon">
  <title>Brgy Poblacion Profiling/Management System</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
      <li class="nav-item active">
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
                <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">
                  <?php 
                  if(isset($_SESSION['name'])){
                   echo 'Welcome'." ".$_SESSION['name'] ;
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

                  <h6 class="m-0 font-weight-bold text-primary">MANAGE PUROK</h6>
                  
                </div>

                <div class="table-responsive p-3">
                 <?php
        $query = "SELECT * FROM purok order by purok";
        $stmt = $conn-> prepare($query);
        $stmt -> execute();
        $result = $stmt -> get_result();
        ?>
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th style="display: none;">ds</th>
                        <th>Purok Name</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tfoot>

                      <tr>
                       <th>#</th>
                        <th>Purok Name</th>
                        <th style="display: none;"></th>

                        <th></th>
                      </tr>
                    </tfoot>
                    <tbody>
                             <?php $i=1; while($row=$result->fetch_assoc()){  ?>
                      <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?=$row['purok'];?></td>
                        <td style="display: none;"><?=$row['id'];?></td>
                        <td></td>
                        
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
      <div class="modal-header bg-primary text-white" >
        <h5 class="modal-title" id="staticBackdropLabel">Add Purok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="overlay" style="display:none;">
    <div class="spinner"></div>
    <br/>
    Loading...
</div>
        <form action="" method="post">
         
     <div class="col">
      <label>Purok Name</label>
      <input type="text" class="form-control" name="puroks" placeholder="ex. Poblacion">
    </div>
   

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="submit btn btn-primary" name="submit" value="Submit">
      </div>
      </form>
    </div>
    </div>
  </div>
</div>
<!---END-->

 <!--EDIT MODAL FOR HOUSEHOLD--->
          <div class="modal fade" id="staticBackdrops" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="staticBackdropLabel">Update Purok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
        <div id="overlays" style="display:none;">
    <div class="spinner"></div>
    <br/>
    Loading...
</div>
        <form action="" method="post">
         
     <div class="col">
      <label>Purok Name</label>
      <input type="text" class="form-control" id="residents" name="puroks1" placeholder="ex. Poblacion">
      <input type="hidden" class="form-control" id="residents1" name="puroks2" placeholder="ex. Poblacion">
    </div>
   

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="update btn btn-primary" name="update" value="Update">
      </div>
      </form>
    </div>
    </div>
  </div>
</div>
<!---END-->

        <!-- Modal delete -->
          <div class="modal fade" id="deleteModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
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
                   <div id="overlay2" style="display:none;">
    <div class="spinner"></div>
    <br/>
    Loading...
</div>
                  <form action="" method="post">
                  <input type="hidden" name="myids" id="myids">
                  <center><p>Are you sure you want to delete this data?</p>
                    <h4><b>PUROK NAME :</b></h4><h4 id="dataa"></h4></center>
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
                  <a href="login.php" class="logout btn btn-primary">Logout</a>
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

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

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
      $('#residents').val(data[1]);
      $('#residents1').val(data[2]);
       });

       $('a.delete').on('click', function(){
      $('#deleteModals').modal('show');
  
      $tr = $(this).closest('tr');
      var data= $tr.children("td").map(function(){
        return $(this).text();

      }).get();
      console.log(data);
      $('#dataa').html(data[1]);
      $('#myids').val(data[2]);
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