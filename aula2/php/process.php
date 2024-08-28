<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $base = $_POST['base'];
    $altura = $_POST['altura'];
    $area = ($base * $altura) / 2;
    $limite = 100;

    if ($area > $limite) {
        $mensagem = "A área do triângulo é maior que 100.";
    } else {
        $mensagem = "A área do triângulo é menor ou igual a 100.";
    }

    echo "<div id='resposta'>
            <h1>$mensagem</h1>
            <p>Área calculada: $area</p>
            <a href='index.html'>Calcular novamente</a>
          </div>";
} else {
    header('Location: index.html');
    exit();
}
?>
