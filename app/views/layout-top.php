<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVC Simples</title>

    <link rel="stylesheet" href="<?=assets('bootstrap/css/bootstrap.min.css')?>" />
    <script src="<?=assets('bootstrap/js/bootstrap.bundle.min.js')?>" ></script>
	<script src="<?=assets('js/jquery.js')?>" ></script>
	<script src="<?=assets('js/jquery.mask.min.js')?>" ></script>
	<script src="<?=assets('js/form.js')?>" ></script>

    <link rel="stylesheet" href="<?=assets('css/estilo.css')?>" />
</head>
<body>

<!-- MENU -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?=route('')?>">Documentação</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?=route('usuarios')?>">Usuários</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?=route('exemplo_upload')?>">Exemplo de Upload</a>
        </li>

        <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?=route('autenticacao/logout')?>">Deslogar</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container">

<?php
#Apresenta as mensagens flash
if (getFlash("success")){
    print "<div class='alert alert-success' role='alert'>".getFlash("success")."</div>";
} else
if (getFlash("error")){
    print "<div class='alert alert-danger' role='alert'>".getFlash("error")."</div>";
}

#Apresenta as mensagens de validacao
if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0){
    print '<div class="alert alert-danger" role="alert">';
    foreach ($_SESSION['errors'] as $erros){
        print "<div>$erros</div>";
    }
    print '</div>'; 
}
?>