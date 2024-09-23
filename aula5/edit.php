<?php
require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_diario = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT Diario.*, Professor.nome_professor, Aulas.materia
    FROM Diario
    JOIN Professor ON Diario.id_professor = Professor.id_professor
    JOIN Aulas ON Diario.id_aula = Aulas.id_aula
    WHERE Diario.id_diario = ?
");
$stmt->bind_param("i", $id_diario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$diario = $result->fetch_assoc();

$professores = $conn->query("SELECT id_professor, nome_professor FROM Professor ORDER BY nome_professor ASC");

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_professor = isset($_POST['id_professor']) ? intval($_POST['id_professor']) : 0;
    $id_aula = isset($_POST['id_aula']) ? intval($_POST['id_aula']) : 0;
    $horario_aula = isset($_POST['horario_aula']) ? $_POST['horario_aula'] : '';
    $data_aula = isset($_POST['data_aula']) ? $_POST['data_aula'] : '';
    $conteudo_abordado = isset($_POST['conteudo_abordado']) ? trim($_POST['conteudo_abordado']) : '';

    if ($id_professor > 0 && $id_aula > 0 && !empty($horario_aula) && !empty($data_aula) && !empty($conteudo_abordado)) {
        $stmt = $conn->prepare("UPDATE Diario SET id_professor = ?, id_aula = ?, horario_aula = ?, data_aula = ?, conteudo_abordado = ? WHERE id_diario = ?");
        if ($stmt) {
            $stmt->bind_param("iisssi", $id_professor, $id_aula, $horario_aula, $data_aula, $conteudo_abordado, $id_diario);
            if ($stmt->execute()) {
                echo "<script>alert('Aula atualizada com sucesso!'); window.location.href='index.php';</script>";
                exit();
            } else {
                $message = "Erro ao atualizar aula: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
            }
            $stmt->close();
        } else {
            $message = "Erro na preparação da consulta: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
        }
    } else {
        $message = "Por favor, preencha todos os campos obrigatórios.";
    }
}

$stmt = $conn->prepare("
    SELECT A.id_aula, A.materia 
    FROM Aulas A
    INNER JOIN Professor_Materias PM ON A.id_aula = PM.id_aula
    WHERE PM.id_professor = ?
");
$stmt->bind_param("i", $diario['id_professor']);
$stmt->execute();
$materias_result = $stmt->get_result();

$materias = [];
while ($row = $materias_result->fetch_assoc()) {
    $materias[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Aula</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function fetchMaterias(selectedAula = null) {
            var id_professor = document.getElementById('id_professor').value;
            var materiaSelect = document.getElementById('id_aula');

            materiaSelect.innerHTML = '<option value="">Carregando...</option>';

            if (id_professor === "") {
                materiaSelect.innerHTML = '<option value="">Selecione o Professor primeiro</option>';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_materias.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var materias = JSON.parse(xhr.responseText);
                    var options = '<option value="">Selecione a Matéria</option>';
                    for (var i = 0; i < materias.length; i++) {
                        var selected = (selectedAula && materias[i].id_aula == selectedAula) ? ' selected' : '';
                        var materia = materias[i].materia.replace(/"/g, '&quot;');
                        options += '<option value="' + encodeURIComponent(materias[i].id_aula) + '"' + selected + '>' + materia + '</option>';
                    }
                    materiaSelect.innerHTML = options;
                }
            };
            xhr.send('id_professor=' + encodeURIComponent(id_professor));
        }

        window.onload = function() {
            fetchMaterias(<?php echo intval($diario['id_aula']); ?>);
        };
    </script>
</head>
<body>
    <div class="container">
        <h1>Editar Aula</h1>
        <?php if ($message != ''): ?>
            <div class="alert"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form method="POST" action="edit.php?id=<?php echo urlencode($id_diario); ?>">
            <label for="id_professor">Nome do Professor:</label>
            <select name="id_professor" id="id_professor" required onchange="fetchMaterias()">
                <option value="">Selecione o Professor</option>
                <?php while($prof = $professores->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($prof['id_professor'], ENT_QUOTES, 'UTF-8'); ?>" <?php if($prof['id_professor'] == $diario['id_professor']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($prof['nome_professor'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="id_aula">Matéria:</label>
            <select name="id_aula" id="id_aula" required>
                <option value="">Selecione o Professor primeiro</option>
            </select>

            <label for="horario_aula">Horário da Aula:</label>
            <input type="time" name="horario_aula" id="horario_aula" value="<?php echo htmlspecialchars($diario['horario_aula'], ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="data_aula">Data da Aula:</label>
            <input type="date" name="data_aula" id="data_aula" value="<?php echo htmlspecialchars($diario['data_aula'], ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="conteudo_abordado">Conteúdo Abordado:</label>
            <textarea name="conteudo_abordado" id="conteudo_abordado" required><?php echo htmlspecialchars($diario['conteudo_abordado'], ENT_QUOTES, 'UTF-8'); ?></textarea>

            <input type="submit" value="Atualizar Aula">
        </form>
        <br>
        <a href="index.php" class="button">Voltar</a>
    </div>
</body>
</html>
