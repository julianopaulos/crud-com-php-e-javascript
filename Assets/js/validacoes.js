function maskCPF(value, pattern, obj){
    let i = 0;
    if(value)value = value.replace(/[^0-9]/g, "");
    if(!isNaN(value) && value && value.length > 10){
        const v = value.toString();
        obj.value = pattern.replace(/#/g, () => v[i++] || '');
    }else{
        obj.value = "";
        alert("Digite corretamente o seu CPF");
    }
}

function formataNome(nomeCompleto, obj){
    if(!nomeCompleto)return;
    nomeCompleto = nomeCompleto.replace(/[0-9]/g, "");
    let arr = nomeCompleto.toLowerCase().split(" ");
    arr.forEach((name, index) => {
        if(name.length > 0)arr[index] = name[0].toUpperCase() + name.substring(1, name.length);
    });
    obj.value = arr.join(" ");
}

function formataValor(valor, obj){
    valor = valor.replace(".", "").replace(",", ".");
    if(valor.length === 0 || valor === 0 || isNaN(valor)){
        obj.value = "";
        return;
    }
    obj.value = valor;
}


function formataConta(numeroConta, obj){
    numeroConta = numeroConta.replace(/[^0-9]/g, "");
    if(numeroConta.length !== 10){
        obj.value = "";
        return;
    }
    obj.value = numeroConta;
}