<?php include 'layout-top.php' ?>

<form method='POST' action='<?=route('exemplo_upload/salvar/'._v($data,"id"))?>' enctype="multipart/form-data">


    <label class='col-md-6'>
        Nome
        <input type="text" class="form-control" name="nome" value="<?=old("nome",$data)?>" >
    </label>


    <label class='col-md-6'>
        Foto

        <?php if (_v($data,"id") != ""): ?>
            <br/>
            <img src="<?=base($data['foto'])?>" class="img-thumbnail" style='max-height:200px;'>
        <?php endif ?>

        <input type="file" class="form-control" name="foto" >
        <div class="form-text">Limite de 3mb e formatos aceitos: .png .jpg .jpeg e .gif</div>
    </label>



<button class='btn btn-primary col-12 col-md-3 mt-3'>Salvar</button>
<a class='btn btn-secondary col-12 col-md-3 mt-3' href="<?=route("exemplo_upload")?>">Novo</a>

</form>

<table class='table'>

    <tr>
        <th>Editar</th>
        <th>Nome</th>
        <th colspan="2">Foto</th>
        <th>Deletar</th>
    </tr>

    <?php foreach($lista['data'] as $item): ?>

        <tr>
            <td>
                <a href='<?=route("exemplo_upload/index/{$item['id']}")?>'>Editar</a>
            </td>
            <td><?=$item['nome']?></td>
            <td><?=$item['foto']?></td>
            <td><img src="<?=base($item['foto'])?>" style='height:50px;'></td>
            <td>
                <a href='<?=route("exemplo_upload/deletar/{$item['id']}")?>'>Deletar</a>
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