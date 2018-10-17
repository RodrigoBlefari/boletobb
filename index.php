<?php 
use OpenBoleto\Banco\BancoDoBrasil;
use OpenBoleto\Agente;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="css/style.css">
    <title>Boleto Banco do Brasill</title>
</head>
<body>

<div class="container">
    <form action="">
    <div class="body-form">
    <h1>GERADOR DE BOLETO<br> BANCO DO BRASIL</h1>
    </div>
    <h2>GERAR TOKEN</h2>
        <label for="">TOKEN</label>  <input placeholder="" type="text">  
        <input class="token-generator" type="button" value="GERAR TOKEN">
    </form>
</div>

<div class="container">
    <form action="">
  
    <h2>GERADOR DE BOLETO </h2>
        <label for="">TOKEN </label><input placeholder="" type="text" value="">
        <label for="">NOME</label><input placeholder="" type="text" value="Rodrigo Blefari Gonçalves">
        <label for="">CPF</label><input placeholder="" type="text" value="400-936-858-66">
        <label for="">ENDEREÇO</label><input placeholder="" type="text" value="Av dom jaime de barros camara">
        <label for="">CEP</label><input placeholder="" type="text" value="09895-400">
        <label for="">ESTADO</label><input placeholder="" type="text" value="SÃO PAULO">
        <label for="">CIDADE</label><input placeholder="" type="text" value="São Bernardo do Campo">
        <label for="">VALOR</label><input placeholder="" type="text" value="150">
        <input class="bol-generator" type="button" value="GERAR BOLETO">
    </form>
</div>

<div class="boleto-modal">
    <div class="modal-content">
    <input class="modal-close" type="button" value="FECHAR">
    <?php
    include 'vendor/kriansa/openboleto/autoloader.php';
    
$sacado = new Agente('Fernando Maia', '023.434.234-34', 'ABC 302 Bloco N', '72000-000', 'Brasília', 'DF');
$cedente = new Agente('FTD com você', '02.123.123/0001-11', 'CLS 403 Lj 23', '71000-000', 'Brasília', 'DF');

$boleto = new BancoDoBrasil(array(
    // Parâmetros obrigatórios
    'dataVencimento' => new DateTime('2013-01-24'),
    'valor' => 23.00,
    'sequencial' => 1234567,
    'sacado' => $sacado,
    'cedente' => $cedente,
    'agencia' => 1724, // Até 4 dígitos
    'carteira' => 18,
    'conta' => 10403005, // Até 8 dígitos
    'convenio' => 1234, // 4, 6 ou 7 dígitos

    // Caso queira um número sequencial de 17 dígitos, a cobrança deverá:
    // - Ser sem registro (Carteiras 16 ou 17)
    // - Convênio com 6 dígitos
    // Para isso, defina a carteira como 21 (mesmo sabendo que ela é 16 ou 17, isso é uma regra do banco)

    // Parâmetros recomendáveis
    //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
    'contaDv' => 2,
    'agenciaDv' => 1,
    'descricaoDemonstrativo' => array( // Até 5
        'Compra de materiais cosméticos',
        'Compra de alicate',
    ),
    'instrucoes' => array( // Até 8
        'Após o dia 30/11 cobrar 2% de mora e 1% de juros ao dia.',
        'Não receber após o vencimento.',
    ),

    // Parâmetros opcionais
    //'resourcePath' => '../resources',
    //'moeda' => BancoDoBrasil::MOEDA_REAL,
    //'dataDocumento' => new DateTime(),
    //'dataProcessamento' => new DateTime(),
    //'contraApresentacao' => true,
    //'pagamentoMinimo' => 23.00,
    //'aceite' => 'N',
    //'especieDoc' => 'ABC',
    //'numeroDocumento' => '123.456.789',
    //'usoBanco' => 'Uso banco',
    //'layout' => 'layout.phtml',
    //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
    //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
    //'descontosAbatimentos' => 123.12,
    //'moraMulta' => 123.12,
    //'outrasDeducoes' => 123.12,
    //'outrosAcrescimos' => 123.12,
    //'valorCobrado' => 123.12,
    //'valorUnitario' => 123.12,
    //'quantidade' => 1,
));

echo $boleto->getOutput();


    ?>
</div>
</div>
</body>
<script src="js/script.js"></script>
</html>