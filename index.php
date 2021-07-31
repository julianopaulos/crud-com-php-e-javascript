<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial</title>
    <link rel="stylesheet" href="Assets/css/global.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
    <header>
        <ul class="header-list">
            <li id="Pessoa">
                Pessoa
            </li>
            <span class="pipe"></span>
            <li id="Conta">
                Conta
            </li>
            <span class="pipe"></span>
            <li id="Movimentacao">
                Movimentação
            </li>
        </ul>
    </header>

    <main class="container"></main>
    <section class="view"></section>

    <script src="./Assets/js/select.js"></script>
    <script src="./Assets/js/delete.js"></script>
    <script src="./Assets/js/update.js"></script>
    <script src="./Assets/js/insert.js"></script>
    <script src="./Assets/js/validacoes.js"></script>
    <script src="./Assets/js/renderizacao.js"></script>
</body>
</html>