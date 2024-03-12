<?php include 'connection.php'; ?>
<?php
session_start();
if (isset($_POST['login'])) {
  $Username = $_POST['username'];
  $Password = $_POST['password'];
  $hashpass = md5($_POST['password']);

  $status = "Active";




  if ($_POST['myps11'] == '') {
    $sql = "SELECT * FROM account where username='$Username' AND password='$Password' AND status='$status'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    $_SESSION['username'] = $row['username'];
    $_SESSION['roles'] = $row['role'];
    $_SESSION['name'] = $row['fullname'];
    $_SESSION['id'] = $row['id'];
    if ($row['role'] == "admin") {

      header("Location: admin/dashboard.php");
    } else if ($row['role'] == "Employee") {
      if ($row['hashpass'] == "") {
        header("Location:newlogin.php");
      } else {
        header("Location:home.php");
      }
    } else {
      $_SESSION['response'] = "Incorrect Credentials";
      $_SESSION['type'] = "danger";
    }
  } else {
    $sql = "SELECT * FROM account where username='$Username' AND hashpass='$hashpass' AND status='$status'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    $_SESSION['username'] = $row['username'];
    $_SESSION['roles'] = $row['role'];
    $_SESSION['name'] = $row['fullname'];
    $_SESSION['id'] = $row['id'];
    if ($rs->num_rows > 0) {

      if ($row['role'] == "admin") {
        $_SESSION['username'] = $row['username'];
        $_SESSION['roles'] = $row['role'];
        $_SESSION['name'] = $row['fullname'];
        $_SESSION['id'] = $row['id'];
        header("Location: admin/dashboard.php");
      } else if ($row['role'] == "Employee") {
        header("Location:home.php");
      } else {
        $_SESSION['response'] = "Incorrect Credentials";
        $_SESSION['type'] = "danger";
      }
    } else {
      $_SESSION['response'] = "Incorrect Credentials";
      $_SESSION['type'] = "danger";
    }
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
  <link href="img/logo/logo.png" rel="icon">
  <title>Login</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">

  <!-- Login Content -->
  <div class="container-login mt-5">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-5 col-md-5">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">

                <?php if (isset($_SESSION['response'])) { ?>
                  <div class="alert alert-<?= $_SESSION['type']; ?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times </button>
                    <?= $_SESSION['response']; ?>
                  </div>
                <?php unset($_SESSION['response']);
                } ?>

                <div class="login-form">

                  <div class="text-center">
                    <img class="img-profile rounded-circle mb-3 bg-secondary" src="img/r.png" style="max-width: 90px">
                    <h1 class="h4 text-gray-900 mb-4">LOGIN</h1>
                  </div>
                  <form action="" method="post" class="user">
                    <div class="form-group">
                      <input type="text" class="form-control" name="myps11" id="myps1" style="visibility: hidden">
                      <input type="text" class="form-control" id="username11" placeholder="Enter Username" name="username" required>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember
                          Me</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" name="login">Login</a>
                    </div>


                  </form>
                  <hr>
                  <div class="text-center">
                    <span class="small">Powered By: </span><a class="font-weight-bold small" href="https://www.facebook.com/SyInvasionz">Praaangk</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>

</body>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('button').click(function() {
      $('#overlay').fadeIn().delay(2000).fadeOut();
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('#username11').keyup(function() {
      var news = $(this).val();
      $.ajax({
        method: "POST",
        url: "usernamepass.php",
        data: {
          myids: news,
        },
        success: function(html) {
          $('#myps1').val(html);
        }

      });
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
</style>