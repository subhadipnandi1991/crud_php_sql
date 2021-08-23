<?php
  include_once 'database.php';

  $test = new Database;

  // $test->insert('students', ['student_name' => 'Sonu Nigam', 'age' =>28, 'city' => 'Goa']);
  // $test->update('students',['city'=>'Ladakh'],'city="Goa"');
  // $test->delete('students','city ="1"');
  // $test->sql('SELECT * FROM students');
  $test->select('students', '*',null,null,null,2);
  echo "<pre>";
  print_r($test->getResult());
  echo "</pre>";

  $test->pagination('students',null,null,2);



 ?>
<!-- <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <a href="show-data.php">SHOW</a>
  </body>
</html> -->
