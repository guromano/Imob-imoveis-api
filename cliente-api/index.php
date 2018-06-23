<?php
require_once __DIR__ . '/vendor/autoload.php';
require "Controller/ClientesController.php";

$app = new Slim\App();

$controller = new ClientesController();
$app->GET('/cliente', [$controller, 'GetClienteInfo']);
$app->POST('/cliente', [$controller, 'CriarCliente']);
$app->PUT('/cliente', [$controller, 'AtualizarCliente']);

$app->run();
                                                                                                                        
?>