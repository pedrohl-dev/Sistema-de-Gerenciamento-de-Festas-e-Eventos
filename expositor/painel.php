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

// --- Processar listagem de categorias e produtos do expositor ---
$categorias = [];
$cat_res = $conn->query("SELECT id_categoria, nome_categoria FROM categorias_produto ORDER BY nome_categoria ASC");
if ($cat_res) {
    while ($row = $cat_res->fetch_assoc()) {
        $categorias[$row['id_categoria']] = $row['nome_categoria'];
    }
}

// Listar produtos do expositor
$produtos = [];
$stmt = $conn->prepare("SELECT id_produto, nome, descricao, id_categoria FROM produtos WHERE id_usuario = ? ORDER BY nome ASC");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$p_res = $stmt->get_result();
while ($r = $p_res->fetch_assoc()) {
    $produtos[] = $r;
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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Expositor - SGFEL</title>
    <link rel="stylesheet" href="painel.css">
</head>
<body>
    <header>
        <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h2>
    </header>
    <nav>
        <a href="../logout.php"><button class="logout">Logout</button></a>
        <h1><a href="painel.php">Painel do Expositor</a></h1>
        <h1><a href="eventos.php">Eventos</a></h1>
    </nav>
    <section>
    <div class="content">
        <p class="title">Gerenciar Produtos</p>
        <div class="container">
        <div class="box">
            <p class="cadastro">Cadastrar Produto</p>
            <form action="salvar_produto.php" method="post">
                <label>Nome:<br><input type="text" name="nome" required></label><br>
                <label>Descrição:<br><textarea name="descricao" rows="3"></textarea></label><br>
                <div class="p-bottom">
                <label>Categoria:<br>
                    <select name="categoria_id" required>
                        <option value="">-- selecione --</option>
                        <?php foreach ($categorias as $id => $nome) : ?>
                            <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($nome); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label><br><br>
                <button class="salvar "type="submit">Salvar Produto</button>
                </div>
            </form>
        </div>
            <div class="line"></div>
        <div class="box">
            <?php if (count($produtos) === 0) : ?>
                <p class="text">Nenhum produto cadastrado.</p>
            <?php else: ?>
                <table>
                    <thead><tr><th>Nome</th><th>Descrição</th><th>Categoria</th><th>Ações</th></tr></thead>
                    <tbody>
                        <?php foreach ($produtos as $prod) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($prod['nome']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($prod['descricao'])); ?></td>
                                <td><?php echo htmlspecialchars($categorias[$prod['id_categoria']] ?? '—'); ?></td>
                                <td class="actions">
                                    <a id="editar" href="editar_produto.php?id=<?php echo $prod['id_produto']; ?>"><script></script>Editar</a>
                                    <a href="excluir_produto.php?id=<?php echo $prod['id_produto']; ?>" onclick="return confirm('Confirmar a exclusão do produto?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        </div>
    </div>
</section>
</body>
</html>