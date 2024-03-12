 <?php include 'connection.php'; ?>

 <?php
session_start();
  if(isset($_POST['mysubmit'])){
    $date = $_POST['dates'];
    $invoice = $_POST['invoice'];
    $fullnames = $_POST['fullnames'];
    $status = $_POST['status'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $qty = $_POST['qty'];
    $purpose = $_POST['purpose'];
    $p = $_POST['nameb'];
    $amountfd = $_POST['amountsf'];
    $total = $_POST['total'];
    $mes = $_POST['available'];
    $statuss = 0;
    if($mes == '<span class="text-danger">This resident have a record in barangay</span>'){
      $_SESSION['response']="Can't create this resident have record in barangay";
    $_SESSION['type']="danger";
    header("Location:clearance.php");
    }else{


    $query= "INSERT INTO clearance (invoice_no,fullname,civilstatus,address,clearance_type,purpose,bname,qty,amount,total,date_issued,status) values (?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn-> prepare($query);
    $stmt ->bind_param("ssssssssssss",$invoice,$fullnames,$status,$address,$type,$purpose,$p,$qty,$amountfd,$total,$date,$statuss);
    $stmt ->execute();
    header("Location: clearance.php");
    $_SESSION['response']="Information is successfully submitted";
    $_SESSION['type']="success";

     }
      }
      ?>