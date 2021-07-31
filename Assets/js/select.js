
function buscaContaPorPessoaId(pessoaId){
    
    if(!pessoaId)return;
    let select_num_conta = document.getElementById("conta");
    while(select_num_conta.options.length > 1){
        for(let i=0; i<select_num_conta.options.length; i++){
            if(select_num_conta.options[i].value)select_num_conta.options[i].remove()
        }
    }
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'getContaPorPessoa',
            'pessoa_id': pessoaId
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        response.data.forEach(conta => {
            let option = document.createElement("option");
            option.value = conta.id;
            option.text = conta.num_conta + " - Saldo: R$" + conta.saldo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            select_num_conta.add(option);
        });
        select_num_conta.selectedIndex = select_num_conta.options.length -1;
    })
    .catch(error=>console.error(error));
}

async function getSaldoContaPorId(contaId){
    let saldo = 0;
    if(!contaId)return retorno;
    await axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'getSaldoConta',
            'conta_id': contaId
        }
    })
    .then(response => {
        if(!response.data){
            return;
        };
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        saldo = response.data;
        return;
    })
    .catch(error=>console.error(error));
    return saldo;
}

async function buscaContaPorNumero(numConta){
    let retorno = false;
    if(!numConta)return retorno;
    await axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'getContaPorNumero',
            'num_conta': numConta
        }
    })
    .then(response => {
        if(!response.data){
            retorno = false;
            return;
        };
        if(response.data.error){
            retorno = true;
            alert(response.data.error);
            return;
        }
        retorno = true;
        return;
    })
    .catch(error=>console.error(error));
    return retorno;
}


async function buscaMovimentacaoPorConta(contaId){
    let retorno = false;
    if(!contaId)return retorno;
    await axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'getMovimentacaoPorConta',
            'conta_id': contaId
        }
    })
    .then(response => {
        if(!response.data){
            retorno = false;
            return;
        };
        if(response.data.error){
            retorno = true;
            alert(response.data.error);
            return;
        }
        console.log(response.data);
        if(response.data === "0"){
            retorno = false;
            return;
        }
        retorno = true;
        return;
    })
    .catch(error=>console.error(error));
    return retorno;
}


function editarPessoa(idPessoa){
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'getPessoaPorId',
            'pessoa_id': idPessoa
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        const form = document.forms.form_pessoa;
        const { nome, cpf, endereco } = form;
        nome.value = response.data.nome;
        cpf.value = response.data.cpf;
        endereco.value = response.data.endereco;
        form.setAttribute('data-operacao-editar', idPessoa);
    })
    .catch(error=>console.error(error));
}

function editarConta(idConta){
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'getContaPorId',
            'conta_id': idConta
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        const form = document.forms.form_conta;
        const { pessoa, num_conta } = form;
        document.querySelectorAll("#pessoa optgroup option").forEach(option => {
            if(option.value === response.data.pessoa_id){
                option.selected = true;
            }
        })
        num_conta.value = response.data.num_conta;
        form.setAttribute('data-operacao-editar', idConta);
    })
    .catch(error=>console.error(error));
}

