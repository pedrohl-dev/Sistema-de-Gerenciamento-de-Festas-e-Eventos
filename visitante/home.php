<?php
session_start();
require_once __DIR__ . "/../conexao.php";
$eventos = $conn->query("SELECT id_evento, nome, descricao, data, local, imagem FROM eventos ORDER BY data ASC");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Home do visitante</title>
        <link rel="stylesheet" href="../css/home.css">
    </head>
    <body>
        <header>
        <h2>Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h2>
    </header>
    <nav>
        <p>Bem-vindo à área do visitante. Aqui você pode ver os eventos disponíveis e se inscrever.</p>
        <a href="../logout.php"><button class="logout">Sair</button></a>
    </nav>
    <section>
    <h1 class="title">Eventos Disponíveis</h1>
        <div class="content">
                <?php while($e=$eventos->fetch_assoc()): ?>
                <div>
                    <table>
                    <thead><tr><th class="nomeevento">Nome</th><th class="datalocal">Data e Local</th><th>Detalhes</th></tr></thead>
                        <tr>
                    <td><h3><?=htmlspecialchars($e['nome'])?></h3></td>
                    <td><p><?=date('d/m/Y', strtotime($e['data']))?> — <?=htmlspecialchars($e['local'])?></p></td>
                    <td><a href="evento.php?id=<?=$e['id_evento']?>">Ver detalhes</a></td>
                </tr>
                </table>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
</body>
</html>
