<?php

function validate($allRules, $data, $flashMessage=null){
    //percorre todas as regras
    foreach($allRules as $field=>$options){

        //caso so tenha uma regra, transforma ela num array com apenas um elemento
        if (array_key_exists("func",$options)){
            $options = [$options];
        }

        //percorre o array
        foreach($options as $option){

            if (!array_key_exists("params",$option)){
                $option["params"] = [];
            }

            if (!isset($data[$field])){
                setValidationError($field, "O campo '$field' não foi enviado. Verifique se esse campo realmente existe no formulário, pois ele consta na validação.");
            } else {

                //chama a funcao de validacao
                $result = $option["func"]($data[$field], ...$option["params"]);

                if ($result == false){
                    //se der falha
                    setValidationError($field, $option["msg"]);
                }
            }
            
        }

    }

    #se alguma validação tiver falhado
    if (count($_SESSION['errors'])){
        if ($flashMessage){
            setFlash("error",$flashMessage);
        }
        #volta para a página que estava
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

}


function setValidationError($field, $msg){
    if (!isset($_SESSION['errors'])){
        $_SESSION['errors'] = [];
    }
    $_SESSION['errors'][$field] = $msg;
}

function hasError($field, $return){
    if (isset($_SESSION['errors']) && isset($_SESSION['errors'][$field])){
        if ($return)
            return $return;
        else
            return true;
    } else {
        if ($return)
            return "";
        else
            return false;
    }
}

function getValidationError($field){
    if (isset($_SESSION['errors']) && isset($_SESSION['errors'][$field])){
        $msg = $_SESSION['errors'][$field];
        unset($_SESSION['errors'][$field]);
        return $msg;
    }
}

function validateRequired($value){
    if ( trim($value) == ""){
        return false;
    }
    return true;
}

function validateDate($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

//https://stackoverflow.com/questions/12026842/how-to-validate-an-email-address-in-php
function validateEmail($email) {
    $v = "/[a-zA-Z0-9_-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";
    return (bool)preg_match($v, $email);
}

//https://programadoresdepre.com.br/script-para-validar-cpf-em-php/
function validateCPF($cpf) {
    // Verifica se o número foi informado
    if(empty($cpf)) {
        return false;
    }
 
    // Elimina possível máscara
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
     
    // Verifica se o número de dígitos informados é igual a 11
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se nenhuma das sequências inválidas abaixo
    // foi digitada. Caso afirmativo, retorna falso
    else if ($cpf == '00000000000' || 
        $cpf == '11111111111' || 
        $cpf == '22222222222' || 
        $cpf == '33333333333' || 
        $cpf == '44444444444' || 
        $cpf == '55555555555' || 
        $cpf == '66666666666' || 
        $cpf == '77777777777' || 
        $cpf == '88888888888' || 
        $cpf == '99999999999') {
        return false;
     // Calcula os dígitos verificadores para verificar se o
     // CPF é válido
     } else {   
         
        for ($t = 9; $t < 11; $t++) {
             
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
 
        return true;
    }
}

function validateEqual($str1, $str2){
    return $str1 == $str2;
}