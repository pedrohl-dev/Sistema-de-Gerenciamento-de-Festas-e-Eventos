-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/05/2026 às 22:53
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
-- Banco de dados: `sgfel`
--
CREATE DATABASE IF NOT EXISTS `sgfel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sgfel`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_produto`
--

CREATE TABLE IF NOT EXISTS `categorias_produto` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias_produto`
--

INSERT INTO `categorias_produto` (`id_categoria`, `nome_categoria`) VALUES
(1, 'Roupas'),
(2, 'Eletrônicos'),
(3, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data` date NOT NULL,
  `local` varchar(150) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id_evento`, `nome`, `descricao`, `data`, `local`, `imagem`) VALUES
(1, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(2, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(3, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(4, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(5, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(6, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(7, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(8, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(9, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(10, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(11, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(12, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(13, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(14, 'teste', 'ewew', '2111-01-01', '111', '1212'),
(15, 'teste', 'ewew', '2111-01-01', '111', '1212');

-- --------------------------------------------------------

--
-- Estrutura para tabela `evento_expositores`
--

CREATE TABLE IF NOT EXISTS `evento_expositores` (
  `id_evento` int(11) DEFAULT NULL,
  `id_expositor` int(11) DEFAULT NULL,
  KEY `fk_id_evento` (`id_evento`),
  KEY `fk_id_usuario` (`id_expositor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `evento_expositores`
--

INSERT INTO `evento_expositores` (`id_evento`, `id_expositor`) VALUES
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `presencas`
--

CREATE TABLE IF NOT EXISTS `presencas` (
  `id_presenca` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  PRIMARY KEY (`id_presenca`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_evento` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `presencas`
--

INSERT INTO `presencas` (`id_presenca`, `id_usuario`, `id_evento`) VALUES
(1, 2, 2),
(2, 2, 1),
(3, 2, 4),
(4, 2, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome`, `descricao`, `id_usuario`, `id_categoria`) VALUES
(1, 'Pc gamer pichau', 'pc gamer da pichau muito bom', 3, 2),
(2, 'teste 1', 'teste teste teste', 3, 3),
(3, 'teste 2', 'teste teste teste', 3, 1),
(4, 'teste', 'teste teste teste', 3, 3),
(5, 'teste', 'teste teste teste', 3, 1),
(7, 'teste', 'teste teste teste', 3, 1),
(8, 'teste', 'produto bom', 4, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','expositor','visitante') NOT NULL,
  `aprovado` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `tipo`, `aprovado`) VALUES
(1, 'Administrador', 'admin@email.com', '202cb962ac59075b964b07152d234b70', 'admin', 1),
(2, 'Visitante', 'visitante@email.com', '$2y$10$IlcnklJo1Y3pOjVHnS//HeT4kjvDsZCkZVFaeOe9GuaFSa4hVaGdG', 'visitante', 1),
(3, 'Expositor', 'expositor@email.com', '$2y$10$0Lakjzr8TNRESdFxPxOPvutE0xqbMmA4xoz3coZg1kESGc36ypMSi', 'expositor', 1),
(4, 'Teste', 'teste@gmail.com', '$2y$10$3GJEsqysJFykdj7h5Wi3COBAk2tK9FXILFbLjL6jZUNQTQNRcX.Le', 'expositor', 1),
(5, 'teste2', 'teste2@gmail.com', '$2y$10$xK6GolNqKo8kyC51wreipO6O31Znn1ZRcCUeNRGWZOEdyr7m1oOte', 'expositor', 0),
(6, 'teste3', 'teste3@gmail.com', '$2y$10$QvUSfYWQM4NYS3XPdOq58eirN/0lG4rg6BbvGdg/AqAvaHK9.wdt.', 'expositor', 0),
(7, 'teste4', 'teste4@gmail.com', '$2y$10$s.VUjEtmBH/qWIJIZsRR7OWb8NWZjzSHRyyteYhc7bkyg/sG9DEia', 'expositor', 0);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `presencas`
--
ALTER TABLE `presencas`
  ADD CONSTRAINT `presencas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `presencas_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_produto` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
