<?php


    /*    
    Seguem os dados do convênio de cobrança gerado para a Cobrança WebService:

    ---------------------------- Consultar - Servico --------------------
    Cliente : 200798496 - EDITORA FTD S/A                                
    Agencia : 1911 - 9 CORP BANK INFRA           Conta   :    100130 - 2 
    Carteira: 17 SIMPLES COM REGISTRO            Variacao: 04 - 3        
    Convenio: 3135329     Contrato: 19920359                             
    Nr Unico OPR     : 20182913553611796  EVT/OPR   : 74334017043        
    Situacao: 1 Ativo                     Finalidade: 00 Cobr. de Titulo 
    Ag./Conta - Credito: 1911 - 9     100130 - 2 EDITORA FTD S/A         
    Ag./Conta - Debito : 1911 - 9     100130 - 2 EDITORA FTD S/A         
                                                                        
                                                                        
    ------------------------ Detalhamento do Convenio ------------------
    Agencia       :       1911 9 - CORP BANK INFRA                      
    Beneficiario  :     100130 2 - EDITORA FTD S/A                      
    Cart/Variacao :     17/043 SIMPLES COM REGISTRO                     
    Tipo Convenio :          4 Cliente: Numera, emite e expede          
    Situacao      :          1 Normal com retorno                       
    Nr.Convenio   :    3135329               Nr.Conv.Lider   : 3135329  
    Formato Conv  :          4 CNAB 400 - BB                            
    Tipo Ret.Lider:          5 CBR641/643 - Gerenciador Financeiro  
    */

    //DADOS DO CLIENTE QUE VAI PAGAR (EMISSOR)

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
    $valorOriginalTitulo                  = number_format($_POST["valor"],2);
    $textoNumeroTelefonePagador           = ""; //Opcional;

    //DADOS DA CONTA BANCO DO BRASIL
    $numeroConvenio                       = 3135329;
    $numeroCarteira                       = 17;
    $numeroVariacaoCarteira               = 19; //convênio esta como 04 - 3;
    $codigoModalidadeTitulo               = 1;
    $dataEmissaoTitulo                    = date('Y-m-d');
    $dataVencimentoTitulo                 = date('Y-m-d', strtotime($dataEmissaoTitulo. ' + 3 days'));
    $codigoTipoDesconto                   = 1;
    $quantidadeDiaProtesto                = 0;
    $codigoTipoJuroMora                   = 0;
    $codigoTipoMulta                      = 2;


    $codigoAceiteTitulo                   = "N";
    $codigoTipoTitulo                     = 2;
    $indicadorPermissaoRecebimentoParcial = "N";
    $textoNumeroTituloBeneficiario        = ""; //Descobrir o que é;
    $codigoTipoContaCaucao                = 1; //não obrigatório;
    $textoNumeroTituloCliente             = "00010140510000000000"; //Nós criamos, confirmar com banco.
    $textoMensagemBloquetoOcorrencia      = "Pagamento disponível até a data de vencimento";
    $codigoTipoInscricaoPagador           = 2;
    $codigoTipoInscricaoPagado            = 2;
    $numeroInscricaoPagador               = 73400584000166;
    $codigoChaveUsuario                   = 1;
    $codigoTipoCanalSolicitacao           = "";

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


$dev = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sch="http://www.tibco.com/schemas/bws_registro_cbr/Recursos/XSD/Schema.xsd">
   <soapenv:Header />
   <soapenv:Body>
      <sch:requisicao>
         <sch:numeroConvenio>1014051</sch:numeroConvenio>
         <sch:numeroCarteira>17</sch:numeroCarteira>
         <sch:numeroVariacaoCarteira>19</sch:numeroVariacaoCarteira>
         <sch:codigoModalidadeTitulo>1</sch:codigoModalidadeTitulo>
         <sch:dataEmissaoTitulo>01.03.2017</sch:dataEmissaoTitulo>
         <sch:dataVencimentoTitulo>21.11.2017</sch:dataVencimentoTitulo>
         <sch:valorOriginalTitulo>30000</sch:valorOriginalTitulo>
         <sch:codigoTipoDesconto>1</sch:codigoTipoDesconto>
         <sch:dataDescontoTitulo>21.11.2016</sch:dataDescontoTitulo>
         <sch:percentualDescontoTitulo />
         <sch:valorDescontoTitulo>10</sch:valorDescontoTitulo>
         <sch:valorAbatimentoTitulo />
         <sch:quantidadeDiaProtesto>0</sch:quantidadeDiaProtesto>
         <sch:codigoTipoJuroMora>0</sch:codigoTipoJuroMora>
         <sch:percentualJuroMoraTitulo />
         <sch:valorJuroMoraTitulo />
         <sch:codigoTipoMulta>2</sch:codigoTipoMulta>
         <sch:dataMultaTitulo>22.11.2017</sch:dataMultaTitulo>
         <sch:percentualMultaTitulo>10</sch:percentualMultaTitulo>
         <sch:valorMultaTitulo />
         <sch:codigoAceiteTitulo>N</sch:codigoAceiteTitulo>
         <sch:codigoTipoTitulo>2</sch:codigoTipoTitulo>
         <sch:textoDescricaoTipoTitulo>DUPLICATA</sch:textoDescricaoTipoTitulo>
         <sch:indicadorPermissaoRecebimentoParcial>N</sch:indicadorPermissaoRecebimentoParcial>
         <sch:textoNumeroTituloBeneficiario>987654321987654</sch:textoNumeroTituloBeneficiario>
         <sch:textoCampoUtilizacaoBeneficiario />
         <sch:codigoTipoContaCaucao>1</sch:codigoTipoContaCaucao>
         <sch:textoNumeroTituloCliente>00010140510000000000</sch:textoNumeroTituloCliente>
         <sch:textoMensagemBloquetoOcorrencia>Pagamento disponível até a data de vencimento</sch:textoMensagemBloquetoOcorrencia>
         <sch:codigoTipoInscricaoPagador>2</sch:codigoTipoInscricaoPagador>
         <sch:numeroInscricaoPagador>73400584000166</sch:numeroInscricaoPagador>
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
    CURLOPT_POSTFIELDS => $dev,

    CURLOPT_HTTPHEADER => array(
    "authorization: Bearer " . $token,
    "cache-control: no-cache",
    "content-type: text/xml",
    "postman-token: ca360c5e-433f-f7c4-858c-0620bc081003",
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
        
        $boleto_display                       = "block";
    }
}


