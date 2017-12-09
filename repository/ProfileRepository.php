<?php


require './model/ModelFactory.php';
require './model/ProfileModel.php';

class ProfileRepository {
    private $data;
    public function __construct($data){
        $this->data = $data;
    }
    public function getById($id){
        $query = "SELECT * FROM profiles where id = {$id}";
        $result = $this->data->executeQuery($query);
        if($result->num_rows > 0){
            //while($row = $result->fetch_assoc()) {
                return ModelFactory::rawToProfileModel($result->fetch_assoc());
                //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["email"]. "<br>";
            //}
        }
        else {
            return NULL;
        }
    }
}
?>
