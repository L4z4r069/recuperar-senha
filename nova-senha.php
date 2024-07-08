<?php

//verificar email
//verificar token
$email = $_GET['email'];
$token = $_GET['token'];

require_once "conexao.php";
$conexao = conectar();
$sql = "SELECT * FROM `recuperar-senha` WHERE email='$email' AND token='$token'";
$resultado = executarSQL($conexao, $sql);
$recuperar = mysqli_fetch_assoc($resultado);
if ($resultado == null) {
    echo "Email ou token incorretos. Tente fazer um novo pedido
    de recuperação de senha.";
    die();
} else {
    // verificar a validade do pedido (data_criacao)
    // verificar se o link ja foi usado
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    $data_criacao = DateTime::createFromFormat(
        'Y-m-d H:i:s',
        $recuperar['data_criacao']
    );
    $UmDia = DateInterval::createFromDateString(('1 day'));
    $dataExpiracao = date_add($data_criacao, $UmDia);
    
    if ($data < $dataExpiracao){
        echo "Funcionou";
    }
}
