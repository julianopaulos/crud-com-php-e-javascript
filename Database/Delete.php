<?php
    require_once __DIR__ . '/Conn/Conn.php';
    class Delete{
        private $connection;
        private $sql;
        private $query;
        function __construct(){
            $conn = new Conn();
            $this->connection = $conn->getConn();
        }

        public function deletePessoa(int $pessoa_id){
            $this->sql = "
                DELETE FROM `pessoas` WHERE id = :pessoaId
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":pessoaId", $pessoa_id, \PDO::PARAM_INT);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            return ["msg"=>"Pessoa deletada com sucesso!"];
        }


        public function deleteConta(int $conta_id){
            $this->sql = "
                DELETE FROM `contas` WHERE id = :contaId
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":contaId", $conta_id, \PDO::PARAM_INT);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            return ["msg"=>"Conta deletada com sucesso!"];
        }

    }