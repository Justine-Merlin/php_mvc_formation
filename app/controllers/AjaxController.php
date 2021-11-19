<?php

class AjaxController extends Controller
{
    public function updatecategAction(){ 
            $id = $this->_getParam('id');
            $name = $this->_getParam('yoyo');
            $slug = Utils::toSlug($name);
            $params = [
                'id' => $id,
                'name' => $name,
                'slug' => $slug
            ]; 
            $cat = new Categorie();

            $return = $cat->save($params);
            echo $return;
            die();
    }

    public function ajaxsearchcategoriesAction()
    {
        $movs = new Movie();
        $cats = new Categorie();
        $searchCateg = $this->_getParam('categories', array());
        // Récupérer les films
        $movies = $movs->searchByCategorie($searchCateg);
        $categs =[];
        foreach($movies as $movie){
            $categs[$movie->id] = $cats->fetchAllCategsByMovie($movie->id);
        }
        $this->view->movies = $movies;
        $this->view->categs = $categs;
        $this->view->allCateg = $cats->fetchAll();
        $this->view->disableLayout();
    }
    public function ajaxresearchmovieAction()
    {
        $mov = new Movie();
        $cats = new Categorie();
        $element = $this->_getParam('element');

        if(isset($element) AND $element != ''){
            $movies = $mov->searchByTitle($element);
            $categs =[];
            foreach($movies as $movie){
                $categs[$movie->id] = $cats->fetchAllCategsByMovie($movie->id);
            }
            $this->view->movies = $movies;
            $this->view->categs = $categs;
            $this->view->allCateg = $cats->fetchAll();
            $this->view->disableLayout();
        }
    }
    public function addbasketAction()
    {
        $add = $this->_getParam('add');
        $remove = $this->_getParam('remove');
        $modelMovie = new Movie();
        
        $movie = $modelMovie->fetchOne(($add) ? $add : $remove);
        $quantity = isset($_SESSION['basket'][$movie->id]) ? $_SESSION['basket'][$movie->id]['quantity'] : 0;

        if($add != ''){
            $_SESSION['basket'][$movie->id] = [
                'quantity' => $quantity+1,
                'movie' => $movie
            ];
        }
        if($remove != ''){
            $_SESSION['basket'][$movie->id] = [
                'quantity' => $quantity-1,
                'movie' => $movie
            ];
        }
        if($_SESSION['basket'][$movie->id]['quantity'] <= 0){
            unset($_SESSION['basket'][$movie->id]);
        }
        echo $_SESSION['basket'][$movie->id]['quantity'];
        die();
    }
}