<?php
class Database
{
  private $timezone_query = "SET time_zone = '+08:00'";
  private $db;

  public function __construct()
  {
    $this->db = $this->db_connect();
  }

  public function db_connect()
  {
    try
    {
      $string = DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME.";";
      $db = new PDO($string, DB_USER, DB_PASS);
      
      $db->exec($this->timezone_query);

      return $db;
    }
    catch(PDOException $e)
    {
      die($e->getMessage());
    }
  }

  public function getLastInsertId()
  {
    return $this->db->lastInsertId();
  }

  public function read($query, $data = [])
  {
    $stm = $this->db->prepare($query);

    if(count($data) == 0)
    {
      $stm = $this->db->query($query);
      $check = 0;
      if($stm)
      {
        $check = 1;
      }
    }
    else
    {
      $check = $stm->execute($data);
    }

    if($check)
    {
      return $stm->fetchAll(PDO::FETCH_OBJ);
    }
    else
    {
      return false;
    }
  }

  public function write($query, $data = [])
  {
    $stm = $this->db->prepare($query);
    if(count($data) == 0)
    {
      $stm = $this->db->query($query);
      $check = 0;
      if($stm)
      {
        $check = 1;
      }
    }
    else
    {
      $check = $stm->execute($data);
    }
    if($check)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}
?>
