<?php
require("Repository/Services/AquisicaoService.php");

class AquisicaoController { 

    protected $aquisicaoService;
    public function GetAquisicaoCliente($request, $response, $args)
    {   
    
        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        $data = $request->getParsedBody();

        if($id_cliente == null){
            return  $response->withStatus(401);;
        }

        $aquisicao = $this->aquisicaoService->GetAquisicaoCliente($data);
        if($aquisicao != null){
            $response->withStatus(200);
            $response->write(json_encode($Aquisicao));
        }else{
            $response->withStatus(500);
        }

        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }

    public function AdquirirImovel($request, $response, $args)
    {   

        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        $data = $request->getParsedBody();

        if($id_cliente == null){
            $response->withStatus(401);
            return $response;
        }

        $data = $request->getParsedBody();

        if($data == null){
            $response->withStatus(400);
            return $response;
        }        
        $success = $this->aquisicaoService->AdquirirImovel($data["id_imovel"],$id_cliente);
        if($success != null){
            $response->withStatus(200);
            $response->write($success ? "true" : "false");
        }else{
            $response->withStatus(500);
        }

        return $response;
    }

    public function CancelarAquisicao($request, $response, $args)
    {   

        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        $id = $args['id_imovel'];
        if($id == null){
            $response->withStatus(400);
            return $response;
        }
        if($id_cliente == null){
            return $response->withStatus(401);
        }
        $success = $this->aquisicaoService->CancelarAquisicao($id,$id_cliente);
        if($response != null){
            $response->withStatus(200);
            $response->write($success ? "true" : "false");
        }else{
            $response->withStatus(500);
        }

        return $response;
    }

    public function __construct()
    {
        $this->aquisicaoService = new AquisicaoService();
    }


}
?>