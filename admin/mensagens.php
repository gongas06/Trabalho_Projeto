<?php
// Backoffice: listagem de mensagens recebidas no formulário de contacto.
require_once 'auth.php';
require_once 'db.php';
require_login();

$result = $mysqli->query("
    SELECT id, nome, email, mensagem, created_at
    FROM mensagens
    ORDER BY created_at DESC
");

include 'includes/header.php';
?>

<div class="container admin-messages">
    <h1>Mensagens</h1>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Mensagem</th>
                    <th>Recebida em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= (int)$row['id']; ?></td>
                    <td><?= htmlspecialchars($row['nome']); ?></td>
                    <td><a href="mailto:<?= htmlspecialchars($row['email']); ?>"><?= htmlspecialchars($row['email']); ?></a></td>
                    <td class="admin-message-cell"><?= nl2br(htmlspecialchars($row['mensagem'])); ?></td>
                    <td><?= htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <a href="delete_mensagem.php?id=<?= (int)$row['id']; ?>"
                           onclick="return confirm('Eliminar esta mensagem?');"
                           style="color:#b00020; font-weight:600;">
                           Apagar
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="admin-empty">Sem mensagens.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
