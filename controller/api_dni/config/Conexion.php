<?php

class Conexion
{

	private $host = "10.0.0.3";
	private $user = "postgres";
	private $pass = "D1R1S@OGT1_postgres";
	private $bdname = "pe_dni";
	private $result = ["rows" => [], "cant_rows" => 0, "row" => null, "error" => null];

	function getConexion(){

		$conexion = null;

		try {
			$conexion = new PDO(
				"pgsql:host=" . $this->host . ";dbname=" .  strtolower($this->bdname),
				$this->user,
				$this->pass
			);

			//$conexion->exec("set names utf8");
			$conexion->setAttribute(
				PDO::ATTR_ERRMODE,
				PDO::ERRMODE_EXCEPTION
			);
		} catch (PDOException $e) {
			throw $e;
		}
		return $conexion;
	}

	function bindFilters(&$stmt, $data){

		foreach ($data as $key => &$value) {
			$pos =  strpos($key, ' ');
			$type = $pos ? substr($key, $pos + 1) : "";
			$key =  substr($key, 0, $pos ? $pos : strlen($key));
			$pdo_param = null;
			if ($value === null) $pdo_param = PDO::PARAM_NULL;
			switch ($type) {
				case 'int':$pdo_param = PDO::PARAM_INT;break;
				case 'bool':$pdo_param = PDO::PARAM_BOOL;break;
				case 'null':$pdo_param = PDO::PARAM_NULL;$value = null;break;
				default: $pdo_param = PDO::PARAM_STR;
			}

			if (($value || $value === 0) && ($key != 'filters_str' && $key != 'limit')) {
				$stmt->bindParam(":" . $key, $value, $pdo_param);
			}
		}

		if ($data && isset($data["start"]) && isset($data["length"])) {
//			$stmt->bindParam(":start",  $data["start"], PDO::PARAM_INT);
			$stmt->bindParam(":length", $data["length"], PDO::PARAM_INT);
		}
	}

	function bindProcedure(&$stmt, $data){
		//echo var_dump($data) . '</br>';
		foreach ($data as $key => &$value) {
			
			$pos =  strpos($key, ' ');
			$type = $pos ? substr($key, $pos + 1) : "";
			$key =  substr($key, 0, $pos ? $pos : strlen($key));
			$pdo_param = null;
			if ($value === null) $pdo_param = PDO::PARAM_NULL;
			/*switch($type){
				case 'int' : $pdo_param = PDO::PARAM_INT;break;
				case 'bool' : $pdo_param = PDO::PARAM_BOOL;break;
				case 'null' : $pdo_param = PDO::PARAM_NULL; $value = null; break;
				default : $pdo_param = PDO::PARAM_STR;
			}*/

			if (is_array($value)) {				
				$stmt->bindParam(":" . $key, $value, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 1024);
				continue;
			}

			if (($key != 'filters_str' && $key != 'limit')) {
				//echo $key.':'.gettype($value).'</br>';				
				if(gettype($value)=='boolean'){
					$stmt->bindParam(":" . $key, $value,PDO::PARAM_BOOL);
				}else if ($type == '') {
					$stmt->bindParam(":" . $key, $value);
				} else {
					$stmt->bindParam(":" . $key, $value, $pdo_param);
				}
			}
		}
	}
	
}











