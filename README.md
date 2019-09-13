# telegram command standby
Standby on/off  Put bot on maintenance mode.
Put on:
  /standby  show current state
  /standby on  : Return message from db
  /standby off  : Return message  OPERATIVO
  
  in GenericMessage and Callbackquery:
 /* Mantenimiento */
		if ( Funciones::esta_en_standby( $this->getTelegram()->getBotId()	) )
			{
			$mensaje = Funciones::msjs_en_standby( $this->getTelegram()->getBotId() );
			$data['text']= $mensaje;
			return Request::sendMessage($data); 	
			}
      


needs a table:
CREATE TABLE `stand_by` (
  `id_bot` bigint(12) NOT NULL,
  `bot_name` varchar(15) NOT NULL,
  `stand_by` tinyint(1) unsigned NOT NULL,
  `message_on` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_bot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
