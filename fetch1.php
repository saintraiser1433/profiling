<?php include 'connection.php' ?>

<?php 
		$input = $_GET['in'];
		$query = "SELECT * FROM resident where fullname='$input'";
        $stmt = $conn-> prepare($query);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $date = date('Y-m-d');


?>

	 <?php


         if($row=$result->fetch_assoc()){  ?>
         	<table>
    <th><h5><b>Date:</b></h5></th>
    <td></td>
    <td><h5><?php echo $date ?></h5></td>
    <tr></tr>
    <th><h5><b>Transaction No:</b></h5></th>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td><h5></h5></td>
    <tr></tr>
    <th><h5><b>Full Name: </b></h5></th>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td><h5><?php echo $row['fullname'];  ?></h5></td>
    <tr></tr>
    <th><h5><b>Civil Status:</b></h5></th>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td><h5><?php echo $row['status'];  ?></h5></td>
    <tr></tr>
    <th><h5><b>Address:</b></h5></th>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td><h5><?php echo $row['address'];  ?></h5></td>
    <tr></tr>
    <tr></tr>
  </table>
  <hr>
 <div class="form-group">
    <label for="exampleInputPassword1">Type</label>
    <select name="type" class="form-control" required>
  <option>-SELECT-</option>
  <option value="Barangay Clearance">Barangay Clearance</option>
  <option value="Indigency">Indigency</option>
  <option value="Business Clearance">Business Clearance</option>

</select>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Purpose</label>
    <input type="text" class="form-control" id="purpose" name="purpose" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Quantity</label>
    <input type="text" class="form-control" id="qty" name="qty" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Amount</label>
    <input type="text" class="form-control" id="amount" name="total" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Total</label>
    <input type="text" class="form-control" id="total" name="total" readonly="readonly" required>
  </div>
          
         <?php } ?>