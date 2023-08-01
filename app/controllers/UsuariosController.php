<?php
use models\Usuario;

/**
* Tutorial CRUD
* Autor:Alan Klinger 05/06/2017
*/

#A classe devera sempre iniciar com letra MAIÚSCULA
#terá sempre o mesmo nome do arquivo
#e precisa terminar com a palavra Controller
class UsuariosController {

	/**
	* Para acessar http:#localhost/NOMEDOPROJETO/usuarios/index
	**/
	function index($id = null){

		#variáveis que serao passados para a view
		$send = [];

		#cria o model
		$model = new Usuario();
		
		$send['data'] = null;
		#se for diferente de nulo é porque estou editando o registro
		if ($id != null){
			#então busca o registro do banco
			$send['data'] = $model->findById($id);
		}

		#busca todos os registros com base no filtro
		$model->addPaginateFilter($_GET);
		$send['lista'] = $model->paginate();


		$send['tipos'] = [0=>"Escolha uma opção", 1=>"Usuário comum", 2=>"Admin"];

		#chama a view
		render("usuarios", $send);
	}

	
	function salvar($id=null){

		$model = new Usuario();

		#Para fazer a validacao basta seguir o modelo
		#func = funcao que será chamada para validar
		#msg = mensagem de erro
		#params = um array com um ou vários outros valores que serão utilizados na funcao de validacao
		#O mesmo campo pode ter mais de uma validacao, conforme o exemplo no email

		#Verifique as validações existentes em app/sys/validations.php
		$rules = ["nome"=>["func"=>"validateRequired", "msg"=>"O campo Nome é obrigatório"], 
				  "dataNascimento"=>["func"=>"validateDate", "msg"=>"O campo Data precisa ser uma data válida", "params"=>['d/m/Y']], 
				  "email"=>[
							["func"=>"validateEmail", "msg"=>"O campo E-mail precisa ser um e-mail válido"],
				  			["func"=>"validateRequired", "msg"=>"O campo E-mail é obrigatório"],
							["func"=>"validateUnique", "msg"=>"Este E-mail já está sendo utilizado", "params"=>["usuarios.email"]],
				  		   ],
				  "senha" =>["func"=>"validateEqual", "msg"=>"A confirmação da senha não foi igual à senha digitada", "params"=>[$_POST["senhaConfirm"]]], 
				];
		#Após definir as regras, basta chamar a funcao validate passando as regras e o array que será verificado
		#O último parâmetro com a mensagem de erro é opcional
		#Caso a validacao falhe, o usuário será redirecionado de volta para o formulário
		validate($rules, $_POST, "Falha ao salvar usuário.");
		
		if ($id == null){
			$id = $model->save($_POST);
		} else {
			$id = $model->update($id, $_POST);
		}
		
		redirect("usuarios/index/$id");
	}

	function deletar(int $id){
		
		$model = new Usuario();
		$model->delete($id);

		redirect("usuarios/index/");
	}


}
