<?php 
namespace Longman\TelegramBot\Commands\AdminCommands;
use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Request;

//	use Longman\TelegramBot\Entities\Keyboard;
//use Longman\TelegramBot\Entities\KeyboardButton;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
 
use Longman\TelegramBot\Funciones;
use PDO;
use Longman\TelegramBot\DB;

error_reporting(E_ALL);


class standbyCommand extends AdminCommand
{
   
    protected $name = 'standby';
    protected $description = 'Actualizador de precios';
    protected $usage = '/standby';
    protected $version = '0.1.0';
    
		
    public function execute()
    {
		if ($this->getCallbackQuery() !== null) {
			 //$message =  $update->getMessage();
             $message  = $this->getCallbackQuery()->getMessage();
			 $chat    =$this->getCallbackQuery()->getMessage()->getChat();
			 $user    = $chat;
			 $chat_id =  $this->getCallbackQuery()->getMessage()->getChat()->getId();
			 $user_id = $chat_id;
			 $text = '';
		}
		else
		{
			$message = $this->getMessage() ?: $this->getEditedMessage();
			$chat    = $message->getChat();
			$user    = $message->getFrom();
			$chat_id = $chat->getId();
			$user_id = $user->getId();
			$text    = trim($message->getText(true));
        }		
        
		$data = [
            'chat_id'      => $chat_id,			
            'text'         => "\xf0\x9f\x91\x87".' *Stand by* '.PHP_EOL."\xf0\x9f\x91\x87",           
        ];
		$mantenimiento = Funciones::esta_en_standby( $this->getTelegram()->getBotId()	);
		if ( $text <> 'on' && $text <> 'off')
		{
			$data['text'].="Uso: on/off ".$text.' '.date('d / m G:i:s').PHP_EOL;
			if ($mantenimiento ) $data['text'].="En mantenimiento";
			if (!$mantenimiento ) $data['text'].="OPERATIVO";
			return Request::sendMessage($data);
		}
		if ( $text == 'on' )  Funciones::standby( true , $this->getTelegram()->getBotId() );
		if ( $text == 'off' ) Funciones::standby(  0 , $this->getTelegram()->getBotId() );
		$mantenimiento = Funciones::esta_en_standby( $this->getTelegram()->getBotId()	);
		
		$mensaje = Funciones::msjs_en_standby( $this->getTelegram()->getBotId() );
		
		if ( $mantenimiento )  
		{
				$data['text'].="Nuevo estado:  En mantenimiento ".$mensaje['message_on'].PHP_EOL.date('d / m G:i:s');
		}
		if (!$mantenimiento ) 
		{
			$data['text'].="Nuevo estado: OPERATIVO".$mensaje['message_off'].PHP_EOL.date('d / m G:i:s');
		}
		
		
		
		
		if ($message->getFrom()->getUsername() != 'damdengobot' ) 
		{		
			return Request::sendMessage($data);
		} else 
		{		
		    $data['text'] = $message->getFrom()->getUsername().' '.'Paso el cron standby ' . 
			PHP_EOL. $data['text'].PHP_EOL.'Fin '. date("d m G:i"); ;
			Funciones::msj_a_admins_php('yo',$data['text'] );		
			return Request::emptyResponse();
		}
		return Request::emptyResponse();       
    }
}
