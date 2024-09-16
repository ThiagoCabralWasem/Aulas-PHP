<?php
$host = 'localhost';
$db = 'sistema_pedidos';
$user = 'root';
$pass = 'root';

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


function limparEntrada($data) {
    return htmlspecialchars(trim($data));
}


if (isset($_POST['create'])) {
    $nome_cliente = limparEntrada($_POST['nome_cliente']);
    $nome_produto = limparEntrada($_POST['nome_produto']);
    $quantidade = (int) $_POST['quantidade'];
    $data_pedido = limparEntrada($_POST['data_pedido']);

    $stmt = $conn->prepare("INSERT INTO pedidos (nome_cliente, nome_produto, quantidade, data_pedido) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $nome_cliente, $nome_produto, $quantidade, $data_pedido);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erro ao inserir pedido: " . $conn->error;
    }
    $stmt->close();
}


if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $nome_cliente = limparEntrada($_POST['nome_cliente']);
    $nome_produto = limparEntrada($_POST['nome_produto']);
    $quantidade = (int) $_POST['quantidade'];
    $data_pedido = limparEntrada($_POST['data_pedido']);

    $stmt = $conn->prepare("UPDATE pedidos SET nome_cliente=?, nome_produto=?, quantidade=?, data_pedido=? WHERE id=?");
    $stmt->bind_param("ssisi", $nome_cliente, $nome_produto, $quantidade, $data_pedido, $id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erro ao atualizar pedido: " . $conn->error;
    }
    $stmt->close();
}


if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM pedidos WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erro ao deletar pedido: " . $conn->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM pedidos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTX STORE</title>
</head>
<body>
    <h1>MTX STORE</h1>

    <h2>Adicionar um Pedido</h2>
    <form method="POST" action="">
        <input type="text" name="nome_cliente" placeholder="Nome do Cliente" required>
        <input type="text" name="nome_produto" placeholder="Nome do Produto" required>
        <input type="number" name="quantidade" placeholder="Quantidade" required>
        <input type="date" name="data_pedido" required>
        <button type="submit" name="create">Adicionar Pedido</button>
    </form>

    <h2>Pedidos</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome do Cliente</th>
            <th>Nome do Produto</th>
            <th>Quantidade</th>
            <th>Data do Pedido</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nome_cliente']; ?></td>
            <td><?php echo $row['nome_produto']; ?></td>
            <td><?php echo $row['quantidade']; ?></td>
            <td><?php echo $row['data_pedido']; ?></td>
            <td>
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="nome_cliente" value="<?php echo $row['nome_cliente']; ?>" required>
                    <input type="text" name="nome_produto" value="<?php echo $row['nome_produto']; ?>" required>
                    <input type="number" name="quantidade" value="<?php echo $row['quantidade']; ?>" required>
                    <input type="date" name="data_pedido" value="<?php echo $row['data_pedido']; ?>" required>
                    <button type="submit" name="update">Atualizar</button>
                </form>


                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja deletar este pedido?')">Deletar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php

$conn->close();
?>
