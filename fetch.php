<?php
  $conn  = new mysqli("localhost","root","","profiling");
  if($conn->connect_error){
    die("Failed to connect!".$conn->connect_error);

  }
  if(isset($_POST['search'])){
    $inputText = $_POST['search'];
    $query = "SELECT * FROM resident where fullname LIKE '%$inputText%'";
    $result = $conn->query($query);
    $response = array();
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        $response[] = array(
          "value"=>$row['resident_id'],
          "label"=>$row['fullname'],
          "puroks"=>$row['purok'],
          "status"=>$row['status'],
          "age"=>$row['age'],

        );
      }
      echo json_encode($response);
    }
    else
 {
  $response["label"] = "No result found";
 }

  }
  


 
        
?>