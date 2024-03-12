<?php include 'connection.php'; ?>
<?php
session_start();


$id = $_SESSION['id'];

if (isset($_POST['submit'])) {
  $idhidden = $_POST['idhidden'];
  $pass = md5($_POST['password']);
  $sql = "UPDATE account SET hashpass='$pass' where id='$idhidden'";
  $conn->query($sql);
  header("Location:home.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">`
  <meta name="author" content="">
  <link href="img/seait.png" rel="icon">
  <title>New Password</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">

  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
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
                <div id="redirecting"></div>
                <div class="login-form p-5">

                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Enter New Password</h1>
                  </div>

                  <form action="" method="post" class="user">

                    <input type="hidden" name="idhidden" value="<?php echo $id; ?>">
                    <div class="form-group">

                      <input type="password" id="password" class="form-control" aria-describedby="emailHelp" placeholder="New Password" name="password" required>
                    </div>

                    <div class="form-group">
                      <input type="password" id="confirm" class="form-control" aria-describedby="emailHelp" placeholder="Confirm Password" name="confirm" required>
                      <div id="error"></div>

                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">View password</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" name="submit" id="submit">Submit</a>
                    </div>
                  </form>
                  <hr>
                  <div class="text-center">
                    <span class="small font-weight-bold"><a href="logout.php"><u>Go back to login page</a></u></span>
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
  <script src="assets/js/ruang-admins.min.js"></script>

</body>







</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('#confirm').keyup(function() {
      var pwd = $('#password').val();
      var cpwd = $('#confirm').val();

      if (cpwd != pwd) {
        $('#error').html('Password are not matching');
        $('#error').css('color', 'red');
        $('#submit').attr('disabled', true);

      } else {
        $('#error').html('');
        $('#submit').attr('disabled', false);
      }
    });


    $('#password').keyup(function() {
      var pwd = $('#password').val();
      var cpwd = $('#confirm').val();
      if (cpwd != pwd) {
        $('#error').html('Password are not matching');
        $('#error').css('color', 'red');
        $('#submit').attr('disabled', true);
      } else {
        $('#error').html('');
        $('#submit').attr('disabled', false);
      }
    });
    $('#customCheck').change(function() {
      if ($(this).is(':checked')) {
        $('#password').attr('type', 'text');
        $('#confirm').attr('type', 'text');
      } else {
        $('#password').attr('type', 'password');
        $('#confirm').attr('type', 'password');
      }
    });
  });
</script>