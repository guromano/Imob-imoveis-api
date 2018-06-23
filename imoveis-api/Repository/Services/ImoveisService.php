<?php
require("Repository/Configuration/conn.php");
require("Models/Imovel.php");
require("Models/Cliente.php");
require("Models/Reclamacao.php");

class ImoveisService{ 

  
    public function getTodosImoveis(){
        try{
            $response = [];
            $rs = $this->db->con->prepare("SELECT * FROM imovel WHERE status_aluguel=1");
            $rs->execute();
            $r = $rs->fetchAll();
            if (sizeof($r) > 0){
                for($i = 0; $i < sizeof($r); $i++){
                    $imovel = new Imovel;
                    $imovel->id_imovel = $r[$i]["id_imovel"];
                    $imovel->responsavel = $this->getCliente($r[$i]["id_responsavel"]);
                    $imovel->status_aluguel = $r[$i]["status_aluguel"];
                    $imovel->vl_quartos = $r[$i]["vl_quartos"];
                    $imovel->vl_banheiros = $r[$i]["vl_banheiros"];
                    $imovel->vl_area = $r[$i]["vl_area"];
                    $imovel->cep = $r[$i]["cep"];
                    $imovel->rua = $r[$i]["rua"];
                    $imovel->bairro = $r[$i]["bairro"];
                    $imovel->cidade = $r[$i]["cidade"];
                    $imovel->estado = $r[$i]["estado"];
                    $imovel->pais = $r[$i]["pais"];
                    $imovel->tipo = $r[$i]["tipo"];
                    $imovel->vl_aluguel = $r[$i]["vl_aluguel"];
                    $imovel->reclamacoes = $this->getReclamacoes($r[$i]["id_imovel"]);
                    array_push($response,$imovel);
                }
                return $response;  
            }else{
                return $response;
            }        
        }
        catch(Exception $e) {
            print_f($e);
            return null;
        }
    }

    public function getImoveisCliente($id_cliente,$tipo){
        if($tipo == "1"){
            return $this->getImoveisInquilino($id_cliente);
        }else{
            return $this->getImoveisProprietario($id_cliente);
        }
    }
    public function getImoveisInquilino($id_cliente){
        try{
            $response = [];
            $rs = $this->db->con->prepare("SELECT a.* FROM imovel as a, aquisicao as b WHERE a.status_aluguel=2 AND a.id_imovel = b.id_imovel AND b.id_inquilino = :id_cliente");
            $rs->bindParam(':id_cliente', $id_cliente);
            $rs->execute();
            $r = $rs->fetchAll();
            if (sizeof($r) > 0){
                for($i = 0; $i < sizeof($r); $i++){
                    $imovel = new Imovel;
                    $imovel->id_imovel = $r[$i]["id_imovel"];
                    $imovel->responsavel = $this->getCliente($r[$i]["id_responsavel"]);
                    $imovel->status_aluguel = $r[$i]["status_aluguel"];
                    $imovel->vl_quartos = $r[$i]["vl_quartos"];
                    $imovel->vl_banheiros = $r[$i]["vl_banheiros"];
                    $imovel->vl_area = $r[$i]["vl_area"];
                    $imovel->cep = $r[$i]["cep"];
                    $imovel->rua = $r[$i]["rua"];
                    $imovel->bairro = $r[$i]["bairro"];
                    $imovel->cidade = $r[$i]["cidade"];
                    $imovel->estado = $r[$i]["estado"];
                    $imovel->pais = $r[$i]["pais"];
                    $imovel->tipo = $r[$i]["tipo"];
                    $imovel->vl_aluguel = $r[$i]["vl_aluguel"];
                    $imovel->reclamacoes = $this->getReclamacoes($r[$i]["id_imovel"]);
                    array_push($response,$imovel);
                }
                return $response;  
            }else{
                return $response;
            }        
        }
        catch(Exception $e) {
            print_f($e);
            return null;
        }
    }

