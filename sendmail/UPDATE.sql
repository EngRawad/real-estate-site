ALTER TABLE `sm_users` DROP `id_cat`;

ALTER TABLE `sm_settings` ADD  `newsubscribernotify` ENUM(  'yes',  'no' ) NOT NULL DEFAULT  'no' AFTER  `ShowAdmin`;
ALTER TABLE `sm_settings` CHANGE  `ShowAdmin`  `show_email` ENUM(  'yes',  'no' ) NOT NULL DEFAULT  'yes';
ALTER TABLE `sm_settings` CHANGE `admin_email` `email` tinytext NOT NULL;

RENAME TABLE sm_cat TO sm_category;

CREATE TABLE IF NOT EXISTS `sm_subscription` (
  `id_sub` int(7) NOT NULL AUTO_INCREMENT,
  `id_user` int(7) NOT NULL,
  `id_cat` int(5) NOT NULL,
  PRIMARY KEY (`id_sub`),
  KEY `id_cat` (`id_cat`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM;

ALTER TABLE `sm_attach` CHANGE `path` `path` VARCHAR( 255 ) NOT NULL;
ALTER TABLE `sm_attach` CHANGE `name` `name` VARCHAR( 255 )  NOT NULL;
ALTER TABLE `sm_aut` CHANGE `passw` `passw` VARCHAR( 32 ) NOT NULL;
ALTER TABLE `sm_category` CHANGE `name` `name` VARCHAR( 200 ) NOT NULL;   
ALTER TABLE `sm_charset` CHANGE `charset` `charset` VARCHAR( 32 ) NOT NULL; 
ALTER TABLE `sm_send` CHANGE `name` `name` VARCHAR( 200 ) NOT NULL;
ALTER TABLE `sm_settings` CHANGE `email` `email` VARCHAR( 200 ) NOT NULL;
ALTER TABLE `sm_settings` CHANGE `organization` `organization` VARCHAR( 200 ) NOT NULL;
ALTER TABLE `sm_settings` CHANGE `from_mail` `from_mail` VARCHAR( 200 ) NOT NULL;
ALTER TABLE `sm_settings` CHANGE `smtp_host` `smtp_host` VARCHAR( 200 ) NOT NULL;
ALTER TABLE `sm_settings` CHANGE `smtp_username` `smtp_username` VARCHAR( 200 ) NOT NULL; 
ALTER TABLE `sm_settings` CHANGE `smtp_password` `smtp_password` VARCHAR( 200 ) NOT NULL;
ALTER TABLE `sm_settings` CHANGE `subjecttextconfirm` `subjecttextconfirm` VARCHAR( 200 ) NOT NULL;
ALTER TABLE `sm_users` CHANGE `name` `name` VARCHAR( 200 ) NOT NULL;   
ALTER TABLE `sm_users` CHANGE `email` `email` VARCHAR( 200 ) NOT NULL; 
ALTER TABLE `sm_users` CHANGE `ip` `ip` VARCHAR( 64 ) NOT NULL;
ALTER TABLE `sm_users` CHANGE `cod` `cod` VARCHAR( 64 ) NOT NULL;

ALTER TABLE `sm_ready_send` ADD INDEX ( `id_user` );
ALTER TABLE `sm_ready_send` ADD INDEX ( `id_send` );