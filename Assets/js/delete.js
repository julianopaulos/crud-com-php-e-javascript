async function excluirConta(idConta, obj){
    if(!confirm("Deseja realmente excluir essa conta?")){
        obj.checked = false;
        return;
    }

    let movimentacao = await buscaMovimentacaoPorConta(idConta);
    
    if(movimentacao){
        alert("Essa conta não pode ser excluída, por tem movimentações!");
        obj.checked = false;
        return;
    }
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'deletarConta',
            'conta_id': idConta
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        renderView("Pages/ListagemConta");
    })
    .catch(error=>console.error(error));
}

function excluirPessoa(idPessoa, obj){
    if(!confirm("Deseja realmente excluir essa pessoa?")){
        obj.checked = false;
        return;
    }
    axios({
        method: 'post',
        url: 'Controller/Controller.php',
        data: {
            'mode': 'deletarPessoa',
            'pessoa_id': idPessoa
        }
    })
    .then(response => {
        if(response.data.error){
            alert(response.data.error);
            return;
        }
        renderView("Pages/ListagemPessoa");
    })
    .catch(error=>console.error(error));
}