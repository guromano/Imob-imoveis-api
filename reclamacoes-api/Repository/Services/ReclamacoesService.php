<?php
require("Repository/Configuration/conn.php");
require("Models/Reclamacao.php");

class ReclamacoesService{ 

    public function CriarReclamacao($data,$id_cliente){
        try {
            $rs = $this->db->con->prepare("INSERT INTO reclamacao (id_imovel, id_reclamante, txt_reclamacao, txt_resposta) VALUES(:id_imovel, id_reclamante, :txt_reclamacao, :txt_resposta)");
            $rs->bindParam(':id_imovel', $data["id_imovel"]);
            $rs->bindParam(':txt_reclamacao', $data["txt_reclamacao"]);
            $rs->bindParam(':id_reclamante', $id_cliente);
            $rs->execute();
            return true;     
        } catch (PDOException $e) {
            print_r($e);
            return false;
        }
    }

    private function VerificarClienteResponsavel($id_reclamacao,$id_cliente){
        try{
            $response = new Cliente;
            $rs = $this->db->con->prepare("SELECT a.id_responsavel FROM nuvem.imovel as a, reclamacao as b".
            " WHERE a.id_imovel = b.id_imovel AND b.id_reclamacao = :id_reclamacao AND b.id_responsavel = :id_responsavel;");
            $rs->bindParam(':id_reclamacao', $id_reclamacao);
            $rs->bindParam(':id_responsavel', $id_cliente);
            $rs->execute();
            $r = $rs->fetchAll();
            if (sizeof($r) > 0){
                return true;
            }else{
                return false;
            }        
        }
        catch(Exception $e) {
            print_r($e);
            return null;
        }
    }


    private function ResponderReclamacao($data){

        try{
            $rs = $this->db->con->prepare("UPDATE reclamacao SET ". 
            "resposta=:resposta".
            " WHERE id_reclamacao=:id_reclamacao");
            $rs->bindParam(':resposta', $data["resposta"]);
            $rs->bindParam(':id_reclamacao', $data["id_reclamacao"]);
            
            $rs->execute();
            return true;       
        }
        catch(Exception $e) {
            print_r($e);
            return false;
        }

    }

    public function __construct()
    {
        $this->db = new DataBase();
    }
}
?>