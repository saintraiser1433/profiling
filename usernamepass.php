<?php
include 'connection.php';

if (isset($_POST['myids'])) {
    $my = $_POST['myids'];

    $sql = "SELECT * FROM account where username='$my'";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    if ($res->num_rows > 0) {
        echo $row['hashpass'];
    } else {
        echo "";
    }
}
