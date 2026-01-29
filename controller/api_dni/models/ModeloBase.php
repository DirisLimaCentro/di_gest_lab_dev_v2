<?php

require_once __DIR__ . "/../config/Conexion.php";
@session_start();

class ModeloBase
{
  private $conexion = null;
  private $debugger = true;

  public function __construct()
  {
    $this->conexion = new Conexion();
  }

  public function getConexionModel(){
    return $this->conexion;
  }

  public function getError($ex)
  {
    $pos = strpos($ex->getMessage(), '1001');
    if ($pos) {
      $msg = substr($ex->getMessage(), $pos + 5);
    } else {
      $msg = $ex->getMessage();
    }
    return $msg;
  }

  function getAllRows($sql, $data = [], $sql_count = "", $data_count = [], $pdo_fetch_option = PDO::FETCH_ASSOC)
  {
    $result = ["rows" => [], "cant_rows" => 0, "row" => null, "error" => ""];
    try {
      $cn = $this->conexion->getConexion();
      $stmt = $cn->prepare($sql);
      $this->conexion->bindFilters($stmt, $data);
      $ok = $stmt->execute();
      $load_cnt = false;
      if ($ok) {
        while ($row = $stmt->fetch($pdo_fetch_option)) {
          $result["rows"][] = $row;
          if (isset($row["cant_rows"]) && $load_cnt == false) {
            $result["cant_rows"] = $row["cant_rows"];
            $load_cnt = true;
          }
        }
      }
      if ($sql_count) {
        $stmt = $cn->prepare($sql_count);
        $this->conexion->bindFilters($stmt, $data_count);
        $ok = $stmt->execute();
        if ($ok) {
          if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result["cant_rows"] = $row["cant_rows"];
          }
        }
      }
      $stmt = null;
      $cn = null;
    } catch (Exception $ex) {
      $result["error"] = $this->getError($ex);
    }
    return $result;
  }

  function getRow($sql, $data = [])
  {
    $result = ["rows" => [], "cant_rows" => 0, "row" => null, "error" => ""];
    try {
      $cn = $this->conexion->getConexion();
      $stmt = $cn->prepare($sql);
      $this->conexion->bindFilters($stmt, $data);
      $ok = $stmt->execute();
      if ($ok) {
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $result["row"] = $row;
        } else {
          $result["error"] = "No se encontraron datos";
        }
      }
      $stmt = null;
      $cn = null;
    } catch (Exception $ex) {
      $result["error"] = $this->getError($ex);
    }
    return $result;
  }

  function getAllRowsProcedure($sql, $data = [])
  {
    $result = ["rows" => [], "cant_rows" => 0, "row" => null, "error" => "", "success" => "", "id"=>null];

    try {

      $cn = $this->conexion->getConexion();
      $stmt = $cn->prepare($sql);
      $this->conexion->bindProcedure($stmt, $data);
      $ok = $stmt->execute();
      $load_cnt = false;
      if ($ok) {

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $result["rows"][] = $row;
          if (isset($row["cant_rows"]) && $load_cnt == false) {
            $result["cant_rows"] = $row["cant_rows"];
            $load_cnt = true;
          }
        }

      } else {
        $result["error"] = "ocurrio un error";
      }
      $stmt = null;
      $cn = null;
    } catch (Exception $ex) {
      //exit( $ex->getMessage() );
      $result["error"] = $this->getError($ex);
    }

    return $result;
  }

  function executeProcess($sql, $data = [], $success_msg = "")
  {

    $result = [
      "rows" => [],
      "cant_rows" => 0,
      "row" => null,
      "error" => "",
      "success" => "",
      "id"=>null,
      "response"=>''
    ];

    try {

      $cn = $this->conexion->getConexion();
      $stmt = $cn->prepare($sql);
      $this->conexion->bindProcedure($stmt, $data);
      $ok = $stmt->execute();

      if ($ok) {

        if ($row = $stmt->fetch()) {
          $msg = $row[0]; 
          if ($msg != '' && !is_numeric($msg) && strpos($msg, '|')===false){
            $result["error"] = $msg;
          }else {
            if(strpos($msg, '|')>0){
              $result['response'] = $msg;
            }else{
              $result["id"] = $msg ? (int)$msg : null;
            }            
            $result["success"] = $success_msg;
          }
        }else{
          $result["success"] = $success_msg;
        }

      } else {
        $result["error"] = "ocurrio un error";
      }
      $stmt = null;
      $cn = null;
    } catch (Exception $ex) {
      //exit( $ex->getMessage() );
      $result["error"] = $this->getError($ex);
    }

    return $result;
  }

  function execProcAndGetRow($sql, $data = []) {

    $result = ["rows" => [], "cant_rows" => 0, "row" => null, "error" => "", "success" => ""];

    try {

      $cn = $this->conexion->getConexion(); //Obtener Conexion 
      $cn->beginTransaction(); //Iniciar la transacción

      $stmt = $cn->prepare($sql);
      $this->conexion->bindProcedure($stmt, $data);
      $stmt->execute();

      $cursorName = $stmt->fetchColumn(); //Recuperar el nombre del cursor devuelto por la función

      if ($cursorName) {       
        $stmt = $cn->prepare("FETCH ALL IN ref_cursor");// Obtener los datos del cursor
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          $result["row"] = $row;
          $cn->commit();
        }
        else {
          $result["error"] = "Sin Datos";
          $cn->rollBack();
        }

      } else {
        $result["error"] = "No se devolvió ningún cursor";
        $cn->rollBack();
      }
      
      $stmt = null;
      $cn = null;
    } catch (Exception $ex) {
      //exit( $ex->getMessage() );
      $result["error"] = $this->getError($ex);
    }

    return $result;
  }

  function execProcAndGetAllRows($sql, $data = [])
  {

    $result = ["rows" => [], "cant_rows" => 0, "row" => null, "error" => "", "success" => ""];

    try {

      $cn = $this->conexion->getConexion(); //Obtener Conexion 
      $cn->beginTransaction(); //Iniciar la transacción

      $stmt = $cn->prepare($sql);
      $this->conexion->bindProcedure($stmt, $data);
      $stmt->execute();

      $cursorName = $stmt->fetchColumn(); //Recuperar el nombre del cursor devuelto por la función

      if ($cursorName) {
        $stmt = $cn->prepare("FETCH ALL IN ref_cursor");// Obtener los datos del cursor
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) $result["rows"][] = $row;

      } else {
        $result["error"] = "No se devolvió ningún cursor";
      }
      
      $stmt = null;
      $cn = null;
    } catch (Exception $ex) {
      //exit( $ex->getMessage() );
      $result["error"] = $this->getError($ex);
    }

    return $result;
  }
}
