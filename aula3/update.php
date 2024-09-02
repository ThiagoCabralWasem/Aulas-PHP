<?php
include 'db.php';

$stmt = $conn->prepare("SELECT name, email FROM user");
$stmt->execute();
$stmt->bind_result($name, $email);

echo "<h2>Usuários cadastrados</h2>";
echo "<ul>";
while ($stmt->fetch()) {
  echo "<li>Nome: " . htmlspecialchars($name) . " | Email: " . htmlspecialchars($email) . "</li>";
}
echo "</ul>";

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['old_email']) && isset($_POST['name']) && isset($_POST['email'])) {
    $old_email = $_POST['old_email'];
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    $stmt = $conn->prepare("SELECT name FROM user WHERE email=?");
    $stmt->bind_param("s", $old_email);
    $stmt->execute();
    $stmt->bind_result($old_name);
    $stmt->fetch();
    $stmt->close();

    if ($old_name) {
      $stmt = $conn->prepare("UPDATE user SET name=?, email=? WHERE email=?");
      $stmt->bind_param("sss", $new_name, $new_email, $old_email);

      if ($stmt->execute() === TRUE) {
        echo "Conta atualizada com sucesso!<br>";
        echo "Nome Antigo: " . htmlspecialchars($old_name) . "<br>";
        echo "Novo Nome: " . htmlspecialchars($new_name) . "<br>";
        echo "Novo Email: " . htmlspecialchars($new_email);
      } else {
        echo "Erro ao atualizar registro: " . $stmt->error;
      }

      $stmt->close();
    } else {
      echo "Usuário não encontrado.";
    }
  } else {
    echo "Por favor, preencha todos os campos.";
  }
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
    <label for="old_email">Email Atual:</label>
    <input type="email" name="old_email" required>
    <label for="name">Novo Nome:</label>
    <input type="text" name="name" required>
    <label for="email">Novo Email:</label>
    <input type="email" name="email" required>
    <input type="submit" value="Atualizar conta">
  </form>
</body>

</html>