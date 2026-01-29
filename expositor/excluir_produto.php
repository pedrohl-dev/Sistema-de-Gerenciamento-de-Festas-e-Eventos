<?php
session_start();
require_once __DIR__ . "/../conexao.php";

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'expositor') {
    header("Location: ../index.php?erro=Acesso negado");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: painel.php");
    exit;
}

$id = intval($_GET['id']);
$id_usuario = $_SESSION['id_usuario'];

$stmt = $conn->prepare("DELETE FROM produtos WHERE id_produto = ? AND id_usuario = ?");
$stmt->bind_param("ii", $id, $id_usuario);
$stmt->execute();

header("Location: painel.php");
exit;
?>
