-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 07-Jul-2019 às 05:01
-- Versão do servidor: 10.1.39-MariaDB
-- versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fabrica`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `CL_CODIGO` bigint(20) UNSIGNED NOT NULL,
  `CL_NOME` text NOT NULL,
  `CL_EMAIL` text NOT NULL,
  `CL_TELEFONE` varchar(11) NOT NULL,
  `CL_ATIVO` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `FU_CODIGO` bigint(20) UNSIGNED NOT NULL,
  `FU_NOME` varchar(100) NOT NULL,
  `FU_EMAIL` varchar(100) NOT NULL,
  `FU_SENHA` char(32) NOT NULL,
  `FU_TIPO` char(1) NOT NULL,
  `FU_ATIVO` tinyint(1) NOT NULL DEFAULT '1',
  `FU_ADMINISTRADOR` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`FU_CODIGO`, `FU_NOME`, `FU_EMAIL`, `FU_SENHA`, `FU_TIPO`, `FU_ATIVO`, `FU_ADMINISTRADOR`) VALUES
(1, 'Jéfter Lucas', 'jeftertecinfo@gmail.com', '8a0dfcd0205ff817a390432dbfd47fb8', '2', 1, 1),
(2, 'Jéfter Lucas Teste', 'jefterlucas17@gmail.com', '202cb962ac59075b964b07152d234b70', '2', 1, 0),
(3, 'Teste', 'teste@gmail.com', '202cb962ac59075b964b07152d234b70', '7', 1, 0),
(4, 'New teste', 'newteste@email.com', '202cb962ac59075b964b07152d234b70', '6', 1, 0),
(5, 'new teste2', 'newteste2@email.com', '202cb962ac59075b964b07152d234b70', '1', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `maquinas`
--

CREATE TABLE `maquinas` (
  `MA_CODIGO` bigint(20) UNSIGNED NOT NULL,
  `MA_NOME` varchar(100) NOT NULL,
  `MA_DESCRICAO` varchar(150) DEFAULT NULL,
  `MA_ATIVO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `maquinas`
--

INSERT INTO `maquinas` (`MA_CODIGO`, `MA_NOME`, `MA_DESCRICAO`, `MA_ATIVO`) VALUES
(1, 'Maquina 01', 'Faz alguma coisa', 1),
(2, 'Maquina 02', 'arredonda as pontas', 1),
(3, 'Maquina 03', 'Emplastificar', 1),
(4, 'Maquina 04', 'Empilhadeira', 1),
(5, 'Maquina 05', 'Maquina de envelopar', 1),
(6, 'Maquina 06', 'Pinadora', 1),
(7, 'Maquina 07', 'Tufão de Tinta', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ocorrencias`
--

CREATE TABLE `ocorrencias` (
  `OC_CODIGO` bigint(20) UNSIGNED NOT NULL,
  `OC_MAQUINA` int(11) NOT NULL,
  `OC_DATA` date NOT NULL,
  `OC_PROBLEMA` int(11) NOT NULL,
  `OC_ORDEM_PRODUCAO` varchar(100) NOT NULL,
  `OC_INICIO` time NOT NULL,
  `OC_FIM` time NOT NULL,
  `OC_STATUS` tinyint(1) NOT NULL,
  `OC_ACAO` varchar(100) NOT NULL,
  `OC_OPERADOR` int(11) NOT NULL,
  `OC_TEMPO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `ocorrencias`
--

INSERT INTO `ocorrencias` (`OC_CODIGO`, `OC_MAQUINA`, `OC_DATA`, `OC_PROBLEMA`, `OC_ORDEM_PRODUCAO`, `OC_INICIO`, `OC_FIM`, `OC_STATUS`, `OC_ACAO`, `OC_OPERADOR`, `OC_TEMPO`) VALUES
(8, 1, '2019-07-06', 3, '123', '13:00:00', '14:00:00', 1, 'Teste na Maquina 01', 1, 60),
(9, 2, '2019-07-06', 1, '124', '14:00:00', '15:00:00', 1, 'Teste na Maquina 02', 4, 60),
(10, 3, '2019-07-06', 4, '125', '15:00:00', '17:30:00', 0, 'Compra da tomada', 1, 150),
(11, 4, '2019-07-06', 1, '4321', '20:00:00', '21:30:00', 1, 'Ajuste do plugin', 1, 90);

-- --------------------------------------------------------

--
-- Estrutura da tabela `operador`
--

CREATE TABLE `operador` (
  `OP_CODIGO` bigint(20) UNSIGNED NOT NULL,
  `OP_NOME` varchar(100) NOT NULL,
  `OP_FUNCAO` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `operador`
--

INSERT INTO `operador` (`OP_CODIGO`, `OP_NOME`, `OP_FUNCAO`) VALUES
(1, 'teste', 'teste'),
(2, 'Operador 1', 'operar maquinas'),
(6, 'Operador 2', 'Listar Views'),
(7, 'Operador 3', 'Lista View teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `plano`
--

CREATE TABLE `plano` (
  `PL_CODIGO` int(11) NOT NULL,
  `PL_INICIO_VIGENCIA` date NOT NULL,
  `PL_FIM_VIGENCIA` date NOT NULL,
  `PL_OBSERVACOES` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `problemas`
--

CREATE TABLE `problemas` (
  `PR_CODIGO` bigint(20) UNSIGNED NOT NULL,
  `PR_DESCRICAO` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `problemas`
--

INSERT INTO `problemas` (`PR_CODIGO`, `PR_DESCRICAO`) VALUES
(1, 'Falha de energia'),
(2, 'Corte de energia da bomba'),
(3, 'Problema eletrico'),
(4, 'Curto Circuito'),
(5, 'Atraso de materia prima'),
(6, 'Maquina desafinada');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD UNIQUE KEY `CL_CODIGO` (`CL_CODIGO`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`FU_CODIGO`),
  ADD UNIQUE KEY `FU_CODIGO` (`FU_CODIGO`);

--
-- Indexes for table `maquinas`
--
ALTER TABLE `maquinas`
  ADD UNIQUE KEY `MA_CODIGO` (`MA_CODIGO`);

--
-- Indexes for table `ocorrencias`
--
ALTER TABLE `ocorrencias`
  ADD UNIQUE KEY `OC_CODIGO` (`OC_CODIGO`),
  ADD KEY `OC_PROBLEMA` (`OC_PROBLEMA`),
  ADD KEY `OC_OPERADOR` (`OC_OPERADOR`);

--
-- Indexes for table `operador`
--
ALTER TABLE `operador`
  ADD UNIQUE KEY `OP_CODIGO` (`OP_CODIGO`);

--
-- Indexes for table `plano`
--
ALTER TABLE `plano`
  ADD PRIMARY KEY (`PL_CODIGO`),
  ADD UNIQUE KEY `PL_CODIGO` (`PL_CODIGO`);

--
-- Indexes for table `problemas`
--
ALTER TABLE `problemas`
  ADD UNIQUE KEY `PR_CODIGO` (`PR_CODIGO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `CL_CODIGO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `FU_CODIGO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `maquinas`
--
ALTER TABLE `maquinas`
  MODIFY `MA_CODIGO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ocorrencias`
--
ALTER TABLE `ocorrencias`
  MODIFY `OC_CODIGO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `operador`
--
ALTER TABLE `operador`
  MODIFY `OP_CODIGO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `problemas`
--
ALTER TABLE `problemas`
  MODIFY `PR_CODIGO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
