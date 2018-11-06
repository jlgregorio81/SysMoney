<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>



<label for="cep">CEP:</label>
<input type="text" name="cep" id="cep"><br>
<button id="btnConsultarCep">Consultar</button>
<div id="viewCep" style="border: solid medium black; width:300px; height:auto">
</div>

<hr>


<label for="name">Nome da Cidade:</label>
<input type="text" name="name" id="name"><br>
<button id="btnConsultarCidade">Consultar</button>
<div id="viewCidade" style="border: solid medium black; width:300px; height:auto">
</div>

<script src="core/vendor/js/jquery-3.3.1.min.js"></script>

<script>

    //..exibe dados da cidade
    $("#btnConsultarCep").click(function (e) {         
        url = "http://viacep.com.br/ws/" + $("#cep").val() + "/json/";
        $("#viewCep").empty();
        $.getJSON(url, function (data) {
            //..primeira msg de sucesso!
            $("#viewCep").append("<p><strong>Requisição realizada!</p>")
            //..percorre os dados em formato JSON e os exibe
            $.each(data, function (key, value) {                  
                 $("#viewCep").append("<p>" + key +" = " + value + "</>");
            });
        }
        ).done(function(){
            //..qdo a requisição termina - sucesso!
            $("#viewCep").append("<p><strong>Dados retornados!</p>")
            }
        ).fail(function(){
            //..erro!
            $("#viewCep").append("<p><strong>Erro!</p>")
            }
        ).always(function (){
            $("#viewCep").append("<p><strong>Fim da Requisição!</p>")
        });
    });

    //exibe cidades pesquisadas
    $("#btnConsultarCidade").click(function (e) { 
        url = "Request.php?class=CityCtr&method=getCities&name="+$("#name").val();
        $("#viewCidade").empty();
        $.getJSON(url, function (data) {
            $.each(data, function (key, value) {                   
                $("#viewCidade").append("<p>" + value.name_city +"/" + value.state_city + "</>");                
            });
        })
    });

</script>
    
</body>
</html>