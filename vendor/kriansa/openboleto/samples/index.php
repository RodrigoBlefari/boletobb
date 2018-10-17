<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="js/script.js"></script>
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
        <label for=""> <input placeholder="TOKEN" type="text"></label>    
        <input class="token-generator" type="button" value="GERAR TOKEN">
    </form>
</div>

<div class="container">
    <form action="">
  
    <h2>GERADOR DE BOLETO </h2>
        <label for=""> <input placeholder="TOKEN" type="text"></label>
        <label for=""> <input placeholder="NOME" type="text"></label>
        <label for=""> <input placeholder="NOME" type="text"></label>
        <label for=""> <input placeholder="NOME" type="text"></label>
        <label for=""> <input placeholder="NOME" type="text"></label>
        <input class="bol-generator" type="button" value="GERAR BOLETO">
    </form>
</div>
 
<div class="boleto-modal">
    <div class="modal-content">
        <?php
            include "banco_do_brasil.php";
        ?>
    </div>
</div>
</body>
</html>