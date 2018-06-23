<?php
require("Repository/Services/ImoveisService.php");

class ImoveisController { 

    protected $imoveisService;
    public function ListarImoveis($request, $response, $args)
    {   
        $listaImoveis = $this->imoveisService->getTodosImoveis();
        if($listaImoveis != null){
            $response->withStatus(200);
            $response->write(json_encode($listaImoveis));
        }else{
            $response->withStatus(401);
        }

        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }

    public function GetImovelPorCodigo($request, $response, $args)
    {   
        $id = $args['id_imovel'];
        $imovel = $this->imoveisService->getImovelPorCodigo($id);
        if($imovel != null){
            $response->withStatus(201);
            $response->write(json_encode($imovel));
        }else{
            $response->withStatus(401);
        }

        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }

    public function CriarImovel($request, $response, $args)
    {   

        $data = $request->getParsedBody();
        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        
        if($id_cliente == null){
            return $response->withStatus(401);;
        }

        if($data == null){
            $response->withStatus(400);
            return $response;
        }        

        $success = $this->imoveisService->CriarImovel($data,$id_cliente);
        if($success != null){
            $response->withStatus(200);
            $response->write($success ? "true" : "false");
        }else{
            $response->withStatus(401);
        }

        return $response;
    }

    public function DeletarImovel($request, $response, $args)
    {   
        $id = $args['id_imovel'];
        
        if($id == null){
            $response->withStatus(200);
            return $response;
        }
        $success = $this->imoveisService->DeletarImovel($id);
        if($response != null){
            $response->withStatus(200);
            $response->write($success ? "true" : "false");
        }else{
            $response->withStatus(500);
        }

        return $response;
    }

    public function AtualizarImovel($request, $response, $args)
    {   
        $id = $args['id_imovel'];
        $data = $request->getParsedBody();
        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        
        if($id == null){
            $response->withStatus(400);
            return $response;
        }
        $success = $this->imoveisService->AtualizarImovel($id,$data,$id_cliente);
        if($response != null){
            $response->withStatus(200);
            $response->write($success ? "true" : "false");
        }else{
            $response->withStatus(500);
        }

        return $response;
    }

    public function ListarImoveisCliente($request, $response, $args)
    {
        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        $tipo = $_SESSION['tipo'];
        $listaImoveis = $this->imoveisService->getImoveisCliente($id_cliente,$tipo);
        if($listaImoveis != null){
            $response->withStatus(200);
            $response->write(json_encode($listaImoveis));
        }else{
            $response->withStatus(401);
        }

        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;   
    }

    public function CriarReclamacao($request, $response, $args)
    {   

        session_start();
        $id_cliente = $_SESSION['id_cliente'];

        if($id_cliente == null){
            $response->withStatus(401);
            return $response;
        }

        $data = $request->getParsedBody();

        if($data == null){
            $response->withStatus(400);
            return $response;
        }        

        $success = $this->imoveisService->CriarReclamacao($data,$id_cliente);
        if($success != null){
            $response->withStatus(200);
            $response->write($success ? "true" : "false");
        }else{
            $response->withStatus(500);
        }

        return $response;
    }

    public function ResponderReclamacao($request, $response, $args)
    {   

        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        $data = $request->getParsedBody();
        
        if($data == null){
            $response->withStatus(400);
            return $response;
        }


        $success = $this->imoveisService->ResponderReclamacao($data);
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
        $this->imoveisService = new ImoveisService();
    }


}
?>