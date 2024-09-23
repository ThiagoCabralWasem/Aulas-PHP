<?php
require 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_professor'])) {
    $id_professor = intval($_POST['id_professor']);

    $stmt = $conn->prepare("
        SELECT A.id_aula, A.materia 
        FROM Aulas A
        INNER JOIN Professor_Materias PM ON A.id_aula = PM.id_aula
        WHERE PM.id_professor = ?
    ");
    if ($stmt) {
        $stmt->bind_param("i", $id_professor);
        $stmt->execute();
        $result = $stmt->get_result();

        $materias = [];
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row;
        }

        echo json_encode($materias);
        exit();
    }
}

echo json_encode([]);
?>
