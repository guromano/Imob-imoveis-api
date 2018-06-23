<?php

require_once __DIR__ . '/vendor/autoload.php';
require "Controller/ImoveisController.php";


$app = new Slim\App();

$controller = new ImoveisController();
$app->GET("/imoveis/cliente",[$controller, 'ListarImoveisCliente']);
$app->GET('/imoveis', [$controller, 'ListarImoveis']);
$app->GET('/imoveis/{id_imovel}', [$controller, 'GetImovelPorCodigo']);
$app->POST('/imoveis', [$controller, 'CriarImovel']);
$app->DELETE('/imoveis/{id_imovel}', [$controller, 'DeletarImovel']);
$app->PUT('/imoveis/{id_imovel}', [$controller, 'AtualizarImovel']);
$app->POST('/reclamacao', [$controller, 'CriarReclamacao']);
$app->PUT('/reclamacao', [$controller, 'ResponderReclamacao']);

$app->run();
                                                                                                                        
?>
