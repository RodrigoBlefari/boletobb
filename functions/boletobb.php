<?php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://oauth.hm.bb.com.br/oauth/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "grant_type=client_credentials&scope=cobranca.registro-boletos",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic ZXlKcFpDSTZJamd3TkROaU5UTXRaalE1TWkwMFl5SXNJbU52WkdsbmIxQjFZbXhwWTJGa2IzSWlPakV3T1N3aVkyOWthV2R2VTI5bWRIZGhjbVVpT2pFc0luTmxjWFZsYm1OcFlXeEpibk4wWVd4aFkyRnZJam94ZlE6ZXlKcFpDSTZJakJqWkRGbE1HUXROMlV5TkMwME1HUXlMV0kwWVNJc0ltTnZaR2xuYjFCMVlteHBZMkZrYjNJaU9qRXdPU3dpWTI5a2FXZHZVMjltZEhkaGNtVWlPakVzSW5ObGNYVmxibU5wWVd4SmJuTjBZV3hoWTJGdklqb3hMQ0p6WlhGMVpXNWphV0ZzUTNKbFpHVnVZMmxoYkNJNk1YMA==",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: 0eb1c6c3-610c-b969-dd8b-98e4da61c3dc"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $token = json_decode($response)->access_token;
    $nomePagador                          = $_POST["nome"];
    $cpf                                  = $_POST["cpf"];
    $textoEnderecoPagador                 = $_POST["endereco"];
    $nomeBairroPagador                    = $_POST["bairro"];
    $numeroCepPagador                     = $_POST["cep"];
    $siglaUfPagador                       = $_POST["estado"];
    $nomeMunicipioPagador                 = $_POST["cidade"];
    $valorOriginalTitulo                  = $_POST["valor"];
    $textoNumeroTelefonePagador           = ""; //Opcional;

    //DADOS DA CONTA BANCO DO BRASIL
    //DEV
    $numeroConvenio                       = 1014051;
    //PROD
    //$numeroConvenio                     = 3135329;
    $numeroCarteira                       = 17;
    $numeroVariacaoCarteira               = 19; //convênio esta como 04 - 3;
    $codigoModalidadeTitulo               = 1;
    $dataEmissaoTitulo                    = date('d.m.Y', strtotime(date('d.m.Y'). ' - 1 days'));
    $dataVencimentoTitulo                 = date('d.m.Y', strtotime($dataEmissaoTitulo. ' + 3 days'));
    $codigoTipoDesconto                   = 0;
    $quantidadeDiaProtesto                = "";
    $codigoTipoJuroMora                   = 0;
    $codigoTipoMulta                      = 0;

    $codigoAceiteTitulo                   = "N";
    $codigoTipoTitulo                     = 2;
    $indicadorPermissaoRecebimentoParcial = "N";
    $textoNumeroTituloBeneficiario        = "987654321987654"; /*código para identificação do Título de Cobrança, gerado pelo banco responsável pela cobrança ou 
    pelo beneficiário, dependendo do tipo de convênio*/
    $codigoTipoContaCaucao                = 1; //não obrigatório;
    $textoNumeroTituloCliente             = "000". $numeroConvenio . "0001234567"; /* define o número adotado e controlado pelo Cliente, para identificar o Título de Cobrança,  Apesar de ser tipo string, só serão aceitos caracteres numéricos neste campo. Os três (3) primeiros 
    bytes devem ser zeros, os sete (7) seguintes serão o número do convênio e os dez (10) finais o número  *///Nós criamos, confirmar com banco.
    $textoMensagemBloquetoOcorrencia      = "Pagamento disponível até a data de vencimento";
    $codigoTipoInscricaoPagador           = 1; //1 para CPf e 2 para CNPJ
    $codigoTipoInscricaoPagado            = 2;
    $numeroInscricaoPagador               = $cpf; // CPF ou CNPJ
    $codigoChaveUsuario                   = 1; // define matrícula do usuário que está executando o registro de título. 
    $codigoTipoCanalSolicitacao           = 5; //define o código do tipo do canal pelo qual está sendo executada a solicitação. 

