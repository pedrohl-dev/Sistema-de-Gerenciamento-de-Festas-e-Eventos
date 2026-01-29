<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {

            // Verifica se expositor foi aprovado
            if ($usuario['tipo'] === 'expositor' && !$usuario['aprovado']) {
                header("Location: index.php?erro=Aguardando aprovação");
                exit;
            }

            // Cria sessão
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            // Redireciona conforme o tipo
            switch ($usuario['tipo']) {
                case 'admin':
                    header("Location: admin/dashboard.php");
                    break;
                case 'expositor':
                    header("Location: expositor/painel.php");
                    break;
                case 'visitante':
                    header("Location: visitante/home.php");
                    break;
            }
            exit;
        } else {
            header("Location: index.php?erro=Senha incorreta");
            exit;
        }
    } else {
        header("Location: index.php?erro=Usuario ou senha incorretos");
        exit;
    }
}
?>