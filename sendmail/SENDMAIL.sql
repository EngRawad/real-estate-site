CREATE TABLE IF NOT EXISTS `sm_attach` (
  `id_attachment` int(7) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR( 255 ) NOT NULL,
  `path` VARCHAR( 255 ) NOT NULL,
  `id_send` int(7) NOT NULL,
  PRIMARY KEY (`id_attachment`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `sm_aut` (
  `passw` VARCHAR( 32 ) NOT NULL
) ENGINE=MyISAM;

INSERT INTO `sm_aut` (`passw`) VALUES ('b59c67bf196a4758191e42f76670ceba');

CREATE TABLE IF NOT EXISTS `sm_category` (
  `id_cat` int(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR( 200 ) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `sm_category` (`id_cat`, `name`) VALUES
(1, 'Category 1'),
(2, 'Category 2'),
(3, 'Category 3');

CREATE TABLE IF NOT EXISTS `sm_charset` (
  `id_charset` int(5) NOT NULL AUTO_INCREMENT,
  `charset` VARCHAR( 32 ) NOT NULL,
  PRIMARY KEY (`id_charset`)
) ENGINE=MyISAM;

INSERT INTO `sm_charset` (`id_charset`, `charset`) VALUES
(1, 'utf-8'),
(2, 'iso-8859-1'),
(3, 'iso-8859-2'),
(4, 'iso-8859-3'),
(5, 'iso-8859-4'),
(6, 'iso-8859-5'),
(7, 'iso-8859-6'),
(8, 'iso-8859-8'),
(9, 'iso-8859-7'),
(10, 'iso-8859-9'),
(11, 'iso-8859-10'),
(12, 'iso-8859-13'),
(13, 'iso-8859-14'),
(14, 'iso-8859-15'),
(15, 'iso-8859-16'),
(16, 'windows-1250'),
(17, 'windows-1251'),
(18, 'windows-1252'),
(19, 'windows-1253'),
(20, 'windows-1254'),
(21, 'windows-1255'),
(22, 'windows-1256'),
(23, 'windows-1257'),
(24, 'windows-1258'),
(25, 'gb2312'),
(26, 'big5'),
(27, 'iso-2022-jp'),
(28, 'ks_c_5601-1987'),
(29, 'euc-kr'),
(30, 'windows-874'),
(31, 'koi8-r'),
(32, 'koi8-u');

CREATE TABLE IF NOT EXISTS `sm_ready_send` (
  `id_ready_send` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(7) NOT NULL,
  `id_send` int(7) NOT NULL,
  PRIMARY KEY (`id_ready_send`),
  KEY `id_user` (`id_user`),
  KEY `id_send` (`id_send`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `sm_send` (
  `id_send` int(7) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR( 200 ) NOT NULL,
  `message` text NOT NULL,
  `prior` enum('1','2','3') NOT NULL DEFAULT '1',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pos` int(7) NOT NULL,
  `id_cat` int(7) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id_send`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sm_settings` (
  `language` enum('en','ru') NOT NULL DEFAULT 'en',
  `count_send` int(4) NOT NULL DEFAULT '0',
  `count_user` int(4) NOT NULL DEFAULT '0',
  `email` VARCHAR( 200 ) NOT NULL,
  `organization` VARCHAR( 200 ) NOT NULL,
  `from_mail` VARCHAR( 200 ) NOT NULL,
  `smtp_host` VARCHAR( 200 ) NOT NULL,
  `smtp_username` VARCHAR( 200 ) NOT NULL,
  `smtp_password` VARCHAR( 200 ) NOT NULL,
  `smtp_port` int(8) NOT NULL DEFAULT '25',
  `smtp_aut` enum('1','2') NOT NULL DEFAULT '1',
  `smtp_ssl` enum('yes','no') NOT NULL DEFAULT 'no',
  `send_server` enum('1','2') NOT NULL,
  `id_charset` int(4) NOT NULL DEFAULT '0',
  `ContentType` enum('1','2') NOT NULL DEFAULT '1',
  `day` int(4) NOT NULL DEFAULT '0',
  `count_interval` int(6) NOT NULL DEFAULT '1',
  `send_limit` enum('yes','no') NOT NULL DEFAULT 'no',
  `smtp_timeout` int(6) NOT NULL DEFAULT '5',
  `limit_number` int(6) NOT NULL DEFAULT '100',
  `many_send` enum('yes','no') NOT NULL DEFAULT 'no',
  `del` enum('yes','no') NOT NULL DEFAULT 'yes',
  `show_email` enum('yes','no') NOT NULL DEFAULT 'yes',
  `newsubscribernotify` enum('yes','no') NOT NULL DEFAULT 'yes',
  `reply` enum('yes','no') NOT NULL DEFAULT 'no',
  `unsubscribe` enum('yes','no') NOT NULL,
  `subjecttextconfirm` VARCHAR( 200 ) NOT NULL,
  `textconfirmation` text NOT NULL,
  `unsublink` text NOT NULL,
  `interval_type` enum('no','m','h','d') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `sm_settings` (`language`, `count_send`, `count_user`, `email`, `organization`, `from_mail`, `smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_aut`, `smtp_ssl`, `send_server`, `id_charset`, `ContentType`, `day`, `count_interval`, `send_limit`, `smtp_timeout`, `limit_number`, `many_send`, `del`, `show_email`, `newsubscribernotify`, `reply`, `unsubscribe`, `subjecttextconfirm`, `textconfirmation`, `unsublink`, `interval_type`) VALUES
('ru', 5, 20, 'admin@mysite.com', '', '', 'smtp.gmail.com', '', '', 25, '1', 'no', '1', 1, '2', 7, 1, 'yes', 5, 100, 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'Подписка на рассылку', 'Здравствуйте, %NAME%\r\n\r\nПолучение рассылки возможно после завершения этапа активации подписки. У Вас %DAYS% дней, чтобы активировать подписку, перейдите по следующей ссылке: %CONFIRM%\r\nЕсли Вы не производили подписку на данный email, просто проигнорируйте это письмо или перейдите по ссылке: %UNSUB%\r\nС уважением, администратор сайта %SERVER_NAME%', 'Отписаться от рассылки: <a href=%UNSUB%>%UNSUB%</a>', 'no');

CREATE TABLE IF NOT EXISTS `sm_subscription` (
  `id_sub` int(7) NOT NULL AUTO_INCREMENT,
  `id_user` int(7) NOT NULL,
  `id_cat` int(5) NOT NULL,
  PRIMARY KEY (`id_sub`),
  KEY `id_cat` (`id_cat`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `sm_users` (
  `id_user` int(7) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR( 200 ) NOT NULL,
  `email` VARCHAR( 200 ) NOT NULL,
  `ip` VARCHAR( 64 ) NOT NULL,
  `cod` VARCHAR( 64 ) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('active','noactive') NOT NULL DEFAULT 'noactive',
  `time_send` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sm_log` (
  `id_log` int(7) NOT NULL AUTO_INCREMENT,
  `count` int(7) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_log`)
) ENGINE=MyISAM;