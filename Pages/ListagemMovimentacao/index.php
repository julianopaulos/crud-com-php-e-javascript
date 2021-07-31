<?php

require_once __DIR__ . '/../../Database/Select.php';

$select = new Select();

$pessoas_movimentacoes = $select->getPessoasMovimentacoesByPessoaId($_GET['pessoa_id'], $_GET['conta_id']);

?>
<h3>Extrato</h3>
<table class="table_movimentacao" border="1" cellpadding="15px" cellspacing="0" width="40%">
    <thead>
        <tr>
            <td>
                Data
            </td>
            <td>
                Valor
            </td>
        </tr>
    </thead>
    <tbody>
        <?php
        $saldo_final = 0;
        foreach ($pessoas_movimentacoes as $pessoas_movimentacao) :
            extract($pessoas_movimentacao);
            $date = new DateTime($data);
        ?>
            <tr class="<?=($tipo_operacao === "retirar")?"red_line":""?>">
                <td><?= $date->format('d/m/Y H:i:s') ?></td>
                <td><?= ($tipo_operacao === "depositar")?$valor:-$valor ?></td>
            </tr>
        <?php
            if($tipo_operacao === "depositar"){
                $saldo_final += $saldo;
            }else{
                $saldo_final -= $saldo;
            }
            
        endforeach;
        ?>
    </tbody>
</table>
<h3>Saldo: R$<?=number_format($saldo_final, 2, ",", ".")?></h3>