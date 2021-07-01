-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 26-Jan-2020 às 19:10
-- Versão do servidor: 5.7.24
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sigep`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_preferences`
--

DROP TABLE IF EXISTS `admin_preferences`;
CREATE TABLE IF NOT EXISTS `admin_preferences` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `user_panel` tinyint(1) NOT NULL DEFAULT '0',
  `sidebar_form` tinyint(1) NOT NULL DEFAULT '0',
  `messages_menu` tinyint(1) NOT NULL DEFAULT '0',
  `notifications_menu` tinyint(1) NOT NULL DEFAULT '0',
  `tasks_menu` tinyint(1) NOT NULL DEFAULT '0',
  `user_menu` tinyint(1) NOT NULL DEFAULT '1',
  `ctrl_sidebar` tinyint(1) NOT NULL DEFAULT '0',
  `transition_page` tinyint(1) NOT NULL DEFAULT '0',
  `usuario` varchar(20) DEFAULT NULL,
  `senha` varchar(20) DEFAULT NULL,
  `numeroContrato` varchar(20) DEFAULT NULL,
  `cartaoPostagem` varchar(20) DEFAULT NULL,
  `cnpjEmpresa` varchar(20) DEFAULT NULL,
  `anoContrato` varchar(20) DEFAULT NULL,
  `diretoria` varchar(200) DEFAULT NULL,
  `ambiente` int(1) NOT NULL DEFAULT '0',
  `ultimo_update` varchar(20) DEFAULT NULL,
  `codAdministrativo` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `admin_preferences`
--

INSERT INTO `admin_preferences` (`id`, `user_panel`, `sidebar_form`, `messages_menu`, `notifications_menu`, `tasks_menu`, `user_menu`, `ctrl_sidebar`, `transition_page`, `usuario`, `senha`, `numeroContrato`, `cartaoPostagem`, `cnpjEmpresa`, `anoContrato`, `diretoria`, `ambiente`, `ultimo_update`, `codAdministrativo`) VALUES
(1, 0, 0, 0, 0, 0, 1, 0, 0, '', '', '', '', '', '', '20', 0, '13-09-2018', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE IF NOT EXISTS `enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rua` varchar(200) NOT NULL,
  `num` varchar(20) DEFAULT NULL COMMENT 'S/N',
  `bairro` varchar(20) NOT NULL,
  `cidade` varchar(20) NOT NULL,
  `estado` varchar(200) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '1' COMMENT '1 = ATIVO | 0 = INATIVO',
  `user` int(11) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT '1' COMMENT '1 = DESTINATARIO | 2 = REMETENTE',
  `cep` varchar(10) NOT NULL,
  `complemento` varchar(200) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `contato` varchar(20) DEFAULT NULL,
  `fone` varchar(20) DEFAULT NULL,
  `ultima_atualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_cadastro` varchar(20) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `rua`, `num`, `bairro`, `cidade`, `estado`, `ativo`, `user`, `tipo`, `cep`, `complemento`, `title`, `contato`, `fone`, `ultima_atualizacao`, `data_cadastro`, `status`) VALUES
