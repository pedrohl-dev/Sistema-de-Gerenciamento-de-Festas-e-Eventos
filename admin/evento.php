<?php
session_start();
require_once '../conexao.php';

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

// Buscar eventos cadastrados
$eventos = $conn->query("SELECT nome, data, local FROM eventos ORDER BY data DESC");
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Eventos</title>
    <link rel="stylesheet" href="../css/evento.css">

<!--Javascript-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btn = document.querySelector('.cadastrar')
            const popUp = document.getElementById('popup')
            const fundo = document.getElementById('fundo')
            const closeBtn = document.getElementById('close-btn')

            function abrirPopup() {
                fundo.style.display = "flex"
                popUp.style.display = "flex"

                fundo.classList.remove("fundo-desaparecer")
                popUp.classList.remove("popup-desaparecer")

                fundo.classList.add("fundo-aparecer")
                popUp.classList.add("popup-aparecer")
            }

            function fecharPopup() {
                fundo.classList.remove("fundo-aparecer")
                popUp.classList.remove("popup-aparecer")

                fundo.classList.add("fundo-desaparecer")
                popUp.classList.add("popup-desaparecer")
                
                setTimeout(() => {
                    fundo.style.display = "none"
                    popUp.style.display = "none"
                }, 400); //0.4s de delay
            }

            btn.addEventListener("click", abrirPopup); // Faz o popup e fundo aparecerem clicando no botão "Cadastrar Evento"

            fundo.addEventListener("click", fecharPopup); // Fecha o popup clicando no fundo transparente

            closeBtn.addEventListener("click", fecharPopup); // Fecha o popup clicando o X
    });

</script>
<!--Javascript-->

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
        <button class="cadastrar" id="cadastrar">Cadastrar Evento</button>
        <h2>Eventos Cadastrados</h2>
    <div class="evento">
            <?php if ($eventos->num_rows > 0): ?>
                <table>
                    <tr class="head"><th>Nome</th><th>Local</th><th>Data</th></tr>
                    <?php while ($evento = $eventos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($evento['nome']); ?></td>
                            <td><?php echo htmlspecialchars($evento['local']); ?></td>
                            <td><?php echo htmlspecialchars($evento['data']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>Nenhum evento cadastrado ainda.</p>
            <?php endif; ?>
            </div>
        </div>
        
        <div class="fundo" id="fundo"></div>
        <div class="popup" id="popup">
        <button class="close-btn" id="close-btn">X</button>
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

                <label>Imagem (link ou nome do arquivo):</label>
                <input type="text" name="imagem">

                <input type="submit" name="criar_evento" value="Criar Evento">
            </form>
        </div>
        <footer>
            <p>&copy; Sistema de Gestão de Feiras e Eventos Locais</p>
        </footer>
    </section>
</body>
</html>