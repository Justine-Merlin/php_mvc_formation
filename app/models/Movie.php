<?php

class Movie extends Model {
    public function __construct() {
        parent::__construct();
        $this->_setTable('movies');
    }
    public function searchByCategorie(array $categ)
    {
        $where = '';
        if(count($categ) > 0){
            foreach($categ as $key=>$categs){ 
                $where.=' inner join moviecategs mc'.$key.' ON mc'.$key.'.id_movie = movies.id and mc'.$key.'.id_categ = '.$categs;
            }
        }
        // echo $where;
        $sql = 'select '.$this->_table.'.id, '.$this->_table.'.image, '.$this->_table.'.title, '.$this->_table.'.slug, '.$this->_table.'.price, '.$this->_table.'.date_release, '.$this->_table.'.description from '.$this->_table;

        $sql.= ''.$where;

        $statement = $this->_dbh->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
    public function searchByTitle($element)
    {
        $sql = 'SELECT * FROM movies WHERE title LIKE "%'.$element.'%" OR description LIKE "%'.$element.'%"';

        $statement = $this->_dbh->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}