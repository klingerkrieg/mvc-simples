<?php include 'layout-top.php' ?>

<form method='POST' action='<?=route('usuarios/salvar/'._v($data,"id"))?>'>

<label class='col-md-6'>
    Nome
    <input type="text" class="form-control" name="nome" value="<?=old("nome",$data)?>" >
</label>

<label class='col-md-4'>
    E-mail
    <input type="text" class="form-control" name="email" value="<?=old("email",$data)?>" >
</label>

<label class='col-md-2'>
    Senha
    <input type="password" class="form-control" name="senha" >
</label>

<label class='col-md-2'>
    Confirmação da senha
    <input type="password" class="form-control" name="senhaConfirm" >
</label>

<label class='col-md-2'>
    Data de nascimento
    <input type="text" class="form-control" name="dataNascimento" value="<?=old("dataNascimento",$data)?>" >
</label>

<label class='col-md-2'>
    Ativado
    <input type="hidden" name="ativado" value="0">
    <input type="checkbox" class="form-check-input" name="ativado" value="1" <?=old("ativado",$data) == 1 ? 'checked' : '' ?> >
</label>

<label class='col-md-6'>
    Tipo
    <select name="tipo" class="form-control">
        <?php
        foreach($tipos as $k=>$tipo){
            old("tipo",$data) == $k ? $selected='selected' : $selected='';
            print "<option value='$k' $selected>$tipo</option>";
        }
        ?>
    </select>
</label>

<button class='btn btn-primary col-12 col-md-3 mt-3'>Salvar</button>
<a class='btn btn-secondary col-12 col-md-3 mt-3' href="<?=route("usuarios")?>">Novo</a>

</form>


<hr/>


<form method='GET' action='<?=route('usuarios/'._v($data,"id"))?>'>

    <div class='row align-items-end'>
        <div  class='col-md-4'>
            <label>
                Pesquisar
                <input type="text" class="form-control" name="search" value="<?=_v($_GET,"search")?>" >
            </label>
        </div>
        <div  class='col-md-4'>
            <button class='btn btn-primary col-12 col-md-3 mt-3'>Pesquisar</button>
        </div>
    </div>

    

</form>

<table class='table'>

    <tr>
        <th>Editar</th>
        <th>Nome</th>
        <th>Data de nascimento</th>
        <th>Deletar</th>
    </tr>

    <?php foreach($lista['data'] as $item): ?>

        <tr>
            <td>
                <a href='<?=route("usuarios/index/{$item['id']}")?>'>Editar</a>
            </td>
            <td><?=$item['nome']?></td>
            <td><?=$item['dataNascimento']?></td>
            <td>
                <a href='<?=route("usuarios/deletar/{$item['id']}")?>'>Deletar</a>
            </td>
        </tr>

    <?php endforeach; ?>

    <tr>
        <td colspan='10'>
            <?=htmlPagination($lista)?>
        </td>
    </tr>
</table>



<?php include 'layout-bottom.php' ?>