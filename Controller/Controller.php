<?php
    $_POST = json_decode(file_get_contents("php://input"),true);

    require_once __DIR__ . '/../Database/Insert.php';
    require_once __DIR__ . '/../Database/Update.php';
    require_once __DIR__ . '/../Database/Delete.php';
    require_once __DIR__ . '/../Database/Select.php';
    
    $insert = new Insert();
    $select = new Select();
    $update = new Update();
    $delete = new Delete();
    
    switch($_POST['mode']){
        case "insertPessoa":
            echo json_encode($insert->insertPessoa($_POST['nome'], $_POST['cpf'], $_POST['endereco']));
        break;
        case "insertConta":
            
            echo json_encode($insert->insertConta($_POST['pessoa_id'], $_POST['num_conta']));
        break;
        case "insertMovimentacao":
            echo json_encode($insert->insertMovimentacao($_POST['pessoa_id'], $_POST['conta_id'], $_POST['valor'], $_POST['operacao']));
        break;
        

        case "editarConta":
            echo json_encode($update->updateConta($_POST['conta_id'], $_POST['pessoa_id'], $_POST['num_conta']));
        break;
        case "editarPessoa":
            echo json_encode($update->updatePessoa($_POST['pessoa_id'], $_POST['nome'], $_POST['cpf'], $_POST['endereco']));
        break;


        case "deletarConta":
            echo json_encode($delete->deleteConta($_POST['conta_id']));
        break;
        case "deletarPessoa":
            echo json_encode($delete->deletePessoa($_POST['pessoa_id']));
        break;


        case "getContaPorPessoa":
            echo json_encode($select->getPessoaContaByPessoaId($_POST['pessoa_id']));
        break;
        case "getPessoaPorId":
            echo json_encode($select->getPessoaPorId($_POST['pessoa_id']));
        break;
        case "getContaPorId":
            echo json_encode($select->getContaById($_POST['conta_id']));
        break;
        case "getContaPorNumero":
            echo json_encode($select->getContaByNumero($_POST['num_conta']));
        break;
        case "getMovimentacaoPorConta":
            echo json_encode($select->getMovimentacaoPorConta($_POST['conta_id']));
        break;
        case "getSaldoConta":
            echo json_encode($select->getSaldoConta($_POST['conta_id']));
        break;
        default:
            echo json_encode(["error" => "Método inexistente!"]);
    }