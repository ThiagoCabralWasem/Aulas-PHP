<?php
require_once "db.php";

$db = new Database("localhost", "root", "root", "blocodenotas");

$notas = $db->read('nota');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Bloco de Notas</title>
</head>
<body>
    <h1>Notas</h1>
    <a href="create.php">Criar Nova Nota</a>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>
        <?php while ($nota = $notas->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($nota['nome']) ?></td>
                <td><?= htmlspecialchars($nota['descricao']) ?></td>
                <td>
                    <?php 
                    $categoria = $db->getCategorias();
                    while ($cat = $categoria->fetch_assoc()) {
                        if ($cat['id'] == $nota['fk_categoria']) {
                            echo htmlspecialchars($cat['nome']);
                        }
                    }
                    ?>
                </td>
                <td>
                    <a href="edit.php?id=<?= $nota['id'] ?>">Editar</a>
                    <a href="delete.php?id=<?= $nota['id'] ?>">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
