<?php
  include 'database.php';
  $obj = new Database;
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Form</title>
  </head>
  <body>
    <form class="" action="save-data.php" method="post">
      <label>Name</label>
      <input type="text" name="sname" value=""><br><br>
      <label>Age</label>
      <input type="text" name="sage" value=""><br><br>
      <label>City</label>
      <select class="" name="scity">
        <?php
          $obj->select('citytb');
          $result = $obj->getResult();

          foreach ($result as list("cid"=>$cid,"cname"=>$cname)) {
            echo "<option value='$cid'>$cname</option>";
          }
         ?>
      </select><br><br>
      <input type="submit" name="" value="Save">
    </form>
  </body>
</html>
