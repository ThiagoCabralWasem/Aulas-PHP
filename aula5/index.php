<?php
require 'db.php';

$sql = "SELECT Diario.id_diario, Professor.nome_professor, Diario.horario_aula, Diario.data_aula, Aulas.materia, Aulas.sala, Diario.conteudo_abordado
        FROM Diario
        JOIN Professor ON Diario.id_professor = Professor.id_professor
        JOIN Aulas ON Diario.id_aula = Aulas.id_aula
        ORDER BY Diario.data_aula DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Diário de Aulas</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function confirmDelete(id) {
            if (confirm("Tem certeza que deseja excluir esta aula?")) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Diário de Aulas</h1>
        <a href="add.php" class="button">Nova Aula</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Professor</th>
                    <th>Horário</th>
                    <th>Data</th>
                    <th>Matéria</th>
                    <th>Sala</th>
                    <th>Conteúdo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_diario'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['nome_professor'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['horario_aula'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['data_aula'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['materia'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['sala'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['conteudo_abordado'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo urlencode($row['id_diario']); ?>" class="button edit">Editar</a>
                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo intval($row['id_diario']); ?>)" class="button delete">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhuma aula encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
