<?php

    require_once __DIR__ . '/../../Database/Select.php';
    require_once __DIR__ . '/../../Utils/functions.php';

    $select = new Select();

    $pessoas = $select->getPessoas();
?>
<form class="form_conta" name="form_conta">
    <label for="pessoa" id="pessoa">
        Pessoa:
    </label>
    <select name="pessoa" id="pessoa">
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
    <label for="num_conta">
        Número da conta:
    </label>
    <input 
        type="text" 
        name="num_conta" 
        onchange="formataConta(this.value, this)" 
        id="num_conta" 
        required
        placeholder="Sua conta (somente números)"
        maxlength="10"
    >

    <button type="button" onclick="sendFormConta()" id="save_conta">Salvar</button>
</form>