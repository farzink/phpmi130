<?php

class AuthHelper {
    public static function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
    public static function verifyPassword($password, $storedPassword){
        return password_verify($password, $storedPassword);
    }
    public static function isPasswordUptoDate($password){
        return !password_needs_rehash($password, PASSWORD_DEFAULT);
    }
}