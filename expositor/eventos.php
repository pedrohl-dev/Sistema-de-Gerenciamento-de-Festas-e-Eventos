<?php
session_start();
require_once __DIR__ . "/../conexao.php";

// Verifica se o usuário está logado e se é expositor
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'expositor') {
    header("Location: ../index.php?erro=Acesso negado");
    exit;
}

// Buscar status de aprovação do expositor diretamente no banco 
$id_usuario = $_SESSION['id_usuario'];
$stmt = $conn->prepare("SELECT aprovado FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$aprovado = $user['aprovado'] ?? 0;

// Se não aprovado, mostra mensagem e sai
if (!$aprovado) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Painel do Expositor - Aguardando aprovação</title>
        <link rel="stylesheet" href="../css/painel.css">
    </head>
    <body>
        <header>
            <h2>Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h2>
        </header>
        <main>
            <p><strong>Status:</strong> Aguardando aprovação pelo administrador.</p>
            <p>Você será notificado quando sua conta for aprovada.</p>
            <a href="../logout.php"><button class="logout">logout</button></a>
        </main>
    </body>
    </html>
    <?php
    exit;
}

// Listar eventos disponíveis
$eventos = [];
$e_res = $conn->query("SELECT id_evento, nome, descricao, 'data', 'local', imagem FROM eventos ORDER BY 'data' ASC");
if ($e_res) {
    while ($row = $e_res->fetch_assoc()) {
        $eventos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos - Expositor</title>
    <link rel="stylesheet" href="eventos_expositor.css">
</head>
<body>
     <header>
        <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h2>
    </header>
    <nav>
        <a href="../logout.php"><button class="logout">Logout</button></a>
        <h2><a href="painel.php">Painel do Expositor</a></h1>
        <h1><a href="eventos.php">Eventos</a></h1>
    </nav>
    <section>
        <p class="title">Eventos</p>
            <div class="eventos-box">
                <?php if (count($eventos) === 0) : ?>
                    <p class="text">Não há eventos cadastrados.</p>
                <?php else: ?>
                    <table>
                        <thead><tr><th>Nome</th><th>Data</th><th>Local</th></tr></thead>
                        <tbody>
                            <?php foreach ($eventos as $ev) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ev['nome']); ?></td>
                                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($ev['data']))); ?></td>
                                    <td><?php echo htmlspecialchars($ev['local']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <a href="meus_eventos.php" class="presenca">Marcar presença em evento</a>
    </section>
</body>
</html>