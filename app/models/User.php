<?php

class User extends Model {
    public function __construct() {
        parent::__construct();
        $this->_setTable('user');
    }
    public function signIn($login, $password){
        $sql = "SELECT * FROM user WHERE login = ? AND password = ?";

        $statement = $this->_dbh->prepare($sql);
        $statement->execute(array($login, md5($password)));

        return $statement->fetch(PDO::FETCH_OBJ);
    }
}