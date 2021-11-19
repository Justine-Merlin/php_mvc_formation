<?php

/**
 * Base controller for the application.
 * Add general things in this controller.
 */
class ApplicationController extends Controller 
{
	public function addCategAction(){
        if(isset($_POST['categorie']) && $_POST['categorie'] != ""){
            $name = $_POST['categorie'];
            $slug = Utils::toSlug($name);

            $param = [
                'name' => $name,
                'slug' => $slug
            ];
            $cat = new Categorie();
            
            $success = "Vous avez réussi";
            $err = "L'opération a échoué";
            Utils::displayMessage($cat->save($param), $success, $err);
        }
    }
    public function addfilmAction(){
        $cat = new Categorie();
        $this->view->cats = $cat->fetchAll();

        if(isset($_POST['title']) && $_POST['title'] !== ""){
            $title = $_POST['title'];
            $description = $_POST['description'];
            $release = $_POST['release'];
            $price = floatval($_POST['price']);
            $slug = Utils::toSlug($title);
            $categ = $_POST['categorie'];

            if($_FILES['image']['name'] != ""){
                $titleimg = md5(uniqid(rand(), true));
                $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
                $titleimg = $titleimg.'.'.$extension_upload;
                Utils::upload('image', 'images/film/'.$titleimg, FALSE, false);
            } else {
                $titleimg = "default.jpg";
            }

            if(isset($_POST['title']) && $_POST['title'] !== ""){
                $title = $_POST['title'];
                //     elseif($idParam != ""){
            //     $titleimg = $filmUpdate->image;
            $params = [
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'date_release' => $release,
                'price' => $price,
                'image' => $titleimg      
            ];

            $movie = new Movie();
            $moviecategs = new MovieCategs();

            $success = "Vous avez réussi";
            $err = "L'opération a échoué";

            $insertReturn = $movie->save($params);
            foreach($categ as $cate){
                $params = [
                    'id_movie' => intval($insertReturn),
                    'id_categ' => intval($cate)
                ];
            $moviecategs->save($params);   
            }
        }
    }}
    public function categoriesAction(){
        $cats = new Categorie();
        $id = $this->_getParam('iddelete');

        if(isset($id)){
            $cats->delete($id);
        }
        $categs = $cats->fetchAll('nom asc');
        $this->view->categs = $categs;
    }

    public function categorieAction() {
        $id = $this->_getParam('id');
        $cats = new Categorie();

        $categ = $cats->fetchOne($id);
        $this->view->categ = $categ;
    }

    public function moviesAction() {
        $movs = new Movie();
        $cats = new Categorie();
        $id = $this->_getParam('iddelete');

        // Supprimer un film
        if(isset($id)){
            $movs->delete($id);
            $cats->deleteCategMovie($id);
        }

        // Récupérer les films
        $movies = $movs->fetchAll();
        foreach($movies as $movie){
            $movie->categs = $cats->fetchAllCategsByMovie($movie->id);
        }
        $this->view->movies = $movies;

        //Récupérer les catégories
        $categs = $cats->fetchAll();
        $this->view->categs = $categs;
    }
    public function update_movieAction() {

        //Récupérer les catégories pour les afficher dans la view
        $cat = new Categorie();
        $this->view->cats = $cat->fetchAll();

        //Récupérer les éléments pour les afficher dans la view
        $id = $this->_getParam('id');
        $mov = new Movie();
        $cats = new Categorie();

        $movie = $mov->fetchOne($id);
        $this->view->movie_categs = $cats->fetchAllCategsByMovie($movie->id);
        $this->view->movie = $movie;
        // echo '<pre>';print_r($movie);

    }
    public function updated_movieAction(){
        if(isset($_POST['title']) && $_POST['title'] !== ""){

            $id = $_POST['id'];

            $cats = new Categorie();
            $cats->deleteCategMovie($id);

            
            $title = $_POST['title'];
            $description = $_POST['description'];
            $release = $_POST['release'];
            $price = floatval($_POST['price']);
            $slug = Utils::toSlug($title);
            $categ = $_POST['categorie'];
            $textImg = $_POST['text-img'];

            if($_FILES['image']['name'] != ""){
                $titleimg = md5(uniqid(rand(), true));
                $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
                $titleimg = $titleimg.'.'.$extension_upload;
                unlink('images/film/'.$textImg);
                Utils::upload('image', 'images/film/'.$titleimg, FALSE, false);
            } elseif($textImg != "") {
                $titleimg = $textImg;
            } else {
                $titleimg = "default.jpg";
            }

            if(isset($_POST['title']) && $_POST['title'] !== ""){
                //     elseif($idParam != ""){
            //     $titleimg = $filmUpdate->image;
            $params = [
                'id' => $id,
                'title' => $title,
                'slug' => $slug,
                'description' => $description,
                'date_release' => $release,
                'price' => $price,
                'image' => $titleimg      
            ];
            var_dump($params);
            $movie = new Movie();
            $moviecategs = new MovieCategs();

            
            $success = "Votre film a bien été mis à jour !";
            $err = "Une erreur s'est produite, veuillez réessayer.";
            Utils::displayMessage($movie->save($params), $success, $err);

            foreach($categ as $cate){
                $params = [
                    'id_movie' => intval($id),
                    'id_categ' => intval($cate)
                ];
            $moviecategs->save($params);   
            }
            }
        }
    }
    public function movie_detailsAction(){
        //Récupérer les éléments pour les afficher dans la view
        $id = $this->_getParam('id');
        $mov = new Movie();
        $cats = new Categorie();

        $movie = $mov->fetchOne($id);
        $this->view->movie_categs = $cats->fetchAllCategsByMovie($movie->id);
        $this->view->movie = $movie;
    }
}   
