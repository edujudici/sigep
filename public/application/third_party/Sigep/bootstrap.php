<?php
ini_set('display_errors', AMBIENTE ? 1 : 1);
ini_set('display_startup_errors', AMBIENTE ? 1 : 1);
ini_set('error_reporting', 'E_ALL|E_STRICT');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/src/PhpSigep/Pdf/php-sigep-fpdf/PhpSigepFPDF.php';

if (!class_exists('PhpSigepFPDF')) {
    throw new RuntimeException(
        'classe PhpSigepFPDF! não encontrada'
    );
}

require_once __DIR__ . '/src/PhpSigep/Bootstrap.php';


$accessDataParaAmbienteDeHomologacao = new \PhpSigep\Model\AccessDataHomologacao();
$config = new \PhpSigep\Config();
$config->setAccessData($accessDataParaAmbienteDeHomologacao);
$config->setEnv(AMBIENTE ? 1 : 2);//2ENV_DEVELOPMENT  //1ENV_PRODUCTION  
$config->setCacheOptions(
    array(
        'storageOptions' => array(
            'enabled' => false,
            'ttl' => 10,
            'cacheDir' => sys_get_temp_dir(),
        ),
    )
);

\PhpSigep\Bootstrap::start($config);