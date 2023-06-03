<?php include 'layout-top.php' ?>



<form method='POST' action='<?=route('usuarios/salvar/'._v($data,"id"))?>'>

<label class='col-md-6'>
    Nome <span style='color:red;'>*</span>
    <input type="text" class="form-control <?=hasError("nome","is-invalid")?>" name="nome" value="<?=old("nome", _v($data,"nome"))?>" >
    <div class='invalid-feedback'><?=getValidationError("nome") ?></div>
</label>

<label class='col-md-4' style='position:relative'>
    Data de nascimento <span style='color:red;'>*</span>
    <input type="text" class="form-control <?=hasError("dataNascimento","is-invalid")?>" name="dataNascimento" value="<?=old("dataNascimento", _v($data,"dataNascimento"))?>" >

    <!-- para esse formato funcionar, o parent tem que ser relative -->
    <div class="invalid-tooltip"><?=getValidationError("dataNascimento") ?></div>
</label>

<label class='col-md-2'>
    Ativado
    <input type="hidden" name="ativado" value="0">
    <input type="checkbox" class="form-check-input" name="ativado" value="1" <?=_v($data,"ativado") == 1 ? 'checked' : '' ?> >
</label>

<label class='col-md-6'>
    Tipo
    <select name="tipo" class="form-control">
        <?php
        foreach($tipos as $k=>$tipo){
            _v($data,"tipo") == $k ? $selected='selected' : $selected='';
            print "<option value='$k' $selected>$tipo</option>";
        }
        ?>
    </select>
</label>

<button class='btn btn-primary col-12 col-md-3 mt-3'>Salvar</button>
<a class='btn btn-secondary col-12 col-md-3 mt-3' href="<?=route("usuarios")?>">Novo</a>

</form>

<table class='table'>

    <tr>
        <th>Editar</th>
        <th>Nome</th>
        <th>Data de nascimento</th>
        <th>Deletar</th>
    </tr>

    <?php foreach($lista as $item): ?>

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
</table>

<?php include 'layout-bottom.php' ?>