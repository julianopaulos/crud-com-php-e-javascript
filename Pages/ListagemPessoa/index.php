<?php

require_once __DIR__ . '/../../Database/Select.php';
require_once __DIR__ . '/../../Utils/functions.php';

$select = new Select();
$pessoas = $select->getPessoas();

?>
<table class="table_pessoa" border="1" cellpadding="15px" cellspacing="0">
    <thead>
        <tr>
            <td>
                Nome
            </td>
            <td>
                CPF
            </td>
            <td>
                Endereço
            </td>
            <td>
                Editar
            </td>
            <td>
                Remover
            </td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($pessoas as $pessoa) :
            extract($pessoa);
        ?>
            <tr>
                <td><?= $nome ?></td>
                <td><?= mask($cpf, "###.###.###-##") ?></td>
                <td><?= $endereco ?></td>
                <td>
                    <input type="radio" name="editar_excluir_pessoa" id="editar_pessoa" value="<?=$id?>">
                </td>
                <td>
                    <input type="radio" name="editar_excluir_pessoa" id="excluir_pessoa" value="<?=$id?>">
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>