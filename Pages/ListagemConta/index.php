<?php

require_once __DIR__ . '/../../Database/Select.php';
require_once __DIR__ . '/../../Utils/functions.php';

$select = new Select();
$pessoas_contas = $select->getPessoasContas();

?>
<table class="table_conta" border="1" cellpadding="15px" cellspacing="0">
    <thead>
        <tr>
            <td>
                Nome
            </td>
            <td>
                CPF
            </td>
            <td>
                Conta
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
        foreach ($pessoas_contas as $pessoas_conta) :
            extract($pessoas_conta);
        ?>
            <tr>
                <td><?= $nome ?></td>
                <td><?= mask($cpf, "###.###.###-##") ?></td>
                <td><?= $num_conta ?></td>
                <td>
                    <input type="radio" name="editar_excluir_conta" id="editar_conta" value="<?=$conta_id?>">
                </td>
                <td>
                    <input type="radio" name="editar_excluir_conta" id="excluir_conta" value="<?=$conta_id?>">
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>