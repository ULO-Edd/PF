-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10-Dez-2021 às 22:09
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

drop schema if exists psi_park;
create schema psi_park;
use psi_park;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `psi_park`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja`
--

DROP TABLE IF EXISTS `loja`;
CREATE TABLE IF NOT EXISTS `loja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designacao` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `loja`
--

INSERT INTO `loja` (`id`, `designacao`) VALUES
(1, 'Loja de Lembranças');


-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_loja` int(11) NULL,
  `descricao` varchar(450) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_loja_fk_idx` (`id_loja`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `id_loja`, `descricao`, `quantidade`, `points`, `image`) VALUES
(1, 1, 'Camaleao', 7, 37, 'camaleao-produto.png'),
(2, 1, 'Folha', 20, 12, 'folha-produto.png'),
(3, 1, 'Flor', 10, 19, 'flor-produto.png'),
(4, 1, 'Sol', 26, 40, 'sol-produto.png'),
(5, 1, 'Bola Futebol', 18, 80, 'bola-produto.png'),
(6, 1, 'Borboleta', 24, 24, 'borboleta-produto.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designacao` varchar(450) NOT NULL,
  `descricao` varchar(450) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_conclusao` date NOT NULL,
  `pontos_participacao` int(4) NOT NULL,
  `ativo` boolean NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `evento` (`id`, `designacao`, `descricao`, `data_inicio`, `data_conclusao`, `pontos_participacao`, `ativo`, `image`) VALUES
(1, 'Evento de Natal', 'Junte-se a nos para uma noite magica de alegria natalina na Celebracao Anual de Natal! Voce sera recebido com uma taça de vinho e sons das suas musicas favoritas de Natal. Delicie-se com um banquete festivo.', '2022-12-01', '2023-12-31', 7, 1, 'natal-evento.jpg'),
(2, 'Evento de Ano Novo', 'Comemore o Ano Novo com estilo e em celebracao na Festa de Ano Novo! Ao entrar no terraco, voce sera recebido com vistas deslumbrantes do horizonte da cidade e uma taça de champanhe de cortesia para brindar ao ano novo.', '2022-12-31', '2023-12-31', 7, 1, 'new-year-evento.jpg');
-- --------------------------------------------------------

--
-- Estrutura da tabela `evento_atividades`
--

DROP TABLE IF EXISTS `activities_evento`;
CREATE TABLE IF NOT EXISTS `activities_evento` (
  `id_evento` int(11) NOT NULL,
  `id_atividade` int(11) NOT NULL,
  PRIMARY KEY (`id_evento`,`id_atividade`),
  KEY `id_evento_atividade_fk_idx` (`id_evento`),
  KEY `id_atividade_evento_fk_idx` (`id_atividade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `activities_evento` (`id_evento`, `id_atividade`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade`
--

DROP TABLE IF EXISTS `atividade`;
CREATE TABLE IF NOT EXISTS `atividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_atividade` int(11) NOT NULL,
  `designacao` varchar(450) NOT NULL,
  `descricao` varchar(450) NOT NULL,
  `lotacao` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tipo_atividade_fk_idx` (`id_tipo_atividade`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `atividade`
--

INSERT INTO `atividade` (`id`, `id_tipo_atividade`, `designacao`, `descricao`, `lotacao`, `image`) VALUES
(1, 1, 'Ponte suspensa', 'Experimente a emoçao da aventura e da natureza com uma visita a ponte suspensa no Brisa Park. A ponte suspensa oferece uma perspectiva unica da beleza natural do parque, desde o riacho abaixo ate as arvores imponentes acima. De um passeio pela ponte, parando para admirar as vistas deslumbrantes ao longo do caminho.', 7, 'ponte_atividade.jpg'),
(2, 2, 'Recreio', 'Traga as criancas para um dia de diversao e emoçao no recreio do Brisa Park. Este parque infantil colorido e imaginativo foi concebido para criancas de todas as idades, oferecendo uma variedade de estruturas de jogo, baloicos e oportunidades de escalada.',20, 'playground.jpg'),
(3, 2, 'Insufláveis', 'Salte, deslize e pule para se divertir nos insuflaveis do Brisa Park. Este parque vibrante e cheio de energia apresenta uma ampla variedade de atracoes inflaveis, de escorregas gigantes a pistas de obstaculos e tudo mais.', 10, 'insuflaveis.jpg'),
(4, 3, 'Montanha Russa', 'Prepare-se para um passeio emocionante na montanha-russa do Brisa Park! Esta montanha-russa iconica apresenta uma estrutura imponente, curvas em alta velocidade e quedas vertiginosas que o deixarao sem folego.', 26, 'mt500x500.png'),
(5, 1, 'Canoagem', 'Descubra a beleza do ar livre com um tranquilo passeio de canoa pelo riacho do Brisa Park. Alugue uma canoa na barraca de aluguer do parque e reme pelo rio calmo e sinuoso, cercado por uma vegetaçao luxuriante e pelo som da natureza.',18, 'canoagem_atividade.jpg'),
(6, 2, 'Tubo de água', 'De um mergulho e venca o calor no famoso tubo de agua do Brisa Park. Este vibrante e excitante parque aquatico apresenta uma grande variedade de atracoes. Suba ate ao topo do escorrega de alta velocidade e experimente a adrenalina de uma queda acentuada, ou flutue ao longo do rio lento e aproveite o sol.', 24, 'parkjoy-section.png'),
(7, 2, 'Roda Gigante', 'Aprecie as vistas e os sons da cidade de uma perspectiva totalmente nova na Roda Gigante no Brisa Park. Ao subir, desfrute de vistas deslumbrantes da cidade, estendendo-se em todas as direcoes.', 50, 'roda_gigante.jpg'),
(8, 1, 'Zipline', 'Voe por entre as arvores e experimente a emocao de sua vida no zipline do Brisa Park. Esta atracao emocionante apresenta uma serie de ziplines que levam a voar alto através do dossel da floresta, dando a voce uma visao panoramica do parque abaixo.', 11, 'zipline.jpg'),
(9, 3, 'Carrinhos de choque', 'Prepare-se para muita diversao e risadas em alta velocidade na arena dos carrinhos de choque do Brisa Park. Suba a bordo de um dos carrinhos coloridos e resistentes e prepare-se para colidir com seus amigos e familiares em um jogo inofensivo e hilariante de colisao.', 12, 'choque_atividade.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '2', 1636457988),
('client', '1', 1636457561),
('client', '4', 1639167693),
('client', '5', 1639167749),
('manager', '3', 1639167631);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1636672976, 1636672976),
('client', 1, NULL, NULL, NULL, 1636672976, 1636672976),
('createActivity', 2, 'Create Activity', NULL, NULL, 1636672976, 1636672976),
('createActivityType', 2, 'Create Activity Type', NULL, NULL, 1636672976, 1636672976),
('createNews', 2, 'Create News', NULL, NULL, 1636672976, 1636672976),
('createSuggestion', 2, 'Create a Suggestion', NULL, NULL, 1636672976, 1636672976),
('createTicket', 2, 'Create Ticket', NULL, NULL, 1636672976, 1636672976),
('deleteActivity', 2, 'Delete Activity', NULL, NULL, 1636672976, 1636672976),
('deleteActivityType', 2, 'Delete Activity Type', NULL, NULL, 1636672976, 1636672976),
('deleteNews', 2, 'Delete News', NULL, NULL, 1636672976, 1636672976),
('deleteTicket', 2, 'Delete Ticket', NULL, NULL, 1636672976, 1636672976),
('deleteUser', 2, 'Delete User', NULL, NULL, 1636672976, 1636672976),
('editActivity', 2, 'Edit Activity', NULL, NULL, 1636672976, 1636672976),
('editActivityType', 2, 'Edit Activity Type', NULL, NULL, 1636672976, 1636672976),
('editNews', 2, 'Edit News', NULL, NULL, 1636672976, 1636672976),
('editUser', 2, 'Edit User', NULL, NULL, 1636672976, 1636672976),
('manager', 1, NULL, NULL, NULL, 1636672976, 1636672976),
('seeActivity', 2, 'See Activity', NULL, NULL, 1636672976, 1636672976),
('seeActivityType', 2, 'See Activity Type', NULL, NULL, 1636672976, 1636672976),
('seeNews', 2, 'See News', NULL, NULL, 1636672976, 1636672976),
('seeSuggestion', 2, 'See Suggestion', NULL, NULL, 1636672976, 1636672976),
('seeTicket', 2, 'See Ticket', NULL, NULL, 1636672976, 1636672976),
('seeUser', 2, 'See User', NULL, NULL, 1636672976, 1636672976);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'client'),
('manager', 'client'),
('manager', 'createActivity'),
('manager', 'createActivityType'),
('manager', 'createNews'),
('client', 'createSuggestion'),
('client', 'createTicket'),
('manager', 'deleteActivity'),
('manager', 'deleteActivityType'),
('manager', 'deleteNews'),
('client', 'deleteTicket'),
('admin', 'deleteUser'),
('manager', 'editActivity'),
('manager', 'editActivityType'),
('manager', 'editNews'),
('admin', 'editUser'),
('admin', 'manager'),
('client', 'seeActivity'),
('manager', 'seeActivityType'),
('client', 'seeNews'),
('admin', 'seeSuggestion'),
('client', 'seeTicket'),
('admin', 'seeUser');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE IF NOT EXISTS `favorito` (
  `id_user` int(11) NOT NULL,
  `id_atividade` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_atividade`),
  KEY `id_favorito_user_fk_idx` (`id_user`),
  KEY `id_favorito_atividade_fk_idx` (`id_atividade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `favorito`
--

INSERT INTO `favorito` (`id_user`, `id_atividade`) VALUES
(1, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `participar`
--

DROP TABLE IF EXISTS `participar`;
CREATE TABLE IF NOT EXISTS `participar` (
  `id_user` int(11) NOT NULL,
  `id_atividade` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_atividade`),
  KEY `id_participar_user_fk_idx` (`id_user`),
  KEY `id_participar_atividade_fk_idx` (`id_atividade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------



--
-- Estrutura da tabela `topico_report`
--

DROP TABLE IF EXISTS `topico_report`;
CREATE TABLE IF NOT EXISTS `topico_report` (
  `id` int(11) auto_increment NOT NULL,
  `topico` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `topico_report`
--

INSERT INTO `topico_report` (`id`, `topico`) VALUES
(1, 'Sugestão'),
(2, 'Reclamação'),
(3, 'Outro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1636672968),
('m140506_102106_rbac_init', 1636672969),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1636672969),
('m180523_151638_rbac_updates_indexes_without_prefix', 1636672969),
('m200409_110543_rbac_update_mssql_trigger', 1636672969),
('m130524_201442_init', 1636672976),
('m190124_110200_add_verification_token_column_to_user_table', 1636672976),
('m211029_174815_init_rbac', 1636672976);

-- --------------------------------------------------------

--
-- Estrutura da tabela `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `descricao` varchar(450) NOT NULL,
  `date_expire` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `news`
--

INSERT INTO `news` (`id`, `titulo`, `descricao`, `date_expire`, `image`) VALUES
(1, 'Novas Atividades', 'Verifique as ultimas atividades que abriram recentemente no nosso parque', '2023-01-01', 'es500x500.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `birthday_date` date NOT NULL,
  `telephone` int(9) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `points` int(9) not null,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telephone` (`telephone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id`, `name`, `lastname`, `birthday_date`, `telephone`, `image`, `points`) VALUES
(1, 'user', 'user', '2021-11-01', 911111111, null, 0),
(2, 'Admin', 'admin', '2021-11-01', 911111112, null, 0),
(3, 'Manager', 'User', '1999-01-28', 912343219, null, 0),
(4, 'user', 'user', '2001-03-17', 934578521, null, 0),
(5, 'user', 'user', '1976-04-20', 968789575, null, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_topico` int(11) NOT NULL,
  `descricao` varchar(450) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_report_fk_idx` (`id_user`),
  KEY `id_topico_report_fk_idx` (`id_topico`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `reports` (`id_user`, `id_topico`, `descricao`) VALUES
(1, 1, 'Mensagem de sugestão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico`
--

DROP TABLE IF EXISTS `historico`;
CREATE TABLE IF NOT EXISTS `historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `descricao` varchar(450) NOT NULL,
  `pontos` int(9) NULL,
  `acumulou` boolean NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_historico_fk_idx` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


--
-- Estrutura da tabela `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) NOT NULL,
  `data_de_compra` date NULL,
  `data_de_uso` date NULL,
  `anulado` boolean null,
  `expirado` boolean null,
  `pre_compra` boolean null,
  `preco` float DEFAULT NULL,
  `numero_atividades` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_id_pessoa_ticket` (`id_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `ticket`
--

INSERT INTO `ticket` (`id`, `id_pessoa`, `data_de_compra`, `data_de_uso`,`anulado`, `expirado`, `pre_compra`, `preco`, `numero_atividades`) VALUES
(1, 1, '2021-12-10', '2021-12-28', false, true, false, 20, 2),
(2, 1, '2021-12-10', '2021-12-28', false, true, false, 20, 0),
(3, 1, '2023-02-05', '2023-02-23', false, false, false, 12, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sections_ticket`
--

DROP TABLE IF EXISTS `activities_ticket`;
CREATE TABLE IF NOT EXISTS `activities_ticket` (
  `id_ticket` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  PRIMARY KEY (`id_ticket`,`id_activity`),
  KEY `id_ticket_activity_fk_idx` (`id_ticket`),
  KEY `id_activity_ticket_fk_idx` (`id_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `activities_ticket` (`id_ticket`, `id_activity`) VALUES
(1, 2),
(1, 4),
(3, 1),
(3, 2),
(3, 5),
(3, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_atividade`
--

DROP TABLE IF EXISTS `tipo_atividade`;
CREATE TABLE IF NOT EXISTS `tipo_atividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipo_atividade`
--

INSERT INTO `tipo_atividade` (`id`, `tipo`) VALUES
(1, 'Aventura'),
(2, 'Diversão'),
(3, 'Radical');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'User1', '9GJdeqLCyKAFuS8b5GVtON-cp_Qg7YMx', '$2y$13$3MVDMpZrznPEbz9TeOQjpezTjwPk5J4BWsLAMUEeQSoSz9zTFWOQy', NULL, 'user@user.com', 10, 1636457561, 1636457561, 'twBaFT7xA182MRphgohBgm6sTW8nuI7X_1636457560'),
(2, 'UserAdmin', '-fl7EYIkTNDireufeJrCM7j1KF_2E1-e', '$2y$13$sUiFAELR2y4LeDT1Jti5SuDonzhpSFyI.sQyPSGpFWkAmGLKTaTeW', NULL, 'admin@admin.com', 10, 1636457988, 1636457988, 'wJsB-R181p1bd1ME1mUCysXAfkQhUX7d_1636457988'),
(3, 'UserManager', '7ruATFWzds00INJB0qqAQtKRIRRF2rel', '$2y$13$Uiketu/2pUOuUu1OA2T9BO5/k6MRt.EXJpGQnPSxqD1cLCKrDrIdi', NULL, 'user.manager@manager.com', 10, 1639167631, 1639167631, 'x_HG7flw9PLputSrOW4Xmj90PD8KkRdx_1639167631'),
(4, 'User2', '5yEmTgbFQ_Dg4GjOZ1s3UJNIA9BmPYin', '$2y$13$TqnvAiUaVdBpumSqhoGkeuCPwjpPz2v5UNomVEnUDCng5GhhJu0Fm', NULL, 'user2.user@user.com', 10, 1639167693, 1639167693, 'g8CQN3_X0H9FnLQFSiPA2Ivjm782CCHV_1639167693'),
(5, 'User3', 'hjEI8VgcFncqEH2AVx5FaPPT2CQ_OXOC', '$2y$13$79Mvk0hbqpM37LpC/gojE.0.G91Y6Ri.CgCNsHN8O1f.CDEB8xz2C', NULL, 'user3.user@user.com', 10, 1639167749, 1639167749, 'FvAJE2jWzvFiL7QMuM3NCRMtydf-vSLz_1639167749');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `id_loja_fk_idx` FOREIGN KEY (`id_loja`) REFERENCES `loja` (`id`);

--
-- Limitadores para a tabela `activities_evento`
--
ALTER TABLE `activities_evento`
  ADD CONSTRAINT `id_evento_atividade_fk_idx` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`),
  ADD CONSTRAINT `id_atividade_evento_fk_idx` FOREIGN KEY (`id_atividade`) REFERENCES `atividade` (`id`);

--
-- Limitadores para a tabela `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `id_tipo_atividade_fk_idx` FOREIGN KEY (`id_tipo_atividade`) REFERENCES `tipo_atividade` (`id`);

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `id_favorito_atividade_fk_idx` FOREIGN KEY (`id_atividade`) REFERENCES `atividade` (`id`),
  ADD CONSTRAINT `id_favorito_user_fk_idx` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
  
--
-- Limitadores para a tabela `favorito`
--
ALTER TABLE `participar`
  ADD CONSTRAINT `id_participar_atividade_fk_idx` FOREIGN KEY (`id_atividade`) REFERENCES `atividade` (`id`),
  ADD CONSTRAINT `id_participar_user_fk_idx` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Limitadores para a tabela `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `id_user_report_fk_idx` FOREIGN KEY (`id_user`) REFERENCES `pessoa` (`id`),
  ADD CONSTRAINT `id_topico_report_fk_idx` FOREIGN KEY (`id_topico`) REFERENCES `topico_report` (`id`);

--
-- Limitadores para a tabela `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `id_user_historico_fk_idx` FOREIGN KEY (`id_user`) REFERENCES `pessoa` (`id`);

--
-- Limitadores para a tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD CONSTRAINT `FK_id_user_pessoa` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK_id_pessoa_ticket` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoa` (`id`);


--
-- Limitadores para a tabela `activities_ticket`
--
ALTER TABLE `activities_ticket`
  ADD CONSTRAINT `id_ticket_activity_fk_idx` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id`),
  ADD CONSTRAINT `id_activity_ticket_fk_idx` FOREIGN KEY (`id_activity`) REFERENCES `atividade` (`id`);

  
  
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