    public function getImoveisProprietario($id_responsavel){
        try{
            $response = [];
            $rs = $this->db->con->prepare("SELECT * FROM imovel WHERE id_responsavel=:id_responsavel");
            $rs->bindParam(':id_responsavel', $id_responsavel);
            $rs->execute();
            $r = $rs->fetchAll();
            if (sizeof($r) > 0){
                for($i = 0; $i < sizeof($r); $i++){
                    $imovel = new Imovel;
                    $imovel->id_imovel = $r[$i]["id_imovel"];
                    $imovel->responsavel = $this->getCliente($r[$i]["id_responsavel"]);
                    $imovel->status_aluguel = $r[$i]["status_aluguel"];
                    $imovel->vl_quartos = $r[$i]["vl_quartos"];
                    $imovel->vl_banheiros = $r[$i]["vl_banheiros"];
                    $imovel->vl_area = $r[$i]["vl_area"];
                    $imovel->cep = $r[$i]["cep"];
                    $imovel->rua = $r[$i]["rua"];
                    $imovel->bairro = $r[$i]["bairro"];
                    $imovel->cidade = $r[$i]["cidade"];
                    $imovel->estado = $r[$i]["estado"];
                    $imovel->pais = $r[$i]["pais"];
                    $imovel->tipo = $r[$i]["tipo"];
                    $imovel->vl_aluguel = $r[$i]["vl_aluguel"];
                    $imovel->reclamacoes = $this->getReclamacoes($r[$i]["id_imovel"]);
                    array_push($response,$imovel);
                }
                return $response;  
            }else{
                return $response;
            }        
        }
        catch(Exception $e) {
            print_f($e);
            return null;
        }
    }
    public function GetImovelPorCodigo($id){
        try{
            $response = new Imovel;
            $rs = $this->db->con->prepare("SELECT * FROM imovel WHERE id_imovel=:id_imovel");
            $rs->bindParam(':id_imovel', $id);
            $rs->execute();
            $r = $rs->fetchAll();
            if (sizeof($r) > 0){
                $response->id_imovel = $r[0]["id_imovel"];
                $response->responsavel = $this->getCliente($r[0]["id_responsavel"]);
                $response->vl_quartos = $r[0]["vl_quartos"];
                $response->vl_banheiros = $r[0]["vl_banheiros"];
                $response->vl_area = $r[0]["vl_area"];
                $response->cep = $r[0]["cep"];
                $response->rua = $r[0]["rua"];
                $response->bairro = $r[0]["bairro"];
                $response->cidade = $r[0]["cidade"];
                $response->estado = $r[0]["estado"];
                $response->pais = $r[0]["pais"];
                $imovel->tipo = $r[$i]["tipo"];
                $response->vl_aluguel = $r[0]["vl_aluguel"];
                $imovel->reclamacoes = $this->getReclamacoes($r[0]["id_imovel"]);
                return $response;  
            }else{
                return $response;
            }        
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return null;
        }
    }

    public function CriarImovel($data,$id_cliente){
        try{
            $rs = $this->db->con->prepare("INSERT INTO imovel (id_responsavel, vl_quartos, vl_banheiros, vl_area, cep, rua, bairro, cidade, estado, pais,tipo, vl_aluguel) VALUES(:id_responsavel, :vl_quartos, :vl_banheiros, :vl_area, :cep, :rua, :bairro, :cidade, :estado, :pais,:tipo, :vl_aluguel)");
            $rs->bindParam(':id_responsavel', $id_cliente);
            $rs->bindParam(':vl_quartos', $data["vl_quartos"]);
            $rs->bindParam(':vl_banheiros', $data["vl_banheiros"]);
            $rs->bindParam(':vl_area', $data["vl_area"]);
            $rs->bindParam(':cep', $data["cep"]);
            $rs->bindParam(':rua', $data["rua"]);
            $rs->bindParam(':bairro', $data["bairro"]);
            $rs->bindParam(':cidade', $data["cidade"]);
            $rs->bindParam(':estado', $data["estado"]);
            $rs->bindParam(':pais', $data["pais"]);
            $rs->bindParam(':tipo', $data["tipo"]);
            $rs->bindParam(':vl_aluguel', $data["vl_aluguel"]);
            $rs->execute();
            return true;       
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return false;
        }
    }

