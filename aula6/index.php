<?php
include 'db.php'; 
$query = "SELECT * FROM notas ORDER BY criado_em DESC";
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
    <div class="container">
        <h1>📒 Meu Bloco de Notas</h1>
        <a href="add.php" class="btn">➕ Adicionar Nova Nota</a>
        
        <div class="notas-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="nota">
                    <h2 contenteditable="true"><?= htmlspecialchars($row['titulo']) ?></h2>
                    <p contenteditable="true"><?= htmlspecialchars($row['conteudo']) ?></p>
                    <p><strong>Categoria:</strong> <?= htmlspecialchars($row['categoria']) ?></p>
                    <div class="actions">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn">✏️ Editar</a>
                        <button onclick="deleteNota(<?= $row['id'] ?>)" class="btn">🗑️ Excluir</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function deleteNota(id) {
            if (confirm("Tem certeza que deseja excluir esta nota?")) {
                fetch(`delete.php?id=${id}`, {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Nota excluída com sucesso!');
                        location.reload();
                    } else {
                        alert('Erro ao excluir a nota.');
                    }
                });
            }
        }
    </script>
</body>
</html>
