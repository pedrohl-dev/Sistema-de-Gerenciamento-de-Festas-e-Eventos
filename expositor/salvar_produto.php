<?php
session_start();
require_once __DIR__ . "/../conexao.php";

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'expositor') {
    header("Location: ../index.php?erro=Acesso negado");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: painel.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$categoria_id = intval($_POST['categoria_id'] ?? 0);

if ($nome === '' || $categoria_id <= 0) {
    header("Location: painel.php?erro=Dados inválidos");
    exit;
}

$stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, id_categoria, id_usuario) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssii", $nome, $descricao, $categoria_id, $id_usuario);
if ($stmt->execute()) {
    header("Location: painel.php?sucesso=Produto cadastrado");
    exit;
} else {
    header("Location: painel.php?erro=Falha ao salvar");
    exit;
}
?>
