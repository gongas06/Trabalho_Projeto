<?php
// Helpers da loja (cart, formatacao e slug).

function loja_slug(string $text): string
{
    $text = trim($text);
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text) ?: '';
    $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return strtolower($text ?? '');
}

function loja_cart_count(): int
{
    if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        return 0;
    }
    return array_sum($_SESSION['cart']);
}

function loja_preco(float $valor): string
{
    return number_format($valor, 2, ',', '.') . ' €';
}

function loja_fetch_cart_variants(mysqli $mysqli, array $cart): array
{
    if (empty($cart)) {
        return [];
    }

    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));

    $sql = "
        SELECT v.id AS variante_id, v.sku, v.tamanho, v.cor, v.preco, v.stock,
               p.id AS produto_id, p.nome AS produto_nome, p.imagem_principal
        FROM loja_produto_variantes v
        JOIN loja_produtos p ON p.id = v.produto_id
        WHERE v.id IN ($placeholders)
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $res = $stmt->get_result();

    $rows = [];
    while ($row = $res->fetch_assoc()) {
        $rows[$row['variante_id']] = $row;
    }
    return $rows;
}

function loja_send_order_email(array $order, array $items): bool
{
    if (empty($order['shipping_email'])) {
        return false;
    }

    $to = $order['shipping_email'];
    $subject = 'Resumo da encomenda #' . $order['id'] . ' - ADPB';

    $lines = [];
    $lines[] = 'Obrigado pela tua compra na loja ADPB!';
    $lines[] = 'Encomenda #' . $order['id'];
    $lines[] = 'Total: ' . number_format((float)$order['total'], 2, ',', '.') . ' €';
    $lines[] = '';
    $lines[] = 'Itens:';
    foreach ($items as $item) {
        $lines[] = '- ' . $item['nome_produto'] . ' (' . $item['nome_variante'] . ') x' . (int)$item['quantidade'] .
            ' — ' . number_format((float)$item['subtotal'], 2, ',', '.') . ' €';
    }
    $lines[] = '';
    $lines[] = 'Entrega:';
    $lines[] = $order['shipping_nome'] . ' — ' . $order['shipping_email'];
    $lines[] = $order['shipping_morada'] . ', ' . $order['shipping_cidade'] . ', ' . $order['shipping_codigo_postal'];
    if (!empty($order['shipping_telefone'])) {
        $lines[] = 'Telefone: ' . $order['shipping_telefone'];
    }
    $lines[] = '';
    $lines[] = 'AD Ponte da Barca';

    $message = implode("\r\n", $lines);
    $headers = "From: ADPB Loja <no-reply@adpb.local>\r\n" .
        "Content-Type: text/plain; charset=UTF-8\r\n";

    return @mail($to, $subject, $message, $headers);
}
?>
