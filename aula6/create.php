<?php
require_once "db.php";

$db = new Database("localhost", "root", "root", "blocodenotas");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["categories"])) {
        $array = [
            "nome" => $_POST["name"],
            "descricao" => $_POST['description']
        ];

        $id = $_POST["categories"];

        echo $db->create($array, $id, "nota");
    }

}





?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
    <form method="POST">
        <label for="name">Nome:</label>
        <input type="text" name="name">
        <label for="description">Descrição:</label>
        <input type="text" name="description">
        <select name="categories">
            <option value="1">Pessoal</option>
            <option value="2">Trabalho</option>
            <option value="3">Estudos</option>
            <option value="4">Financeiro</option>
            <option value="5">Saúde</option>
        </select>
        <button type="submit">Criar</button>
    </form>
</body>
</html>