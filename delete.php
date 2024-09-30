<?php
require_once "db.php";

$db = new Database("localhost", "root", "root", "blocodenotas");
$conn = $db->getConnection(); 

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_nota = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM nota WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $id_nota);
    if ($stmt->execute()) {
        echo "<script>alert('Nota excluída com sucesso!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir a nota.'); window.location.href='index.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Erro na preparação da consulta.'); window.location.href='index.php';</script>";
}

$conn->close();
?>
