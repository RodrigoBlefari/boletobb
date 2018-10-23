<?php 
use OpenBoleto\Banco\BancoDoBrasil;
use OpenBoleto\Agente;

$token    = "";
$nome     = "";
$cpf      = "";
$endereco = "";
$cep      = "";
$estado   = "";
$cidade   = "";
$valor    = "";
$boleto_display = "none";

if(isset($_POST["boleto"])){
    include "functions/boletobb.php";
}

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

<div class="forms">

    <div class="container">
        <form method="POST" action="">
    
        <h2>GERADOR DE BOLETO</h2>
            <label for="">TOKEN</label><input    type="text"   name="token"    value=<?= $token ?>>
            <label for="">NOME</label><input     type="text"   name="nome"     value="Rodrigo Blefari Gonçalves">
            <label for="">CPF</label><input      type="text"   name="cpf"      value="40093685866">
            <label for="">ENDEREÇO</label><input type="text"   name="endereco" value="Av dom jaime de barros camara">
            <label for="">BAIRRO</label><input   type="text"   name="bairro"   value="Planalto">
            <label for="">CEP</label><input      type="text"   name="cep"      value="09895400">
            <label for="">ESTADO</label><input   type="text"   name="estado"   value="SP">
            <label for="">CIDADE</label><input   type="text"   name="cidade"   value="SÃO PAULO">
            <label for="">VALOR R$</label><input type="text"   name="valor"    value="150">
            <input class="bol-generator"         type="submit" name="boleto"   value="GERAR BOLETO">
        </form>
    </div>

    <div class="boleto-modal" style="display:<?= $boleto_display ?>">
        <div class="modal-content">
            <input class="modal-close" type="submit" value="FECHAR">
            <?php
            include 'vendor/kriansa/openboleto/autoloader.php';
            
            $sacado = new Agente($nomePagador,  $cpf, $textoEnderecoPagador, $numeroCepPagador, $siglaUfPagador, $nomeMunicipioPagador);
            $cedente = new Agente('FTD com você', '02.123.123/0001-11', 'CLS 403 Lj 23', '71000-000', 'Brasília', 'DF');
            $date = new DateTime();
            $date->add(new DateInterval('P3D'));
            $boleto = new BancoDoBrasil(array(
            // Parâmetros obrigatórios
        
            'dataVencimento' => $date,
            'valor' => $valorOriginalTitulo,
            'sequencial' => 1234567,
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => 1911, // Até 4 dígitos
            'carteira' => $numeroCarteira,
            'conta' => 100130, // Até 8 dígitos
            'convenio' => $numeroConvenio, // 4, 6 ou 7 dígitos

            // Caso queira um número sequencial de 17 dígitos, a cobrança deverá:
            // - Ser sem registro (Carteiras 16 ou 17)
            // - Convênio com 6 dígitos
            // Para isso, defina a carteira como 21 (mesmo sabendo que ela é 16 ou 17, isso é uma regra do banco)

            // Parâmetros recomendáveis
            //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
            'contaDv' => 2,
            'agenciaDv' => 9,
            'descricaoDemonstrativo' => array( // Até 5
                'Compra de Livros',
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
</div>
<?php 
echo "<pre>";
print_r($configData);
echo "</pre>";
?>
</body>

<script src="js/script.js"></script>
</html>