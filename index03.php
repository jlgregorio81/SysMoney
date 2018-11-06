<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste Ajax</title>
</head>
<body>


<form method="post" action="Request.php?class=CityCtr&method=getCities">
    <label for="nome">Nome:</label>
    <input type="text" name="name" id="nome"><br>
    <input type="submit" value="OK">
</form>

<!-- carrega o Jquery -->
<script src="core/vendor/js/jquery-3.3.1.min.js"></script>

<?php

require_once('autoload.php');

use app\dao\CityDao;

    $cityDao = new CityDao();
    $cities = $cityDao->selectAllAsJson("name_city like 'J%' ");

    var_dump($cities);


?>


    
</body>
</html>


