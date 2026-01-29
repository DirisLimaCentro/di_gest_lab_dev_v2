<?php

class Utilitario
{

    static function generarFiltros($data,$data_filters,$extra_filter = []){
        $filters = [];
        foreach( $data as $key => $value ){
            $key = explode(" " , $key)[0];
            //echo var_dump( $key ) . " " . var_dump( $value === 0 || $value );
            if(($value === 0 || $value) && isset($data_filters[$key])) $filters[] = $data_filters[$key];
        }
        $filters = array_merge($filters, $extra_filter);
        return count($filters) > 0 ? "WHERE " . implode(" AND ",$filters) : "";
    }

    static function getRequestParam($param,$options=[]){
        
        //opciones de devolucion de datos
        $options["upper"] = isset($valid_params["upper"]) ? $valid_params["upper"] : true;  //t: devuelve el valor en mayusculas
        $options["rnull"] = isset($valid_params["rnull"]) ? $valid_params["rnull"] : false; //t: devuelve null en lugar de string vacio              
        $options["rint"] = isset($valid_params["rint"]) ? $valid_params["rint"] : false;  //t: devuelve el dato como tipo int
        $options["rnum"] = isset($valid_params["rnum"]) ? $valid_params["rnum"] : false;  //t: devuelve el dato como tipo float

        //opciones de validacion:
        $options["isnum"] = isset($valid_params["isnum"]) ? $valid_params["isnum"] : true;  //t: valida si el valor es numerico
        $options["isreq"] = isset($valid_params["isreq"]) ? $valid_params["isreq"] : true;  //t: valida si el valor es requerido

        /*Pendiende de desarrollo*/

        $value = isset($_REQUEST[$param]) ? $_REQUEST [$param] : "";
        //return $upper === true ? strtoupper($value) : $value;

    }

    static function getParam($param,$upper = true){
        $value = isset($_REQUEST[$param]) ? $_REQUEST [$param] : "";
        return $upper === true ? mb_strtoupper($value) : $value;
    }
    
    static function getIntParam($param){
        $value = isset($_REQUEST [$param]) ? $_REQUEST[$param] : null;
        if($value === ""){ $value = null;}
        else if(is_numeric($value)){ $value = (int)$value; }
        return $value;
    }

    static function getSearch(){        
        $search_arr = isset($_REQUEST["search"]) ? $_REQUEST ["search"] : [];
        return isset($search_arr["value"]) ? $search_arr["value"] : "";
    }

    static function validParamValue( $param, $text_param , $valid_params = []){

        $value = Utilitario::getParam($param);

        $vp["required"] = isset($valid_params["required"]) ? $valid_params["required"] : true;

        if( $vp["required"] == true && ( $value == null || $value == "" )){
            throw new Exception("El campo $text_param es obligatorio.");
        }        
    }

    static function getArray($set){
        settype($set, 'array'); // can be called with a scalar or array
        $result = array();
        foreach ($set as $t) {
            if (is_array($t)) {
                $result[] = self::getArray($t);
            } else {
                $t = str_replace('"', '\\"', $t); // escape double quote
                if (!is_numeric($t)) // quote only non-numeric values
                    $t = '"' . $t . '"';
                $result[] = $t;
            }
        }
        return '{' . implode(",", $result) . '}'; // format
    }



}