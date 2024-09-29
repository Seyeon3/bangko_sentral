<?php
// Centralize Controller Functions
Class Controller
{
  protected function loadView($view,$data = [])
  {
    if(file_exists("../app/views/". $view .".php"))
    {
      include "../app/views/". $view .".php";
    }else{
      include "../app/views/404.php";
    }
  }

  protected function loadModel($model)
  {
    if(file_exists("../app/models/". $model .".php"))
    {
      include "../app/models/". $model .".php";
      return $model = new $model(); //return as object
    }

    return false;
  }

  protected function isActiveUserLoggedIn()
  {
      return isset($_SESSION['user_id']);
  }

  protected function isMaintenance()
  {
      $DB = new Database();
      // Use CONVERT_TZ to ensure NOW() is in Manila time
      $query = "SELECT *
                FROM maintenance
                WHERE CONVERT_TZ(NOW(), @@session.time_zone, '+08:00') BETWEEN start AND end;";
      $result = $DB->read($query);
      if ($result) 
      {
        $data['current_page'] = "Maintenance";
        $data['message'] =  $result[0]->maintenance_message;
        $this->loadView("maintenance",$data);
        exit();
      }
  }
  
}

// continue