$prod = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sch="http://www.tibco.com/schemas/bws_registro_cbr/Recursos/XSD/Schema.xsd">
<soapenv:Header />
<soapenv:Body>
    <sch:requisicao>
    <sch:numeroConvenio>' . $numeroConvenio . '</sch:numeroConvenio>
    <sch:numeroCarteira>' . $numeroCarteira . '</sch:numeroCarteira>
    <sch:numeroVariacaoCarteira>' . $numeroVariacaoCarteira . '</sch:numeroVariacaoCarteira>
    <sch:codigoModalidadeTitulo>' . $codigoModalidadeTitulo . '</sch:codigoModalidadeTitulo>
    <sch:dataEmissaoTitulo>' . $dataEmissaoTitulo . '</sch:dataEmissaoTitulo>
    <sch:dataVencimentoTitulo>' . $dataVencimentoTitulo . '</sch:dataVencimentoTitulo>
    <sch:valorOriginalTitulo>' . $valorOriginalTitulo . '</sch:valorOriginalTitulo>
    <sch:codigoTipoDesconto>' . $codigoTipoDesconto . '</sch:codigoTipoDesconto>
    <sch:dataDescontoTitulo></sch:dataDescontoTitulo>
    <sch:percentualDescontoTitulo />
    <sch:valorDescontoTitulo></sch:valorDescontoTitulo>
    <sch:valorAbatimentoTitulo />
    <sch:quantidadeDiaProtesto>' . $quantidadeDiaProtesto . '</sch:quantidadeDiaProtesto>
    <sch:codigoTipoJuroMora>' . $codigoTipoJuroMora . '</sch:codigoTipoJuroMora>
    <sch:percentualJuroMoraTitulo />
    <sch:valorJuroMoraTitulo />
    <sch:codigoTipoMulta>' . $codigoTipoMulta . '</sch:codigoTipoMulta>
    <sch:dataMultaTitulo></sch:dataMultaTitulo>
    <sch:percentualMultaTitulo></sch:percentualMultaTitulo>
    <sch:valorMultaTitulo />
    <sch:codigoAceiteTitulo>' . $codigoAceiteTitulo . '</sch:codigoAceiteTitulo>
    <sch:codigoTipoTitulo>' . $codigoTipoTitulo . '</sch:codigoTipoTitulo>
    <sch:textoDescricaoTipoTitulo></sch:textoDescricaoTipoTitulo>
    <sch:indicadorPermissaoRecebimentoParcial>' . $indicadorPermissaoRecebimentoParcial . '</sch:indicadorPermissaoRecebimentoParcial>
    <sch:textoNumeroTituloBeneficiario>' . $textoNumeroTituloBeneficiario . '</sch:textoNumeroTituloBeneficiario>
    <sch:textoCampoUtilizacaoBeneficiario />
    <sch:codigoTipoContaCaucao>' . $codigoTipoContaCaucao . '</sch:codigoTipoContaCaucao>
    <sch:textoNumeroTituloCliente>' . $textoNumeroTituloCliente . '</sch:textoNumeroTituloCliente>
    <sch:textoMensagemBloquetoOcorrencia>' . $textoMensagemBloquetoOcorrencia . '</sch:textoMensagemBloquetoOcorrencia>
    <sch:codigoTipoInscricaoPagador>' . $codigoTipoInscricaoPagador . '</sch:codigoTipoInscricaoPagador>
    <sch:numeroInscricaoPagador>' . $numeroInscricaoPagador . '</sch:numeroInscricaoPagador>
    <sch:nomePagador>' . $nomePagador . '</sch:nomePagador>
    <sch:textoEnderecoPagador>' . $textoEnderecoPagador . '</sch:textoEnderecoPagador>
    <sch:numeroCepPagador>' . $numeroCepPagador . '</sch:numeroCepPagador>
    <sch:nomeMunicipioPagador>' . $nomeMunicipioPagador . '</sch:nomeMunicipioPagador>
    <sch:nomeBairroPagador>' . $nomeBairroPagador . '</sch:nomeBairroPagador>
    <sch:siglaUfPagador>' . $siglaUfPagador . '</sch:siglaUfPagador>
    <sch:textoNumeroTelefonePagador>' . $textoNumeroTelefonePagador . '</sch:textoNumeroTelefonePagador>
    <sch:codigoTipoInscricaoAvalista />
    <sch:numeroInscricaoAvalista />
    <sch:nomeAvalistaTitulo />
    <sch:codigoChaveUsuario>' . $codigoChaveUsuario . '</sch:codigoChaveUsuario>
    <sch:codigoTipoCanalSolicitacao>' . $codigoTipoCanalSolicitacao . '</sch:codigoTipoCanalSolicitacao>
    </sch:requisicao>
</soapenv:Body>
</soapenv:Envelope>';

