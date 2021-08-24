<?php
  include_once 'database.php';

  $test = new Database;

  // $test->insert('students', ['student_name' => 'Sonu Nigam', 'age' =>28, 'city' => 'Goa']);

  // $test->update('students',['city'=>'Ladakh'],'city="Goa"');

  // $test->delete('students','city ="1"');

  // $test->sql('SELECT * FROM students');

  $columns = "students.student_name, students.age, citytb.cname";
  $join = "citytb ON students.city=citytb.cid";
  $limit = 2;

  $test->select('students', $columns,$join,null,null,$limit);
  echo "<pre>";
  print_r($test->getResult());
  echo "</pre>";

  $test->pagination('students',null,null,$limit);



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
