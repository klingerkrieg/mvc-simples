<?php
use models\Foto;

class Exemplo_UploadController {

	function index($id = null){

		#variáveis que serao passados para a view
		$send = [];

		#cria o model
		$model = new Foto();
		
		
		$send['data'] = null;
		#se for diferente de nulo é porque estou editando o registro
		if ($id != null){
			#então busca o registro do banco
			$send['data'] = $model->findById($id);
		}

		#busca todos os registros
		$send['lista'] = $model->paginate();

		#chama a view
		render("exemplo-upload", $send);
	}

	
	function salvar($id=null){

		
		$model = new Foto();


		#Essa validacao será diferente
		
		#o campo nome sempre existirá, e sempre será validado
		$rules = [	"nome"=>["func"=>"validateRequired", "msg"=>"O campo Nome é obrigatório"]];

		#agora, se nao existir ID significa que é uma nova foto
		# obrigatoriamente a foto deve ser enviada
		# mas se a ID já existir então a foto não é obrigatória, o usuário pode querer alterar apenas o nome
		# nesse caso a validação só vai existir se uma foto tiver sido enviada, por isso o $_FILES['foto']["name"] != ""
		if ($id == null || $_FILES['foto']["name"] != ""){

			#adiciona a validacao na foto
			$rules["foto"] = [["func"=>"validateRequired", 		"msg"=>"O campo Foto é obrigatório"],
								["func"=>"validateFileExtension", 	"msg"=>"Formato de imagem não aceito.", "params"=>["png|jpg|jpeg|gif"]],
								["func"=>"validateFileSize", 		"msg"=>"Imagem maior que o tamanho máximo permitido.", "params"=>["3mb"]],
							];

		}
		#Após definir as regras a validacao segue normalmente
		
		#Neste caso estamos passando o array $_POST e o $_FILES para verificacao, 
		# pois os uploads vão em $_FILES mas também temos informações em $_POST
		validate($rules, array_merge($_POST,$_FILES), "Falha ao salvar a foto.");


		#cria o array que será salvo
		$dados = [];
		$dados["nome"] = $_POST["nome"];

		#so adiciona a imagem se tiver sido enviada
		if ($_FILES['foto']["name"] != "")
			$dados["foto"] = saveUpload($_FILES["foto"],"./uploads/");
		
		#salva
		if ($id == null){
			$id = $model->save($dados);
		} else {
			$id = $model->update($id, $dados);
		}
		
		redirect("exemplo_upload/index/$id");
	}

	function deletar(int $id){
		
		$model = new Foto();
		$model->delete($id);

		redirect("exemplo_upload/index/");
	}


}
