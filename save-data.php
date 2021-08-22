<?php
  include 'database.php';

  // print_r($_POST);
  // die();

    $obj = new Database;
    $value = ['student_name' => $_POST['sname'], 'age' => $_POST['sage'], 'city' => $_POST['scity']];
// print_r ($value);
// die();
    if ($obj->insert('students', $value)){
      echo "<h2>Data Inserted Successfully.</h2>";
    } else {
  		echo "<h2>Data is Not Inserted Successfully.</h2>";
  	}
 ?>
