<?php
    require_once __DIR__ . '/Conn/Conn.php';
    class Update{
        private $connection;
        private $sql;
        private $query;
        function __construct(){
            $conn = new Conn();
            $this->connection = $conn->getConn();
        }

        public function updateConta($conta_id, $pessoa_id, $num_conta){
            
            $this->sql = "
                UPDATE `contas`
                SET 
                    pessoa_id = :pessoaId,
                    num_conta = :numConta
                WHERE id = :contaId
            ";

            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":pessoaId", $pessoa_id, \PDO::PARAM_INT);
                $this->query->bindParam(":numConta", $num_conta, \PDO::PARAM_INT);
                $this->query->bindParam(":contaId", $conta_id, \PDO::PARAM_INT);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            return ["msg"=>"Dados alterados com sucesso!"];
        }

        public function updatePessoa($pessoa_id, $nome, $cpf, $endereco){
            
            $this->sql = "
                UPDATE `pessoas`
                SET 
                    nome = :nome,
                    cpf = :cpf,
                    endereco = :endereco
                WHERE id = :pessoaId
            ";
            
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":pessoaId", $pessoa_id, \PDO::PARAM_INT);
                $this->query->bindParam(":nome", $nome, \PDO::PARAM_STR);
                $this->query->bindParam(":cpf", $cpf, \PDO::PARAM_STR);
                $this->query->bindParam(":endereco", $endereco, \PDO::PARAM_STR);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            return ["msg"=>"Dados alterados com sucesso!"];
        }
    }