<?php

require_once __DIR__ . "../../utilitario/Utilitario.php";
require_once __DIR__ . "/ModeloBase.php";

class Token
{
  private $conexion;

  public function __construct()
  {
    $this->conexion = new Conexion();
  }

  function getToken()
  {
    $result = ["error" => "", "rows" => [],"row"=>null];

    try {

      $cn = $this->conexion->getConexion();
      $sql = "SELECT id,descrip_token token,fecha_registro,fecha_limite
        FROM tbl_genera_token
        WHERE id_estado_registro='1' 
            AND abreviatura_institucion = 'API_DLC_DNI'
        ORDER BY fecha_registro desc LIMIT 1
      ";
      //$id_usuario = $_SESSION["id_usuario"];
      $stmt = $cn->prepare($sql);

      $ok = $stmt->execute();
      //echo $ok;exit();
      if ($ok) {
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $result["row"] = $row;
        }
      }
    } catch (Exception $ex) {
      $cn = null;
      $result["error"] = "Error" . $ex->getMessage();
    }
    return $result;
  }

  function saveToken($data)
  {
    $result = ["error" => "", "rows" => [], "row" => null];

    try {

      $cn = $this->conexion->getConexion();
      if($data['id']==null){
        $sql = "INSERT INTO tbl_genera_token(descrip_token,abreviatura_institucion,fecha_registro,fecha_limite)
          VALUES(:token,'API_DLC_DNI',now(),:fecha_exp)
        ";
      }else{
        $sql = "UPDATE tbl_genera_token SET 
          descrip_token = :token,          
          fecha_registro = now(),
          fecha_limite = :fecha_exp
          WHERE id = :id
        ";
      }

      //$id_usuario = $_SESSION["id_usuario"];
      $stmt = $cn->prepare($sql);
      $stmt->bindParam(":token", $data['token']);
      $stmt->bindParam(":fecha_exp", $data['fecha_exp']);
      if($data['id']) $stmt->bindParam(":id", $data['id']);

      $ok = $stmt->execute();
      if (!$ok) {
        $result["error"] = "No se pudo guardar los datos";
      }
    } catch (Exception $ex) {
      $cn = null;
      $result["error"] = "Error" . $ex->getMessage();
    }
    return $result;
  }
}
