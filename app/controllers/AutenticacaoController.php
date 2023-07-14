<?php
use models\Usuario;

class AutenticacaoController {

    private $home = "usuarios";

    function index(){

        if (isset($_SESSION['user'])){
            redirect($this->home);
            die();
        }

        #variáveis que serao passados para a view
        $send = [];
        #chama a view
        render("auth/login", $send);
    }


    function logar(){

        $model = new Usuario();
        #busca o usuario pelo email e senha
        $user = $model->findByEmailAndSenha($_POST["email"],  $_POST["senha"]);
    
        if ($user != null){
            #se encontrar salva na sessao
            $_SESSION['user'] = $user;
            redirect($this->home);
        } else {
            #caso contrario, manda para o login novamente
            $send = ["msg"=>"Login ou senha inválida"];
            render("auth/login", $send);
        }
    }

    function logout(){
        session_destroy();
        redirect("autenticacao");
    }


    function novo_usuario(){
		#cria o model
		$model = new Usuario();
		$send = ["data"=>[]];
		#chama a view
		render("auth/cadastro", $send);
	}

    function salvar_usuario(){
		$model = new Usuario();

		$rules = ["nome"=>["func"=>"validateRequired", "msg"=>"O campo Nome é obrigatório"], 
				  "email"=>[
							["func"=>"validateEmail", "msg"=>"O campo E-mail precisa ser um e-mail válido"],
                            ["func"=>"validateRequired", "msg"=>"O campo E-mail é obrigatório"],
                            ["func"=>"validateUnique", "msg"=>"Este E-mail já está sendo utilizado", "params"=>["usuarios.email"]],
				  		   ],
				  "senha" =>["func"=>"validateEqual", "msg"=>"A confirmação da senha não foi igual à senha digitada", "params"=>[$_POST["senhaConfirm"]]], 
				];
		validate($rules, $_POST, "Falha ao salvar usuário.");
		
		$id = $model->save($_POST);
		
		redirect("autenticacao");
	}
    

}
