<?php
session_start();
require_once __DIR__ . '/../admin/db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$userId = (int)$_SESSION['user_id'];

$stmt = $mysqli->prepare("
    SELECT id, total, status, payment_status, created_at
    FROM loja_encomendas
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Minhas Encomendas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; margin:0; padding:0; }
        .container { max-width: 900px; margin: 80px auto; background:#fff; padding:30px; border-radius:14px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color:#c8102e; margin-bottom: 20px; }
        table { width:100%; border-collapse: collapse; }
        th, td { padding:10px; border:1px solid #eee; text-align:left; }
        th { background:#fafafa; }
        .btn { background:#c8102e; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:600; }
        .back-button { position:absolute; top:20px; left:20px; color:#ffffff; text-decoration:none; font-weight:600; background:#c71b1b; padding:8px 16px; border-radius:999px; box-shadow:0 6px 14px rgba(199,27,27,0.25); }
    </style>
</head>
<body>

<a href="perfil.php" class="back-button">← Voltar ao perfil</a>

<div class="container">
    <h2>Minhas Encomendas</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Status</th>
                <th>Pagamento</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?= (int)$row['id']; ?></td>
                    <td><?= number_format((float)$row['total'], 2, ',', '.'); ?> €</td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td><?= htmlspecialchars($row['payment_status'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($row['created_at']); ?></td>
                    <td><a class="btn" href="encomenda.php?id=<?= (int)$row['id']; ?>">Ver</a></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Ainda não tens encomendas.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