$dev = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sch="http://www.tibco.com/schemas/bws_registro_cbr/Recursos/XSD/Schema.xsd">
    <soapenv:Header />
    <soapenv:Body>
    <sch:requisicao>
        <sch:numeroConvenio>1014051</sch:numeroConvenio>
        <sch:numeroCarteira>17</sch:numeroCarteira>
        <sch:numeroVariacaoCarteira>19</sch:numeroVariacaoCarteira>
        <sch:codigoModalidadeTitulo>1</sch:codigoModalidadeTitulo>
        <sch:dataEmissaoTitulo>24.10.2018</sch:dataEmissaoTitulo>
        <sch:dataVencimentoTitulo>27.10.2018</sch:dataVencimentoTitulo>
        <sch:valorOriginalTitulo>30000</sch:valorOriginalTitulo>
        <sch:codigoTipoDesconto>0</sch:codigoTipoDesconto>
        <sch:dataDescontoTitulo></sch:dataDescontoTitulo>
        <sch:percentualDescontoTitulo />
        <sch:valorDescontoTitulo></sch:valorDescontoTitulo>
        <sch:valorAbatimentoTitulo />
        <sch:quantidadeDiaProtesto></sch:quantidadeDiaProtesto>
        <sch:codigoTipoJuroMora>0</sch:codigoTipoJuroMora>
        <sch:percentualJuroMoraTitulo />
        <sch:valorJuroMoraTitulo />
        <sch:codigoTipoMulta>0</sch:codigoTipoMulta>
        <sch:dataMultaTitulo></sch:dataMultaTitulo>
        <sch:percentualMultaTitulo></sch:percentualMultaTitulo>
        <sch:valorMultaTitulo />
        <sch:codigoAceiteTitulo>N</sch:codigoAceiteTitulo>
        <sch:codigoTipoTitulo>2</sch:codigoTipoTitulo>
        <sch:textoDescricaoTipoTitulo></sch:textoDescricaoTipoTitulo>
        <sch:indicadorPermissaoRecebimentoParcial>N</sch:indicadorPermissaoRecebimentoParcial>
        <sch:textoNumeroTituloBeneficiario>987654321987654</sch:textoNumeroTituloBeneficiario>
        <sch:textoCampoUtilizacaoBeneficiario />
        <sch:codigoTipoContaCaucao>1</sch:codigoTipoContaCaucao>
        <sch:textoNumeroTituloCliente>00010140511111111111</sch:textoNumeroTituloCliente>
        <sch:textoMensagemBloquetoOcorrencia>Pagamento disponível até a data de vencimento</sch:textoMensagemBloquetoOcorrencia>
        <sch:codigoTipoInscricaoPagador>1</sch:codigoTipoInscricaoPagador>
        <sch:numeroInscricaoPagador>90299295290</sch:numeroInscricaoPagador>
        <sch:nomePagador>MERCADO ANDREAZA DE MACEDO</sch:nomePagador>
        <sch:textoEnderecoPagador>RUA SEM NOME</sch:textoEnderecoPagador>
        <sch:numeroCepPagador>12345678</sch:numeroCepPagador>
        <sch:nomeMunicipioPagador>BRASILIA</sch:nomeMunicipioPagador>
        <sch:nomeBairroPagador>SIA</sch:nomeBairroPagador>
        <sch:siglaUfPagador>DF</sch:siglaUfPagador>
        <sch:textoNumeroTelefonePagador>45619988</sch:textoNumeroTelefonePagador>
        <sch:codigoTipoInscricaoAvalista />
        <sch:numeroInscricaoAvalista />
        <sch:nomeAvalistaTitulo />
        <sch:codigoChaveUsuario>1</sch:codigoChaveUsuario>
        <sch:codigoTipoCanalSolicitacao>5</sch:codigoTipoCanalSolicitacao>
    </sch:requisicao>
    </soapenv:Body>
</soapenv:Envelope>';

    $curl = curl_init();
    //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt_array($curl, array(
    CURLOPT_PORT => "7101",
    CURLOPT_URL => "https://cobranca.homologa.bb.com.br:7101/registrarBoleto",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $prod,
    //CURLOPT_POSTFIELDS => $dev,
    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer " . $token,
        "cache-control: no-cache",
        "content-type: text/xml",
        "token: ca360c5e-433f-f7c4-858c-0620bc081003",
        "soapaction: registrarBoleto"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {

        $myXMLData = str_replace(":","",$response);
        $movies = new SimpleXMLElement($myXMLData);
        $json  = json_encode($movies);
        $configData = json_decode($json, true);
        $configData = $configData['SOAP-ENVBody']['ns0resposta'];
        //mostra boleto
        $boleto_display                       = "block";
    }
}


