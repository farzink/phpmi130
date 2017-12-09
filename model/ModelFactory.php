<?php



class ModelFactory {

    //used to convert mysql fetch result to (its corresponding object model) profile model
    public static function rawToProfileModel($raw){
        $profile = new ProfileModel();
        $profile->id = $raw["id"];
        $profile->firstname = $raw["firstname"];
        $profile->lastname = $raw["lastname"];
        $profile->email = $raw["email"];
        $profile->phone = $raw["phone"];
        $profile->creationDateTime = $raw["creationdatetime"];
        $profile->updateDateTime = $raw["updateddatetime"];        
        return $profile;
    }
}