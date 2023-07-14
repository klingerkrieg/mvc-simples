<?php

/**
* Funcao para pegar um valor de um array de forma segura
* sem dar erro caso nao exista
* $arr $key
*/
function _v($arr,$val){
	if (isset($arr[$val])){
		return $arr[$val];	
	} else {
		return "";	
	}
}

function dd($arr){
    print "<pre>";
    print_r($arr);
    print "</pre>";
    die();
}

/**
* AmericanDate to PtBrDate
*/
function dateToBr($date = ""){
    if ($date == ""){
        return "";
    }
    
    $date = date_create_from_format('Y-m-d',$date);
    return date_format($date, 'd/m/Y');
}

/**
* AmericanDate to PtBrDate
*/
function dateToEUA($date = ""){
    if ($date == ""){
        return "";
    }
    
    $date = date_create_from_format('d/m/Y', $date);
    return date_format($date, 'Y/m/d');
}


function old($field, $default=null){
    //se for array usa o mesmo field como chave
    if (is_array($default)){
        return _v($default,$field);
    }

    if (isset($_SESSION['old']) && isset($_SESSION['old'][$field])){
        return $_SESSION['old'][$field];
    } else {
        return $default;
    }
}


function setFlash($key, $msg){
    if (!isset($_SESSION['flash'])){
        $_SESSION['flash'] = [];
    }

    $_SESSION['flash'][$key] = ["msg"=>$msg, "out"=>false];
}

function getFlash($key){
    if (isset($_SESSION['flash']) && isset($_SESSION['flash'][$key])){
        $_SESSION['flash'][$key]["out"] = true;
        return $_SESSION['flash'][$key]["msg"];
    } else {
        return "";
    }
}


function print_pdo_error($sql, $data){
    global $DEBUG_MODE;
    global $pdo;

    if ($DEBUG_MODE) {
        foreach($data as $key=>$value){
            $sql = str_replace($key, '\'' . str_replace('\'', '\\\'', $value) . '\'', $sql);
        }

        $msg = $pdo->errorInfo();
        print "<div class='codeError'>$sql<br/><br/>{$msg[2]}</div>";
    }
}