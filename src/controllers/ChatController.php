<?php 


namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class ChatController extends Controller {

    private $loggedUser;

    public function __construct() { 
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/login');
        }
    }


    public function index($atts = []) {

        $id = $this->loggedUser->id;
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }



        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect('/');
        }

        

        $this->render('comment', [
            'loggedUser' => $this->loggedUser,
            'user' => $user
        ]);
    }

 

    

}  