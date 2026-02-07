-- Tabelas da loja online ADPB

CREATE TABLE `loja_categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `loja_produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_id` int DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `descricao` text,
  `imagem_principal` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `loja_produtos_categoria_fk` FOREIGN KEY (`categoria_id`) REFERENCES `loja_categorias` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `loja_produto_imagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `loja_produto_imagens_produto_fk` FOREIGN KEY (`produto_id`) REFERENCES `loja_produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `loja_produto_variantes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `sku` varchar(80) DEFAULT NULL,
  `tamanho` varchar(50) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `loja_produto_variantes_produto_fk` FOREIGN KEY (`produto_id`) REFERENCES `loja_produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `loja_encomendas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `public_token` varchar(64) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending_payment','paid','cancelled') NOT NULL DEFAULT 'pending_payment',
  `payment_provider` varchar(40) DEFAULT NULL,
  `payment_method` varchar(40) DEFAULT NULL,
  `payment_status` varchar(40) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `email_sent` tinyint(1) NOT NULL DEFAULT '0',
  `shipping_nome` varchar(120) NOT NULL,
  `shipping_email` varchar(120) NOT NULL,
  `shipping_telefone` varchar(40) DEFAULT NULL,
  `shipping_morada` varchar(255) NOT NULL,
  `shipping_cidade` varchar(120) NOT NULL,
  `shipping_codigo_postal` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `public_token` (`public_token`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `loja_encomendas_user_fk` FOREIGN KEY (`user_id`) REFERENCES `utilizadores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `loja_encomenda_itens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `encomenda_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `variante_id` int NOT NULL,
  `nome_produto` varchar(150) NOT NULL,
  `nome_variante` varchar(120) DEFAULT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `quantidade` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `encomenda_id` (`encomenda_id`),
  CONSTRAINT `loja_encomenda_itens_encomenda_fk` FOREIGN KEY (`encomenda_id`) REFERENCES `loja_encomendas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
