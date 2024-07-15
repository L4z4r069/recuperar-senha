<?php

$email = $_POST['email'];
$token = $_POST['token'];
$senha = $_POST['senha'];
$repetirSenha = $_POST['repetirSenha'];

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

    if ($data > $dataExpiracao) {
        echo "Essa solicitação de recuperação de senha expirou!
        Faça um novo pedido de recuperação de senha.";
        die();
    }

    if ($recuperar['usado'] == 1){
        echo "Esse pedido de recuperação de senha já foi utilizado
        anteriomente! Para recuperar a senha faça um novo pedido
        de recuperação de senha";
        die();
    } 

    if ($senha != $repetirSenha){
        echo "A senha que você digitou é diferente de senha que você 
        digitou no repetir senha. Por favor tente novamente!";
        die();
    }

    $sql2 = "UPDATE usuario SET senha = '$senha' 
             WHERE email = '$email'";
    executarSQL($conexao, $sql2);
    $sql3 = "UPDATE `recuperar-senha` SET usado=1 
             WHERE email='$email' AND token='$token'";
    executarSQL($conexao, $sql3);

    echo "Nova senha cadastrada com sucesso! Faça o login
    para acessar o sistema.<br>";
    echo "<a href='index.php'>Acessar Sistema</a>";
 }
?>