<?php
  /**
   *
   */
  class Database
  {
    private $db_host = "localhost";
    private $db_user = "badshah007";
    private $db_pass = "Baadshah@165$";
    private $db_name = "crud_php_class";

    private $conn = false;
    private $mysqli;
    private $result = array();

    function __construct()
    {
      if (!$this->conn) {
        $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        $this->conn = true;
        // echo "Connection created!<br/>";


        if($this->mysqli->connect_error) {
          array_push($this->error, $this->mysqli->connect_error);
          return false;
        }
      } else {
        return true;
      }
    }

    public function insert($table, $params=array())
    {
      if($this->tableExists($table)) {
        $tableKeys = implode(', ', array_keys($params));
        $tableValues = implode("', '" , $params);
        // echo $tableKeys;
        // echo $tableValues;

        $sql = "INSERT INTO $table($tableKeys) VALUES('$tableValues')";
        // echo $sql;
        if ($this->mysqli->query($sql)) {
          // echo "<pre>";
          // print_r($this->mysqli) ;
          // echo "</pre>";
          array_push($this->result, $this->mysqli->insert_id);
          // echo "record submited to DB";
          return true;
        } else {
          array_push($this->error, $this->mysqli->error);
          return false;
        }
      } else {
        // echo "Table name does not exist.";
        return false;
      }
    }

    public function update($table, $params=array(), $where=null)
    {
      if($this->tableExists($table)) {
        $args = array();
        foreach ($params as $key => $value) {
          $args[] = "$key = '$value'";
        }
        // print_r($args);
        $sql = "UPDATE $table SET ".implode(', ', $args);
        if ($where != null) {
          $sql .= " WHERE $where";
        }
        // echo $sql;
        if ($this->mysqli->query($sql)) {
          // echo "<pre>";
          // print_r($this->mysqli) ;
          // echo "</pre>";
          array_push($this->result, $this->mysqli->affected_rows);
          // echo "RECORD UPDATED SUCCESSFULLY INTO DB";
          return true;
        } else {
          array_push($this->error, $this->mysqli->error);
          return false;
        }
      } else {
        // echo "Table name does not exist.";
        return false;
      }

    }

    public function delete($table, $where=null)
    {
      if($this->tableExists($table)) {

        $sql = "DELETE FROM $table";
        // echo $sql;
        if ($where!=null) {
          $sql .= " WHERE $where";
        }
        // echo $sql;
        if ($this->mysqli->query($sql)) {
          // echo "<pre>";
          // print_r($this->mysqli) ;
          // echo "</pre>";
          array_push($this->result, $this->mysqli->affected_rows);
          // echo "record deleted successfully from DB";
          return true;
        } else {
          array_push($this->error, $this->mysqli->error);
          return false;
        }
      } else {
        // echo "Table name does not exist.";
        return false;
      }
    }

    public function select($table, $rows="*", $join=null, $where=null, $order=null, $limit=null)
    {
      if($this->tableExists($table)) {
        $sql = "SELECT $rows FROM $table";
        if ($join != null) {
          $sql .= " JOIN $join";
        }
        if ($where != null) {
          $sql .= " WHERE $where";
        }
        if ($order != null) {
          $sql .= "  ORDER BY $order";
        }
        if($limit != null){
          if (isset($_GET['page'])) {
            $page = $_GET['page'];
          } else {
            $page = 1;
          }
          $start = ($page - 1) * $limit;
          $sql .= " LIMIT $start,$limit";
        }

      $query = $this->mysqli->query($sql);

      if($query){
        $this->result = $query->fetch_all(MYSQLI_ASSOC);
        return true; // Query was successful
      }else{
        array_push($this->result, $this->mysqli->error);
        return false; // No rows were returned
      }
      } else {
      return false; // Table does not exist
      }
    }

    public function pagination($table, $join=null, $where=null, $limit=null)
    {
      if ($this->tableExists($table)) {
        if($limit != null) {
          $sql = "SELECT COUNT(*) FROM $table";
          if($join != null) {
            $sql .= " JOIN $join";
          }
          if($where != null) {
            $sql .= " WHERE $where";
          }

          $query = $this->mysqli->query($sql);

          $total_record = $query->fetch_array();
          $total_record = $total_record[0];

          $total_page = ceil($total_record / $limit);

          $url = basename($_SERVER['PHP_SELF']);
          if (isset($_GET['page'])) {
            $page = $_GET['page'];
          } else {
            $page = 1;
          }

          $output = "<ul class='pagination'>";

          if($page>1) {
            $output .= "<li><a href='$url?page=".($page-1)."'>Prev</a></li>";
          }
          if($total_record > $limit) {
            for($i = 1; $i <= $total_page; $i++){
              if($i == $page) {
                $cls = "class='active'";
              } else {
                $cls ="";
              }
              $output .= "<li><a href='$url?page=$i'>$i</a></li>";
            }
          }
          if($page<$total_page) {
            $output .= "<li><a href='$url?page=".($page+1)."'>Next</a></li>";
          }
          $output .= "</ul>";

          echo $output;

        }
      } else {
        return false;
      }
    }

    public function sql($sql)
    {
      $query = $this->mysqli->query($sql);

      if($query) {
        $this->result = $query->fetch_all(MYSQLI_ASSOC);
        return true;
      } else {
        array_push($this->result, $this->mysqli->error);
        return false;
      }
    }

    public function getResult()
    {
      $val = $this->result;
      $this->result = array();
      return $val;
    }

    public function tableExists($table)
    {
      $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
      $tableInDb = $this->mysqli->query($sql);
      if($tableInDb) {
        if ($tableInDb->num_rows == 1) {
          return true;
        } else {
          array_push($this->result, $table." does not exist in this db.");
          return false;
        }
      }
    }

    function __destruct(){
      if ($this->conn ) {
        if($this->mysqli->close()){
          // echo "<pre>";
          // print_r ($this->mysqli);
          // echo "</pre>";
          $this->conn = false;
          // echo "Connection closed!";
          return true;
        } else {
          return false;
        }
      }
    }
  }

 ?>
