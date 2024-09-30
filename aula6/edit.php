<?php
require_once "db.php";

$db = new Database("localhost", "root", "root", "blocodenotas");

$nota = null;
if (isset($_GET['id'])) {
    $nota = $db->getNota($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedNota = [
        'nome' => $_POST['nome'],
        'descricao' => $_POST['descricao'],
        'fk_categoria' => $_POST['categoria']
    ];
    $db->update($updatedNota, $_GET['id'], 'nota');
    header('Location: index.php');
}

