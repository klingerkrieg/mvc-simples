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


function print_pdo_error($sql, $data=[]){
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

/** 
 * Essa função simula o envio de e-mail, salvando os e-mails enviados na pasta sent
*/
function send_email($assunto, $destino, $msg){
    global $last_email;
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: ".EMAIL_NAME." <".EMAIL_FROM.">";

    $html =  "<pre>". htmlentities($headers) ."</pre><hr/>" . $msg;
    if (!file_exists("./sent/"))
        mkdir("./sent");

    $last_email ="./sent/".date('Y-m-d_H.i.s').".html";
    file_put_contents($last_email, $html);

    return true;
    /*    
    $enviaremail = mail($destino, $assunto, $msg, $headers, "-Xeef5ef7cff2773:23e3de4fedb40b");
    if($enviaremail){
        return true;
    } else {
        return false;
    }*/
}

function get_last_email_sent(){
    if (!file_exists("./sent/"))
        return false;

    $files1 = scandir("./sent/", SCANDIR_SORT_DESCENDING);
    if (isset($files1[0]) && $files1[0] != "." && $files1[0] != ".."){
        return $files1[0];
    }
    return false;
}

function saveUpload($file, $output){

    if (!file_exists($output))
        mkdir($output);

    $newName = $file["name"];
    $i = 1;
    while(file_exists($output."/".$newName)){
        $name = substr($file["name"], 0, strrpos($file["name"], '.'));
        $ext = substr(strrchr($file["name"], '.'), 1);
        $newName = $name."[".$i."].$ext";
        $i++;
    }
    $out = str_replace("//","/",$output."/".$newName);
    move_uploaded_file($file["tmp_name"],$out);

    return $out;
}