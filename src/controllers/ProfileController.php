<?php 


namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class ProfileController extends Controller {

    private $loggedUser;

    public function __construct() { 
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/login');
        }
    }

    public function index($atts = []) {
        $page = intval(filter_input(INPUT_GET, 'page'));

        $contagem = [];


        $id = $this->loggedUser->id;
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }



        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect('/');
        }

        if($this->loggedUser->id != $user->id){
            $contagem = UserHandler::getUser($this->loggedUser->id, true);
            
        }
        

        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;



        $feed = PostHandler::getUserFeed(
            $id,
            $page,
            $this->loggedUser->id
        );


        $isFollowing = false;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        

        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing'=>$isFollowing,
            'contagem'=>$contagem

        ]);
    }

    public function follow($atts){
        $to = intval($atts['id']);

        
        if($exists = UserHandler::idExists($to)){

            if(UserHandler::isFollowing($this->loggedUser->id, $to)){
                Userhandler::unfollow($this->loggedUser->id, $to);
            }else{
                Userhandler::follow($this->loggedUser->id, $to);
            }

        }

        $this->redirect('/perfil/'.$to);

    }

    public function friends($atts = []){

        $id = $this->loggedUser->id;
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }



        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect('/');
        }

        $isFollowing = false;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing'=>$isFollowing

        ]);


    }


    public function photos($atts = []){

        $id = $this->loggedUser->id;
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }



        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect('/');
        }

        $isFollowing = false;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_photos', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing'=>$isFollowing

        ]);


    }

}  