(1, 'asdasd', '123', 'x', 'Aimorés', 'MG', 1, 1, 2, '35200-000', 'xxxxx', 'asdasasd', 'anderso', '(33) 9 9923-8273', '2020-01-26 15:42:45', '2020-01-26 13:42:45', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE IF NOT EXISTS `etiquetas` (
  `id_etiquetas` int(11) NOT NULL AUTO_INCREMENT,
  `remetente` varchar(11) NOT NULL,
  `altura` int(11) NOT NULL,
  `largura` int(11) NOT NULL,
  `comprimento` int(11) NOT NULL,
  `peso` varchar(20) NOT NULL,
  `servico` varchar(20) NOT NULL,
  `quant` int(11) NOT NULL,
  `adicional` varchar(20) DEFAULT NULL,
  `valor` varchar(11) NOT NULL,
  `diametro` varchar(20) DEFAULT NULL,
  `dest_title` varchar(200) NOT NULL,
  `dest_rua` varchar(200) NOT NULL,
  `dest_num` varchar(20) NOT NULL,
  `dest_complemento` varchar(200) NOT NULL,
  `dest_bairro` varchar(20) NOT NULL,
  `dest_cep` varchar(20) NOT NULL,
  `dest_cidade` varchar(50) NOT NULL,
  `dest_estado` varchar(20) NOT NULL,
  `dest_nfe` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `idplp` varchar(20) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `sem_dev` varchar(20) DEFAULT NULL,
  `caminho` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dt_emissao` varchar(20) DEFAULT NULL,
  `custo` varchar(50) DEFAULT NULL,
  UNIQUE KEY `id` (`id_etiquetas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `bgcolor` char(7) NOT NULL DEFAULT '#607D8B',
  `user_panel` int(1) NOT NULL DEFAULT '0',
  `sidebar_form` int(1) NOT NULL DEFAULT '0',
  `messages_menu` int(1) NOT NULL DEFAULT '0',
  `notifications_menu` int(1) NOT NULL DEFAULT '0',
  `tasks_menu` int(1) NOT NULL DEFAULT '0',
  `user_menu` int(1) NOT NULL DEFAULT '0',
  `ctrl_sidebar` int(1) NOT NULL DEFAULT '0',
  `transition_page` int(1) NOT NULL DEFAULT '0',
  `tags` int(1) NOT NULL DEFAULT '0',
  `plp` int(1) NOT NULL DEFAULT '0',
  `reports` int(1) NOT NULL DEFAULT '0',
  `ban` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `bgcolor`, `user_panel`, `sidebar_form`, `messages_menu`, `notifications_menu`, `tasks_menu`, `user_menu`, `ctrl_sidebar`, `transition_page`, `tags`, `plp`, `reports`, `ban`) VALUES
(1, 'admin', 'Administrator', '#000000', 1, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 0),
(4, 'USUARIO', 'USUÁRIO SIMPLES', '#2196f3', 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0),
(5, 'BLOQUEADOS', 'USUARIOS BLOQUEADOS', '#f44336', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `plp`
--

DROP TABLE IF EXISTS `plp`;
CREATE TABLE IF NOT EXISTS `plp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caminho` text,
  `numero` varchar(50) NOT NULL,
  `data_hora` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `public_preferences`
--

DROP TABLE IF EXISTS `public_preferences`;
CREATE TABLE IF NOT EXISTS `public_preferences` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `transition_page` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `public_preferences`
--

INSERT INTO `public_preferences` (`id`, `transition_page`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

DROP TABLE IF EXISTS `servicos`;
CREATE TABLE IF NOT EXISTS `servicos` (
  `cod_ver` varchar(255) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `limit_tags` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `limit_tags`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'YwQrWQ4qQpetnl07bxOdHO', 1268889823, 1580065823, 1, 'Admin', 'istrator', 'ADMIN', '27999119408', 21),
(2, '::1', 'usuario usuario', '$2y$08$ckN1lux1084eQIVdehthbOv2QezvcE3Es0KaVtkjIDdcG9AoAJI8e', NULL, 'usuario@email.com', NULL, NULL, NULL, NULL, 1536372655, 1536814134, 1, 'usuario', 'usuario', 'usuario', '3332674812', 23),
(3, '::1', 'bloqueados bloqueados', '$2y$08$TjJcsT6F4txjr8e9VyMvfu1W7H7BBievb2EwyQ2Erf/pKgHJ5KhhK', NULL, 'bloqueado@email.com', NULL, NULL, NULL, 'TseOVnvYZoKIYFrJ17h7KO', 1536455178, 1536814121, 1, 'BLOQUEADOS', 'BLOQUEADOS', 'BLOQUEADOS', '27999119407', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(4, 1, 1),
(11, 2, 4),
(12, 3, 5);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
