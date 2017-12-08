<?php

require './model/ProfileModel.php';

class ProfileRepository {
    private $data;
    public function __construct($data){
        $this->data = $data->getConnection();
    }
    public function getById(){
        $result = $this->data->query("SELECT * FROM profiles");
        return $result;
    }
}
?>