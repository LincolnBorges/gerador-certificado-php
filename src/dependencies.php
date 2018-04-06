<?php

$container = $app->getContainer();

/**
 * @var Slim\Container $c
 * @return \Slim\Views\PhpRenderer
 */
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

/**
 * @var Slim\Container $c
 * @return \Monolog\Logger
 */
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

/**
 * @var Slim\Container $c
 * @return PHPMailer
 */
$container['phpmailer'] = function ($c) {
    $mail = new PHPMailer();
    $mail->SetFrom("certificado@lnborges.com.br", "Certificado");

    return $mail;
};

/**
 * @var Slim\Container $c
 * @return FPDF
 */
$container['fpdf'] = function ($c) {
    return new FPDF();
};