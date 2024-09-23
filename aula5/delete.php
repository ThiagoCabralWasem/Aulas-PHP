<?php
require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_diario = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM Diario WHERE id_diario = ?");
if ($stmt) {
    $stmt->bind_param("i", $id_diario);
    if ($stmt->execute()) {
        echo "<script>alert('Aula excluída com sucesso!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir a aula.'); window.location.href='index.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Erro na preparação da consulta.'); window.location.href='index.php';</script>";
}

$conn->close();
?>
