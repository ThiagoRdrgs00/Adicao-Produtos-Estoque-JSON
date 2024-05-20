<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "estoque";
    
    $conexao = new mysqli($servername, $username, $password, $database);
        
    if (mysqli_connect_error()){
        echo "Houve um erro ao tentar se conectar com o banco de dados.";
    }
?>