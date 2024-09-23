<?php
require 'db.php';

$professores = $conn->query("SELECT id_professor, nome_professor FROM Professor ORDER BY nome_professor ASC");

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_professor = isset($_POST['id_professor']) ? intval($_POST['id_professor']) : 0;
    $id_aula = isset($_POST['id_aula']) ? intval($_POST['id_aula']) : 0;
    $horario_aula = isset($_POST['horario_aula']) ? $_POST['horario_aula'] : '';
    $data_aula = isset($_POST['data_aula']) ? $_POST['data_aula'] : '';
    $conteudo_abordado = isset($_POST['conteudo_abordado']) ? trim($_POST['conteudo_abordado']) : '';

    if ($id_professor > 0 && $id_aula > 0 && !empty($horario_aula) && !empty($data_aula) && !empty($conteudo_abordado)) {
        $stmt = $conn->prepare("INSERT INTO Diario (id_professor, id_aula, horario_aula, data_aula, conteudo_abordado) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iisss", $id_professor, $id_aula, $horario_aula, $data_aula, $conteudo_abordado);
            if ($stmt->execute()) {
                echo "<script>alert('Aula adicionada!'); window.location.href='index.php';</script>";
                exit();
            } else {
                $message = "Erro ao adicionar aula: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
            }
            $stmt->close();
        } else {
            $message = "Erro na consulta: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
        }
    } else {
        $message = "Preencha os campos obrigatórios.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Nova Aula</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script>
        function fetchMaterias() {
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
                        var materia = materias[i].materia.replace(/"/g, '&quot;');
                        options += '<option value="' + encodeURIComponent(materias[i].id_aula) + '">' + materia + '</option>';
                    }
                    materiaSelect.innerHTML = options;
                }
            };
            xhr.send('id_professor=' + encodeURIComponent(id_professor));
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Adicionar Nova Aula</h1>
        <?php if ($message != ''): ?>
            <div class="alert"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form method="POST" action="add.php">
            <label for="id_professor">Nome do Professor:</label>
            <select name="id_professor" id="id_professor" required onchange="fetchMaterias()">
                <option value="">Selecione o Professor</option>
                <?php while($prof = $professores->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($prof['id_professor'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($prof['nome_professor'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="id_aula">Matéria:</label>
            <select name="id_aula" id="id_aula" required>
                <option value="">Selecione o Professor primeiro</option>
            </select>

            <label for="horario_aula">Horário da Aula:</label>
            <input type="time" name="horario_aula" id="horario_aula" required>

            <label for="data_aula">Data da Aula:</label>
            <input type="date" name="data_aula" id="data_aula" required>

            <label for="conteudo_abordado">Conteúdo Abordado:</label>
            <textarea name="conteudo_abordado" id="conteudo_abordado" required></textarea>

            <input type="submit" value="Adicionar Aula">
        </form>
        <br>
        <a href="index.php" class="button">Voltar</a>
    </div>
</body>
</html>
