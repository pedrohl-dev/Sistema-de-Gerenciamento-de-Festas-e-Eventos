<?php
session_start();
require_once __DIR__ . "/../conexao.php";
if($_SESSION['tipo']!=='admin') die('Acesso negado');

$res=$conn->query("SELECT e.id_evento,e.nome,e.data,e.local,    
 (SELECT COUNT(*) FROM presencas p WHERE p.id_evento=e.id_evento) AS total_presencas,
 (SELECT COUNT(*) FROM evento_expositores ee WHERE ee.id_evento=e.id_evento) AS total_expositores
 FROM eventos e ORDER BY e.data");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Eventos</title>
        <link rel="stylesheet" href="../css/eventos_presencas.css">
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
        <h1 class="title">Eventos e Presenças</h1>
        <div class="content">
        <table border="1">
            <tr><th>Nome</th><th>Data</th><th>Local</th><th>Visitantes</th><th>Expositores</th></tr>
            <?php while($r=$res->fetch_assoc()): ?>
            <tr>
            <td><?=$r['nome']?></td>
            <td><?=date('d/m/Y', strtotime($r['data']))?></td>
            <td><?=$r['local']?></td>
            <td><?=$r['total_presencas']?></td>
            <td><?=$r['total_expositores']?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        </div>
        <footer>
            <p>&copy; Sistema de Gestão de Feiras e Eventos Locais</p>
        </footer>
        </section>
    </body>
</html>
