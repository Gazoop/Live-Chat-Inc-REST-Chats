<?php
/*
// Live Chat Inc Basic REST Class - Created by James Parmee Morris
*/
class LiveChatInc {

	public $secured_session_id = '';
	public $chat_id = '';
	private $url = 'https://api.livechatinc.com/';
	private $license_id = '';
	private $group_id = '';

	public function __construct($license_id, $group_id='', $chat_id='', $secured_session_id=''){
        	$this->license_id=$license_id;
    		$this->group_id=$group_id;
		$this->secured_session_id=$secured_session_id;
		$this->chat_id=$chat_id;
    	}
		
	public function createChat($message, $name='Visitor', $email=''){   
		$paramters = array(
		    "licence_id"        =>  $this->license_id,
		    "welcome_message"   =>  $message,
		    "name"              =>  $name,
		);        
		if($this->group_id!='')$paramters['group']=$this->group_id;

		if($email!='')$paramters['email']=$email;
		if($name!='')$paramters['name']=$name;

		$return = $this->json_post("visitors/".$this->chat_id."/chat/start",$paramters);
		$this->outsource_chat_id = $return['secured_session_id'];
		return $return['secured_session_id'];
	}
    
	public function sendChat($message){
		$paramters = array(
    			"licence_id"        =>  $this->license_id,
		    	"message"           =>  $message,
			"secured_session_id"=>  $this->secured_session_id,
		);        
		$return = $this->json_post("visitors/".$this->chat_id."/chat/send_message",$paramters);
		return $return['success'];
	}
    
	public function closeChat(){
		$paramters = array(
		    "licence_id"        =>  $this->license_id,
		    "secured_session_id"=>  $this->secured_session_id,
		);
		$return = $this->json_post("visitors/".$this->chat_id."/chat/close",$paramters);
		return $return['success'];
	}
    
	public function getPendingChats($last_message_id=0){
		$paramters = array(
		    "licence_id"        =>  $this->license_id,
		    "secured_session_id"=>  $this->secured_session_id,
		);
		$return = $this->json_get("visitors/".$this->chat_id."/chat/get_pending_messages",$paramters);
		return $return;
	}

	
	private function json_get($tool, $parameters=array()){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$this->url.$tool."?".http_build_query($parameters));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Version: 2'));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);
		curl_close($ch);
		$data = @json_decode($result,true);
		return $data;
	}

	private function json_post($tool, $parameters){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url.$tool);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Version: 2'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		$data = @json_decode($result,true);
		return $data;
	}
}

?>
