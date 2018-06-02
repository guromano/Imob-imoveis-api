<?php
require("Repository/Services/ImoveisService.php");

class ImoveisController { 

    protected $loginService;

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
            $response->withStatus(200);
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

    public function __construct()
    {
        $this->imoveisService = new ImoveisService();
    }


}
?>