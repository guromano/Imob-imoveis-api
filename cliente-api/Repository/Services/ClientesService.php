<?php
require("Repository/Configuration/conn.php");
require("Models/Cliente.php");

class ClientesService{ 

    public function CriarCadastro($data){
        try {
            $this->db->con->beginTransaction();
            $userData = $data["user"];
            $clienteData = $data["cliente"];
            
            $id = $this->CriarCliente($clienteData);

            if($id == null){
                $dbh->rollBack();
                return false;
            }
            if($this->CriarUser($userData,$id,$clienteData["nome"])){
                $this->db->con->commit();
                return true;
            }else{
                $db->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage(), "\n";
            $dbh->rollBack();
            return false;
        }  
        
    }

    private function CriarUser($userData,$id_cliente){
        try {
            $rs = $this->db->con->prepare("INSERT INTO user (email, senha, tipo, id_cliente) VALUES(:email, md5(:senha), :tipo, :id_cliente)");
            $rs->bindParam(':email', $userData["email"]);
            $rs->bindParam(':senha', $userData["senha"]);
            $rs->bindParam(':tipo', $userData["tipo"]);
            $rs->bindParam(':id_cliente', $id_cliente);
            $rs->execute();
            return true;     
        } catch (PDOException $e) {
            print_r($e);
            return false;
        }
    }
    
    private function CriarCliente($clienteData){

        try {
            $rs = $this->db->con->prepare("INSERT INTO cliente (nome, cpf, rg, email_contato, tel_contato) VALUES(:nome, :cpf, :rg, :email_contato, :tel_contato)");
            $rs->bindParam(':nome', $clienteData["nome"]);
            $rs->bindParam(':cpf', $clienteData["cpf"]);
            $rs->bindParam(':rg', $clienteData["rg"]);
            $rs->bindParam(':email_contato', $clienteData["email_contato"]);
            $rs->bindParam(':tel_contato', $clienteData["tel_contato"]);
            $rs->execute();
            return $this->db->con->lastInsertId(); 
        } catch (PDOException $e) {
            return null;
        }    

    }


    public function getCliente($id){
        try{
            $response = new Cliente;
            $rs = $this->db->con->prepare("SELECT * FROM cliente WHERE id_cliente=:id_cliente");
            $rs->bindParam(':id_cliente', $id);
            $rs->execute();
            $r = $rs->fetchAll();
            if (sizeof($r) > 0){
                $response->id_cliente = $r[0]["id_cliente"];
                $response->nome = $r[0]["nome"];
                $response->cpf = $r[0]["cpf"];
                $response->rg = $r[0]["rg"];
                $response->email_contato = $r[0]["email_contato"];
                $response->tel_contato = $r[0]["tel_contato"];
                return $response; 
            }else{
                return null;
            }        
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return null;
        }
    }
    public function AtualizarCadastro($data,$id_cliente,$id_user){
        try{
            $this->db->con->beginTransaction();
            // $userData = $data["user"];
            $clienteData = $data["cliente"];
            // &&  $this->AtualizarUser($clienteData)
             if($this->AtualizarCliente($clienteData)){
                $this->db->con->commit();
                return true;      
             }else{
                $dbh->rollBack();
                return false;
             }
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            $dbh->rollBack();
            return false;
        }
    }

    private function AtualizarCliente($clienteData,$id_cliente){

        try{
            $rs = $this->db->con->prepare("UPDATE cliente SET ". 
            "(nome=:nome, cpf=:cpf, rg=:rg, email_contato=:email_contato, tel_contato=:tel_contato)".
            " WHERE = id_cliente=:id_cliente");
            $rs->bindParam(':nome', $clienteData["nome"]);
            $rs->bindParam(':cpf', $clienteData["cpf"]);
            $rs->bindParam(':rg', $clienteData["rg"]);
            $rs->bindParam(':email_contato', $clienteData["email_contato"]);
            $rs->bindParam(':tel_contato', $clienteData["tel_contato"]);
            
            $rs->execute();
            return true;       
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return false;
        }

    }

    // private function AtualizarUser($userData,$id_user){

    //     try{
    //         $rs = $this->db->con->prepare("UPDATE user SET ". 
    //         "nome=:nome, cpf=:cpf, rg=:rg, email_contato=:email_contato, tel_contato=:tel_contato)".
    //         " WHERE = id_cliente=:id_cliente");
    //         $rs->bindParam(':nome', $userData["nome"]);
    //         $rs->bindParam(':cpf', $userData["cpf"]);
    //         $rs->bindParam(':rg', $userData["rg"]);
    //         $rs->bindParam(':email_contato', $userData["email_contato"]);
    //         $rs->bindParam(':tel_contato', $userData["tel_contato"]);
            
    //         $rs->execute();
    //         return true;       
    //     }
    //     catch(Exception $e) {
    //         echo $e->getMessage(), "\n";
    //         return false;
    //     }

    // }

    public function __construct()
    {
        $this->db = new DataBase();
    }
}
?>