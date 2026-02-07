<?php
// Configurações de base de dados e paths de upload.

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root'); 
define('DB_NAME', 'adpb_site');
define('DB_PORT', 8889); 

define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('IMAGES_DIR', dirname(__DIR__) . '/Imagens/Jogos/');

// Pagamentos (configurar para ativar).
define('PAYMENT_PROVIDER', 'stripe'); // stripe | paypal
define('STRIPE_SECRET_KEY', '');
define('STRIPE_PUBLISHABLE_KEY', '');
define('STRIPE_WEBHOOK_SECRET', '');
define('PAYPAL_BUSINESS_EMAIL', '');
define('PAYPAL_ENV', 'sandbox'); // sandbox | live
?>
