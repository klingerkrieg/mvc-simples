<?php include 'app/views/layout-top.php' ?>

<form method='POST' action='<?=route('autenticacao/logar/')?>'>

    <label class='col-md-4'>
        E-mail
        <input type="text" class="form-control" name="email" value="<?=old("email")?>" >
    </label>

    <label class='col-md-4'>
        Senha
        <input type="password" class="form-control" name="senha" >
    </label>

    <button class='btn btn-primary col-12 col-md-3 mt-3'>Entrar</button>
    <br/>
    <a class='col-12 col-md-3 mt-3' href="<?=route("autenticacao/recuperar_senha")?>">Esqueci a minha senha</a>
    <a class='col-12 col-md-3 mt-3' href="<?=route("autenticacao/novo_usuario")?>">Novo cadastro</a>

</form>

<?php

if ($_GET['show_last_email'] == 1){
    <script>
    window.open('https://javascript.info/');
    </script>
}

?>

<?php include 'app/views/layout-bottom.php' ?>
