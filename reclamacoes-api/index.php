<?php
require_once __DIR__ . '/vendor/autoload.php';
require "Controller/ReclamacoesController.php";

$app = new Slim\App();

$controller = new ReclamacaoController();
$app->GET('/reclamacao/inquilino', [$controller, 'GetReclamacoesCliente']);
$app->POST('/reclamacao', [$controller, 'CriarReclamacao']);
$app->PUT('/reclamacao', [$controller, 'ResponderReclamaacao']);

$app->run();
                                                                                                                        
?>
