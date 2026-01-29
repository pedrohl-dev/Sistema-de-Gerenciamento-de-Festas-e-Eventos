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
    <title>TESTEEEE</title>
    <link rel="stylesheet" href="teste.css">
</head>
<body>
    <header>
        <h1>Painel Administrativo</h1>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</p>
    </header>

    <nav>
        <a href="#aprovar">Aprovar Expositores</a>
        <a href="#criar">Criar Evento</a>
        <a href="#listar">Listar Eventos</a>
        <a href="../logout.php">Logout</a>
    </nav>

   <div class="aprova">
   <h2>Aprovação de Expositores</h2>
   <div class="box-e">
        <?php if ($expositores->num_rows > 0): ?>
            <table>
                <tr><th>Nome</th><th>Email</th><th>Ação</th></tr>
                <?php while ($exp = $expositores->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exp['nome']); ?></td>
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
   <div class="evento">
   <h2>Eventos Cadastrados</h2>
        <div class="box-c">
        <?php if ($eventos->num_rows > 0): ?>
            <table>
                <tr><th>Nome</th><th>Data</th><th>Local</th></tr>
                <?php while ($evento = $eventos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($evento['data'])); ?></td>
                        <td><?php echo htmlspecialchars($evento['local']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Nenhum evento cadastrado ainda.</p>
        <?php endif; ?>
        </div>
    </div>
    <div class="cadastro">
    <h2>Cadastrar Novo Evento</h2>
        <form method="post" action="">
            <label>Nome do Evento:</label>
            <input type="text" name="nome" required>

            <label>Descrição:</label>
            <textarea name="descricao" rows="3"></textarea>

            <label>Data:</label>
            <input type="date" name="data" required>

            <label>Local:</label>
            <input type="text" name="local" required>

            <label>Imagem (caminho ou nome do arquivo):</label>
            <input type="text" name="imagem">

            <input type="submit" name="criar_evento" value="Criar Evento">
        </form>
    </div>

    <footer>
        <p>&copy; 2025 SGFEL - Sistema de Gestão de Feiras e Eventos Locais</p>
    </footer>
</body>
</html>
