<?php

    require_once __DIR__ . '/../../Database/Select.php';
    require_once __DIR__ . '/../../Utils/functions.php';

    $select = new Select();

    $pessoas = $select->getPessoasContasAgrupado();
?>
<form class="form_movimentacao" name="form_movimentacao">
    <label for="pessoa">
        Pessoa:
    </label>
    <select 
        name="pessoa" 
        id="pessoa"
        onchange="buscaContaPorPessoaId(this.value)"
    >
        <option></option>
        <optgroup label="Pessoas">
        <?php
            foreach($pessoas as $pessoa):
                extract($pessoa);
                ?>
                <option value="<?=$id?>"><?=$nome." - ".mask($cpf, "###.###.###-##")?></option>
                <?php
            endforeach;
        ?>
        </optgroup>
    </select>
    <label for="conta">
        Número da conta:
    </label>
    <select name="conta" id="conta">
        <option></option>
    </select>

    <label for="valor">
        Valor:
    </label>
    <input 
        type="text" 
        name="valor" 
        id="valor" 
        required
        onchange="formataValor(this.value, this)"
    >

    <label for="depositar_retirar">
        Depositar/Retirar:
    </label>
    <select name="depositar_retirar" id="depositar_retirar">
        <option></option>
        <option value="depositar">Depositar</option>
        <option value="retirar">Retirar</option>
    </select>

    <button type="button" onclick="sendFormMovimentacao()" id="save_movimentacao">Salvar</button>
</form>