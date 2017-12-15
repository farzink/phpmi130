<?php



class ModelFactory {

    //used to convert mysql fetch result to (its corresponding object model) profile model
    public static function rawToProfileModel($raw){
        $profile = new ProfileModel();
        $profile->id = $raw["id"];
        $profile->firstname = $raw["firstname"];
        $profile->lastname = $raw["lastname"];
        $profile->email = $raw["email"];
        $profile->password = $raw["password"];
        $profile->phone = $raw["phone"];
        $profile->creationDateTime = $raw["creationdatetime"];
        $profile->updateDateTime = $raw["updateddatetime"];        
        return $profile;
    }
    public static function rawToAuthTempModel($raw){
        $authtemp = new AuthTempModel();
        $authtemp->id = $raw["id"];
        $authtemp->token = $raw["token"];
        $authtemp->expirationdatetime = $raw["expirationdatetime"];        
        $authtemp->creationDateTime = $raw["creationdatetime"];
        $authtemp->updateDateTime = $raw["updateddatetime"];        
        return $authtemp;
    }
}