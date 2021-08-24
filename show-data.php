<?php
  include_once 'database.php';

  $obj = new Database;

  $columns = "students.id, students.student_name, students.age, citytb.cname";
  $join = "citytb ON students.city=citytb.cid";
  $limit = 2;

  $obj->select('students', '*',$join,null,null,$limit);
  $result = $obj->getResult();
  echo "<table border='1' width='500px'>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Age</th>
          <th>City</th>
        </tr>";
  foreach ($result as list("id"=>$id, "student_name"=>$name, "age"=>$age,"cname"=>$city)) {
    echo "<tr><td>$id </td><td>$name </td><td>$age </td><td>$city </td></tr>";
  }
  echo "</table>";
  $obj->pagination('students',null,null,$limit);
