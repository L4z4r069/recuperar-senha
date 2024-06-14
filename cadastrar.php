<?php

require_once "conecta.php";

$conectar = conectar();

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//TODO armazenar a senha de modo seguro
$sql = "INSERT INTO usuario (nome, email, senha) 
        VALUES ('$nome', '$email', '$senha')";

$resultado = mysqli_query($conectar, $sql);

if (mysqli_errno($conexao) == 1062) {
    echo "Email ja cadastrado no sistema1 tente fazer o login ou
    faça a recuperação de senha";
    die();
} else {
    echo "Erro ao buscar o novo usuario! " .
        mysqli_errno($conectar) . ": " . mysqli_error($conectar);
    die();
}
header('location: index.php');
