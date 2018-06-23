<?php

require_once __DIR__ . '/vendor/autoload.php';
require "Controller/AquisicaoController.php";

$app = new Slim\App();

$controller = new AquisicaoController();
$app->GET('/aquisicao', [$controller, 'GetAquisicaoCliente']);
$app->POST('/aquisicao', [$controller, 'AdquirirImovel']);
$app->DELETE('/aquisicao/{id_imovel}', [$controller, 'CancelarAquisicao']);

$app->run();
                                                                                                                        
?>
