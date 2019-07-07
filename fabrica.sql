-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 28-Fev-2019 às 13:43
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.2.14

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

--
-- Extraindo dados da tabela `clientes`
--
-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `FU_CODIGO` int(11) NOT NULL,
  `FU_LOGIN` varchar(100) NOT NULL,
  `FU_SENHA` char(32) NOT NULL,
  `FU_ADMINISTRADOR` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD PRIMARY KEY (`FU_CODIGO`);

--
-- Indexes for table `plano`
--
ALTER TABLE `plano`
  ADD PRIMARY KEY (`PL_CODIGO`),
  ADD UNIQUE KEY `PL_CODIGO` (`PL_CODIGO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `CL_CODIGO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `clientes` (`CL_CODIGO`, `CL_NOME`, `CL_EMAIL`, `CL_TELEFONE`, `CL_ATIVO`) VALUES
(12, 'Jéfter Lucas Lima da Silva', 'jefter@gmail.com', '83998570157', 1),
(13, 'New Cliente', 'newcliente@gmail.com', '20190326000', 2),
(14, 'Teste', 'teste@gmail.com', '83998570157', 0),
(15, 'Teste', 'teste@gmail.com', '99999999999', 2),
(20, 'testando', 'testando@gmail.com', '90000000000', 1);


--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`FU_CODIGO`, `FU_LOGIN`, `FU_SENHA`, `FU_ADMINISTRADOR`) VALUES
(1, 'JEFTER', '202cb962ac59075b964b07152d234b70', 1);

--
-- Extraindo dados da tabela `plano`
--

INSERT INTO `plano` (`PL_CODIGO`, `PL_INICIO_VIGENCIA`, `PL_FIM_VIGENCIA`, `PL_OBSERVACOES`) VALUES
(12, '2019-02-27', '2019-03-27', 'NULL'),
(13, '2019-02-19', '2019-02-27', 'teste new Cliente'),
(14, '2019-02-26', '2019-03-26', 'NULL'),
(15, '2019-01-27', '2019-02-26', 'teste novamente'),
(16, '1970-01-01', '1970-01-01', 'NULL'),
(17, '1970-01-01', '1970-01-01', 'NULL'),
(18, '1970-01-01', '1970-01-01', 'NULL'),
(19, '1970-01-01', '1970-01-01', 'NULL'),
(20, '2019-02-28', '2019-03-27', 'testando');


