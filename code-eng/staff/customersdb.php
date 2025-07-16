<?php
$host = 'sql109.infinityfree.com';
$db   = 'if0_39477627_giorgiosupport';
$user = 'if0_39477627';
$pass = 'QkfyWlKtj7';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->query("SELECT * FROM customers");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer List</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 30px; }
        table {
            width: 100%; background-color: white; border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px; border-bottom: 1px solid #ddd; text-align: left;
        }
        th {
            background-color: #007bff; color: white;
        }
        tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>

<h2>All Customers</h2>

<table>
    <thead>
        <tr>
            <th>Customer ID</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= $customer['customerid'] ?></td>
                <td><?= htmlspecialchars($customer['name']) ?></td>
                <td><?= htmlspecialchars($customer['surname']) ?></td>
                <td><?= htmlspecialchars($customer['email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
