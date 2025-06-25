-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/06/2025 às 03:18
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
-- Banco de dados: `sitefinal`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendas`
--

CREATE TABLE `agendas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `local_id` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `arquivo` text DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `horariofin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendas`
--

INSERT INTO `agendas` (`id`, `usuario_id`, `local_id`, `data`, `arquivo`, `observacao`, `horario`, `horariofin`) VALUES
(75, 1, 1, '2025-06-12', NULL, '', '08:20:00', '09:10:00'),
(76, 1, 1, '2025-06-12', NULL, '', '09:10:00', '10:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `albuns`
--

CREATE TABLE `albuns` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `albuns`
--

INSERT INTO `albuns` (`id`, `nome`, `data`, `status`) VALUES
(6, 'Desenvolvimento de Sistema', '2025-06-18', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `albuns_imagens`
--

CREATE TABLE `albuns_imagens` (
  `id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `imagem` text DEFAULT NULL,
  `locais_ids` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `descricao`, `tipo`, `status`, `imagem`, `locais_ids`) VALUES
(3, 'DEV', 'DEV descricao', 0, 1, 'https://img.freepik.com/fotos-gratis/quarto-vazio-de-fundo-de-estudio-abstrato-de-gradiente-verde-liso-de-luxo-com-espaco-para-seu-texto-e-imagem_1258-99418.jpg?semt=ais_hybrid&w=740', 'Array'),
(4, 'Ciencias', 'Estudo das Ciencias', 0, 1, 'https://cdn-icons-png.flaticon.com/256/6747/6747064.png', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `horarios`
--

CREATE TABLE `horarios` (
  `secretaria` text DEFAULT NULL,
  `aulas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `horarios`
--

INSERT INTO `horarios` (`secretaria`, `aulas`) VALUES
('Secretaria\r\nSegunda a Sexta: 8h às 17h\r\nSábado: 8h às 12h\r\nDomingo: Fechado', 'Aulas\r\nManhã: 7h30 às 11h30\r\nTarde: 13h às 17h\r\nNoite: 19h às 22h30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `locais`
--

CREATE TABLE `locais` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `cor` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `locais`
--

INSERT INTO `locais` (`id`, `nome`, `status`, `cor`) VALUES
(1, 'Laboratório Informatica', 1, 'blue'),
(3, 'Laboratório Desenho Técnico', 1, 'orange'),
(5, 'Quadra', 1, 'red'),
(10, 'Laboratório de Matemática', 1, 'green'),
(13, 'Sala Notebooks', 1, '#000000');

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `resumo` varchar(254) DEFAULT NULL,
  `texto` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `imagem` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `resumo`, `texto`, `status`, `imagem`) VALUES
(22, 'a', 'a', 'a', 1, 'imagens/1750812046_olho.jpg'),
(23, 'asas', 'assasa', 'sasasas', 1, '685b4a2e75528.jpg'),
(24, 'sasasas', 'asasas', 'asasasas', 1, '685b4a4bad79c.gif'),
(25, 'e', 'ee', 'eee', 1, '685b4bbb21a7d.png'),
(26, 'e', 'ee', 'eee', 1, '685b4bcfc46a8.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `usuario` varchar(150) DEFAULT NULL,
  `senha` varchar(20) DEFAULT NULL,
  `cargo` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha`, `cargo`, `status`) VALUES
(1, 'teste', 'teste@gmail.com', '1324', 1, 1),
(4, 'Joao', 'joao@gmail.com', '1234', 0, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `local_id` (`local_id`);

--
-- Índices de tabela `albuns`
--
ALTER TABLE `albuns`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `albuns_imagens`
--
ALTER TABLE `albuns_imagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`);

--
-- Índices de tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `locais`
--
ALTER TABLE `locais`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de tabela `albuns`
--
ALTER TABLE `albuns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `albuns_imagens`
--
ALTER TABLE `albuns_imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `locais`
--
ALTER TABLE `locais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `agendas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `agendas_ibfk_2` FOREIGN KEY (`local_id`) REFERENCES `locais` (`id`);

--
-- Restrições para tabelas `albuns_imagens`
--
ALTER TABLE `albuns_imagens`
  ADD CONSTRAINT `albuns_imagens_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albuns` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
