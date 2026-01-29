<?php
session_start();
require_once __DIR__ . "/../conexao.php";
if($_SERVER['REQUEST_METHOD']!=='POST') die('Acesso inválido');
if(!isset($_SESSION['id_usuario']) || $_SESSION['tipo']!=='visitante') die('Faça login como visitante');

$id_evento=intval($_POST['id_evento']);
$id_usuario=$_SESSION['id_usuario'];

$chk=$conn->query("SELECT 1 FROM presencas WHERE id_evento=$id_evento AND id_usuario=$id_usuario");
if($chk->num_rows==0){
    $conn->query("INSERT INTO presencas (id_evento,id_usuario) VALUES ($id_evento,$id_usuario)");
}
header("Location: evento.php?id=".$id_evento);
