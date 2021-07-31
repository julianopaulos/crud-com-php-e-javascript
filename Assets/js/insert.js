async function sendFormMovimentacao(){
    const form = document.forms.form_movimentacao;
    const { pessoa, conta, valor, depositar_retirar } = form;
    if(!pessoa.value || !conta.value || !valor.value || !depositar_retirar.value){
        alert("Todos os campos devem estar preenchidos");
        return;
    }

    if(depositar_retirar.value === "retirar"){
        let saldo = await getSaldoContaPorId(conta.value);
        if(saldo && saldo < Number(valor.value)){
            alert("Saldo insuficiente para realizar a retirada!");
            form.reset();
            return;
        }
    }
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'insertMovimentacao',
            'pessoa_id': pessoa.value,
            'conta_id': conta.value,
            'valor': valor.value,
            'operacao': depositar_retirar.value
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        renderView("Pages/ListagemMovimentacao", {pessoa_id: pessoa.value, conta_id: conta.value});
        form.reset();
    })
    .catch(error=>console.error(error));
}


async function sendFormConta(){
    const form = document.forms.form_conta;
    const { pessoa, num_conta } = form;
    
    if(form.hasAttribute("data-operacao-editar")){
        sendFormContaEdicao();
        return;
    }

    if(!pessoa.value || !num_conta.value){
        alert("Todos os campos devem estar preenchidos");
        return;
    }
    let conta = await buscaContaPorNumero(num_conta.value);
    
    if(conta){
        alert("Número de conta já cadastrada!");
        form.reset();
        return;
    }
    
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'insertConta',
            'pessoa_id': pessoa.value,
            'num_conta': num_conta.value
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        renderView("Pages/ListagemConta");
        form.reset();
    })
    .catch(error=>console.error(error));
}

function sendFormPessoa(){
    const form = document.forms.form_pessoa;
    const { nome, cpf, endereco } = form;

    if(form.hasAttribute("data-operacao-editar")){
        sendFormPessoaEdicao();
        return;
    }

    if(!nome.value || !cpf.value || !endereco.value){
        alert("Todos os campos devem estar preenchidos");
        return;
    }
    let cpf_sem_formatacao = cpf.value.replace(/[^0-9]/g, "");
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'insertPessoa',
            'nome': nome.value,
            'cpf': cpf_sem_formatacao,
            'endereco': endereco.value
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        renderView("Pages/ListagemPessoa");
        form.reset();
    })
    .catch(error=>console.error(error));
}