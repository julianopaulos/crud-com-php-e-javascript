function renderForm(elementId) {
    removeAllchieldren();
    let url = getUrl(elementId);
    axios.get(url)
    .then(response => {
        document.querySelector(".container").innerHTML = response.data;
    })
    .catch(error => console.log(error));
}

function renderView(viewName, getParams = {}){
    axios.get(viewName, {params: getParams})
    .then(response => {
        document.querySelector(".view").innerHTML = response.data;
        document.querySelectorAll(".view .table_conta input[type=radio]").forEach(input => {
            if(input.id === "editar_conta"){
                input.addEventListener('change', () => editarConta(input.value));
            }else{
                input.addEventListener('change', () => excluirConta(input.value, input));
            }
        });
        document.querySelectorAll(".view .table_pessoa input[type=radio]").forEach(input => {
            if(input.id === "editar_pessoa"){
                input.addEventListener('change', () => editarPessoa(input.value));
            }else{
                input.addEventListener('change', () => excluirPessoa(input.value, input));
            }
        });
    })
    .catch(error => console.log(error));
}

function getUrl(elementId){
    let url;
    switch(elementId){
        case "Pessoa":
            url = "Pages/CadastroPessoa";
            renderView("Pages/ListagemPessoa");
        break;
        case "Conta":
            url = "Pages/CadastroConta";
            renderView("Pages/ListagemConta");
        break;
        case "Movimentacao":
            url = "Pages/CadastroMovimentacao";
        break;
    }
    return url;
}

document.querySelectorAll(".header-list li").forEach(element => {
    element.addEventListener("click", ()=>renderForm(element.id));
});

function removeAllchieldren(){
    let views = document.querySelector(".view");
    for (child of views.children){
        child.remove();
    }
}


window.onload = function(){
    renderForm("Pessoa");
}
