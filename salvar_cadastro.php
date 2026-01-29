<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    // Verifica se o e-mail já está cadastrado
    $verifica = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $verifica->bind_param("s", $email);
    $verifica->execute();
    $resultado = $verifica->get_result();

    if ($resultado->num_rows > 0) {
        header("Location: cadastro.php?erro=E-mail já cadastrado");
        exit;
    }

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Expositores começam com aprovação pendente
    $aprovado = ($tipo === 'expositor') ? 0 : 1;

    $sql = "INSERT INTO usuarios (nome, email, senha, tipo, aprovado) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $senha_hash, $tipo, $aprovado);

    if ($stmt->execute()) {
        header("Location: cadastro.php?msg=Cadastro realizado com sucesso!");
        exit;
    } else {
        header("Location: cadastro.php?erro=Erro ao cadastrar usuário");
        exit;
    }
}
?>
