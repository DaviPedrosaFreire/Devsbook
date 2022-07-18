<?php
namespace src\handlers;


use \src\models\Message;

class MessageHandler {

    public function old($id){
        $array = array();

        
        
        $array = Message::select('messages.id, messages.id_user, messages.id_group, messages.date_msg, messages.msg, users.name')
        ->join('users', 'users.id', '=', 'messages.id_user')
        ->where('id_group', '=', $id)
        ->get();
        
        

		return $array;

    }

    public function add($id, $id_group, $msg) {

        $date = date('Y-m-d H:i:s');

        $sql = Message::insert([
            'id_user' => $id,
            'id_group' => $id_group,
            'date_msg' => $date,
            'msg' => $msg,
        ])
        ->execute();
    }

    public function get($last_time, $groups) {
		$array = array();
        
    
        $array = Message::select('messages.id, messages.id_user, messages.id_group, messages.date_msg, messages.msg, users.name')
        ->join('users', 'users.id', '=', 'messages.id_user')
        ->where('date_msg', '>', $last_time)
        ->where('id_group', 'IN', $groups)
        ->get();

        
		return $array;
	}



}