<?php
require("Repository/Services/ReclamacoesService.php");

class ReclamacoesController { 

    protected $reclamacoesService;
   
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

        $success = $this->reclamacoesService->CriarReclamacao($data,$id_cliente);
        if($success != null){
            $response->withStatus(200);
            $response->write($success ? "true" : "false");
        }else{
            $response->withStatus(500);
        }

        return $response;
    }

    public function ResponderReclamcao($request, $response, $args)
    {   

        session_start();
        $id_cliente = $_SESSION['id_cliente'];
        $data = $request->getParsedBody();
        print_r($data);
        
        if($data == null){
            $response->withStatus(400);
            return $response;
        }

        $success = $this->reclamacoesService->ResponderReclamacao($data);
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
        $this->reclamacoesService = new ReclamacoesService();
    }


}
?>