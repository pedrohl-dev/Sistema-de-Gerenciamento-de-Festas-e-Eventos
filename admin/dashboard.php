<?php
session_start();
require_once '../conexao.php'; // ajuste o caminho conforme a estrutura do seu projeto

// Verificação de sessão e tipo de usuário
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Aprovação de expositores
if (isset($_GET['aprovar'])) {
    $id = intval($_GET['aprovar']);
    $stmt = $conn->prepare("UPDATE usuarios SET aprovado = 1 WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}

// Cadastro de evento
if (isset($_POST['criar_evento'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];
    $local = $_POST['local'];
    $imagem = $_POST['imagem'];

    $stmt = $conn->prepare("INSERT INTO eventos (nome, descricao, data, local, imagem) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $descricao, $data, $local, $imagem);
    $stmt->execute();
    $stmt->close();
}

// Buscar expositores pendentes
$expositores = $conn->query("SELECT id_usuario, nome, email FROM usuarios WHERE tipo='expositor' AND aprovado=0");

// Buscar eventos cadastrados
$eventos = $conn->query("SELECT nome, data, local FROM eventos ORDER BY data DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <header>
        <h1>Painel Administrativo</h1>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</p>
    </header>

    <nav>
        <a href="eventos_presencas.php">Presenças confirmadas</a>
        <a href="dashboard.php">Aprovação de Expositores</a>
        <a href="evento.php">Gerenciar Eventos</a>
        <a class="logout" href="../logout.php">Logout</a>
    </nav>

    <section>
    <div class="aprova">
    <h2>Aprovação de Expositores</h2>
    <div class="box-e">
            <?php if ($expositores->num_rows > 0): ?>
                <table>
                    <tr><th>Nome</th><th>Email</th><th>Ação</th></tr>
                    <?php while ($exp = $expositores->fetch_assoc()): ?>
                        <tr>
                            <td class="nome"><?php echo htmlspecialchars($exp['nome']); ?></td>
                            <td><?php echo htmlspecialchars($exp['email']); ?></td>
                            <td class="botaodaaprovacao"><a href="dashboard.php?aprovar=<?php echo $exp['id_usuario']; ?>"><button>Aprovar</button></a></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>Não há expositores pendentes de aprovação.</p>
            <?php endif; ?>
            </div>
        </div>
    
    <footer>
        <p>&copy; Sistema de Gestão de Feiras e Eventos Locais</p>
    </footer>
    </section>
</body>
</html>
