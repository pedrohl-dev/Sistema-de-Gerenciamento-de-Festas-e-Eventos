<?php
session_start();
require_once __DIR__ . "/../conexao.php";

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'expositor') {
    header("Location: ../index.php?erro=Acesso negado");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT id_produto, nome, descricao, id_categoria FROM produtos WHERE id_produto = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id, $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        header("Location: painel.php?erro=Produto não encontrado");
        exit;
    }
    $produto = $res->fetch_assoc();

    // obter categorias
    $cats = [];
    $r = $conn->query("SELECT id_categoria, nome_categoria FROM categorias_produto ORDER BY nome_categoria ASC");
    while ($row = $r->fetch_assoc()) $cats[$row['id_categoria']] = $row['nome_categoria'];
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Editar Produto</title>
        <link rel="stylesheet" href="editar.css">
    </head>
    <body>
    <div class="box">
    <h2 class="title">Editar Produto</h2>
    <div class="input-box">
    <div class="text-box">
    <form method="post" action="editar_produto.php">
        <input type="hidden" name="id_produto" value="<?php echo $produto['id_produto']; ?>">
        <label>Nome:<br><input type="text" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required></label><br>
        <label>Categoria:<br>
            <select name="categoria_id" required>
                <?php foreach ($cats as $k=>$v): ?>
                    <option value="<?php echo $k; ?>" <?php if ($k==$produto['id_categoria']) echo 'selected'; ?>><?php echo htmlspecialchars($v); ?></option>
                <?php endforeach; ?>
            </select>
        </label><br><br>
        </div>
        <div class="desc-box">
            <label>Descrição:<br><textarea name="descricao"><?php echo htmlspecialchars($produto['descricao']); ?></textarea></label><br>
        </div>

    </form>
</div>
<div class="button-box">
    <button type="submit">Salvar</button>
    <button><a href="painel.php">Cancelar</a></button>
</div>
</div>

</body>
</html>
<?php
    exit;
}

// Processa POST para atualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_produto'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria_id = intval($_POST['categoria_id'] ?? 0);

    if ($id <= 0 || $nome === '' || $categoria_id <= 0) {
        header("Location: painel.php?erro=Dados inválidos");
        exit;
    }

    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, id_categoria = ? WHERE id_produto = ? AND id_usuario = ?");
    $stmt->bind_param("ssiii", $nome, $descricao, $categoria_id, $id, $id_usuario);
    if ($stmt->execute()) {
        header("Location: painel.php?sucesso=Produto atualizado");
        exit;
    } else {
        header("Location: painel.php?erro=Falha ao atualizar");
        exit;
    }
}
?>
