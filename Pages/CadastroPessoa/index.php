<form class="form_pessoa" name="form_pessoa">
    <label for="nome">
        Nome:
    </label>
    <input 
        type="text" 
        name="nome" 
        onchange="formataNome(this.value, this)" 
        id="nome" 
        required
        placeholder="Seu nome"
    >
    <label for="cpf">
        CPF:
    </label>
    <input 
        type="text" 
        name="cpf" 
        id="cpf"
        onchange="maskCPF(this.value, '###.###.###-##', this)" 
        required
        placeholder="Seu CPF (somente números)"
        maxlength="14"
    >
    <label for="endereco">
        Endereço
    </label>
    <input 
        type="text" 
        name="endereco" 
        id="endereco" 
        placeholder="Seu endereço"
        required
    >
    
    <button 
        type="button" 
        onclick="sendFormPessoa()" 
        id="save_pessoa"
    >
        Salvar
    </button>
</form>