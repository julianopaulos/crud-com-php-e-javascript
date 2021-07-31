function sendFormPessoaEdicao(){
    const form = document.forms.form_pessoa;
    const { nome, cpf, endereco } = form;
    if(!nome.value || !cpf.value || !endereco.value){
        alert("Todos os campos devem estar preenchidos");
        return;
    }
    let cpf_sem_formatacao = cpf.value.replace(/[^0-9]/g, "");
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'editarPessoa',
            'pessoa_id': form.getAttribute("data-operacao-editar"),
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



function sendFormContaEdicao(){
    const form = document.forms.form_conta;
    const { pessoa, num_conta } = form;
    if(!pessoa.value || !num_conta.value){
        alert("Todos os campos devem estar preenchidos");
        return;
    }
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'editarConta',
            'conta_id': form.getAttribute("data-operacao-editar"),
            'pessoa_id': pessoa.value,
            'num_conta': num_conta.value
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        form.removeAttribute("data-operacao-editar");
        renderView("Pages/ListagemConta");
        form.reset();
    })
    .catch(error=>console.error(error));
}