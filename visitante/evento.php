<?php
session_start();
require_once __DIR__ . "/../conexao.php";
$id_evento = intval($_GET['id']??0);
$ev = $conn->query("SELECT * FROM eventos WHERE id_evento=$id_evento")->fetch_assoc();
if(!$ev) die("Evento não encontrado");

// Expositores confirmados
$expo = $conn->query("SELECT u.id_usuario,u.nome FROM evento_expositores ee JOIN usuarios u ON u.id_usuario=ee.id_expositor WHERE ee.id_evento=$id_evento");

// produtos
$prod_por_exp=[];
foreach($conn->query("SELECT u.id_usuario FROM evento_expositores ee JOIN usuarios u ON u.id_usuario=ee.id_expositor WHERE ee.id_evento=$id_evento") as $ex){
    $id_exp=$ex['id_usuario'];
    $prod_por_exp[$id_exp]=$conn->query(
        "SELECT p.nome,p.descricao,c.nome_categoria FROM produtos p LEFT JOIN categorias_produto c ON c.id_categoria=p.id_categoria WHERE p.id_usuario=$id_exp"
    )->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Evento - Detalhes</title>
        <link rel="stylesheet" href="../css/eventos_detalhes.css">

        <script>
            function presencaConfirma() {
                alert("Presença confirmada com sucesso!");
            }
        </script>

    </head>
<body>
    <div class="content">
        <h1><?=htmlspecialchars($ev['nome'])?></h1>
            <p><?=date('d/m/Y', strtotime($ev['data']))?> — <?=htmlspecialchars($ev['local'])?></p>

            <h2>Expositores Confirmados</h2>
            <div class="box">
                <?php foreach($expo as $ex): ?>
                    <h3 class="title"><?=htmlspecialchars($ex['nome'])?></h3>
                    <ul>
                    <?php foreach($prod_por_exp[$ex['id_usuario']] as $p): ?>
                    <li><b><?=$p['nome']?></b> — <?=$p['descricao']?> (<?=$p['nome_categoria']?>)</li>
                    <?php endforeach; ?>
                    </ul>
                    <?php endforeach; ?>

                    <form method="post" action="confirmar_presenca.php">
                    <input type="hidden" name="id_evento" value="<?=$id_evento?>">
                    </div>
                <div class="button-area">
                <button type="submit" onclick="presencaConfirma()">Confirmar Presença</button>
                <button><a href="home.php">Retornar</a></button>
                    </div>
        </div>
    </form>
</body>
</html>
