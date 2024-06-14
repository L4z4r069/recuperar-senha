<?php

// TODO usar sessão
$email = $_POST['email'];
$senha = $_POST['senha'];

require_once "conecta.php";
$conexao = conectar();

$sql = "SELECT * FROM usuario WHERE email = '$email'";
$resultado = mysqli_query($conexao, $sql);

if ($resultado === false) {
        echo "Erro ao buscar usúario! " .
            mysqli_errno($conectar) . ": " . mysqli_error($conectar);
        die();
    }
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
