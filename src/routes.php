<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response, array $args) {
    $this->logger->info("Slim-Skeleton '/' route");
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->post('/generate', function (Request $request, Response $response, array $args) {
    $this->logger->info("Generate Certificate");

    $email = $request->getParam('email');
    $nome = $request->getParam('nome');
    $cpf = $request->getParam('cpf');

    $empresa = "Universidade do Lincoln Borges";
    $curso = "Workshop Segurança da Informação";
    $data = "29/05/2017";
    $carga_h = "8 horas";

    $texto1 = utf8_decode($empresa);
    $texto2 = utf8_decode("pela participação no ".$curso." \n realizado em ".$data." com carga horária total de ".$carga_h.".");
    $texto3 = utf8_decode("São Paulo, ".utf8_encode(strftime( '%d de %B de %Y', strtotime( date( 'Y-m-d' ) ) )));

    $pdf = new FPDF();
    $pdf->AddPage('L');
    $pdf->SetLineWidth(1.5);

    // desenha a imagem do certificado
    $imageDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images';
    $pdf->Image($imageDir . DIRECTORY_SEPARATOR . 'certificado.jpg', 0, 0, 295);
    //$pdf->SetAlpha(1);

    // Mostrar texto no topo
    $pdf->SetFont('Arial', '', 15);
    $pdf->SetXY(109,46); //Parte chata onde tem que ficar ajustando a posição X e Y
    $pdf->MultiCell(265, 10, $texto1, '', 'L', 0); // Tamanho width e height e posição

    // Mostrar o nome
    $pdf->SetFont('Arial', '', 30); // Tipo de fonte e tamanho
    $pdf->SetXY(20,86); //Parte chata onde tem que ficar ajustando a posição X e Y
    $pdf->MultiCell(265, 10, $nome, '', 'C', 0); // Tamanho width e height e posição

    // Mostrar o corpo
    $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
    $pdf->SetXY(20,110); //Parte chata onde tem que ficar ajustando a posição X e Y
    $pdf->MultiCell(265, 10, $texto2, '', 'C', 0); // Tamanho width e height e posição

    // Mostrar a data no final
    $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
    $pdf->SetXY(32,172); //Parte chata onde tem que ficar ajustando a posição X e Y
    $pdf->MultiCell(165, 10, $texto3, '', 'L', 0); // Tamanho width e height e posição

    $pdfdoc = $pdf->Output('', 'S');

//    $subject = 'Seu Certificado do Workshop';
//    $messageBody = "Olá $nome<br><br>É com grande prazer que entregamos o seu certificado.<br>Ele está em anexo nesse e-mail.<br><br>Atenciosamente,<br>Lincoln Borges<br><a href='http://www.lnborges.com.br'>http://www.lnborges.com.br</a>";
//
//    $mail = new PHPMailer();
//    $mail->SetFrom("certificado@lnborges.com.br", "Certificado");
//    $mail->Subject = $subject;
//    $mail->MsgHTML(utf8_decode($messageBody));
//    $mail->AddAddress($email);
//    $mail->addStringAttachment($pdfdoc, 'certificado.pdf');
//    $mail->Send();

    $certificadosDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'certificados';
    $certificado = "{$certificadosDir}/{$cpf}.pdf";
    $pdf->Output($certificado, 'F');

    header("Content-type:application/pdf");
    readfile($certificado);
    die;
});
