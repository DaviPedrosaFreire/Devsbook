<?php
namespace src\handlers;

use \src\models\User;
use \src\models\UserRelation;

use \src\handlers\PostHandler;

class UserHandler {

    public static function checkLogin(){
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];
            $data = User::select()->where('token', $token)->one();

            if(count($data) > 0){
                
                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->name = $data['name'];
                $loggedUser->avatar = $data['avatar'];
                
                return $loggedUser;
                
            }
            
        }
        
        return false;
    }

    public static function verifyLogin($email, $password){
        $user = User::select()->where('email', $email)->one();
        if($user){
            if(password_verify($password, $user['password'])){
                $token = md5(time().rand(0,999) );
                
                User::update()
                ->set('token',$token)
                ->where('email',$email)
                ->execute();

                return $token;
            }
        }
        return false;
    } 


    public static function idExists($id){
        $user = User::select()->where('id', $id)->one();
        return $user ? true : false;
    }

    public static function emailExists($email){
        $user = User::select()->where('email', $email)->one();
        return $user ? true : false;
    }

    public static function searchUser(  $term  ){
        $data = User::select()->where('name','like','%'.$term.'%')->get();
        $users = [];
        if($data){
            foreach($data as $user){
                $newUser = new User();
                $newUser->id = $user['id'];
                $newUser->name = $user['name'];
                $newUser->avatar = $user['avatar'];

                $users[] = $newUser;
            } 
        }
        return $users;
    }   

    public static function getUser($id, $full = false) {
        
        $data = User::select()->where('id', $id)->one();

        if($data){
            $user = new User();
            $user->id = $data['id'];
            $user->name = $data['name'];
            $user->birthdate = $data['birthdate'];
            $user->city = $data['city'];
            $user->work = $data['work'];
            $user->cover = $data['cover'];
            $user->avatar = $data['avatar'];
            $user->email = $data['email'];

            if($full){
                $user->followersCount = [];
                $user->followingCount = [];
                $user->photos = [];

                $followers = UserRelation::select()->where('user_to', $id)->get();
                foreach($followers as $follower){
                    $userData = User::select()->where('id', $follower['user_from'])->one();
                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->avatar = $userData['avatar'];

                    $user->followersCount[] = $newUser;
                }

                
                $following = UserRelation::select()->where('user_from', $id)->get();
                foreach($following as $follower){
                    $userData = User::select()->where('id', $follower['user_to'])->one();
                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->avatar = $userData['avatar'];

                    $user->followingCount[] = $newUser;
                }

                $user->photos = PostHandler::getPhotosFrom($id);
                
            }
            
            return $user;
            
        }   
            
        return false;
        
    }

    public static function addUser($name,$email,$password,$birthdate) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0,999));

        User::insert([
            'email' => $email,
            'password' => $hash,
            'name' => $name,
            'birthdate' => $birthdate,
            'token' => $token
        ])->execute();
        
        $data = User::select()->where('token', $token)->one();
        UserRelation::insert([
            'user_from'=>$data['id'],
            'user_to'=>1
        ])->execute();
        
        return $token;
    }

    public static function isFollowing($from,$to){
        $data = UserRelation::select()
        ->where('user_from', $from)
        ->where('user_to',$to)
        ->one();

        if($data){
            return true;
        }
        
        return false;
        
    }  

    public static function follow($from, $to){
        UserRelation::insert([
            'user_from'=>$from,
            'user_to'=>$to
        ])->execute();

    }

    public static function unFollow($from, $to){
        UserRelation::delete()->where('user_from',$from)->where('user_to',$to)->execute();
    }

    public static function updateUser($id,$name,$email,$birthdate,$password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0,999) );

        User::update([
            'email' => $email,
            'password' => $hash,
            'name' => $name,
            'birthdate' => $birthdate,
            'token' => $token
        ])->where('id', $id)->execute();

        
        return $token;
    }

    public static function updateAvatar($newAvatar, $id) {

        

        if(in_array($newAvatar['type'],['image/jpeg','image/jpg','image/png']  )){
            $avatarWidth = 200;
            $avatarHeight = 200;
            
            list($widthOrigi, $heightOrigi) = getimagesize($newAvatar['tmp_name']);
            $ratio = $widthOrigi / $heightOrigi;

            $newWidth = $avatarWidth;
            $newHeight = $newWidth / $ratio;

            if($newHeight < $avatarHeight) {
                $newHeight = $avatarHeight;
                $newWidth = $newHeight * $ratio;
            }

            $x = $avatarWidth - $newWidth;
            $y = $avatarHeight - $newHeight;
            $x = $x<0 ? $x/2 : $x;
            $y = $y<0 ? $y/2 : $y;

            $finalImage = imagecreatetruecolor($avatarWidth, $avatarHeight);

            switch($newAvatar['type']){
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($newAvatar['tmp_name']);
                break;

                case 'image/png':
                    $image = imagecreatefrompng($newAvatar['tmp_name']);
                break;
            }
            
            imagecopyresampled(
                $finalImage,$image,
                $x,$y,0,0,
                $newWidth,$newHeight,$widthOrigi,$heightOrigi

            );

            $avatarName = md5(time().rand(0,999)).'.jpg';

            imagejpeg($finalImage, './media/avatars/'.$avatarName, 100);
            
            
            $name = User::select('avatar')->where('id', $id)->get();
            if($name[0]['avatar'] != 'default.jpg'){
                unlink('./media/avatars/'.$name[0]['avatar']);
            }      
            
            User::update([
                'avatar' => $avatarName,
            ])->where('id', $id)->execute();
            
            return $avatarName;

        }
    }

    public static function updateCover($newCover, $id) {

        if(in_array($newCover['type'],['image/jpeg','image/jpg','image/png']  )){
            $coverWidth = 850;
            $coverHeight = 310;
            
            list($widthOrigi, $heightOrigi) = getimagesize($newCover['tmp_name']);
            $ratio = $widthOrigi / $heightOrigi;

            $newWidth = $coverWidth;
            $newHeight = $newWidth / $ratio;

            if($newHeight < $coverHeight) {
                $newHeight = $coverHeight;
                $newWidth = $newHeight * $ratio;
            }

            $x = $coverWidth - $newWidth;
            $y = $coverHeight - $newHeight;
            $x = $x<0 ? $x/2 : $x;
            $y = $y<0 ? $y/2 : $y;

            $finalImage = imagecreatetruecolor($coverWidth, $coverHeight);

            switch($newCover['type']){
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($newCover['tmp_name']);
                break;

                case 'image/png':
                    $image = imagecreatefrompng($newCover['tmp_name']);
                break;
            }
            
            imagecopyresampled(
                $finalImage,$image,
                $x,$y,0,0,
                $newWidth,$newHeight,$widthOrigi,$heightOrigi

            );

            $coverName = md5(time().rand(0,999)).'.jpg';

            imagejpeg($finalImage, './media/covers/'.$coverName, 100);
            
            $name = User::select('cover')->where('id', $id)->get();
            if($name[0]['cover'] != 'cover.jpg'){
                unlink('./media/covers/'.$name[0]['cover']);
            }    


            User::update([
                'cover' => $coverName,
            ])->where('id', $id)->execute();
            
            return $coverName;

        }



    }


        

}