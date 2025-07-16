<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'sql109.infinityfree.com';
    $db   = 'if0_39477627_giorgiosupport';
    $user = 'if0_39477627';
    $pass = 'QkfyWlKtj7';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $stmt = $pdo->prepare("INSERT INTO customers (Name, Surname, email) VALUES (?, ?, ?)");

        $stmt->execute([
            $_POST['name'],
            $_POST['surname'],
            $_POST['email']
        ]);

        echo '<p class="success">✅ Customer added successfully!</p>';

    } catch (PDOException $e) {
        echo '<p class="error">❌ Error: ' . $e->getMessage() . '</p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuovo Utente</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            padding: 30px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success, .error {
            text-align: center;
            font-weight: bold;
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Nuovo Utente</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Nome" required>
        <input type="text" name="surname" placeholder="Cognome" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Aggiungi Utente</button>
    </form>
</div>

</body>
</html>
