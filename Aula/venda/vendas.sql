-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/12/2024 às 01:24
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vendas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`) VALUES
(3, 'Celular'),
(4, 'Eletrodo'),
(5, 'games'),
(6, 'livros');

-- --------------------------------------------------------

--
-- Estrutura para tabela `parcela`
--

CREATE TABLE `parcela` (
  `id` int(11) NOT NULL,
  `venda_id` int(11) NOT NULL,
  `numero_parcela` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `vencimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `parcela`
--

INSERT INTO `parcela` (`id`, `venda_id`, `numero_parcela`, `valor`, `vencimento`) VALUES
(8, 13, 1, 10000.00, '2025-01-06'),
(9, 13, 2, 10000.00, '2025-02-06'),
(10, 13, 3, 10000.00, '2025-03-06'),
(11, 13, 4, 10000.00, '2025-04-06'),
(12, 13, 5, 10000.00, '2025-05-06'),
(13, 13, 6, 10000.00, '2025-06-06'),
(14, 14, 1, 13333.33, '2025-01-07'),
(15, 14, 2, 13333.33, '2025-02-07'),
(16, 14, 3, 13333.33, '2025-03-07'),
(17, 14, 4, 13333.33, '2025-04-07'),
(18, 14, 5, 13333.33, '2025-05-07'),
(19, 14, 6, 13333.33, '2025-06-07'),
(20, 15, 1, 46.00, '2025-01-10'),
(21, 15, 2, 46.00, '2025-02-10'),
(22, 15, 3, 46.00, '2025-03-10'),
(23, 15, 4, 46.00, '2025-04-10'),
(24, 15, 5, 46.00, '2025-05-10'),
(25, 16, 1, 46.00, '2025-01-10'),
(26, 16, 2, 46.00, '2025-02-10'),
(27, 16, 3, 46.00, '2025-03-10'),
(28, 16, 4, 46.00, '2025-04-10'),
(29, 16, 5, 46.00, '2025-05-10'),
(30, 17, 1, 12000.00, '2025-01-11'),
(31, 17, 2, 12000.00, '2025-02-11'),
(32, 17, 3, 12000.00, '2025-03-11'),
(33, 17, 4, 12000.00, '2025-04-11'),
(34, 17, 5, 12000.00, '2025-05-11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `preco`, `id_categoria`, `categoria_id`) VALUES
(6, 'Iphone 16', 20000.00, NULL, 3),
(7, 'Brastemp Maquina Xy', 23.00, NULL, 4),
(8, 'Sonic 5', 300.00, NULL, 5),
(9, 'Harry Poter', 300.00, NULL, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`) VALUES
(8, 'marcelo', 'marcelo@teste.com', '$2y$10$09ywFVpAytSNKpajDFQpBO3aURDQ5NKOeyHBN4xn6m83ieR178yg2'),
(9, 'Maria Julia', 'mariaJulia@teste.com', '$2y$10$S8RTavfw4GZjPYk6qgL/Gej9mWIHUWiu10Zr48FPmHlCwwxtmWhD2'),
(10, 'Joao Pedro', 'jp@teste.com', '$2y$10$v80rAFgVM37m2Cu8BCgtve5TqVFVrTk9Dp7rtjwAOrAmrwILIKh7i');

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `data_venda` datetime DEFAULT current_timestamp(),
  `condicoes_pagamento` varchar(50) NOT NULL,
  `quantidade_parcelas` int(11) DEFAULT NULL,
  `produto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `preco_produto` decimal(10,2) DEFAULT NULL,
  `condicao_pagamento` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `venda`
--

INSERT INTO `venda` (`id`, `id_usuario`, `id_produto`, `quantidade`, `data_venda`, `condicoes_pagamento`, `quantidade_parcelas`, `produto_id`, `usuario_id`, `total`, `preco_produto`, `condicao_pagamento`) VALUES
(13, NULL, NULL, 3, '2024-12-06 18:20:53', '', NULL, 6, 8, 60000.00, 20000.00, 'parcelado'),
(14, NULL, NULL, 4, '2024-12-06 21:43:30', '', NULL, 6, 8, 80000.00, 20000.00, 'parcelado'),
(15, NULL, NULL, 10, '2024-12-10 16:59:52', '', NULL, 7, 9, 230.00, 23.00, 'parcelado'),
(16, NULL, NULL, 10, '2024-12-10 17:00:15', '', NULL, 7, 9, 230.00, 23.00, 'parcelado'),
(17, NULL, NULL, 3, '2024-12-10 21:23:37', '', NULL, 6, 8, 60000.00, 20000.00, 'parcelado');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `parcela`
--
ALTER TABLE `parcela`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venda_id` (`venda_id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_produto` (`id_produto`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `parcela`
--
ALTER TABLE `parcela`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `parcela`
--
ALTER TABLE `parcela`
  ADD CONSTRAINT `parcela_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `venda` (`id`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
