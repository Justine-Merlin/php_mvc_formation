<?php

class MovieCategs extends Model {
    public function __construct() {
        parent::__construct();
        $this->_setTable('moviecategs');
    }
}