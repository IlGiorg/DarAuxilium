<?php
$host = 'sql109.infinityfree.com';
$db   = 'if0_39477627_giorgiosupport';
$user = 'if0_39477627';
$pass = 'QkfyWlKtj7';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Handle status update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
        $stmt = $pdo->prepare("UPDATE tickets SET status = ? WHERE ticket_id = ?");
        $stmt->execute([$_POST['new_status'], $_POST['ticket_id']]);
    }

    // Get tickets with status open or in progress
    $stmt = $pdo->query("
        SELECT t.*, c.Name, c.Surname, c.email
        FROM tickets t
        JOIN customers c ON t.customer_id = c.customerid
        WHERE t.status IN ('closed')
        ORDER BY 
            CASE t.priority
                WHEN 'high' THEN 1
                WHEN 'medium' THEN 2
                WHEN 'low' THEN 3
            END,
            t.open_date DESC
    ");
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Closed Tickets</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; padding: 30px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 12px; border-bottom: 1px solid #ccc; text-align: left; }
        th { background-color: #007bff; color: white; }
        .popup {
            display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%);
            background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .popup-close {
            position: absolute; top: 5px; right: 10px; cursor: pointer; font-weight: bold;
        }
        .edit-form select { padding: 5px; }
        .edit-form button { padding: 6px 10px; margin-left: 5px; }
    </style>
</head>
<body>

<h2>Closed</h2>

<table>
    <thead>
        <tr>
            <th>Ticket ID</th>
            <th>Customer</th>
            <th>Device</th>
            <th>Date Opened</th>
            <th>Category</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= $ticket['ticket_id'] ?></td>
                <td>
                    <?= $ticket['Name'] ?> <?= $ticket['Surname'] ?>
                    <button onclick="showPopup('<?= htmlspecialchars($ticket['Name']) ?>', '<?= htmlspecialchars($ticket['Surname']) ?>', '<?= htmlspecialchars($ticket['email']) ?>')">Info</button>
                </td>
                <td><?= $ticket['device'] ?></td>
                <td><?= $ticket['open_date'] ?></td>
                <td><?= $ticket['issue_category'] ?></td>
                <td><?= ucfirst($ticket['priority']) ?></td>
                <td>
                    <form method="post" class="edit-form">
                        <input type="hidden" name="ticket_id" value="<?= $ticket['ticket_id'] ?>">
                        <select name="new_status">
                            <option value="closed">Closed</option>
                            <option value="open" <?= $ticket['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                            <option value="in progress" <?= $ticket['status'] === 'in progress' ? 'selected' : '' ?>>In Progress</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
                <td><?= $ticket['description'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="popup" id="popup">
    <span class="popup-close" onclick="hidePopup()">✖</span>
    <h3>Customer Info</h3>
    <p id="popup-name"></p>
    <p id="popup-email"></p>
</div>

<script>
function showPopup(name, surname, email) {
    document.getElementById('popup-name').textContent = `Name: ${name} ${surname}`;
    document.getElementById('popup-email').textContent = `Email: ${email}`;
    document.getElementById('popup').style.display = 'block';
}
function hidePopup() {
    document.getElementById('popup').style.display = 'none';
}
</script>

</body>
</html>
