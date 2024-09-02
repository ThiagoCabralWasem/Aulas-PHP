<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];

  $stmt = $conn->prepare("UPDATE user SET name=?, email=? WHERE id=?");
  $stmt->bind_param("ssi", $name, $email, $id);

  if ($stmt->execute() === TRUE) {
    echo "Registro atualizado com sucesso!";
  } else {
    echo "Erro ao atualizar registro: " . $stmt->error;
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atualizar Conta</title>
</head>
<body>
  <form method="post" action="update.php">
    <label for="id">ID</label>  
    <input type="text" name="id" required>
    <label for="name">Nome</label>  
    <input type="text" name="name" required>
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <input type="submit" value="Atualizar conta">
  </form>  
</body>
</html>
