<?php

class Categorie extends Model {
    public function __construct() {
        parent::__construct();
        $this->_setTable('categorie');
    }
    public function fetchAllCategsByMovie($idMovie) {

        $sql = 'select categorie.id, categorie.name from categorie inner join moviecategs ON categorie.id = moviecategs.id_categ where moviecategs.id_movie='.$idMovie;

        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_OBJ);
    // $sql = 'select * from movies inner join moviecategs inner join categorie where movies.id = moviecategs.id_movie and moviecategs.id_categ = categorie.id';

    // $statement = $this->_dbh->prepare($sql);
    // $statement->execute(array());
    
    // return $statement->fetchAll(PDO::FETCH_OBJ);
    }
    public function deleteCategMovie($id){
        $sql = 'delete from moviecategs where id_movie ='.$id;

        $statement = $this->_dbh->prepare($sql);
        $statement->execute();
    }

}