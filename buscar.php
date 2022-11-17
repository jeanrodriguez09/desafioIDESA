<?php

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

require_once 'Database.php';

$handle = new SQLite3("idesa.db");

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['lote']))
    {
      $lote=$_GET['lote'];
      //Mostrar un post
      $sql = $handle->query("SELECT * FROM debts where lote='$lote'");
      header("HTTP/1.1 200 OK");
      $data = [];
      while ($row=$sql->fetchArray(SQLITE3_ASSOC)){
          array_push($data, $row);
      }
      print (json_encode($data));
      exit();
    }
    else {
        //Mostrar lista de post
        $res = $handle->query("SELECT * from debts");
        $data = [];
        while ($row=$res->fetchArray(SQLITE3_ASSOC)){
            array_push($data, $row);
        }
        print (json_encode($data));
    }
}else{
header("HTTP/1.1 400 Bad Request");
}
?>