<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Envoyer Ticket</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            padding: 30px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .success {
            text-align: center;
            color: green;
        }

        .error {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Invia richiesta di support - Ticket</h2>
    <form method="post">
        <p>Numero Identificativo Personale</p>
        <input type="number" name="customer_id" placeholder="Your Personal ID Number" required>
        <!-- <input type="text" name="customer_name" placeholder="Customer Name" required> -->
         <p>Dispositivo</p>
        <select name="device">
            <option value="iPhone">iPhone</option>
            <option value="Android">Android</option>
            <option value="Windows 11">Windows 11</option>
            <option value="Windows 10">Windows 10</option>
            <option value="Windows">Other Windows</option>
            <option value="MacBook">MacBook</option>
            <option value="iPad">iPad</option>
        </select>
        <p>Data del problema</p>
        <input type="date" name="open_date" required>
        <p>Categoria</p>
        <select name="issue_category">
            <option value="software">Software</option>
            <option value="hardware">Hardware</option>
            <option value="connection">Problemi di Connessione (Wifi,VPN)</option>
            <option value="performance">Problemi di Performance (Lento, Bloccato)</option>
            <option value="account">Account</option>
            <option value="complaints">Reclami e Feedback</option>
            <option value="other">Altro</option>
        </select>
        <p>Priorità - Per favore, sii cosciente</p>
        <select name="priority">
            <option value="low">Faible</option>
            <option value="medium" selected>Moyen</option>
            <option value="high">Élevé</option>
        </select>
        <textarea name="description" placeholder="Descrivi il problema" rows="4"></textarea>
        <button type="submit" name="submit">Envoyer Ticket</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $host = 'sql109.infinityfree.com';
        $db   = 'if0_39477627_giorgiosupport';
        $user = 'if0_39477627';
        $pass = 'QkfyWlKtj7';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            $stmt = $pdo->prepare("INSERT INTO tickets (customer_id, status, device, open_date, issue_category, priority, description, openedby) 
                                   VALUES (?, 'open', ?, ?, ?, ?, ?, 'user')");
//                          add ?, for name /\
            $stmt->execute([
            $_POST['customer_id'],
            //$_POST['customer_name'],
            $_POST['device'],
            $_POST['open_date'],
            $_POST['issue_category'],
            $_POST['priority'],
            $_POST['description']
            ]);

            echo '<p class="success">✅ Ticket submitted successfully!</p>';

        } catch (PDOException $e) {
            echo '<p class="error">❌ Error: ' . $e->getMessage() . '</p>';
        }
    }
    ?>
</div>

</body>
</html>
