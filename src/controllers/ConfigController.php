<?php 


namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;
use core\Router;



class ConfigController extends Controller {

    private $loggedUser;

    public function __construct() { 
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/login');
        }
    }

    public function index($atts = []) {
        $page = intval(filter_input(INPUT_GET, 'page'));

        $id = $this->loggedUser->id;
        if(!empty($atts['id'])){
            $id = $atts['id'];
        }


        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect('/');
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


        $user->birthdate = explode('-',$user->birthdate);
        $dataFormat = $user->birthdate[2].'/'.$user->birthdate[1].'/'.$user->birthdate[0];
        $user->birthdate = $dataFormat;

        $this->render('config', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing'=>$isFollowing

        ]);

        $_SESSION['flash'] = '';

    }


    public function atualizaAction(){   
        $id = filter_input(INPUT_POST, 'id');
        $avatar = $_FILES['avatar'];
        $cover = $_FILES['cover'];
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $birthdate = filter_input(INPUT_POST, 'birthdate');
        $password = filter_input(INPUT_POST, 'password');
        $passConfirm = filter_input(INPUT_POST, 'passConfirm');



        if(!empty($avatar) && !empty($_FILES['avatar']['tmp_name'])) {
            $avatarName = UserHandler::updateAvatar($avatar, $id);
            $this->loggedUser->avatar = $avatarName;
        }

        if(!empty($cover) && !empty($_FILES['cover']['tmp_name'])) {
            $coverName = UserHandler::updateCover($cover, $id);
            $this->loggedUser->cover = $coverName;
        }


        $birthdate = explode('/', $birthdate);
        $dataFormat = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];


        if($password === $passConfirm && !empty($password)){
            $update = UserHandler::updateUser($id,$name,$email,$dataFormat,$password);

            $_SESSION['token'] = $update;
            $this->redirect('/');

        }else {
            $_SESSION['flash'] = 'Digite uma senha para alterar dados do cadastro';
            $this->redirect('/config');
        }


    }

   
    


   

}  