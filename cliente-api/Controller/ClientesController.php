<?php
require("Repository/Services/ClientesService.php");

class ClientesController { 

    protected $clientesService;
    public function GetClienteInfo($request, $response, $args)
    {   
    
        session_start();
        $id_cliente = $_SESSION['id_cliente'];

        if($id_cliente == null){
            $response->withStatus(401);
            return $response;
        }

        $cliente = $this->clientesService->getCliente($id_cliente);
        if($cliente != null){
            $response->withStatus(200);
            $response->write(json_encode($cliente));
        }else{
            $response->withStatus(500);
        }

        $newResponse = $response->withHeader(
            'Content-type',
            'application/json; charset=utf-8'
        );
        return $newResponse;
    }

    public function CriarCliente($request, $response, $args)
    {   

        $data = $request->getParsedBody();
        
        if($data == null){
            $response->withStatus(400);
            return $response;
        }        

        $success = $this->clientesService->CriarCadastro($data);
        if($success != null){
            $response->withStatus(200);
            $response->write($success ? "true" : "false");
        }else{
            $response->withStatus(500);
        }

        return $response;
    }

    public function AtualizarCliente($request, $response, $args)
    {   
        $data = $request->getParsedBody();
        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        $id_user = $_SESSION['id_user'];
        
        if($id == null){
            $response->withStatus(400);
            return $response;
        }
        $success = $this->clientesService->AtualizarCadastro($data,$id_cliente,$id_user);
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
        $this->clientesService = new ClientesService();
    }


}
?>