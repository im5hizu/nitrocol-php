<?php

class User {
    public function __construct($id, $username, $f_name, $l_name, $img, $role){
        $this->id = $id;
        $this->username = $username;
        $this->f_name = $f_name;
        $this->l_name = $l_name;
        $this->img = $img;
        $this->role = $role;
    }
}