    public function DeletarImovel($id_imovel){
        try{
            $rs = $this->db->con->prepare("DELETE FROM imovel WHERE id_imovel=:id_imovel");
            $rs->bindParam(':id_imovel', $id_imovel);
            $rs->execute();
            return true;       
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return false;
        }
    }

    private function getCliente($id){
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
    private function getReclamacoes($id_imovel){
        try{
            $reclamacoes = [];
            $rs = $this->db->con->prepare("SELECT * FROM reclamacao WHERE id_imovel=:id_imovel");
            $rs->bindParam(':id_imovel', $id_imovel);
            $rs->execute();
            $r = $rs->fetchAll();
            if (sizeof($r) > 0){
                for($i = 0; $i < sizeof($r); $i++){
                    $reclamacao = new reclamacao;
                    $reclamacao->id_reclamacao = $r[$i]["id_reclamacao"];
                    $reclamacao->reclamante = $this->getCliente($r[$i]["id_reclamante"]);
                    $reclamacao->reclamacao = $r[$i]["txt_reclamacao"];
                    $reclamacao->resposta = $r[$i]["txt_resposta"];
                    array_push($reclamacoes,$reclamacao);
                }
                return $reclamacoes;  
            }else{
                return $reclamacoes;
            }
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return null;
        }
    }
    public function AtualizarImovel($id,$data,$id_cliente){
        try{
            $rs = $this->db->con->prepare("UPDATE imovel SET ". 
            "vl_quartos=:vl_quartos, vl_banheiros=:vl_banheiros, vl_area=:vl_area, cep=:cep, rua=:rua, bairro=:bairro, cidade=:cidade, estado=:estado,".
            " pais=:pais, tipo=:tipo, vl_aluguel=:vl_aluguel WHERE id_responsavel=:id_responsavel AND id_imovel=:id");
            $rs->bindParam(':vl_quartos', $data["vl_quartos"]);
            $rs->bindParam(':vl_banheiros', $data["vl_banheiros"]);
            $rs->bindParam(':vl_area', $data["vl_area"]);
            $rs->bindParam(':cep', $data["cep"]);
            $rs->bindParam(':rua', $data["rua"]);
            $rs->bindParam(':bairro', $data["bairro"]);
            $rs->bindParam(':cidade', $data["cidade"]);
            $rs->bindParam(':estado', $data["estado"]);
            $rs->bindParam(':pais', $data["pais"]);
            $rs->bindParam(':tipo', $data["tipo"]);
            $rs->bindParam(':vl_aluguel', $data["vl_aluguel"]);
            $rs->bindParam(':id_responsavel', $id_cliente);
            $rs->bindParam(':id', $id);
            
            $rs->execute();
            return true;       
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return false;
        }
    }

    public function __construct()
    {
        $this->db = new DataBase();
    }


    public function CriarReclamacao($data,$id_cliente){
        try {
            $rs = $this->db->con->prepare("INSERT INTO reclamacao (id_imovel, id_reclamante, txt_reclamacao) VALUES(:id_imovel, :id_reclamante, :txt_reclamacao)");
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

    public function VerificarClienteResponsavel($id_reclamacao,$id_cliente){
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
            echo $e->getMessage(), "\n";
            return null;
        }
    }


    public function ResponderReclamacao($data){

        try{
            $rs = $this->db->con->prepare("UPDATE reclamacao SET ". 
            "txt_resposta=:resposta".
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
}
?>