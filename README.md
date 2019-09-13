# telegramcommands
Standby on/off
Put bot on maintenance mode.

needs a table:
CREATE TABLE `stand_by` (
  `id_bot` bigint(12) NOT NULL,
  `bot_name` varchar(15) NOT NULL,
  `stand_by` tinyint(1) unsigned NOT NULL,
  `message_on` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_bot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
