<?php
    require_once __DIR__ . '/Conn/Conn.php';
    require_once __DIR__ . '/Select.php';
    require_once __DIR__ . '/Update.php';
    class Insert{
        private $connection;
        private $sql;
        private $query;
        private $select;
        private $update;
        function __construct(){
            $conn = new Conn();
            $this->connection = $conn->getConn();
            $this->select = new Select();
            $this->update = new Update();
        }

        public function insertPessoa(string $nome, int $cpf, string $endereco){
            $this->sql = "
                INSERT INTO 
                    `pessoas`(`nome`, `cpf`, `endereco`)
                VALUES(:nome, :cpf, :endereco)
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":nome", $nome, \PDO::PARAM_STR);
                $this->query->bindParam(":cpf", $cpf, \PDO::PARAM_INT);
                $this->query->bindParam(":endereco", $endereco, \PDO::PARAM_STR);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            return ["msg"=>"Pessoa cadastrada com sucesso!"];
        }

        public function insertConta(int $pessoa_id, int $num_conta){
            echo $pessoa_id." teste ".$num_conta;
            $this->sql = "
                INSERT INTO 
                    `contas`(`pessoa_id`, `num_conta`)
                VALUES(:pessoaId, :numConta)
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":pessoaId", $pessoa_id, \PDO::PARAM_INT);
                $this->query->bindParam(":numConta", $num_conta, \PDO::PARAM_INT);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            return ["msg"=>"Conta cadastrada com sucesso!"];
        }

        public function insertMovimentacao(int $pessoa_id, int $conta_id, string $valor, string $tipo_operacao){
            $this->sql = "
                INSERT INTO 
                    `movimentacoes`(`pessoa_id`, `conta_id`, `valor`, `tipo_operacao`, `data`)
                VALUES(:pessoaId, :contaId, :valor, :tipoOperacao, NOW())
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":pessoaId", $pessoa_id, \PDO::PARAM_INT);
                $this->query->bindParam(":contaId", $conta_id, \PDO::PARAM_INT);
                $this->query->bindParam(":valor", $valor, \PDO::PARAM_STR);
                $this->query->bindParam(":tipoOperacao", $tipo_operacao, \PDO::PARAM_STR);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            
            return ["msg"=>"Movimentação cadastrada com sucesso!"];
        }

        public function insertSaldoMovimentacoes($movimentacao_id, $saldo){
            $this->sql = "
                INSERT INTO 
                    `saldo_movimentacoes`(`movimentacao_id`, `saldo`)
                VALUES(:movimentacaoId, :saldo)
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":movimentacaoId", $movimentacao_id, \PDO::PARAM_INT);
                $this->query->bindParam(":saldo", $saldo, \PDO::PARAM_STR);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            return ["msg"=>"Movimentação cadastrada com sucesso!"];
        }
    }