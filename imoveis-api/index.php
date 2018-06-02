<?php

require_once __DIR__ . '/vendor/autoload.php';
require "Controller/ImoveisController.php";

header_remove();
header('Content-Type: application/json');

$app = new Slim\App();

$controller = new ImoveisController();
$app->GET('/imoveis', [$controller, 'ListarImoveis']);
$app->GET('/imoveis/{id_imovel}', [$controller, 'GetImovelPorCodigo']);

$app->run();
