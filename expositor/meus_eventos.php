<?php
session_start();
require_once __DIR__ . "/../conexao.php";
if($_SESSION['tipo']!=='expositor') die('Acesso negado');

$id_exp=$_SESSION['id_usuario'];
$eventos=$conn->query("SELECT id_evento,nome,data FROM eventos ORDER BY data");

$meus=$conn->query("SELECT id_evento FROM evento_expositores WHERE id_expositor=$id_exp")->fetch_all(MYSQLI_ASSOC);
$lista=array_column($meus,'id_evento');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $conn->query("DELETE FROM evento_expositores WHERE id_expositor=$id_exp");
    if(isset($_POST['evento'])){
        foreach($_POST['evento'] as $ev){
            $ev=intval($ev);
            $conn->query("INSERT INTO evento_expositores (id_evento,id_expositor) VALUES ($ev,$id_exp)");
        }
    }
    header("Location: meus_eventos.php");
    exit;
}
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Meus Eventos</title></head><body>
<h1>Participar de Eventos</h1>
<form method="post">
<?php while($e=$eventos->fetch_assoc()): ?>
<label>
 <input type="checkbox" name="evento[]" value="<?=$e['id_evento']?>" <?=in_array($e['id_evento'],$lista)?'checked':''?>> 
 <?=$e['nome']?> — <?=date('d/m/Y', strtotime($e['data']))?>
</label><br>
<?php endwhile; ?>
<button type="submit">Salvar</button>
<button><a href="eventos.php">Retornar</button>
</form>
</body></html>
