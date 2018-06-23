<?php
require("Repository/Configuration/conn.php");
require("Models/Aquisicao.php");

class AquisicaoService{ 

    public function AdquirirImovel($id_imovel,$id_cliente){
        try {
            $this->db->con->beginTransaction();
            $id_responsavel = $this->getResponsavel($id_imovel);
            if(!$this->InserirAquisicao($id_imovel,$id_responsavel,$id_cliente)){
                $dbh->rollBack();
                return false;
            }
            if(!$this->AlterarEstadoImovel($id_imovel)){
                $dbh->rollBack();
                return false;
            }
            $this->db->con->commit();
            return true;     
        } catch (PDOException $e) {
            print_r($e);
            return false;
        }
    }

    private function getResponsavel($id_imovel){
        try{
            $rs = $this->db->con->prepare("SELECT id_responsavel FROM nuvem.imovel".
            " WHERE id_imovel = :id_imovel;");
            $rs->bindParam(':id_imovel', $id_imovel);
            $rs->execute();
            $r = $rs->fetchAll();
            return $r[0]["id_responsavel"];
        }
        catch(Exception $e) {
            print_r($e);
            return null;
        }
    }

    private function InserirAquisicao($id_imovel,$id_proprietario,$id_inquilino){
        try{
            $rs = $this->db->con->prepare("INSERT INTO aquisicao (id_imovel, id_inquilino, id_proprietario) VALUES(:id_imovel, :id_inquilino, :id_proprietario)");
            $rs->bindParam(':id_imovel', $id_imovel);
            $rs->bindParam(':id_inquilino', $id_inquilino);
            $rs->bindParam(':id_proprietario', $id_proprietario);
            $rs->execute();
            return true;
        }catch (PDOException $e) {
            print_r($e);
            return false;
        }

    }
    private function DeletarAquisicao($id_imovel,$id_inquilino){
        try{
            $rs = $this->db->con->prepare("DELETE FROM aquisicao WHERE id_imovel=:id_imovel AND id_inquilino=:id_inquilino");
            $rs->bindParam(':id_imovel', $id_imovel);
            $rs->bindParam(':id_inquilino', $id_inquilino);
            $rs->execute();
            return true;       
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return false;
        }

    }
    private function AlterarEstadoImovel($id_imovel){
        
        try{
            $rs = $this->db->con->prepare("UPDATE imovel SET". 
            " status_aluguel='2'".
            " WHERE id_imovel=:id_imovel");
            $rs->bindParam(':id_imovel', $id_imovel);
            
            $rs->execute();
            return true;       
        }
        catch(Exception $e) {
            print_r($e);
            return false;
        }
    }
    private function AlterarEstadoImovelDisponivel($id_imovel){
        
        try{
            $rs = $this->db->con->prepare("UPDATE imovel SET". 
            " status_aluguel='1'".
            " WHERE id_imovel=:id_imovel");
            $rs->bindParam(':id_imovel', $id_imovel);
            
            $rs->execute();
            return true;       
        }
        catch(Exception $e) {
            print_r($e);
            return false;
        }
    }
    
    public function CancelarAquisicao($id,$id_cliente){
        try {
            $this->db->con->beginTransaction();
            if(!$this->DeletarAquisicao($id,$id_cliente)){
                $dbh->rollBack();
                return false;
            }
            if(!$this->AlterarEstadoImovelDisponivel($id)){
                $dbh->rollBack();
                return false;
            }
            $this->db->con->commit();
            return true;     
        } catch (PDOException $e) {
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