<?php
namespace src\handlers;

use \src\models\User;
use \src\models\Group;

class GroupHandler {

    public function getList() {
        $array = array();

        $array = Group::select()->get();

        return $array;
    }

    public function add($name) {

        $sql = Group::insert([
            'name' => $name,
        ])
        ->execute();

    }

}