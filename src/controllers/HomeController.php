<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class HomeController extends Controller {

    private $loggedUser;

    public function __construct() { 
        $this->loggedUser = UserHandler::checkLogin();
        
        if($this->loggedUser === false){
            $this->redirect('/login');
        }
    }

    public function index() {
        $page = intval(filter_input(INPUT_GET, 'page'));

        

        $feed = PostHandler::getHomeFeed(
            $this->loggedUser->id,
            $page
        );

        
        $id = $this->loggedUser->id;
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }



        $user = UserHandler::getUser($id, true);

        $isFollowing = false;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }


        $this->render('home', [
            'loggedUser' => $this->loggedUser,
            'feed' => $feed,
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);
    }


}