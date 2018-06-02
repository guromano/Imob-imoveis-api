<?php
require("Repository/Configuration/conn.php");
require("Models/Imovel.php");
require("Models/Cliente.php");

class ImoveisService{ 

  
    public function getTodosImoveis(){
        try{
            $response = [];
            $rs = $this->db->con->prepare("SELECT * FROM imovel");
            $rs->execute();
            $r = $rs->fetchAll();
            if (sizeof($r) > 0){
                for($i = 0; $i < sizeof($r); $i++){
                    $imovel = new Imovel;
                    $imovel->id_imovel = $r[$i]["id_imovel"];
                    $imovel->responsavel = $this->getCliente($r[$i]["id_responsavel"]);
                    $imovel->vl_quartos = $r[$i]["vl_quartos"];
                    $imovel->vl_banheiros = $r[$i]["vl_banheiros"];
                    $imovel->vl_area = $r[$i]["vl_area"];
                    $imovel->cep = $r[$i]["cep"];
                    $imovel->rua = $r[$i]["rua"];
                    $imovel->bairro = $r[$i]["bairro"];
                    $imovel->cidade = $r[$i]["cidade"];
                    $imovel->estado = $r[$i]["estado"];
                    $imovel->pais = $r[$i]["pais"];
                    $imovel->vl_aluguel = $r[$i]["vl_aluguel"];
                    array_push($response,$imovel);
                }
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
                $response->vl_aluguel = $r[0]["vl_aluguel"];
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
                    $response->id_user = $r[0]["id_user"];
                    $response->rg = $r[0]["rg"];
                    $response->email_contato = $r[0]["email_contato"];
                    $response->tel_contato = $r[0]["tel_contato"];
                    return $response; 
            }else{
                return $null;
            }        
        }
        catch(Exception $e) {
            echo $e->getMessage(), "\n";
            return null;
        }
    }

    public function __construct()
    {
        $this->db = new DataBase();
    }
}
?>