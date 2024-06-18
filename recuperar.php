<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "conecta.php";
$conexao = conectar();

$email = $_POST['email'];
$sql = "SELECT * FROM usuario WHERE email = '$email'";
$resultado = executarSQL($conexao, $sql);

$usuario = mysqli_fetch_assoc($resultado);
if($usuario == null){
    echo "Email não cadastrado! Faça o cadastro e     
    em seguida realize o login.";
    die();
}

// Gerar um token unico
$token = bin2hex(random_bytes(50));

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);
try{
    // Configurações
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->setLanguage('br');
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Imprime as mensagens de erro
    $mail->isSMTP(); // Envia o email usanto HTTP
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port = 587; 
} catch (Exception $e) {
    echo "Não foi possivel enviar o email.
    Maile error: {$mail->ErrorInfo}";
}
?>