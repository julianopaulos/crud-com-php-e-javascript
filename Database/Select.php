<?php
    require_once __DIR__ . '/Conn/Conn.php';
    class Select{
        private $connection;
        private $sql;
        private $query;
        private $results;
        function __construct(){
            $conn = new Conn();
            $this->connection = $conn->getConn();
        }

        public function getPessoas(){
            $this->sql = "
                SELECT
                    *
                FROM
                    pessoas
                ORDER BY id
            ";
            $this->query = $this->connection->prepare($this->sql);
            
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            $this->results = $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $this->results;
        }

        public function getPessoaPorId(int $pessoa_id){
            $this->sql = "
                SELECT
                    *
                FROM
                    pessoas
                WHERE id = :pessoaId
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
            $this->results = $this->query->fetch(\PDO::FETCH_ASSOC);
            return $this->results;
        }

        public function getPessoasContas(){
            $this->sql = "
                SELECT
                    p.id,
                    p.nome,
                    p.cpf,
                    c.num_conta,
                    c.id AS conta_id
                FROM
                    pessoas p
                INNER JOIN contas c ON c.pessoa_id = p.id
                ORDER BY c.id, p.id
            ";
            $this->query = $this->connection->prepare($this->sql);
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            $this->results = $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $this->results;
        }

        public function getPessoasContasAgrupado(){
            $this->sql = "
                SELECT
                    p.id,
                    p.nome,
                    p.cpf,
                    c.num_conta,
                    c.id AS conta_id
                FROM
                    pessoas p
                INNER JOIN contas c ON c.pessoa_id = p.id
                GROUP BY p.id
                ORDER BY c.id, p.id
            ";
            $this->query = $this->connection->prepare($this->sql);
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            $this->results = $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $this->results;
        }

        public function getPessoaContaByPessoaId(int $pessoa_id){
            $this->sql = "
                SELECT
                    c.id,
                    c.num_conta,
                    SUM(IFNULL(IF(m.tipo_operacao = 'depositar', m.valor, -m.valor), 0)) AS saldo
                FROM
                    pessoas p
                INNER JOIN contas c ON c.pessoa_id = p.id
                LEFT JOIN movimentacoes m ON m.pessoa_id = p.id
                    AND m.conta_id = c.id
                WHERE p.id = :pessoaId
                GROUP BY c.id
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
            $this->results = $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $this->results;
        }

        public function getPessoasMovimentacoesByPessoaId(int $pessoa_id, $conta_id){
            $this->sql = "
                SELECT
                    m.valor,
                    m.data,
                    IFNULL(m.valor, 0) AS saldo,
                    m.tipo_operacao
                FROM
                    pessoas p
                INNER JOIN contas c ON c.pessoa_id = p.id
                INNER JOIN movimentacoes m ON m.pessoa_id = p.id
                    AND m.conta_id = c.id
                WHERE 
                    p.id = :pessoaId
                AND c.id = :contaId
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":pessoaId", $pessoa_id, \PDO::PARAM_INT);
                $this->query->bindParam(":contaId", $conta_id, \PDO::PARAM_INT);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            $this->results = $this->query->fetchAll(\PDO::FETCH_ASSOC);
            return $this->results;
        }

        public function getLastInsertedId(){
            $this->sql = "SELECT last_insert_id() AS id";
            $this->query = $this->connection->prepare($this->sql);
            $this->query->execute();
            $this->results = $this->query->fetch(\PDO::FETCH_ASSOC);
            return $this->results['id'];
        }

        public function getContaById(int $conta_id){
            $this->sql = "
                SELECT
                    c.id,
                    c.num_conta,
                    p.id AS pessoa_id
                FROM
                    pessoas p
                INNER JOIN contas c ON c.pessoa_id = p.id
                WHERE c.id = :contaId
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":contaId", $conta_id, \PDO::PARAM_INT);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            
            $this->query->execute();
            var_dump($this->query->errorInfo()[0]);
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()[0]];
            }
            $this->results = $this->query->fetch(\PDO::FETCH_ASSOC);
            return $this->results;
        }

        public function getContaByNumero(int $num_conta){
            $this->sql = "
                SELECT
                    c.id
                FROM
                    contas c
                WHERE c.num_conta = :numConta
            ";
            $this->query = $this->connection->prepare($this->sql);
            try{
                $this->query->bindParam(":numConta", $num_conta, \PDO::PARAM_INT);
            }catch(\PDOException $error){
                return ["error"=>$error->getMessage()];
            }
            
            $this->query->execute();
            if($this->query->errorInfo() && $this->query->errorCode() !== '00000'){
                return ["error"=>$this->query->errorInfo()];
            }
            $this->results = $this->query->fetch(\PDO::FETCH_ASSOC);
            return $this->results['id'];
        }

        public function getMovimentacaoPorConta(int $conta_id){
            $this->sql = "
                SELECT
                    COUNT(c.id) AS id
                FROM 
                    contas c
                INNER JOIN movimentacoes m ON c.id = m.conta_id
                WHERE conta_id = :contaId
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
            $this->results = $this->query->fetch(\PDO::FETCH_ASSOC);
            return $this->results['id'];
        }

        public function getSaldoConta($conta_id){
            $this->sql = "
                SELECT
                    SUM(IFNULL(IF(m.tipo_operacao = 'depositar', m.valor, -m.valor), 0)) AS saldo
                FROM contas c
                INNER JOIN movimentacoes m ON m.conta_id = c.id
                WHERE c.id = :contaId
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
            $this->results = $this->query->fetch(\PDO::FETCH_ASSOC);
            return $this->results['saldo'];
        }
        

    }

    