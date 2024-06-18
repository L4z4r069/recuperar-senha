<?php

// TODO usar sessão
$email = $_POST['email'];
$senha = $_POST['senha'];

require_once "conecta.php";
$conexao = conectar();

$sql = "SELECT * FROM usuario WHERE email = '$email'";
$resultado = $resultado = executarSQL($conexao, $sql);

$usuario = mysqli_fetch_assoc($resultado);
if($usuario == NULL){
    echo "Email não existe no sistema! 
    Por favor, primeiro realize o cadastro no sistema";
    die();
}
if ($senha == $usuario['senha']) {
    header('location: principal.php');
} else {
    echo "Senha invalida! Tente novamente.";
}
