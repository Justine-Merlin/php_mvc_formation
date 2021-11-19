<?php

class Utils {
    public static function toSlug($value){
        $string = preg_replace("/['’]/", ' ', $value);
        $string = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $string);
        $string = preg_replace('/[-\s]+/', '-', $string);
        return trim($string, '-');
    }

    public static function displayMessage($req, $successMessage, $errMessage){
        if($req>0){
            $_SESSION['message']['success'] []= $successMessage;
        } else {
            $_SESSION['message']['err'] []= $errMessage; 
        }
    }

    public static function upload($index, $destination, $maxsize=FALSE, $extensions=FALSE){
        //Test1: fichier correctement uploadé
        if(!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;
        //Test2: taille limite
        if($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;
        //Test3: extension
        $ext = substr(strrchr($_FILES[$index]['name'], '.'),1);
        if($extensions !== FALSE AND !in_array($ext, $extensions)) return FALSE;
        //Déplacement  
        return move_uploaded_file($_FILES[$index]['tmp_name'], $destination);
    }
}
