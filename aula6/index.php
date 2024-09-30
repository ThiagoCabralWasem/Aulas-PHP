<?php
include 'db.php';

$query = "SELECT nota.id, nota.nome AS nota_nome, nota.descricao, categoria.nome AS categoria_nome 
          FROM nota 
          JOIN categoria ON nota.fk_categoria = categoria.id 
          ORDER BY nota.id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloco de Notas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

</body>
</html>