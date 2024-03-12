<?php include 'connection.php' ?>

<?php

//fetch.php

if(isset($_POST["year"]))
{
 $query = "
 SELECT * FROM blotter
 WHERE year = '".$_POST["year"]."' 
 ORDER BY id ASC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output[] = array(
   'month'   => $row["month"],
   'profit'  => floatval($row["id"])
  );
 }
 echo json_encode($output);
}

?>