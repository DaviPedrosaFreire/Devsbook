<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;
use \src\handlers\GroupHandler;
use \src\handlers\MessageHandler;

class AjaxController extends Controller {

    private $loggedUser;

    public function __construct() { 
        $this->loggedUser = UserHandler::checkLogin();
        
        if($this->loggedUser === false){
            header("Content-Type: application/json");
            echo json_encode(['error' => 'Usuário nao logado']);
            exit;
        }
    }

    public function like($atts = []) {
        $id = $atts['id'];

        if(PostHandler::isLiked($id, $this->loggedUser->id)){
            //delete no like
            PostHandler::deleteLike($id, $this->loggedUser->id);
        }else{
            //inserir um like
            PostHandler::addLike($id, $this->loggedUser->id);
        }
        
    }


    public function comments(){
        $array = ['error'=>''];

        $id = filter_input(INPUT_POST, 'id');
        $txt = filter_input(INPUT_POST, 'txt');

        if($id && $txt){
            PostHandler::addComment($id,$txt,$this->loggedUser->id);

            
            $array['link'] = '/perfil/'.$this->loggedUser->id;
            $array['avatar'] = '/media/avatars/'.$this->loggedUser->avatar;
            $array['name'] = $this->loggedUser->name;
            $array['body'] = $txt;
        }

        header("Content-Type: application/json");
        echo json_encode($array);
        exit;

    }

    public function upload() {
        $array = ['error'=>''];

        if(isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])){
            $photo = $_FILES['photo'];

            $maxWidth = 800;
            $maxHeight = 800;

            if(in_array($photo['type'],['image/png','image/jpg','image/jpeg'])){
                list($widthOrig,$heightorigi) = getimagesize($photo['tmp_name']);
                $ratio = $widthOrig / $heightorigi;

                $newWidth = $maxWidth;
                $newHeight = $maxHeight;

                $ratioMax = $maxWidth / $maxHeight;

                if($ratioMax > $ratio){
                    $newWidth = $newHeight * $ratio;

                }else {
                    $newHeight = $newWidth / $ratio;
                }
                

                $finalImage = imagecreatetruecolor($newWidth,$newHeight);

                switch($photo['type']){
                    case 'image/png':
                        $image = imagecreatefrompng($photo['tmp_name']);
                    break;

                    case 'image/jpg':
                    case 'image/jpeg':
                        $image = imagecreateFromjpeg($photo['tmp_name']);
                    break;
                }

                imagecopyresampled(
                    $finalImage,$image,
                    0,0,0,0,
                    $newWidth,$newHeight,$widthOrig,$heightorigi
                );

                $photoName = md5(time().rand(0,999)).'.jpg';

                imagejpeg($finalImage,'media/uploads/'.$photoName);

                PostHandler::addPost(
                    $this->loggedUser->id,
                    'photo',
                    $photoName
                );

            }


        }else{
            $array['error'] = 'Nenhuma imagem enviada';
        }

        header("Content-Type: application/json");
        echo json_encode($array);
        exit;

    }


    public function old_message() {
        $array = array('status' => '1', 'error' => '0');
        $messages = new MessageHandler();

        if(!empty($_POST['id_group'])){
            $id_group = $_POST['id_group'];
            $array['msgs'] = $messages->old($id_group);
        } else {
            $array['status'] = '1';
            $array['errorMsg'] = 'Mensagem vazia';
        }

        echo json_encode($array);
        exit;
    }

    public function get_groups() {
        $array = array('status' => '1');
        $groups = new GroupHandler();

        $array['list'] = $groups->getList();

        echo json_encode($array);
        exit;

    }

    public function add_group() {
        $array = array('status'=>'1', 'error' => '0');
        $groups = new GroupHandler();

        if(!empty($_POST['name'])) {
            $name = $_POST['name'];
            $groups->add($name);
        } else {
            $array['error'] = '1';
            $array['errorMsg'] = 'Falta o nome do grupo';
        }
        
        echo json_encode($array);
        exit;
    }

    public function add_message() {
        $array = array('status' => '1', 'error' => '0');
        $messages = new MessageHandler();

        if(!empty($_POST['msg']) && !empty($_POST['id_group'])){
            $msg = $_POST['msg'];
            $id_group = $_POST['id_group'];
            $id = $this->loggedUser->id;

            $messages->add($id, $id_group, $msg);
        } else {
            $array['status'] = '1';
            $array['errorMsg'] = 'Mensagem vazia';
        }

        echo json_encode($array);
        exit;
    }

    public function get_messages() {
		$array = array('status' => '1', 'msgs' => array(), 'last_time' => date('Y-m-d H:i:s'));
		$messages = new MessageHandler();

		set_time_limit(60);

        
		$ult_msg = date('Y-m-d H:i:s');
		if(!empty($_GET['last_time'])) {
			$ult_msg = $_GET['last_time'];
		}

		$groups = array();
		if(!empty($_GET['groups']) && is_array($_GET['groups'])) {
			$groups = $_GET['groups'];
		}

        

		while(true) {
			session_write_close();
			$msgs = $messages->get($ult_msg, $groups);

			if(count($msgs) > 0) {
				$array['msgs'] = $msgs;
				$array['last_time'] = date('Y-m-d H:i:s');
				break;
			} else {
				sleep(2);
				continue;
			}

		}



		echo json_encode($array);
		exit;
	}


    
}