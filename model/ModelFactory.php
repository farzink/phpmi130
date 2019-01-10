<?php

require_once 'OrderValidationModel.php';
require_once 'OrderHistoryModel.php';


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
        $profile->address = $raw["address"];
        $profile->creationDateTime = $raw["creationdatetime"];
        $profile->updateDateTime = $raw["updateddatetime"];        
        $profile->emailToken = $raw["emailToken"];        
        $profile->expirationdatetime = $raw["expirationdatetime"];        
        return $profile;
    }
    public static function rawToAuthTempModel($raw){
        $authtemp = new AuthTempModel();
        $authtemp->id = $raw["id"];
        $authtemp->token = $raw["token"];
        $authtemp->expirationdatetime = $raw["expirationdatetime"];        
        $authtemp->creationDateTime = $raw["creationdatetime"];
        $authtemp->updateDateTime = $raw["updateddatetime"];        
        $authtemp->profileid = $raw["profileid"];        
        return $authtemp;
    }
    public static function rawToCSRFModel($raw){
        $model = new CSRFModel();
        $model->id = $raw["id"];
        $model->email = $raw["email"];
        $model->token = $raw["token"];
        $model->expirationdatetime = $raw["expirationdatetime"];        
        $model->creationDateTime = $raw["creationdatetime"];
        $model->updateDateTime = $raw["updateddatetime"];                
        return $model;
    }
    public static function rawToItemModel($raw){
        $model = new ItemModel();
        $model->id = $raw["id"];
        $model->title = $raw["title"];
        $model->description = $raw["description"];
        $model->imageAddress = $raw["imageAddress"];
        $model->price = $raw["price"];
        $model->quantity = $raw["quantity"];
        $model->creationDateTime = $raw["creationdatetime"];
        $model->updateDateTime = $raw["updateddatetime"];
        return $model;      
    }
    public static function rawToOrderModel($raw){
        $model = new OrderModel();
        $model->id = $raw["id"];
        //$model->profileId = $raw["profileId"];
        $model->itemId = $raw["itemId"];
        $model->price = $raw["price"];        
        $model->title = $raw["title"];        
        $model->imageAddress = $raw["imageAddress"];        
        //$model->creationDateTime = $raw["creationdatetime"];
        //$model->updateDateTime = $raw["updateddatetime"];
        return $model;      
    }

    public static function OrderItemViewModelToOrderItem($model){
        $orderModel = new OrderModel();
        $orderModel->id = $model->id;
        $orderModel->profileId = $model->profileId;
        $orderModel->itemId = $model->itemId;
        $orderModel->price = $model->price;
        //$orderModel->title = $model->title;
        //$orderModel->imageAddress = $model->imageAddress;
        return $orderModel;
    }
    public static function ProfileViewModelToProfile($model){
        $profile = new ProfileModel();        
        $profile->firstname = $model->firstname;
        $profile->lastname = $model->lastname;
        $profile->phone = $model->phone;
        $profile->email = $model->email;
        $profile->address = $model->address;
        return $profile;
    }
    public static function rawToOrderValidationModel($raw){
        $order = new OrderValidationModel();     
        $order->count = $raw["count"];
        $order->itemId = $raw["itemId"];                
        return $order;
    }
    public static function rawToHistoryModel($raw){
        $model = new OrderHistoryModel();
        $model->id = $raw["id"];
        $model->profileId = $raw["profileId"];
        $model->total = $raw["total"];
        $model->items = $raw["items"];                
        $model->creationDateTime = $raw["creationdatetime"];
        $model->updateDateTime = $raw["updateddatetime"];
        return $model;      
    }
}




